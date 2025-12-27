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

class SendUserMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @param Chat $message
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
    public function broadcastWith()
    {
        $user = User::find($this->message->sender_id);

        $userData = $user ? [
            'id' => $user->id,
            'name' => $user->name,
            'image' => asset('storage/' . $user->picture),
        ] : [
            'id' => null,
            'name' => 'Unknown User',
            'image' => asset('storage/default-avatar.png'),
        ];

        return [
            'message' => $this->message->message,
            'image' => $this->message->image ? asset('storage/' . $this->message->image) : null,
            'receiver_id' => $this->message->receiver_id,
            'sender_id' => $this->message->sender_id,
            'user' => $userData,
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
        return 'user-message';
    }
}
