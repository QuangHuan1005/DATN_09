<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderStatus; // Giả sử bạn có model này
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdateMail;

class OrderObserver
{
    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order)
    {
        // Kiểm tra xem trạng thái đơn hàng có bị thay đổi không
        if ($order->isDirty('order_status_id')) {

            $newStatusId = $order->order_status_id;

            // Lấy tên trạng thái (Giả sử bạn có relation orderStatus)
            // Hoặc query trực tiếp: OrderStatus::find($newStatusId)->name
            $statusName = $order->status->name ?? 'Trạng thái mới';
            $userEmail = $order->user->email ?? null;

            if ($userEmail) {
                $type = 'update';

                // Giả định ID trạng thái (Bạn sửa lại theo DB của bạn)
                // Ví dụ: 5 là Hủy, 6 là Hoàn trả
                if ($newStatusId == 5) {
                    $type = 'cancel';
                } elseif ($newStatusId == 6) {
                    $type = 'return';
                }

                Mail::to($userEmail)->send(new OrderStatusUpdateMail($order, $statusName, $type));
            }
        }
    }
}
