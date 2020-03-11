<?php

namespace App\Http\Controllers\Admin\Users;

use App\Addon;
use App\Enums\AddonCode;
use App\Enums\FancyNotificationPeriod;
use App\Enums\Role;
use App\Enums\TicketStatus;
use App\Events\RegisterInvoiceEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\FancyNumberRequest;
use App\Http\Requests\FancySettingRequest;
use App\Http\Requests\UserRequest;
use App\Mail\WelcomeMail;
use App\PBXMessage;
use App\Product;
use App\Services\DIDService;
use App\Services\FancySettingService;
use App\Services\StripeService;
use App\Services\UserService;
use App\Ticket;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:admin|agent'])->except(['createFancy', 'storeFancy', 'editFancy', 'updateFancy']);
        $this->middleware(['role:user'])->only(['createFancy', 'storeFancy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::role(Role::USER)->with('fancy_number')->withTrashed()->get();

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
        $addons = Addon::subscription()->orWhere('code', AddonCode::PROFESSIONAL_RECORDING)->get();

        $urls = [
            'fancy_settings' => route('admin.users.edit_fancy', '_user_'),
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
     * @throws \Stripe\Error\Api
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $stripe_service = new StripeService();

        // Find product by slug
        $product = Product::whereSlug($data['product'])->first();

        // Get Stripe Product by Name
        $stripe_product = $stripe_service->getProductByName($product->name);

        // Get all product Plans (base and subscription add-ons)
        $stripe_plans = $stripe_service->getProductPlansByNames($stripe_product->id, [$product->name]);

        $stripe_plans_id = $stripe_plans->map(function ($item) {
            return ['plan' => $item->id];
        })->toArray();

        // Create Stripe Customer
        // TODO: Catch error and send response to user
        $stripe_customer = $stripe_service->createCustomer($data);

        // Create Subscription
        // TODO: Catch error to delete Stripe Customer and send response to user
        $stripe_subscription = $stripe_service->createSubscription($stripe_customer->id, $stripe_plans_id);

        // Purchase Reserved DID
        $did_data = $data['did'];

        // TODO: Catch error to delete Stripe Customer and Subscription and send response to user
        $did_service = new DIDService();

        try {
            $did_purchase = $did_service->purchaseReservation($did_data['reservation'], $did_data['number']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        };

        Log::info(print_r($did_purchase, true));

        // Create Fancy User        
        $user_service = new UserService();
        $user = $user_service->createFromStripe($data, $stripe_customer);

        // Create User subscription
        $user->createSubscription($product->id, $stripe_product->id, $stripe_subscription);

        // Create Invoice for One Time Fee Add-ons
        $addons = Addon::whereIn('code', $data['addons'])->get();

        $addons->each(function ($addon) use ($data, $user, $stripe_service) {
            $stripe_invoice = $stripe_service->createInvoice($addon->cost * 100, $data['email'], $addon->name);
            event(new RegisterInvoiceEvent($user->model(), $addon, $stripe_invoice));
        });

        // Create User Fancy number
        $user->assignFancyNumber($did_data['number'], $data['number_type'], $did_purchase);

        // Send reset password to new user
        Mail::to($user->model())->send(new WelcomeMail($user->model()));

        // Create Ticket
        $ticket = new Ticket();
        $ticket->fancy_number_id = $user->fancyNumberModel()->id;
        $ticket->status = TicketStatus::PENDING;
        $ticket->save();

        return response()->json(['success' => true, 'user' => $user->model()->id]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function createFancy()
    {
        if (Auth::user()->fancy_number) {
            return redirect()->route('admin.dashboard');
        }

        $did_service = new DIDService();
        $did_country = $did_service->getCountryByISO('US');
        $did_regions = $did_service->getRegionsByCountry($did_country['id']);

        $urls = [
            'create_fancy' => route('admin.users.store_fancy'),
            'fancy_settings' => route('admin.users.edit_fancy', '_user_'),
            'did_cities' => route('admin.dids.cities', '_region_'),
            'dids_availables' => route('admin.dids.availables', '_city_'),
            'did_reservation' => route('admin.dids.create_reservation'),
        ];

        return view('admin.users.create-fancy', compact('did_country', 'did_regions', 'urls'));
    }

    /**
     * Store a new Fancy Number
     *
     * @param \App\Http\Requests\FancyNumberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeFancy(FancyNumberRequest $request)
    {
        $did_service = new DIDService();
        $did_purchase = $did_service->purchaseAvailableDID($request->input('data.did.id', ''));

        // Create User Fancy number
        $user_service = new UserService($request->user());
        $user_service->assignFancyNumber($did_purchase['number'], $request->input('number_type'), $did_purchase);

        $request->user()->update(['phone_number' => $request->input('phone_number')]);

        // Create Ticket
        $ticket = new Ticket();
        $ticket->fancy_number_id = $user_service->fancyNumberModel()->id;
        $ticket->status = TicketStatus::PENDING;
        $ticket->save();

        return response()->json(['success' => true, 'user' => $request->user()->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function editFancy(Request $request, User $user)
    {
        if (is_null($user->fancy_number)) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'icon' => 'alert-circle',
                'message' => 'User doesn\'t have a Fancy Number'
            ]);
        }

        $addon = Addon::where('code', AddonCode::PROFESSIONAL_RECORDING)->first();

        $data = [
            'user' => $user,
            'has_professional_recording' => $user->hasBoughtAddon($addon->id),
            'settings' => (new FancySettingService($user))->getSettingsToEdit(),
            'notification_periods' => FancyNotificationPeriod::getValues(),
            'messages' => PBXMessage::get(['id', 'message', 'type'])->groupBy('type')->toArray(),
            'allow_upload_audio' => $request->user()->hasRole(Role::USER)
        ];

        return view('admin.users.edit-fancy', $data);
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
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        (new FancySettingService($user))->SaveSetting($request);

        if ($request->user()->hasRole(Role::USER)) {
            return response()->json([
                'text' => 'Go to Dashboard',
                'url' => route('admin.dashboard')
            ]);
        }

        return response()->json([
            'text' => 'Return to User list',
            'url' => route('admin.users.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function usersByRole(string $role)
    {
        $users = SpatieRole::findByName($role)
            ->users()
            ->select(['id', 'first_name', 'last_name'])
            ->orderBy('first_name')
            ->simplePaginate(5);

        $users->setPath('');

        return response()->json($users);
    }

    /**
     * Impersonate user
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        $user_to_personify = User::find($id);

        if (Auth::user()->hasRole(Role::ADMIN) && $user_to_personify->hasRole(Role::ADMIN) === false) {
            Auth::user()->setImpersonating($user_to_personify->id);
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Stop Impersonate user
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        return redirect()->back();
    }
}
