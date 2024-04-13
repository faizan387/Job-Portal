<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Created with following command
 * php artisan make:mail PurchaseMail --markdown=emails.notify
 */
class PurchaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $plan;
    public $billingEnd;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plan, $billingEnd)
    {
        $this->subject = 'Purchase confirmation';
        $this->plan = $plan;
        $this->billingEnd = $billingEnd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notify');
    }

}
