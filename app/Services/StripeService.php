<?php

namespace App\Services;

use Stripe\Customer as StripeCustomer;
use Stripe\Invoice as StripeInvoice;
use Stripe\Plan as StripePlan;
use Stripe\Product as StripeProduct;
use Stripe\Subscription as StripeSubscription;

class StripeService
{
    /**
     * The Stripe API key.
     *
     * @var string
     */
    private $stripeKey;

    /**
     * Create a Stripe customer for the given model.
     *
     * @param  array  $options
     * @return \Stripe\Customer
     */
    public function createCustomer(array $options = [])
    {
        return StripeCustomer::create(
            $this->buildCustomerPayload($options),
            $this->getStripeKey()
        );
    }

    /**
     * Create a Stripe Subscription for the given Customer and plan(s)
     *
     * @param string $customer_id
     * @param array $plans
     * @return \Stripe\Subscription
     */
    public function createSubscription(string $customer_id, array $plans)
    {
        return StripeSubscription::create(
            ["customer" => $customer_id, "items" => $plans],
            $this->getStripeKey()
        );
    }

    /**
     * Get a Stripe Product by name.
     * 
     * @param string $name
     * @return mixed
     * */
    public function getProductByName(string $name)
    {
        $products = collect($this->getAllProducts()->data);

        return $products->firstWhere("name", $name);
    }

    /**
     * Get a collection of Products.
     * 
     * @return \Stripe\Collection
     */
    public function getAllProducts(int $limit = 100)
    {
        return StripeProduct::all(["limit" => $limit], $this->getStripeKey());
    }

    /**
     * Get a collection of Plans by names
     *
     * @param string $product_id
     * @param array $names
     * @return Illuminate\Support\Collection
     */
    public function getProductPlansByNames(string $product_id, array $names)
    {
        $plans = collect($this->getAllPlansByProduct($product_id, 10)->data);

        return $plans->whereIn("nickname", $names)->values();
    }

    /**
     * Get a collection of Plans
     *
     * @param string $product_id
     * @param integer $limit
     * @return \Stripe\Collection
     */
    public function getAllPlansByProduct(string $product_id, int $limit = 100)
    {
        return StripePlan::all(
            ["product" => $product_id, "limit" => $limit],
            $this->getStripeKey()
        );
    }

    /**
     * Get a Stripe Invoice by Id
     *
     * @param string $id
     * @return \Stripe\Invoice
     */
    public function getInvoice(string $id)
    {
        return StripeInvoice::retrieve($id, $this->getStripeKey());
    }

    /** 
     * Build the payload for subscription creation.
     * 
     * @param array $options
     * @return array
     */
    private function buildCustomerPayload(array $options)
    {
        return [
            "name" => "{$options['first_name']} {$options['last_name']}",
            "email" => $options["email"],
            "address" => [
                "city" => $options["city"],
                "country" => $options["country"],
                "line1" => $options["address"],
                "postal_code" => $options["zip_code"],
                "state" => $options["state"]
            ],
            "source" => $options["stripe_token"]
        ];
    }

    /**
     * Get Subscription by Id
     *
     * @param string $subscription_id
     * @return \Stripe\Subscription
     */
    public function getSubscription(string $subscription_id)
    {
        return StripeSubscription::retrieve($subscription_id, $this->getStripeKey());
    }

    /**
     * Get the Stripe API key.
     *
     * @return string
     */
    private function getStripeKey()
    {
        if ($this->stripeKey) {
            return $this->stripeKey;
        }

        if ($key = getenv('STRIPE_SECRET')) {
            return $key;
        }

        return config('services.stripe.secret');
    }
}
