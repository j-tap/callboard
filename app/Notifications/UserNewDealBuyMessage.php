<?php

namespace App\Notifications;

use App\Notifications\Channels\SocketChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;


class UserNewDealBuyMessage extends Notification
{
    use Queueable;

    private $message;
    private $user;
    private $deal;

    public function __construct($message, $user, $deal)
    {
        $this->message = $message;
        $this->user = $user;
        $this->deal = $deal;
    }

    public function via($notifiable)
    {
        return [SocketChannel::class];
    }

    public function toSocket()
    {
        event(new \App\Events\DealsBuyMessage($this->message, $this->user, $this->deal));
    }
}
