<?php

namespace App\Listeners;

use App\Events\UpdateSubscriptionEvent;
use Stripe\Subscription as StripeSubscription;
use App\Subscription;
use Illuminate\Support\Facades\Log;

class UpdateSubscriptionListener
{
    /**
     * An Stripe Subscription
     *
     * @var StripeSubscription
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
        $ends_at = date($this->stripeSubscription->current_period_end);

        Log::info('Subscription date: ' . $ends_at);

        $subscription->save(['ends_at', $ends_at]);
    }
}
