<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * php artisan make:mail ShortlistMail --markdown=emails.shortlist
 */
class ShortlistMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $title;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $title)
    {
        $this->name = $name;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.shortlist');
    }
}
