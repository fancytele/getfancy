<?php

namespace App\Http\Controllers\Admin\Users;

use App\Addon;
use App\Address;
use App\Enums\AddonCode;
use App\Enums\FancyNotificationPeriod;
use App\Enums\Role;
use App\Enums\TicketStatus;
use App\Events\RegisterInvoiceEvent;
use App\FancyNumber;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Requests\FancyNumberRequest;
use App\Http\Requests\FancySettingRequest;
use App\Http\Requests\UserRequest;
use App\Mail\ReceiptSubscriptionMail;
use App\Mail\WelcomeMail;
use App\PBXMessage;
use App\Services\DIDService;
use App\Services\FancySettingService;
use App\Services\PhoneSystemService;
use App\Services\StripeService;
use App\Services\UserService;
use App\Subscription;
use App\Ticket;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Spatie\Permission\Models\Role as SpatieRole;
use Stripe\Exception\ApiErrorException;
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
        $this->middleware(['role:admin|agent'])->except(['createFancy', 'storeFancy', 'editFancy', 'updateFancy','editProfile', 'updateProfile','cancelSubscription','getAllPaymentMethods','deletePaymentMethod','updateTwoFactorAuthentication','usersByRole','impersonate','stopImpersonate','addAuthorizedUser','deleteAuthorizedUser','updateDefaultCard','getPhoneSystemsDashboardLink','getDIDSetting','getCallInformation']);
        $this->middleware(['role:user'])->only(['createFancy', 'storeFancy','editProfile', 'updateProfile','cancelSubscription' ,'getAllPaymentMethods','deletePaymentMethod','updateTwoFactorAuthentication' ,'addAuthorizedUser','deleteAuthorizedUser','updateDefaultCard' ,'getPhoneSystemsDashboardLink','getDIDSetting','getCallInformation']);
        $this->middleware(['role:admin|user|agent'])->only(['usersByRole','impersonate','stopImpersonate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function index()
    {
        $users = User::role(Role::USER)->with(['fancy_number', 'agent'])->withTrashed()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function create()
    {
        $did_service = new DIDService();
        $did_country = $did_service->getCountryByISO('UK');
        $did_regions = $did_service->getRegionsByCountry($did_country['id']);

        $addons = Addon::subscription()->orWhere('code', AddonCode::PROFESSIONAL_RECORDING)->get();

        $urls = [
            'fancy_settings' => route('admin.users.edit_fancy', '_user_'),
            'create_user' => route('admin.users.store'),
            'did_cities' => route('admin.dids.cities', '_region_'),
            'dids_availables' => route('admin.dids.availables', '_city_'),
            'did_reservation' => route('admin.dids.create_reservation'),
        ];

        return view('admin.users.create', compact( 'addons', 'did_country', 'did_regions', 'urls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $stripe_service = new StripeService();

        // Create Stripe Customer
        // TODO: Catch error and send response to user
        $stripe_customer = $stripe_service->createCustomer($data);

        // Create Subscription
        // TODO: Catch error to delete Stripe Customer and send response to user
        $stripe_subscription = $stripe_service->createSubscription($stripe_customer->id, $data);

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
        $user->createSubscription($data, $stripe_subscription);

        // Create Invoice for One Time Fee Add-ons
        $addons = Addon::whereIn('code', $data['addons'])->get();

        $addons->each(function ($addon) use ($data, $user, $stripe_service) {
            $stripe_invoice = $stripe_service->createInvoice($addon->cost * 100, $data['email'], $addon->name);
            event(new RegisterInvoiceEvent($user->model(), $addon, $stripe_invoice));
        });

        // Create User Fancy number
        $user->assignFancyNumber($did_data['number'], $data['number_type'], $did_purchase);

        //Create Customer Phone System
        $phone_system_service = new PhoneSystemService();
        $phone_system_service->createCustomer($user->model());

        //Create Customer Session PhoneSystem
        $phone_system_service->createCustomerSession($user->model());

        // Send reset password to new user
        Mail::to($user->model())->send(new WelcomeMail($user->model()));

        //Trigger email
        $invoice= app(EmailController::class)->receiptSubscription($stripe_subscription->latest_invoice , $data);
        Mail::to($data['email'])->send(new ReceiptSubscriptionMail($invoice->receipt));

        // Create Ticket
        $ticket = new Ticket();
        $ticket->fancy_number_id = $user->fancyNumberModel()->id;
        $ticket->status = TicketStatus::PENDING;
        $ticket->save();

        return response()->json(['success' => true, 'user' => $user->model()->id]);
    }

    /**
     * @return Application|Factory|RedirectResponse|View
     */
    public function createFancy()
    {
        if (Auth::user()->fancy_number) {
            return redirect()->route('admin.dashboard');
        }

        $did_service = new DIDService();
        $did_country = $did_service->getCountryByISO('UK');
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
     * @param FancyNumberRequest $request
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

        //Create Customer Phone System
        $phone_system_service = new PhoneSystemService();
        $phone_system_service->createCustomer($request->user());

        //Create Customer Session PhoneSystem
        $phone_system_service->createCustomerSession($request->user());

        // Create Ticket
        $ticket = new Ticket();
        $ticket->fancy_number_id = $user_service->fancyNumberModel()->id;
        $ticket->status = TicketStatus::PENDING;
        $ticket->save();

        return response()->json(['success' => true, 'user' => $request->user()->id]);
    }

    /**
     *  Show the form for editing the specified resource.
     * @param Request $request
     * @param User $user
     * @return Application|Factory|RedirectResponse|View
     */
    public function editFancy(Request $request, User $user)
    {
        if (is_null($user->fancy_number)) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'icon' => 'alert-circle',
                'message' => 'User doesn\'t have a Fancyy Number'
            ]);
        }

        $addon = Addon::where('code', AddonCode::PROFESSIONAL_RECORDING)->first();

        $data = [
            'user' => $user,
            'has_professional_recording' => $user->hasBoughtAddon($addon->id),
            'professional_recording_price' => $addon->cost,
            'settings' => (new FancySettingService($user))->getSettingsToEdit(),
            'notification_periods' => FancyNotificationPeriod::getValues(),
            'messages' => PBXMessage::get(['id', 'message', 'type'])->groupBy('type')->toArray(),
            'allow_upload_audio' => $request->user()->hasRole(Role::USER)
        ];

        return view('admin.users.edit-fancy', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param FancySettingRequest $request
     * @param User $user
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function usersByRole(string $role)
    {
        if(auth()->user()->hasRole(Role::USER))
        {
            $authorized_users = User::where('authorized_user_id_1' , '=', auth()->user()->id)
                ->orWhere('authorized_user_id_1' , '=',  auth()->user()->id)
                ->orWhere('authorized_user_id_1' , '=',  auth()->user()->id)
                ->simplePaginate(5);

            $authorized_users->setPath('');

            return response()->json($authorized_users);


        }
       else{
           $users = SpatieRole::findByName($role)
               ->users()
               ->select(['id', 'first_name', 'last_name'])
               ->orderBy('first_name')
               ->simplePaginate(5);

           $users->setPath('');

           return response()->json($users);
       }

    }


    /**
     * Impersonate user
     * @param $id
     * @return RedirectResponse
     */

    public function impersonate($id)
    {
        $user_to_personify = User::find($id);

        if (Auth::user()->hasRole(Role::ADMIN) OR Auth::user()->hasRole(Role::USER) && $user_to_personify->hasRole(Role::ADMIN) === false) {
            Auth::user()->setImpersonating($user_to_personify->id);
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Stop Impersonate user
     *
     * @return RedirectResponse
     */
    public function stopImpersonate()
    {
        Auth::user()->stopImpersonating();

        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param User $user
     * @return Application|Factory|JsonResponse|View
     */

    public function editProfile(Request $request, User $user)
    {
        if($request->wantsJson())
        {
            $billing_information = Address::where('user_id' , '=' , $user->id)
                ->where('type' , '=' , 'billing')->first();

            $subscription = Subscription::where('user_id', '=', $user->id)->pluck('id')->first();

            $authorized_users = User::where('id' , '=', $user->authorized_user_id_1)
                ->orWhere('id' , '=', $user->authorized_user_id_2)
                ->orWhere('id' , '=', $user->authorized_user_id_3)
                ->get();

            return response()->json(["user" =>$user,
                "billing_information" => $billing_information,
                'subscription' =>$subscription,
                'authorized_users' => $authorized_users
            ] , 200);
        }
        else{
            return view ('admin.users.edit-user', array('user' => $user));
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateProfile(Request $request, User $user)
    {
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $user_service = new UserService();

        $user = $user_service->updateProfile($data, $user);

        if($user->status() == 422)
        {
            return response()->json($user , 422);
        }
        if($user->status() == 401){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        else{
            return response()->json($user , 200);
        }
    }

    /**
     * Update Two Factor Authentication
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateTwoFactorAuthentication(Request $request, User $user){

        $data = $request->all();

        if($data['is_twoFactorAuthentication'] == false){
            $user->is_twoFactorAuthentication = 0;
            $user->save();
        }
        if($data['is_twoFactorAuthentication'] == true){
            $user->is_twoFactorAuthentication = 1;
            $user->save();
        }

        return response()->json($user);
    }
    /**
     * Cancel Subscription
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function cancelSubscription(Request $request, User $user){

        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $subscription_id = Subscription::where('user_id' , '=' , auth()->user()->id)->pluck('stripe_id')->first();

        if(!$subscription_id)
        {
            return response()->json(['data'=>['errors' => ['message' => 'No Subscription']]],404);
        }

        $user_service = new UserService();

        //Cancel Subscription
        $user_service->cancelSubscription();

        $fancyNumber_id = FancyNumber::where('user_id' , auth()->user()->id)->pluck('id')->first();

        // Update Ticket
        $ticket = Ticket::where('fancy_number_id' ,'=' ,  $fancyNumber_id)->first();
        $ticket->status = TicketStatus::CANCELED;
        $ticket->save();

        //Cancel Stripe Subscription
        $stripe_service = new StripeService();
        $cancel_subscription= $stripe_service->cancelSubscription($subscription_id);

        return response()->json($cancel_subscription);
    }

    /**
     * To fetch all payment methods
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
   public function getAllPaymentMethods(Request $request, User $user){
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        if($user->stripe_id){
            $stripe_service = new StripeService();
            $all_payment_method= $stripe_service->getAllPaymentMethods();
            return response()->json($all_payment_method);
        }
        else{
            return response()->json('There is no payment method' , 204);
        }
    }


    /**
     * Delete payment method, where as default card can't be deleted
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function deletePaymentMethod(Request $request, User $user){
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $stripe_service = new StripeService();

        $delete_payment_method = $stripe_service->deletePaymentMethod($data);

        return response()->json($delete_payment_method);
    }

    /**
     * Add Authorised User
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function addAuthorizedUser(Request $request, User $user){
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $user_service = new UserService();

        $user = $user_service->addAuthorizedUser($data, $user);

        if($user->status() == 422)
        {
            return response()->json($user , 422);
        }
        else{
            return response()->json($user , 200);
        }
    }

    /**
     * Delete Authorised User
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function deleteAuthorizedUser(Request $request, User $user){

        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $user_service = new UserService();

        $user = $user_service->deleteAuthorizedUser($data, $user);

        return response()->json($user , 200);
    }

    /**
     * Update Default Card
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateDefaultCard(Request $request, User $user)
    {
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        $data = $request->all();

        $stripe_service = new StripeService();

        $update_default_card = $stripe_service->updateDefaultCard($data);

        return response()->json($update_default_card);
    }

    //Milestone 3

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function getPhoneSystemsDashboardLink(Request $request, User $user){
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }

        //Create Customer Session PhoneSystem
        $phone_system_service = new PhoneSystemService();
        $phone_system_link = $phone_system_service->createCustomerSession(auth()->user());

        if($phone_system_link->getStatusCode() == 200){
            $link = FancyNumber::where('user_id', '=', auth()->user()->id)->pluck('dashboard_link_phone_system')->first();
            return response()->json(['link' => $link],200);
        }
        else{
            return response()->json(['message' => "Something went wrong. Please try again later"] , 401);
        }
    }

    public function getCallInformation(Request $request, User $user){
        if ($request->user()->hasRole(Role::USER) && $request->user()->id != $user->id) {
            return response()->json('Cannot update other User information', Response::HTTP_FORBIDDEN);
        }
        $user_service = (new UserService(Auth::user()))->callInformation();

        return view('admin.users.call-information' , $user_service);
    }

}