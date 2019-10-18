<?php

namespace App\Http\Controllers\Admin\Users;

use App\Addon;
use App\Enums\Role;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\WelcomeMail;
use App\Product;
use App\Services\DIDService;
use App\Services\StripeService;
use App\Services\UserService;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
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
        $users = User::role(Role::User)->withTrashed()->get();

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
     * @param  \App\Http\Requests\UserRequest  $request
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
        $user->assignFancyNumber($did_data['id'], $did_data['number'], $data['number_type'], $did_purchase);

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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editFancy(User $user)
    {
        return view('admin.users.edit-fancy', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
