<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $message;
    private $user;

    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('dialog.' . $this->message->dialog_id);
    }

    public function broadcastWith()
    {
        return [
            'dialog_id' => $this->message->dialog_id,
            'message' => $this->message->message,
            'message_id' => $this->message->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'org_name' => $this->user->organization->org_name,
                'photo' => $this->user->photo,
            ],
            'date_create' => $this->message->created_at
        ];
    }
}
