<?php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class DatabaseCustomChannel
{
    public function send($notifiable, Notification $notification)
    {
        $notification->toDatabase($notifiable)->save();
    }
}