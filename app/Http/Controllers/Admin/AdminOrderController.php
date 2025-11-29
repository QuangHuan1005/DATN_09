<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Models\Order;
use App\Models\OrderStatus;

class AdminOrderController extends Controller
{
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_DONE      = 5; // Hoàn thành
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Hoàn hàng

    /**
     * Danh sách trạng thái (có màu hiển thị)
     */
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


    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index(Request $request)
    {

        $query = Order::with(['status', 'user', 'paymentStatus'])
            ->withSum('details', 'quantity')
            ->orderByDesc('id');

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('order_status_id', $request->status);
        }

        // Tìm kiếm theo mã đơn hoặc tên khách
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('order_code', 'like', "%$kw%")
                    ->orWhere('name', 'like', "%$kw%");
            });
        }

        $orders = $query->paginate(9);
        $statuses = $this->getStatuses();

        return view(
            'admin.orders.index',
            compact('orders', 'statuses'),
            [
                'pageTitle' => 'Danh sách đơn hàng'
            ]
        );
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(string $id)
    {
        $order = Order::with([
            'details.productVariant.product',
            'details.productVariant.size',
            'details.productVariant.color',
            'status',
            'user',
            'payment.paymentMethod',
        ])->findOrFail($id);

        // Chuẩn hóa dữ liệu dòng sản phẩm
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

        $statuses = $this->getStatuses(); // <-- Thêm để đồng bộ trạng thái

        return view(
            'admin.orders.show',
            compact('order', 'lines', 'calc_subtotal', 'calc_discount', 'calc_total', 'statuses'),
            [
                'pageTitle' => 'Chi tiết đơn hàng'
            ]
        );
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function update(Request $request, $id, InventoryService $inv)
    {
        $data = $request->validate([
            'order_status_id' => ['required', 'integer'],
        ]);

        $order = Order::findOrFail($id);

        $oldStatus = (int) $order->order_status_id;
        $newStatus = (int) $data['order_status_id'];

        // Chỉ cho phép tiến từng bước hoặc giữ nguyên
        if ($newStatus !== $oldStatus && $newStatus !== $oldStatus + 1) {
            return back()->with('error', 'Chỉ được cập nhật trạng thái tiến từng bước một.');
        }

        $order->update($data);

        $statusDeductStock = [
            self::STATUS_CONFIRMED,
            self::STATUS_SHIPPING,
            self::STATUS_DELIVERED,
            self::STATUS_DONE,
        ];

        $statusRestoreStock = [
            self::STATUS_CANCEL,
            self::STATUS_RETURNED,
        ];

        // Điều chỉnh tồn kho
        if (!in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusDeductStock)) {
            $inv->deductForOrder($order);
        }

        if (in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusRestoreStock)) {
            $inv->restoreForOrder($order);
        }

        if (in_array($oldStatus, $statusRestoreStock) && in_array($newStatus, $statusDeductStock)) {
            $inv->deductForOrder($order);
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
    }
}
