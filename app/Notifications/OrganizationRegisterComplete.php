<?php

namespace App\Notifications;

use App\Models\Org\OrganizationNotification;
use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrganizationRegisterComplete extends Notification implements ShouldQueue
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
        $notifiable->email = $notifiable->owner->email;

        return (new MailMessage())
            ->subject('Оргинизация зарегистрирована')
            ->view('emails.register_organization', ['organization' => $notifiable])
            ->from(config('b2b.email.noreply'));
    }

    public function toDatabase($notifiable)
    {
        return new OrganizationNotification([
            'organization_id' => $notifiable->id,
            'props' => json_encode([
                'message' => 'notifications.organization.register',
                'props' => [
                    'organization' => $notifiable->org_name
                ]
            ]),
        ]);
    }

}
