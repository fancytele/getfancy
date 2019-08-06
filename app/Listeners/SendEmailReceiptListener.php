<?php

namespace App\Listeners;

use App\Events\SendEmailReceiptEvent;
use App\Mail\ReceiptSubscriptionMail;
use App\Services\ReceiptMailService;
use Illuminate\Support\Facades\Mail;

class SendEmailReceiptListener
{
    /**
     * Handle the event.
     *
     * @param  SendEmailReceiptEvent  $event
     * @return void
     */
    public function handle(SendEmailReceiptEvent $event)
    {
        $receipt_service = new ReceiptMailService($event->stripeReceipt);

        Mail::to($event->stripeReceipt['customer_email'])
            ->send(new ReceiptSubscriptionMail($receipt_service->getDataToMail()));
    }
}
