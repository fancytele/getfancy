<?php

namespace App\Services;

use App\Address;
use App\Enums\AddressType;
use App\Enums\DIDOrderStatus;
use App\Enums\Role;
use App\FancyNumber;
use App\User;
use App\Subscription;
use Illuminate\Support\Facades\Hash;
use Stripe\Customer as StripeCustomer;
use Stripe\Subscription as StripeSubscription;

class UserService
{
    /**
     * User model
     *
     * @var \App\User;
     */
    private $model;

    /**
     * Get User model
     *
     * @return \App\User
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
        $this->model->assignRole(Role::User);

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
        $this->create($this->buildUserWithStripePayload($user_options, $stripe_customer));
        $this->syncAddresses($user_options);

        return $this;
    }

    /**
     * Create user Subscription with Stripe info
     *
     * @param int $product_id
     * @param string $stripe_product_id
     * @param StripeSubscription $stripe_subscription
     * 
     * @return void
     */
    public function createSubscription(int $product_id, string $stripe_product_id, StripeSubscription $stripe_subscription)
    {
        $subscription = new Subscription([
            'product_id' => $product_id,
            'stripe_id' => $stripe_subscription->id,
            'stripe_product' => $stripe_product_id,
            'ends_at' => $stripe_subscription->current_period_end
        ]);

        $this->model->subscriptions()->save($subscription);

        return $this;
    }

    public function assignFancyNumber(string $did, string $did_number, string $did_type, array $did_purchase)
    {
        $fancy_number = new FancyNumber([
            'type' => $did_type,
            'did_id' => $did, // TODO: Investigate real DID, aparently this is the Available DID and not the purchased one
            'did_purchase_id' => $did_purchase['id'],
            'did_number' => $did_number,
            'did_reference' => $did_purchase['reference'],
            'did_status' => DIDOrderStatus::getValue($did_purchase['status'])
        ]);

        $this->model->fancy_numbers()->save($fancy_number);
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
        $card = $stripe_customer->sources->data['0']; // Get always default Card

        $payload = [
            'first_name' => $user_options['first_name'],
            'last_name' => $user_options['last_name'],
            'email' => $user_options['email'],
            'phone_number' => $user_options['phone_number'] ?? '',
            'password' => User::generatePassword(),
            'company_name' => $user_options['company_name'] ?? null,
            'company_phone' => $user_options['company_phone'] ?? null,
            'company_contact_name' => $user_options['company_contact_name'] ?? null,
            'stripe_id' => $stripe_id,
            'card_brand' => $card->brand,
            'card_last_four' => $card->last4
        ];

        if (isset($user_options['password'])) {
            $payload['password'] = Hash::make($user_options['password']);
        }

        return $payload;
    }

    /**
     * Sync Addresses when they exists
     *
     * @param array $user_options
     */
    private function syncAddresses(array $user_options)
    {
        $addresses = [];

        if (isset($user_options['company_country'])) {
            $addresses[] = new Address([
                'address1' => $user_options['company_address1'],
                'address2' => $user_options['company_address2'],
                'country' => $user_options['company_country'],
                'city' => $user_options['company_city'],
                'state' => $user_options['company_state'],
                'zip_code' => $user_options['company_zip_code'],
                'type' => AddressType::COMPANY
            ]);
        }

        if (isset($user_options['billing_country'])) {
            $addresses[] = new Address([
                'address1' => $user_options['billing_address1'],
                'address2' => $user_options['billing_address2'],
                'country' => $user_options['billing_country'],
                'city' => $user_options['billing_city'],
                'state' => $user_options['billing_state'],
                'zip_code' => $user_options['billing_zip_code'],
                'type' => AddressType::BILLING
            ]);
        }

        if (count($addresses) > 0) {
            $this->model->addresses()->saveMany($addresses);
        }
    }
}
