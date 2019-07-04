<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendClientPassword extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $password;

    public function __construct($email,  $password)
    {
        $this->password = $password;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('TamTem, доступ к сервису')
            ->view('emails.send_password_client', ['user'=>$notifiable, 'email'=>$this->email, 'password' => $this->password ])
            ->from(config('b2b.email.noreply'));
    }
}