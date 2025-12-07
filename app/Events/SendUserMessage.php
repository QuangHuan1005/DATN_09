<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

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
        return new Channel('admin-messages.' .$this->message->receiver_id); 
    }

    /**
     * Prepare the data to be broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // Assuming sender_id is a user ID
        $user = User::find($this->message->sender_id); 

        if ($user) {
            return [
                'message' => $this->message->message,
                'receiver_id' => $this->message->receiver_id,
                'sender_id' => $this->message->sender_id,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => asset('storage/' . $user->picture), 
                ],
                'created_at' => $this->message->created_at,
            ];
        } else {
            return [
                'message' => $this->message->message,
                'receiver_id' => $this->message->receiver_id,
                'sender_id' => $this->message->sender_id,
                'user' => [
                    'id' => null,
                    'name' => 'Unknown User',
                    'image' => asset('storage/default-avatar.png'), 
                ],
                'created_at' => $this->message->created_at,
            ];
        }
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