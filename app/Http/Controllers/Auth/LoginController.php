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

    public function authenticated(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'otp'=>'required'
        ]);

        $expire_time = User::select('otp_expire_time')->where('email' , $request->email)->first();

        $expire_time = \DateTime::createFromFormat("Y-m-d H:i:s" , $expire_time->otp_expire_time);

        if(!empty($expire_time) && $expire_time > Carbon::now()){
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'otp' => $request->otp])) {

                $user = Auth::user();

                return redirect(route('admin.dashboard'));
            }
            else{
                return response()->json(['message' => 'Invalid data']);
            }
        }
        else{
            return redirect(route('admin.login.show'));
        }

    }

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
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }
    }
}
