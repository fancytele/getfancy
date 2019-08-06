<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SendEmailReceiptEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Array of Stripe Invoice
     *
     * @var array
     */
    public $stripeReceipt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $stripe_receipt)
    {
        $this->stripeReceipt = $stripe_receipt;
    }
}
