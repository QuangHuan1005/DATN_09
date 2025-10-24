<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Models\Order;

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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order, InventoryService $inv)
    {
        $data = $request->validate([
            'order_status_id' => ['required','integer'],
            // ... các field khác bạn cần
        ]);

        $old = (int) $order->order_status_id;
        $new = (int) $data['order_status_id'];

        $order->update($data);

        // ===== Điều chỉnh tồn kho =====
        if (in_array($new, [self::STATUS_CONFIRMED, self::STATUS_SHIPPING, self::STATUS_DELIVERED, self::STATUS_DONE], true)) {
            $inv->deductForOrder($order);   // trừ tồn (idempotent)
        }

        if (in_array($new, [self::STATUS_CANCEL, self::STATUS_RETURNED], true)) {
            $inv->restoreForOrder($order);  // hoàn tồn (idempotent)
        }

        return back()->with('success','Đã cập nhật đơn hàng');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
