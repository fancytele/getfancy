<?php

namespace App\Events;

use App\Services\StripeService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UpdateSubscriptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * An Stripe Subscription
     *
     * @var \Stripe\Subscription
     */
    public $stripeSubscription;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $subscription_id)
    {
        $this->stripeSubscription = $this->getStripeSubscription($subscription_id);
    }

    /**
     * @param string $subscription_id
     * @return void
     */
    private function getStripeSubscription(string $subscription_id)
    {
        $stripe_service = new StripeService();

        return $stripe_service->getSubscription($subscription_id);
    }
}
