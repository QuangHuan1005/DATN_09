<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AdminTypingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin_id;
    public $seller_id;
    public $is_typing;

    public function __construct($admin_id, $seller_id, $is_typing = true)
    {
        $this->admin_id = $admin_id;
        $this->seller_id = $seller_id;
        $this->is_typing = $is_typing;
    }

    public function broadcastOn()
    {
        return new Channel('admin-messages.' . $this->seller_id);
    }

    public function broadcastAs()
    {
        return 'admin-typing';
    }

    public function broadcastWith()
    {
        return [
            'admin_id' => $this->admin_id,
            'is_typing' => $this->is_typing,
        ];
    }
}