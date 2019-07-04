<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Org\OrganizationNotification;

class DealNewMember extends Notification implements ShouldQueue
{
    use Queueable;

    private $member;

    public function __construct($member)
    {
        $this->member = $member;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = $notifiable->user->email;

        return (new MailMessage())
            ->subject('Deal new member')
            ->view('emails.deal_new_member', ['deal' => $notifiable, 'member' => $this->member])
            ->from(config('b2b.email.noreply'));
    }

    public function toDatabase($notifiable)
    {
        return new OrganizationNotification([
            'organization_id' => $notifiable->id,
            'props' => json_encode([
                'message' => 'notifications.deal.newmember',
                'props' => [
                    'deal_id' => $notifiable->id,
                    'deal_name' => $notifiable->name,
                    'member' => $this->member->org_name
                ]
            ]),
        ]);
    }
}
