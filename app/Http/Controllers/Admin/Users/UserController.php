<?php

namespace App\Http\Controllers\Admin\Users;

use App\Addon;
use App\Enums\FancyAudioType;
use App\Enums\FancyNotificationPeriod;
use App\Enums\Role;
use App\Enums\TicketStatus;
use App\FancySetting;
use App\Http\Controllers\Controller;
use App\Http\Requests\FancySettingRequest;
use App\Http\Requests\UserRequest;
use App\Mail\WelcomeMail;
use App\PBXMessage;
use App\Product;
use App\Services\DIDService;
use App\Services\StripeService;
use App\Services\UserService;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|agent']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::role(Role::USER)->withTrashed()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $did_service = new DIDService();
        $did_country = $did_service->getCountryByISO('US');
        $did_regions = $did_service->getRegionsByCountry($did_country['id']);

        $products = Product::all();
        $addons = Addon::subscription()->get();

        $urls = [
            'user_list' => route('admin.users.index'),
            'create_user' => route('admin.users.store'),
            'did_cities' => route('admin.dids.cities', '_region_'),
            'dids_availables' => route('admin.dids.availables', '_city_'),
            'did_reservation' => route('admin.dids.create_reservation'),
        ];

        return view('admin.users.create', compact('products', 'addons', 'did_country', 'did_regions', 'urls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $stripe_service = new StripeService();

        // Find product by slug
        $product = Product::whereSlug($data['product'])->first();

        // Get Stripe Product by Name
        $stripe_product = $stripe_service->getProductByName($product->name);

        // Get all product Plans (base and features)
        $stripe_plans = $stripe_service->getProductPlansByNames(
            $stripe_product->id,
            Arr::prepend($data['addons'], $product->name)
        );

        $plans = $stripe_plans->map(function ($item) {
            return ['plan' => $item->id];
        })->toArray();

        // Create Stripe Customer
        // TODO: Catch error and send response to user
        $stripe_customer = $stripe_service->createCustomer($data);

        // Create Subscription
        // TODO: Catch error to delete Stripe Customer and send response to user
        $stripe_subscription = $stripe_service->createSubscription($stripe_customer->id, $plans);

        // Purchase Reserved DID
        $did_data = $data['did'];

        // TODO: Catch error to delete Stripe Customer and Subscription and send response to user
        $did_service = new DIDService();
        $did_purchase = $did_service->purchaseReservation($did_data['reservation']);

        \Log::info(print_r($did_purchase, true));

        // Create Fancy User        
        $user_service = new UserService();
        $user = $user_service->createFromStripe($data, $stripe_customer);

        // Create User subscription
        $user->createSubscription($product->id, $stripe_product->id, $stripe_subscription);

        // Create User Fancy number
        $user->assignFancyNumber($did_data['number'], $data['number_type'], $did_purchase);

        // Send reset password to new user
        Mail::to($user->model())->send(new WelcomeMail($user->model()));

        // Create Ticket
        $ticket = new Ticket();
        $ticket->fancy_number_id = $user->fancyNumberModel()->id;
        $ticket->status = TicketStatus::PENDING;

        $ticket->save();

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function editFancy(User $user)
    {
        if (is_null($user->fancy_number)) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'icon' => 'alert-circle',
                'message' => 'User doesn\'t have a Fancy Number'
            ]);
        }

        $settings = collect([]);

        if ($user->fancy_setting) {
            $settings['business_hours'] = optional($user->fancy_setting)->business_hours;
            $settings['downtime_hours'] = optional($user->fancy_setting)->downtime_hours;

            $settings['notification'] = [
                'email' => optional($user->fancy_setting)->email_notification,
                'period' => optional($user->fancy_setting)->period_notification
            ];

            $settings['pbx'] = [
                'business' => optional($user->fancy_setting)->business_message_id,
                'business_text' => optional($user->fancy_setting)->business_custom_message,
                'downtime' => optional($user->fancy_setting)->downtime_message_id,
                'downtime_text' => optional($user->fancy_setting)->downtime_custom_message,
                'onhold' => optional($user->fancy_setting)->onhold_message_id,
                'onhold_text' => optional($user->fancy_setting)->onhold_custom_message
            ];

            $settings['extensions'] = optional($user->fancy_setting)->extensions ?? [];

            $settings['audio'] = [
                'type' => optional($user->fancy_setting)->audio_type ?? FancyAudioType::PREDEFINED,
                'buy_professional' => optional($user->fancy_setting)->audio_type === FancyAudioType::PROFESSIONAL
            ];
        }

        $notification_periods = FancyNotificationPeriod::getValues();
        $messages = PBXMessage::get(['id', 'message', 'type'])->groupBy('type')->toArray();

        return view('admin.users.edit-fancy', compact('user', 'settings', 'notification_periods', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\FancySettingRequest $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function updateFancy(FancySettingRequest $request, User $user)
    {
        $fancy_number = $user->fancy_number;
        $ticket = $fancy_number->ticket;

        $setting = FancySetting::firstOrNew(['fancy_number_id' => $fancy_number->id]);

        if ($setting->exists && $ticket->inProgress()) {
            $new_ticket = $ticket->replicate();
            $new_ticket->parent_id = $ticket->id;
            $new_ticket->save();

            $ticket->reason = $request->input('reason');
            $ticket->reason_by = $request->user()->id;
            $ticket->delete();
        }

        // Business Hours
        $setting->business_hours = $request->input('business_hours');

        // Downtime Hours
        $setting->downtime_hours = $request->input('downtime_hours');

        //  Notification
        $setting->email_notification = (string) $request->input('notification.email');
        $setting->period_notification = (string) $request->input('notification.period');

        // PBX
        $setting->business_message_id = $request->input('business_id');

        if (is_null($setting->business_message_id) && $request->has('business_text')) {
            $setting->business_custom_message = $request->input('business_text');
        } else {
            $setting->business_custom_message = null;
        }

        $setting->downtime_message_id = $request->input('downtime_id');

        if (is_null($setting->downtime_message_id) && $request->has('downtime_text')) {
            $setting->downtime_custom_message = $request->input('downtime_text');
        } else {
            $setting->downtime_custom_message = null;
        }

        $setting->onhold_message_id = $request->input('onhold_id');

        if (is_null($setting->onhold_message_id) && $request->has('onhold_text')) {
            $setting->onhold_custom_message = $request->input('onhold_text');
        } else {
            $setting->onhold_custom_message = null;
        }

        // Extensions
        $setting->extensions = $request->input('extensions');

        // Audio
        $setting->audio_type = $request->input('audio_type');

        if ($request->input('audio_type') === FancyAudioType::PROFESSIONAL) {
            // TODO: Verify if user already bought it. If not: set payment to be executed in 30 days.
        }

        $fancy_number->settings()->save($setting);

        return response()->json(['message' => 'success', 'data' => $setting]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
