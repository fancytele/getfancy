<?php

namespace App\Events;

use App\Addon;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Stripe\Invoice as StripeInvoice;

class RegisterInvoiceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Addon
     */
    public $addon;

    /**
     * @var \Stripe\Invoice
     */
    public $stripeInvoice;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Addon $addon
     * @param StripeInvoice $stripeInvoice
     */
    public function __construct(User $user, Addon $addon, StripeInvoice $stripeInvoice)
    {
        $this->user = $user;
        $this->addon = $addon;
        $this->stripeInvoice = $stripeInvoice;
    }
}
