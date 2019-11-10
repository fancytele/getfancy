<?php

namespace App\Listeners;

use App\Events\RegisterInvoiceEvent;
use App\Invoice;

class RegisterInvoiceListener
{
    /**
     * Handle the event.
     *
     * @param RegisterInvoiceEvent $event
     * @return void
     */
    public function handle(RegisterInvoiceEvent $event)
    {
        $invoice = new Invoice();
        $invoice->user_id = $event->user->id;
        $invoice->addon_id = $event->addon->id;
        $invoice->amount = $event->addon->cost;
        $invoice->stripe_invoice = $event->stripeInvoice->id;

        $invoice->save();
    }
}
