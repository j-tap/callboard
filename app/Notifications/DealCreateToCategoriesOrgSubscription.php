<?php

namespace App\Notifications;

use App\Models\Org\OrganizationNotification;
use App\Notifications\Channels\DatabaseCustomChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DealCreateToCategoriesOrgSubscription extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $userName;
    protected $categoryName;
 
  //  public function __construct($orgCat, $user)
    public function __construct($userEmail, $userName, $categoryName)
    {
        $this->email = $userEmail;
        $this->userName = $userName;
        $this->categoryName = $categoryName;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $notifiable->email = $this->email;
        $urlToDeal = $notifiable->id;
        return (new MailMessage())
            ->subject('TamTem, размещена новая заявка, по вашей категории')
            ->view('emails.deal_create_categories_subcription', ['user_name' =>$this->userName, 'category_name' => $this->categoryName, 'dealId' => $urlToDeal ])
            ->from(config('b2b.email.noreply'));
    }
}
