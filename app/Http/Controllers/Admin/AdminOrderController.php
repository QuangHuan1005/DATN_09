<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User; 
use App\Models\OrderStatusLog;

class AdminOrderController extends Controller
{
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_DONE      = 5; // Hoàn thành
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Hoàn hàng

    private function getStatuses()
    {
        return [
            (object)['id' => self::STATUS_PENDING,   'name' => 'Chờ xác nhận', 'color_class' => 'bg-warning text-dark'],
            (object)['id' => self::STATUS_CONFIRMED, 'name' => 'Xác nhận',   'color_class' => 'bg-primary text-white'],
            (object)['id' => self::STATUS_SHIPPING,  'name' => 'Đang giao hàng',     'color_class' => 'bg-info text-white'],
            (object)['id' => self::STATUS_DELIVERED, 'name' => 'Đã giao hàng',       'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_DONE,      'name' => 'Hoàn thành',    'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_CANCEL,    'name' => 'Đã hủy',       'color_class' => 'bg-danger text-white'],
            (object)['id' => self::STATUS_RETURNED,  'name' => 'Hoàn hàng',     'color_class' => 'bg-secondary text-white'],
        ];
    }

    public function index(Request $request)
    {
        $query = Order::with(['status', 'user', 'paymentStatus', 'staff'])
            ->withSum('details', 'quantity')
            ->orderByDesc('id');

         if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

        if ($request->filled('status')) {
            $query->where('order_status_id', $request->status);
        }

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('order_code', 'like', "%$kw%")
                  ->orWhere('name', 'like', "%$kw%");
            });
        }

        $orders = $query->paginate(5);
        $statuses = $this->getStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'), [
            'pageTitle' => 'Danh sách đơn hàng'
        ]);
    }

    public function show(string $id)
    {
        $order = Order::with([
            'details.productVariant.product',
            'details.productVariant.size',
            'details.productVariant.color',
            'status',
            'user',
            'payment.method',
            'staff',
        ])->findOrFail($id);

        $lines = $order->details->map(function ($d) {
            $v = $d->productVariant;
            $variantText = [];
            if ($v?->size?->name)  $variantText[] = "Size: {$v->size->name}";
            if ($v?->color?->name) $variantText[] = "Màu: {$v->color->name}";
            return (object)[
                'product_name' => $v?->product?->name ?? 'Sản phẩm',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'        => $v?->image,
                'unit_price'   => (int)$d->price,
                'qty'          => (int)$d->quantity,
                'line_total'   => (int)($d->price * $d->quantity),
            ];
        });

        $calc_subtotal = $lines->sum('line_total');
        $calc_discount = (int)$order->discount;
        $calc_total    = (int)$order->total_amount;
        $statuses = $this->getStatuses();

        return view(
            'admin.orders.show',
            compact('order', 'lines', 'calc_subtotal', 'calc_discount', 'calc_total', 'statuses'),
            ['pageTitle' => 'Chi tiết đơn hàng']
        );
    }

   public function update(Request $request, $id, InventoryService $inv)
{
    // Xác thực dữ liệu đầu vào: Chỉ cần order_status_id là số nguyên và bắt buộc.
    $data = $request->validate([
        'order_status_id' => ['required', 'integer'],
    ]);

    // Lấy đơn hàng hiện tại. Hàm findOrFail sẽ tự động trả về 404 nếu không tìm thấy.
    $order = Order::findOrFail($id);

    $oldStatus = (int) $order->order_status_id;
    $newStatus = (int) $data['order_status_id'];

    // 1. Quy tắc chuyển trạng thái
    // Đảm bảo trạng thái chỉ được chuyển tiến từng bước một (ví dụ: 1 -> 2, không phải 1 -> 3).
    // Quy tắc này áp dụng cho các trạng thái tuần tự. Trạng thái Hủy (Cancel) và Hoàn hàng (Returned)
    // thường là ngoại lệ, nhưng logic này đang áp đặt một trình tự nghiêm ngặt.
    if ($newStatus !== $oldStatus && $newStatus !== $oldStatus + 1) {
        if ($request->ajax()) {
            return response()->json(['message' => 'Chỉ được cập nhật trạng thái tiến từng bước một.'], 422);
        }
        return back()->with('error', 'Chỉ được cập nhật trạng thái tiến từng bước một.');
    }

    // Cập nhật trạng thái mới cho đơn hàng
    $order->order_status_id = $newStatus;

    // 2. Quản lý Kho Hàng (Inventory Management)
    // Danh sách các trạng thái mà khi chuyển tới sẽ cần TRỪ KHO (hàng đã được dành/xuất đi).
    $statusDeductStock = [self::STATUS_CONFIRMED, self::STATUS_SHIPPING, self::STATUS_DELIVERED, self::STATUS_DONE];
    // Danh sách các trạng thái mà khi chuyển tới sẽ cần HOÀN KHO (hàng đã bị hủy/trả lại).
    $statusRestoreStock = [self::STATUS_CANCEL, self::STATUS_RETURNED];

    // Case 1: TRỪ KHO
    // Nếu trạng thái cũ KHÔNG thuộc nhóm trừ kho VÀ trạng thái mới THUỘC nhóm trừ kho (ví dụ: PENDING -> CONFIRMED).
    // Tức là, đây là lần đầu tiên đơn hàng đi vào quá trình xuất kho.
    if (!in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusDeductStock)) {
        $inv->deductForOrder($order);
    }

    // Case 2: HOÀN KHO
    // Nếu trạng thái cũ THUỘC nhóm trừ kho VÀ trạng thái mới THUỘC nhóm hoàn kho (ví dụ: SHIPPING -> CANCEL).
    // Tức là, đơn hàng đã xuất kho nay bị hủy/trả lại, cần đưa hàng về lại.
    if (in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusRestoreStock)) {
        $inv->restoreForOrder($order);
    }

    // Case 3: TRỪ KHO LẠI (Tái xử lý)
    // Nếu trạng thái cũ THUỘC nhóm hoàn kho VÀ trạng thái mới THUỘC nhóm trừ kho (ví dụ: CANCEL -> CONFIRMED).
    // Tức là, đơn hàng đã bị hủy nay được kích hoạt lại, cần trừ kho một lần nữa.
    if (in_array($oldStatus, $statusRestoreStock) && in_array($newStatus, $statusDeductStock)) {
        $inv->deductForOrder($order);
    }

    // 3. Cập nhật Trạng thái Thanh toán (Payment Status Update)
    $PAYMENT_STATUS_UNPAID = 1; // Chưa thanh toán
    $PAYMENT_STATUS_PAID   = 2; // Đã thanh toán
    $PAYMENT_METHOD_COD    = 1; // Thanh toán khi nhận hàng (Cash on Delivery)

    // Nếu trạng thái mới là Đã giao hàng (DELIVERED) hoặc Hoàn thành (DONE):
    if (in_array($newStatus, [self::STATUS_DELIVERED, self::STATUS_DONE])) {
        // Đối với phương thức COD: Mặc định đơn hàng được coi là ĐÃ THANH TOÁN khi giao hàng thành công.
        if ((int)$order->payment_method_id === $PAYMENT_METHOD_COD) {
            $order->payment_status_id = $PAYMENT_STATUS_PAID;
        } else {
            // Đối với các phương thức thanh toán khác (ví dụ: online):
            // Nếu trạng thái thanh toán hiện tại vẫn là CHƯA THANH TOÁN (Unpaid), ta cập nhật thành ĐÃ THANH TOÁN.
            // Điều này nhằm đảm bảo tính toàn vẹn dữ liệu ở bước cuối cùng.
            if ((int)$order->payment_status_id === $PAYMENT_STATUS_UNPAID) {
                $order->payment_status_id = $PAYMENT_STATUS_PAID;
            }
        }
    }

    // 4. Lưu dữ liệu và Ghi Log
    $order->save();

    // Ghi lại lịch sử thay đổi trạng thái để theo dõi và kiểm toán.
    OrderStatusLog::create([
        'order_id'          => $order->id,
        'order_status_id'   => $newStatus,
        'actor_type'        => 'system', // Ghi log hành động thực hiện bởi Admin/System.
    ]);

    // Xử lý phản hồi (Response)
    if ($request->ajax()) {
        return response()->json(['message' => 'Đã cập nhật trạng thái đơn hàng']);
    }

    return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
}

}
