<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HaveUsCallYouMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User name
     *
     * @var string
     */
    public $name;

    /**
     * User phone number
     *
     * @var string
     */
    public $phone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $phone)
    {
        $this->name = $name;
        $this->phone = $phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A new user wants to be contacted')
            ->to(config('fancy.email'))
            ->view('mails.call-you');
    }
}
