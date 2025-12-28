<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Storage;

class SendAdminMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel('admin-messages.' . $this->message->receiver_id);
    }

    /**
     * Prepare the data to be broadcast.
     *
     * @return array
     */
    // Thêm trường image vào broadcastWith()
    public function broadcastWith()
    {
        $admin = User::find($this->message->sender_id);

        $adminData = $admin ? [
            'id' => $admin->id,
            'name' => $admin->name,
            'image' => asset('storage/' . $admin->picture),
        ] : [
            'id' => null,
            'name' => 'Unknown Admin',
            'image' => asset('storage/default-avatar.png'),
        ];

        return [
            'message' => $this->message->message,
            // Trong broadcastWith() của cả 2 event
            'image' => $this->message->image ? asset('storage/' . $this->message->image) : null,
            'receiver_id' => $this->message->receiver_id,
            'sender_id' => $this->message->sender_id,
            'admin' => $adminData,
            'created_at' => $this->message->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * The name of the event to broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'admin-message';
    }
}
