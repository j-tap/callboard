<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisterConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $notifiable->rollConfirmKey();

        return (new MailMessage())
            ->subject('TamTem, завершение регистрации')
            ->view('emails.register_confirmation', ['user' => $notifiable])
            ->from(config('b2b.email.noreply'));
    }
}
