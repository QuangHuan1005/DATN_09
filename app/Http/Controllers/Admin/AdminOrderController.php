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
<<<<<<< HEAD
            'payment.paymentMethod',
=======
            'payment.method',
            'staff',
>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8
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
        $data = $request->validate([
            'order_status_id' => ['required', 'integer'],
        ]);

        $order = Order::findOrFail($id);

        $oldStatus = (int) $order->order_status_id;
        $newStatus = (int) $data['order_status_id'];

        if ($newStatus !== $oldStatus && $newStatus !== $oldStatus + 1) {
            return back()->with('error', 'Chỉ được cập nhật trạng thái tiến từng bước một.');
        }

        $order->order_status_id = $newStatus;

        // ============= KHO =============
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

        // ============= THANH TOÁN =============
        $PAYMENT_STATUS_UNPAID = 1;
        $PAYMENT_STATUS_PAID   = 2;

        $PAYMENT_METHOD_COD    = 1;

        if (in_array($newStatus, [self::STATUS_DELIVERED, self::STATUS_DONE])) {
            if ((int)$order->payment_method_id === $PAYMENT_METHOD_COD) {
                $order->payment_status_id = $PAYMENT_STATUS_PAID;
            } else {
                if ((int)$order->payment_status_id === $PAYMENT_STATUS_UNPAID) {
                    $order->payment_status_id = $PAYMENT_STATUS_PAID;
                }
            }
        }

        $order->save();

        OrderStatusLog::create([
            'order_id'        => $order->id,
            'order_status_id' => $newStatus,
            'actor_type'      => 'system',
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
    }

    public function assignForm(Order $order)
    {
        if ($order->staff_id) {
            $staffs = User::where('id', $order->staff_id)->get(); 
        } else {
            $staffs = User::where('role_id', 3)
                ->where('is_verified', 1)
                ->where('is_locked', 0)
                ->get();
        }

        return view('admin.orders.assign', compact('order', 'staffs'), [
            'pageTitle' => 'Gán nhân viên xử lý đơn'
        ]);
    }
}
