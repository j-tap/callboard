<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallMeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.call_me')
        // ->with([
        //   'phone' => $this->phone,
        // ])
        ->subject('TamTem, заказ звонка от клиента.')
        ->from(config('b2b.email.noreply'));
    }
}
