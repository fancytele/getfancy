<?php

namespace App\Jobs;

use App\Events\SendEmailReceiptEvent;
use App\Events\UpdateSubscriptionEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;

class InvoiceSucceededJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** 
     * @var \Spatie\WebhookClient\Models\WebhookCall 
     */
    public $webhookCall;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $receipt = $this->webhookCall->payload['data']['object'];
        $subscription_id = $receipt['subscription'];

        // Event to Update subscription in Fancy
        event(new UpdateSubscriptionEvent($subscription_id));

        // Send Email of the Receipt
        event(new SendEmailReceiptEvent($receipt));
    }
}
