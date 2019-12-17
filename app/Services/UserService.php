<?php

namespace App\Services;

use App\Address;
use App\Enums\AddressType;
use App\Enums\DIDOrderStatus;
use App\Enums\Role;
use App\FancyNumber;
use App\User;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Stripe\Customer as StripeCustomer;
use Stripe\Subscription as StripeSubscription;

class UserService
{
    /**
     * User model
     *
     * @var User
     */
    private $model;

    /**
     * Fancy Number model
     *
     * @var FancyNumber
     */
    private $fancyNumber;

    /**
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->model = $user;
    }

    /**
     * Get User model
     *
     * @return User
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Get User Fancy Number model
     *
     * @return FancyNumber
     */
    public function fancyNumberModel()
    {
        return $this->fancyNumber;
    }

    /**
     * @param array $options
     * 
     * @return $this
     */
    public function create(array $options)
    {
        $this->model = User::create($options);
        $this->model->assignRole(Role::USER);

        return $this;
    }

    /**
     * @param array $user_options
     * @param StripeCustomer $stripe_customer
     *
     * @return UserService
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
     * @return UserService
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

    public function assignFancyNumber(string $did_number, string $did_type, array $did_purchase)
    {
        $did_service = new DIDService();
        $did = $did_service->getPurchasedDID($did_purchase['id']);

        $this->fancyNumber = new FancyNumber([
            'type' => $did_type,
            'did_id' => $did['id'],
            'did_purchase_id' => $did_purchase['id'],
            'did_number' => $did_number,
            'did_reference' => $did_purchase['reference'],
            'did_status' => DIDOrderStatus::getValue(strtoupper($did_purchase['status']))
        ]);

        $this->model->fancy_number()->save($this->fancyNumber);
    }

    /**
     * @return array
     */
    public function dashboardInfo()
    {
        $user = $this->model;

        if (!$user->fancy_number) {
            return [];
        }

        // '50640000229'
        $carbon = new Carbon();
        $calls = $this->getCalls($user->fancy_number->did_number, $carbon->year, $carbon->month);

        if ($calls->isEmpty()) {
            return compact('user');
        }

        $chart = $this->getCallsChart($calls);
        $overview = $this->getCallsOverview($calls);
        $range = $carbon->firstOfMonth()->format('Y-m-d') . ' to ' . $carbon->today()->format('Y-m-d');

        return compact('user', 'calls', 'chart', 'overview', 'range');
    }

    /**
     * Build the payload with stripe information.
     *
     * @param array $user_options
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

    /**
     * @return Collection
     */
    private function getCalls(string $fancy_number, int $year, int $month)
    {
        return collect((new DIDService())->getCDRReport($fancy_number, $year, $month));
    }

    /**
     * return array
     */
    private function getCallsChart(Collection $calls)
    {
        $labels = [];
        $values = [];

        $group = $calls->groupBy('Date');

        foreach ($group as $key => $value) {
            $date = new Carbon($key);

            array_push($labels, $date->shortEnglishDayOfWeek . ', ' . $date->day);
            array_push($values, $value->where('Disconnect Code', 200)->count());
        }

        return compact('labels', 'values');
    }

    /**
     * @return array
     */
    private function getCallsOverview(Collection $calls)
    {
        $total = $calls->count();
        $successful = $calls->where('Disconnect Code', 200)->count();
        $successful_average = number_format(($successful / $total) * 100, 2);
        $unsuccessful = $total - $successful;
        $unsuccessful_average = 100 - $successful_average;
        $duration = gmdate("i:s",  number_format($calls->avg('Duration (secs)')));

        return compact('total', 'successful', 'successful_average', 'unsuccessful', 'unsuccessful_average', 'duration');
    }
}
