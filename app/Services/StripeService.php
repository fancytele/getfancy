<?php

namespace App\Services;

use Stripe\Customer as StripeCustomer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice as StripeInvoice;
use Stripe\InvoiceItem as StripeInvoiceItem;
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
     * @param array $options
     * @return StripeCustomer
     * @throws ApiErrorException
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
     * @param array $data
     * @return \Stripe\Subscription
     * @throws ApiErrorException
     */
    public function createSubscription(string $customer_id, array $data)
    {
        $price = floor($data['price']*100)/100;
        return StripeSubscription::create(
            ['customer' => $customer_id, 'items' => [[
                'price_data' => [
                    'unit_amount' => ($price*100),
                    'currency' => 'usd',
                    'product' => $data['product_id'],
                    'recurring' => [
                        'interval' => 'month',
                    ],
                ]
            ]],
                'trial_period_days' => 30
            ],
            $this->getStripeKey()
        );
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Stripe\Error\Api
     */
    public function getProductByName(string $name)
    {
        $products = collect($this->getAllProducts()->data);

        return $products->firstWhere('name', $name);
    }

    /**
     * @param int $limit
     * @return \Stripe\Collection
     * @throws \Stripe\Error\Api
     */
    public function getAllProducts(int $limit = 100)
    {
        return StripeProduct::all(['limit' => $limit], $this->getStripeKey());
    }

    /**
     * Get a collection of Plans by names
     *
     * @param string $product_id
     * @param array $names
     * @return \Illuminate\Support\Collection
     * @throws \Stripe\Error\Api
     */
    public function getProductPlansByNames(string $product_id, array $names)
    {
        $plans = collect($this->getAllPlansByProduct($product_id, 10)->data);

        return $plans->whereIn('nickname', $names)->values();
    }

    /**
     * @param string $product_id
     * @param integer $limit
     * @return \Stripe\Collection
     * @throws \Stripe\Error\Api
     */
    public function getAllPlansByProduct(string $product_id, int $limit = 100)
    {
        return StripePlan::all(
            ['product' => $product_id, 'limit' => $limit],
            $this->getStripeKey()
        );
    }

    /**
     * @param int $amount | Amount in cents
     * @param string $customerEmail
     * @param string $description
     * @return StripeInvoice
     * @throws \Stripe\Error\Api
     */
    public function createInvoice(int $amount, string $customerEmail, string $description)
    {
        $customer = $this->retreiveCustomeByEmail($customerEmail);
        $this->generateInvoiceItem($amount, $customer->id, $description);

        $invoice = StripeInvoice::create(
            ['customer' => $customer->id, 'collection_method' => 'charge_automatically'],
            $this->getStripeKey()
        );

        return $invoice->pay();
    }

    /**
     * @param string $id
     * @return \Stripe\Invoice
     */
    public function getInvoice(string $id)
    {
        return StripeInvoice::retrieve($id, $this->getStripeKey());
    }

    /**
     * @param string $subscription_id
     * @return \Stripe\Subscription
     */
    public function getSubscription(string $subscription_id)
    {
        return StripeSubscription::retrieve($subscription_id, $this->getStripeKey());
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
            'name' => "{$options['first_name']} {$options['last_name']}",
            'email' => $options['email'],
            'phone' => $options['company_phone'] ?? '',
            'address' => [
                'city' => $options['billing_city'],
                'country' => $options['billing_country'],
                'line1' => $options['billing_address1'],
                'line2' => $options['billing_address2'],
                'postal_code' => $options['billing_zip_code'],
                'state' => $options['billing_state']
            ],
            'source' => $options['stripe_token']
        ];
    }

    /**
     * @return string
     */
    private function getStripeKey()
    {
        if ($this->stripeKey) {
            return $this->stripeKey;
        }

        if ($key = getenv('STRIPE_SECRET')) {
            $this->stripeKey = $key;
            return $this->stripeKey;
        }

        $this->stripeKey = config('services.stripe.secret');
        return $this->stripeKey;
    }

    /**
     * @param string $email
     * @return mixed
     * @throws \Stripe\Error\Api
     */
    private function retreiveCustomeByEmail(string $email)
    {
        $customers = StripeCustomer::all(['email' => $email], $this->getStripeKey());

        return $customers->data[0];
    }

    /**
     * @param int $amount
     * @param string $customerId
     * @param string $description
     */
    private function generateInvoiceItem(int $amount, string $customerId, string $description)
    {
        StripeInvoiceItem::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customerId,
            'description' => $description,
        ], $this->getStripeKey());
    }

    /**
     * @param $subscription_id
     * @return string|StripeSubscription
     */
    public function cancelSubscription($subscription_id)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $subscription = StripeSubscription::retrieve($subscription_id);
            return $subscription->cancel();
        } catch (ApiErrorException $e) {
           return $e->getMessage();
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function updatePaymentMethod($data)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try{

            $customer = StripeCustomer::retrieve(auth()->user()->stripe_id);

            $card = StripeCustomer::createSource(auth()->user()->stripe_id , [
                'source' => $data['stripe_token']
            ]);

            $customer->default_source=$card['id'];

            $customer->save();

         
            return $card;

        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    public function updateUserDetails(array $data){
        try {
            return StripeCustomer::update(auth()->user()->stripe_id, [
                'email' => $data['email'],
                'name' =>"{$data['first_name']} {$data['last_name']}",
            ], $this->getStripeKey());
        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array $data
     * @return string|StripeCustomer
     */
    public function updateBillingAddress(array $data){

        try {
            return StripeCustomer::update(auth()->user()->stripe_id, [
                'address' => [
                    'city' => $data['address_1'],
                    'country' => $data['country'],
                    'line1' => $data['address_1'],
                    'line2' => $data['address_2'],
                    'postal_code' => $data['zip_code'],
                    'state' => $data['state']
                ],
            ], $this->getStripeKey());
        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return array|string
     */
    public function getAllPaymentMethods(){

        try {
            $customer = StripeCustomer::retrieve(auth()->user()->stripe_id, $this->getStripeKey());

            $default_card = $customer->default_source;
            $payment_method = \Stripe\PaymentMethod::all([
                'customer' => auth()->user()->stripe_id,
                'type' => 'card',
            ], $this->getStripeKey());

            return ([$default_card, $payment_method ]);
        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $data
     * @return string
     */
    public function deletePaymentMethod($data){
        try {
            return StripeCustomer::deleteSource(auth()->user()->stripe_id , $data['card_id'], [],$this->getStripeKey());
        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $data
     * @return string|StripeCustomer
     */
    public function updateDefaultCard($data){

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try{

            $customer = StripeCustomer::retrieve(auth()->user()->stripe_id);

            $customer->default_source=$data['card_id'];

            $customer->save();

            return $customer;

        } catch (ApiErrorException $e) {
            return $e->getMessage();
        }
    }
}
