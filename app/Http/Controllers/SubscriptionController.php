<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Create user and set subscription
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function create(SubscriptionRequest $request)
    {
        $plan = Plan::whereSlug($request->checkout_plan)->first();

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->newSubscription($plan->slug, $plan->stripe_plan)
            ->create($request->stripe_token, [
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'address' => [
                    'line1' => $request->address,
                    'city' => $request->city,
                    'country' => $request->country,
                    'postal_code' => $request->zip_code
                ],
                'metadata' => [
                    'professional_recordings' => true,
                    'multi_ring' => false,
                    'fraud_alert' => true,
                    'call_blocker' => false,
                    'additional_number' => false
                ]
            ]);

        $credentials = $user->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
    }
}
