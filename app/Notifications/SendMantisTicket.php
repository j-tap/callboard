<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendMantisTicket extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $title;

    public function __construct($msg, $title)
    {
        $this->message = $msg;
        $this->title = $title;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = 'mantis_tamtem@tamtem.ru';
        return (new MailMessage())
            ->subject($this->title)
            ->view('emails.mantis', ['msg' => $this->message])
            ->from(config('b2b.email.noreply'));
    }
}