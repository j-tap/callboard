<?php

namespace App\Notifications;

use App\Models\Org\OrganizationNotification;
use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DealSetWinner extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [DatabaseCustomChannel::class];
    }


    public function toDatabase($notifiable)
    {
        return new OrganizationNotification([
            'organization_id' => $notifiable->id,
            'props' => json_encode([
                'message' => 'notifications.deal.setwinner',
                'props' => [
                    'deal_id' => $notifiable->id,
                    'deal_name' => $notifiable->name,
                    'winner' => $notifiable->winner->org_name
                ]
            ]),
        ]);
    }
}
