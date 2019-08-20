<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User name
     *
     * @var string
     */
    public $name;
    /**
     * User email
     *
     * @var string
     */
    public $email_address;
    /**
     * User message
     *
     * @var string
     */
    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, string $email_address, string $text)
    {
        $this->name = $name;
        $this->email_address = $email_address;
        $this->text = $text;
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
            ->view('mails.contact-us');
    }
}
