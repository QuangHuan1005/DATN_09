<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusName;
    public $messageType; // 'cancel', 'return', 'update'

    public function __construct(Order $order, $statusName, $messageType = 'update')
    {
        $this->order = $order;
        $this->statusName = $statusName;
        $this->messageType = $messageType;
    }

    public function build()
    {
        $subject = '';
        switch ($this->messageType) {
            case 'cancel':
                $subject = 'Thông báo hủy đơn hàng #' . $this->order->order_code;
                break;
            case 'return':
                $subject = 'Thông báo hoàn trả đơn hàng #' . $this->order->order_code;
                break;
            default:
                $subject = 'Cập nhật trạng thái đơn hàng #' . $this->order->order_code;
                break;
        }

        return $this->subject($subject)
            ->view('emails.order_status_update');
    }
}
