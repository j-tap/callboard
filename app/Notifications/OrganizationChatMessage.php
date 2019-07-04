<?php

namespace App\Notifications;

use App\Notifications\Channels\SocketChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;


class OrganizationChatMessage extends Notification
{
    use Queueable;

    private $message;
    private $user;

    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return [SocketChannel::class];
    }

    public function toSocket()
    {
      //  event(new \App\Events\DialogMessage($this->message, $this->user));
        event(new \App\Events\ChatMessage($this->message, $this->user));
    }
}
