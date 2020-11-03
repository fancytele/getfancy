<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Enums\AddonType;
use App\Events\RegisterInvoiceEvent;
use App\Invoice;
use App\Mail\ReceiptSubscriptionMail;
use App\Product;
use App\Http\Requests\SubscriptionRequest;
use App\Services\StripeService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;

class SubscriptionController extends Controller
{
    private $stripeService;
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param StripeService $stripeService
     * @param UserService $userService
     */
    public function __construct(StripeService $stripeService, UserService $userService)
    {
        $this->stripeService = $stripeService;
        $this->userService = $userService;
    }

    /**
     * Create user and set subscription
     *
     * @param SubscriptionRequest $request
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function create(SubscriptionRequest $request)
    {
        $data = $request->all();

        // Create Stripe Customer
        // TODO: Catch error and send response to user
        $stripe_customer = $this->stripeService->createCustomer($data);

        // Create Subscription
        $stripe_subscription = $this->stripeService->createSubscription($stripe_customer->id, $data);

        // Create Fancy User        
        $user = $this->userService->createFromStripe($data, $stripe_customer);

        // Create User subscription
        $user->createSubscription($data, $stripe_subscription);

        // Create Invoice for One Time Fee Add-ons
        $addons = Addon::whereIn('code', $data['addons'])->get();

        $addons->each(function ($addon) use ($data, $user) {
            $stripe_invoice = $this->stripeService->createInvoice($addon->cost * 100, $data['email'], $addon->name);
            event(new RegisterInvoiceEvent($user->model(), $addon, $stripe_invoice));
        });

        //Trigger email
        $invoice= app(EmailController::class)->receiptSubscription($stripe_subscription->latest_invoice , $data);
        Mail::to($data['email'])->send(new ReceiptSubscriptionMail($invoice->receipt));

        // Login User and redirect to Dashboard
        Auth::login($user->model());

        return response()->json(['route' => route('admin.dashboard')]);
    }
}
