<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCodeVerificationEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
   /* function authenticated(Request $request, $user)
    {
        $user->update(['last_login' => Carbon::now()->toDateTimeString()]);
    } */

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws ValidationException
     * First it checks if user two factor authentication is on or not if on then,
     * it checks the two factor code is not expired and not null then,
     * it checks if the two factor code matches with the database or not if yes,
     * authenticate the user with email, password if authenticated redirect the user to dashboard
     * else return back with input and error message on the login page itself.
     * if two factor code does not matches it throws an error message.
     * if the otp is expired is send it back to login page where getOTP() generates the two factor code.
     * if two factor authentication is off it authenticated the user and redirect to dashboard.
     */
    public function authenticated(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $two_factor_code_details = User::select('two_factor_code_expire_time' , 'two_factor_code','is_twoFactorAuthentication')->where('email' , $request->email)->first();

        if($two_factor_code_details)
        {
            if($two_factor_code_details->is_twoFactorAuthentication == 1)
            {
                if($request->two_factor_code != null){
                    $expire_time = \DateTime::createFromFormat("Y-m-d H:i:s" , $two_factor_code_details->two_factor_code_expire_time);
                    if(!empty($expire_time) && $expire_time > Carbon::now())
                    {
                        if($two_factor_code_details->two_factor_code== $request->two_factor_code)
                        {
                            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                            {

                                return redirect(route('admin.dashboard'));
                            }
                            else{
                                return back()->withInput()->with('credentialErrorMessage','These credentials do not match our records.');
                            }
                        }

                        else{
                            return back()->withInput()->with('twoFactorCodeErrorMessage','Two factor code is invalid');
                        }
                    }
                    else{
                        return back()->withInput()->with('twoFactorCodeExpiredErrorMessage','Two factor code is expired.');
                    }
                }
                else{
                    return back()->withInput()->with('TwoFactorCodeEmpty','Please provide some input.');
                }
            }
            else{
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                    return redirect(route('admin.dashboard'));
                }
                else{
                    return back()->withInput()->with('credentialErrorMessage','These credentials do not match our records.');
                }
            }
        }
       else{
           return back()->withInput()->with('InvalidEmailErrorMessage','These credentials do not match our records.');
       }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * if two factor authentication is on, it will generate two factor authentication code.
     * else it will authenticate the user and return user object with status code 202 and in blade file it will automatically press the submit button,
     * then, it will go to authenticated() and, again authenticate the user and redirect the user to the dashboard.
     */
    public function generateTwoFactorCode(Request $request)
    {
        $two_factor_code = mt_rand(100000,999999);

        $expire_time = Carbon::now()->addMinutes(10);

        $user= User::where('email' ,'=', $request->email)->first();

        if($user)
        {
            if($user->is_twoFactorAuthentication == 1)
            {
                if(Hash::check($request->password , $user->password))
                {
                    $user->two_factor_code = $two_factor_code ;

                    $user->two_factor_code_expire_time = $expire_time;

                    $user->save();

                    try{
                        Mail::to($user->email)->send(new TwoFactorCodeVerificationEmail($user, $two_factor_code ));
                    }
                    catch (\Exception $e){
                        return response()->json($e->getMessage(),500);
                    }
                }
                else{
                    return response()->json('These credentials do not match our records.',401);
                }
            }
            else{
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                    return response()->json($user , 202);
                }
                else{
                    return response()->json('These credentials do not match our records.',401);
                }
            }

        }
        else{
            return response()->json('These credentials do not match our records.',401);
        }

    }
}
