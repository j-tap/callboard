<?php

namespace App\Notifications;

use App\Models\Org\OrganizationNotification;
use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrganizationReport extends Notification
{
    use Queueable;

    private $report;

    public function __construct($report)
    {
        $this->report = $report;
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
                'message' => 'notifications.reports.create',
                'props' => [
                    'report_id' => $this->report->id
                ]
            ]),
        ]);
    }
}
