<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    protected $password_reset_token;
    protected $new_password;

    public function __construct($password_reset_token,  $new_password)
    {
        $this->password_reset_token = $password_reset_token;
        $this->new_password = $new_password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('TamTem, вы забыли пароль')
            ->view('emails.password_reset_confirmation', ['user' => $notifiable, 'password_reset_token' => $this->password_reset_token, 'new_password' => $this->new_password ])
            ->from(config('b2b.email.noreply'));
    }
}