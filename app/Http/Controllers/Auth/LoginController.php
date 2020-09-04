<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerificationEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     * First, it checks the otp is not expired and not null then,
     * authenticate the user with email, password and OTP if authenticated redirect the user to dashboard
     * else return back with input and error message on the login page itself.
     * if the otp is expired is send it back to login page where getOTP() generates the otp.
     */
    public function authenticated(Request $request)  //TODO: error messages, description, language translation
    {

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'otp'=>'required'
        ]);

        $otpDetails = User::select('otp_expire_time' , 'otp')->where('email' , $request->email)->first();

        $expire_time = \DateTime::createFromFormat("Y-m-d H:i:s" , $otpDetails->otp_expire_time);

        if(!empty($expire_time) && $expire_time > Carbon::now())
        {
            if($otpDetails->otp == $request->otp)
            {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

                    return redirect(route('admin.dashboard'));
                }
                else{
                    return back()->withInput()->with('credentialErrorMessage','These credentials do not match our records.');
                }
            }

            else{
                return back()->withInput()->with('otpErrorMessage','Otp is invalid');
            }
        }
        else{
            return back()->withInput()->with('otpExpiredErrorMessage','OTP is expired.');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * checks the user credentials if the user is a valid user then it generates OTP
     * else throws an error message
     */
    public function sendOtp(Request $request)
    {
        $otp = mt_rand(1000,9999);

        $expire_time = Carbon::now()->addMinutes(10);

        $user= User::where('email' ,'=', $request->email)->first();

            if(Hash::check($request->password , $user->password))
            {
                $user->otp = $otp;

                $user->otp_expire_time = $expire_time;

                $user->save();

                Mail::to($user->email)->send(new OtpVerificationEmail($user, $otp));
            }
            else{
                return response()->json('These credentials do not match our records.',401);
            }

    }
}
