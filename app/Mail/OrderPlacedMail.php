<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function build()
    {
        $code = $this->order->order_code ?? ('#' . $this->order->id);

        return $this->subject("Đặt hàng thành công - {$code}")
            ->view('emails.order_placed')
            ->with(['order' => $this->order]);
    }
}
