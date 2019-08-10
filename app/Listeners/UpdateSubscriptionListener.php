<?php

namespace App\Listeners;

use App\Events\UpdateSubscriptionEvent;
use App\Subscription;

class UpdateSubscriptionListener
{
    /**
     * An Stripe Subscription
     *
     * @var \Stripe\Subscription
     */
    protected $stripeSubscription;

    /**
     * Handle the event.
     *
     * @param  UpdateSubscriptionEvent  $event
     * @return void
     */
    public function handle(UpdateSubscriptionEvent $event)
    {
        $this->stripeSubscription = $event->stripeSubscription;
        $this->updateSubscription();
    }

    /**
     * Update Fancy Subscription with the given Stripe Subscription
     *
     * @return void
     */
    private function updateSubscription()
    {
        $subscription = Subscription::where('stripe_id', $this->stripeSubscription->id)->first();

        // Subscription not found, cancel event 
        if (!$subscription) {
            return false;
        }

        $ends_at = date($this->stripeSubscription->current_period_end);
        $subscription->save(['ends_at', $ends_at]);
    }
}
