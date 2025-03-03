<?php

namespace App\Notifications;

use App\Models\Org\OrganizationNotification;
use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DealCreate extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail', DatabaseCustomChannel::class];
       // return [DatabaseCustomChannel::class];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = $notifiable->user->email;

        return (new MailMessage())
            ->subject('TamTem, размещение новой заявки')
            ->view('emails.deal_create', ['deal' => $notifiable])
            ->from(config('b2b.email.noreply'));
    }

    public function toDatabase($notifiable)
    {
        return new OrganizationNotification([
            'organization_id' => $notifiable->id,
            'props' => json_encode([
                'message' => 'notifications.deal.create',
                'props' => [
                    'deal_id' => $notifiable->id,
                    'deal_name' => $notifiable->name,
                ]
            ]),
        ]);
    }
}
