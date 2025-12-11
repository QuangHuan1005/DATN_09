<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class SellerTypingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $seller_id;
    public $admin_id;
    public $is_typing;

    public function __construct($seller_id, $admin_id, $is_typing = true)
    {
        $this->seller_id = $seller_id;
        $this->admin_id = $admin_id;
        $this->is_typing = $is_typing;
    }

    public function broadcastOn()
    {
        return new Channel('admin-messages.' . $this->admin_id);
    }

    public function broadcastAs()
    {
        return 'user-typing';
    }

    public function broadcastWith()
    {
        return [
            'seller_id' => $this->seller_id,
            'is_typing' => $this->is_typing,
        ];
    }
}