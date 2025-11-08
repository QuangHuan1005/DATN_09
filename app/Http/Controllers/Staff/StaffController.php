<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\InventoryService;

class StaffController extends Controller
{
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_DONE      = 5; // Hoàn thành
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Hoàn hàng

    /**
     * Dashboard của Staff
     */
    public function dashboard()
    {
        $staffId = auth('staff')->id();

        $ordersCount = Order::where('staff_id', $staffId)->count();
        $ordersPending = Order::where('staff_id', $staffId)
            ->where('order_status_id', self::STATUS_CONFIRMED)
            ->count();

        return view('staff.dashboard', compact('ordersCount', 'ordersPending'), [
            'pageTitle' => 'Dashboard nhân viên'
        ]);
    }

    /**
     * Danh sách đơn hàng được gán cho staff
     */
    public function orders(Request $request)
    {
        $staffId = auth('staff')->id();

        $query = Order::with(['status', 'user', 'paymentStatus'])
            ->withSum('details', 'quantity') 
            ->where('staff_id', $staffId)
            ->orderByDesc('id');

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

        $orders = $query->paginate(10);
        $statuses = $this->getStatuses();

        return view('staff.orders.index', compact('orders', 'statuses'), [
            'pageTitle' => 'Đơn hàng được gán'
        ]);
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $staffId = auth('staff')->id();

        $order = Order::with([
            'details.productVariant.product',
            'details.productVariant.size',
            'details.productVariant.color',
            'status',
            'user',
            'payment.method',
        ])->where('staff_id', $staffId)->findOrFail($id);

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

        return view('staff.orders.show', compact('order', 'lines', 'calc_subtotal', 'calc_discount', 'calc_total', 'statuses'), [
            'pageTitle' => 'Chi tiết đơn hàng'
        ]);
    }

    /**
     * Cập nhật trạng thái đơn hàng (staff chỉ được cập nhật tiến từng bước)
     */
    public function updateStatus(Request $request, $id, InventoryService $inv)
    {
        $staffId = auth('staff')->id();

        $data = $request->validate([
            'order_status_id' => 'required|integer',
        ]);

        $order = Order::where('staff_id', $staffId)->findOrFail($id);

        $oldStatus = (int) $order->order_status_id;
        $newStatus = (int) $data['order_status_id'];

        if ($newStatus !== $oldStatus && $newStatus !== $oldStatus + 1) {
            return back()->with('error', 'Chỉ được cập nhật trạng thái tiếp theo.');
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

        if (!in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusDeductStock)) {
            $inv->deductForOrder($order);
        }

        if (in_array($oldStatus, $statusDeductStock) && in_array($newStatus, $statusRestoreStock)) {
            $inv->restoreForOrder($order);
        }

        if (in_array($oldStatus, $statusRestoreStock) && in_array($newStatus, $statusDeductStock)) {
            $inv->deductForOrder($order);
        }

        return back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    /**
     * Các trạng thái đơn hàng
     */
    private function getStatuses()
    {
        return [
            (object)['id' => self::STATUS_PENDING,   'name' => 'Chờ xác nhận', 'color_class' => 'bg-warning text-dark'],
            (object)['id' => self::STATUS_CONFIRMED, 'name' => 'Xác nhận',     'color_class' => 'bg-primary text-white'],
            (object)['id' => self::STATUS_SHIPPING,  'name' => 'Đang giao hàng','color_class' => 'bg-info text-white'],
            (object)['id' => self::STATUS_DELIVERED, 'name' => 'Đã giao hàng', 'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_DONE,      'name' => 'Hoàn thành',   'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_CANCEL,    'name' => 'Đã hủy',       'color_class' => 'bg-danger text-white'],
            (object)['id' => self::STATUS_RETURNED,  'name' => 'Hoàn hàng',    'color_class' => 'bg-secondary text-white'],
        ];
    }
}
