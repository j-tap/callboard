<?php

namespace App\Notifications;

use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Org\OrganizationNotification;

class DealWinner extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail', DatabaseCustomChannel::class];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = $notifiable->winner->owner->email;

        return (new MailMessage())
            ->subject('Deal winner')
            ->view('emails.deal_winner', ['deal' => $notifiable])
            ->from(config('b2b.email.noreply'));
    }

    public function toDatabase($notifiable)
    {
        return new OrganizationNotification([
            'organization_id' => $notifiable->winner->id,
            'props' => json_encode([
                'message' => 'notifications.deal.winner',
                'props' => [
                    'deal_id' => $notifiable->id,
                    'deal_name' => $notifiable->name,
                ]
            ]),
        ]);
    }
}
