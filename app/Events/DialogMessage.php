<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DialogMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $message;

    public function __construct($message, $user)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        if ($this->user->organization_id == $this->message->dialog->buyer_id) {
            return new PrivateChannel('dialog.organization.' . $this->message->dialog->seller_id);
        } else {
            return new PrivateChannel('dialog.organization.' . $this->message->dialog->buyer_id);
        }
    }

    public function broadcastWith()
    {
        return [
            'dialog_id' => $this->message->dialog_id,
            'sender' => [
                'name' => $this->user->name,
                'org_name' => $this->user->organization->org_name,
            ]
        ];
    }
}
