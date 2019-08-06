<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ReceiptSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The receipt data.
     *
     * @var object
     */
    public $receipt;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.receipt')->subject("Fancy Payment Receipt");
    }
}
