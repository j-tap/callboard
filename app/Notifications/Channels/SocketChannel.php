<?php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SocketChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $notification->toSocket();
    }
}