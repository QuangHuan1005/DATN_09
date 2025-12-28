<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Models\Order;
use App\Models\OrderCancelRequest;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminOrderController extends Controller
{
    // Hằng số trạng thái đơn hàng
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_DONE      = 5; // Hoàn thành
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Hoàn hàng

    // Hằng số trạng thái thanh toán (KHỚP VỚI DB CỦA BẠN)
    const PAYMENT_STATUS_UNPAID   = 1;
    const PAYMENT_STATUS_PAID     = 2;
    const PAYMENT_STATUS_REFUNDED = 3; // Hoàn tiền hệ thống

    // Hằng số phương thức thanh toán
    const PAYMENT_METHOD_COD = 1;

    /**
     * Lấy danh sách trạng thái để hiển thị (Màu sắc CSS)
     */
    private function getStatuses()
    {
        return [
            (object)['id' => self::STATUS_PENDING,   'name' => 'Chờ xác nhận', 'color_class' => 'bg-warning text-dark'],
            (object)['id' => self::STATUS_CONFIRMED, 'name' => 'Xác nhận',      'color_class' => 'bg-primary text-white'],
            (object)['id' => self::STATUS_SHIPPING,  'name' => 'Đang giao hàng', 'color_class' => 'bg-info text-white'],
            (object)['id' => self::STATUS_DELIVERED, 'name' => 'Đã giao hàng',  'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_DONE,      'name' => 'Hoàn thành',    'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_CANCEL,    'name' => 'Đã hủy',        'color_class' => 'bg-danger text-white'],
            (object)['id' => self::STATUS_RETURNED,  'name' => 'Hoàn hàng',      'color_class' => 'bg-secondary text-white'],
        ];
    }

    /**
     * Trang danh sách đơn hàng
     */
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

        $orders = $query->paginate(15); 
        $statuses = $this->getStatuses();

        return view('admin.orders.index', compact('orders', 'statuses'), [
            'pageTitle' => 'Danh sách đơn hàng'
        ]);
    }

    /**
     * Chi tiết đơn hàng
     */
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
                'product_name' => $v?->product?->name ?? 'Sản phẩm không tồn tại',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'        => $v?->image ?? $v?->product?->image,
                'unit_price'   => (int)$d->price,
                'qty'          => (int)$d->quantity,
                'line_total'   => (int)($d->price * $d->quantity),
            ];
        });

        $calc_subtotal = $lines->sum('line_total');
        $calc_discount = (int)$order->discount;
        $calc_total    = (int)$order->total_amount;
        $statuses = $this->getStatuses();

        return view('admin.orders.show', 
            compact('order', 'lines', 'calc_subtotal', 'calc_discount', 'calc_total', 'statuses'),
            ['pageTitle' => 'Chi tiết đơn hàng #' . $order->order_code]
        );
    }

    /**
     * Cập nhật trạng thái đơn hàng (Xử lý chính)
     */
  public function update(Request $request, $id, InventoryService $inv)
{
    $order = Order::findOrFail($id);
    $oldStatus = (int)$order->order_status_id;
    $newStatus = (int)$request->order_status_id;

    // 1. Nếu không thay đổi trạng thái
    if ($oldStatus === $newStatus) {
        return back()->with('info', 'Trạng thái đơn hàng không thay đổi.');
    }

    // 2. Kiểm tra đơn hàng đã đóng (Hủy/Hoàn thành/Hoàn hàng) thì không cho đổi
    if (in_array($oldStatus, [self::STATUS_DONE, self::STATUS_CANCEL, self::STATUS_RETURNED])) {
        return $this->handleResponse($request, 'Đơn hàng đã đóng, không thể thay đổi trạng thái.', 'error', 422);
    }

    // --- MỚI: CHẶN XÁC NHẬN KHI ĐANG CÓ YÊU CẦU HỦY ---
    // Nếu khách đang gửi yêu cầu hủy (is_cancel_requested = 1) mà Admin lại cố tình chuyển trạng thái khác Hủy
    if ($order->is_cancel_requested == 1 && $newStatus !== self::STATUS_CANCEL) {
        return $this->handleResponse($request, 'Đơn hàng đang có yêu cầu hủy từ khách. Vui lòng xử lý yêu cầu hủy trước hoặc chọn trạng thái Hủy.', 'error', 422);
    }

    // 3. Kiểm tra quy trình chống nhảy bước
    $validNextSteps = [
        self::STATUS_PENDING   => [self::STATUS_CONFIRMED, self::STATUS_CANCEL],
        self::STATUS_CONFIRMED => [self::STATUS_SHIPPING, self::STATUS_CANCEL],
        self::STATUS_SHIPPING  => [self::STATUS_DELIVERED, self::STATUS_CANCEL],
        self::STATUS_DELIVERED => [self::STATUS_DONE, self::STATUS_RETURNED],
    ];

    if (!isset($validNextSteps[$oldStatus]) || !in_array($newStatus, $validNextSteps[$oldStatus])) {
        $statusNames = collect($this->getStatuses())->pluck('name', 'id');
        $errorMessage = "Quy trình không hợp lệ: Không thể chuyển từ [" . ($statusNames[$oldStatus] ?? $oldStatus) . "] sang [" . ($statusNames[$newStatus] ?? $newStatus) . "].";
        return $this->handleResponse($request, $errorMessage, 'error', 422);
    }

    // 4. Validate lý do nếu là Hủy đơn
    if ($newStatus === self::STATUS_CANCEL) {
        $request->validate([
            'admin_reason' => 'required|min:5'
        ], [
            'admin_reason.required' => 'Vui lòng nhập lý do hủy đơn.',
            'admin_reason.min' => 'Lý do hủy phải có ít nhất 5 ký tự.'
        ]);
    }

    try {
        DB::beginTransaction();

        // 5. XỬ LÝ KHO
        $statusDeductStock = [self::STATUS_CONFIRMED, self::STATUS_SHIPPING, self::STATUS_DELIVERED, self::STATUS_DONE];

        // Trường hợp A: Chuyển sang trạng thái trừ kho
        if (!in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusDeductStock)) {
            $inv->deductForOrder($order);
        } 
        // Trường hợp B: Chuyển sang Hủy hoặc Hoàn trả (Gọi restore)
        elseif (in_array($newStatus, [self::STATUS_CANCEL, self::STATUS_RETURNED])) {
            // Service của bạn sẽ tự check: Chỉ cộng lại nếu chi tiết dòng có status = 2
            $inv->restoreForOrder($order);
        }

        // 6. XỬ LÝ THANH TOÁN VÀ ĐỒNG BỘ YÊU CẦU HỦY
        if ($newStatus === self::STATUS_CANCEL) {
            $reason = $request->input('admin_reason');
            $order->note = "Admin hủy: " . $reason;
            $order->is_cancel_requested = 0; // Tắt cờ yêu cầu hủy

            // Cập nhật trạng thái thanh toán
            if ((int)$order->payment_method_id !== self::PAYMENT_METHOD_COD) { 
                if ((int)$order->payment_status_id === self::PAYMENT_STATUS_PAID) {
                    $order->payment_status_id = self::PAYMENT_STATUS_REFUNDED;
                }
            } else {
                $order->payment_status_id = self::PAYMENT_STATUS_UNPAID;
            }

            // ĐỒNG BỘ: Nếu có yêu cầu hủy đang treo, tự động duyệt nó luôn
            OrderCancelRequest::where('order_id', $order->id)
                ->where('status_id', 1) // 1 là trạng thái Pending của yêu cầu hủy
                ->update([
                    'status' => 'accepted',
                    'status_id' => 2, // 2 là Accepted
                    'reason_admin' => "Admin đã duyệt hủy trực tiếp từ danh sách đơn hàng: " . $reason
                ]);

        } elseif (in_array($newStatus, [self::STATUS_DELIVERED, self::STATUS_DONE])) {
            $order->payment_status_id = self::PAYMENT_STATUS_PAID;
        }

        // 7. Cập nhật trạng thái và lưu
        $order->order_status_id = $newStatus;
        $order->save();

        // 8. Ghi log lịch sử
        OrderStatusLog::create([
            'order_id' => $order->id,
            'order_status_id' => $newStatus,
            'actor_type' => 'admin',
            'actor_id' => auth()->id(), // Thêm ID người thực hiện để dễ truy vết
            'note' => ($newStatus === self::STATUS_CANCEL) ? $request->admin_reason : 'Cập nhật bởi Admin.'
        ]);

        DB::commit();
        return $this->handleResponse($request, 'Cập nhật trạng thái thành công.', 'success');

    } catch (Exception $e) {
        DB::rollBack();
        \Log::error("Order Update Error: " . $e->getMessage());
        return $this->handleResponse($request, 'Lỗi hệ thống: ' . $e->getMessage(), 'error', 500);
    }
}

    private function handleResponse(Request $request, $message, $type = 'success', $code = 200)
    {
        if ($request->ajax()) {
            return response()->json(['message' => $message], $code);
        }
        return back()->with($type, $message);
    }
}