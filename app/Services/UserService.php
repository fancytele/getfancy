<?php

namespace App\Services;

use App\User;
use App\Subscription;
use Illuminate\Support\Facades\Hash;
use Stripe\Customer as StripeCustomer;
use Stripe\Product as StripeProduct;
use Stripe\Subscription as StripeSubscription;

class UserService
{
    /**
     * User model
     *
     * @var App\Model;
     */
    private $model;

    /**
     * Get User model
     *
     * @return App\User
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @param array $options
     * 
     * @return $this
     */
    public function create(array $options)
    {
        $this->model = User::create($options);

        return $this;
    }

    /**
     * @param array $options
     * @param StripeCustomer $stripe_customer
     * 
     * @return $this
     */
    public function createFromStripe(array $user_options, StripeCustomer $stripe_customer)
    {
        return $this->create($this->buildUserWithStripePayload($user_options, $stripe_customer));
    }

    /**
     * Create user Subscription with Stripe info
     *
     * @param int $product_id
     * @param string $stripe_product_id
     * @param StripeSubscription $stripe_subscription
     * @return void
     */
    public function createSubscription(int $product_id, string $stripe_product_id, StripeSubscription $stripe_subscription)
    {
        $subscription = new Subscription([
            "product_id" => $product_id,
            "stripe_id" => $stripe_subscription->id,
            "stripe_product" => $stripe_product_id,
            "ends_at" => $stripe_subscription->current_period_end
        ]);

        $this->model->subscriptions()->save($subscription);

        return $this;
    }

    /**
     * Build the payload with stripe information.
     * 
     * @param array $options
     * @param StripeCustomer $stripe_customer
     * 
     * @return array
     */
    private function buildUserWithStripePayload(array $user_options, StripeCustomer $stripe_customer)
    {
        $stripe_id = $stripe_customer->id;
        $card = $stripe_customer->sources->data["0"]; // Get always default Card

        return [
            "first_name" => $user_options["first_name"],
            "last_name" => $user_options["last_name"],
            "email" => $user_options["email"],
            "password" => Hash::make($user_options["password"]),
            "stripe_id" => $stripe_id,
            "card_brand" => $card->brand,
            "card_last_four" => $card->last4
        ];
    }
}
