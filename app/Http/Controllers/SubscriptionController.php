<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\StripeService;
use App\Services\UserService;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    private $stripeService;
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StripeService $stripeService, UserService $userService)
    {
        $this->stripeService = $stripeService;
        $this->userService = $userService;
    }

    /**
     * Create user and set subscription
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function create(SubscriptionRequest $request)
    {
        $data = $request->all();

        // Create Stripe Customer
        $stripe_customer = $this->stripeService->createCustomer($data);

        // Create Fancy User        
        $user = $this->userService->createFromStripe($data, $stripe_customer);

        // Find product by slug
        $product = Product::whereSlug($data["checkout_product"])->first();

        // Get Stripe Product by Name
        $stripe_product = $this->stripeService->getProductByName($product->name);

        // Get all product Plans (base and features)
        $stripe_plans = $this->stripeService->getProductPlansByNames(
            $stripe_product->id,
            Arr::prepend($data["addons"], $product->name)
        );

        $plans = $stripe_plans->map(function ($item) {
            return ["plan" => $item->id];
        })->toArray();

        // Create Subscription
        $stripe_subscription = $this->stripeService->createSubscription($stripe_customer->id, $plans);

        // Create User subscription
        $this->userService->createSubscription($product->name, $stripe_product, $stripe_subscription);

        //TODO: 
        // Create Email with custom Invoice ($stripe_subscription->latest_invoice)

        // Login User and redirect to Dahsboard
        $credentials = $user->model()->only("email", "password");

        //TODO: Review why is not logged in the user
        if (Auth::attempt($credentials)) {
            return response()->json(['route' => route('home')]);
        }
    }
}
