<?php

namespace App\Http\Requests;

use App\Rules\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_confirmation' => ['same:email'],
            'password' => ['required', 'string', 'min:8', new StrongPassword],
            'password_confirmation' => ['same:password'],
            'company_name' => ['required'],
            'company_phone' => ['required'],
            'company_country' => ['required'],
            'company_city' => ['required'],
            'company_state' => ['required'],
            'company_zip_code' => ['required'],
            'company_address1' => ['required'],
            'addons.*' => 'exists:addons,code',
            'billing_country' => ['required'],
            'billing_city' => ['required'],
            'billing_state' => ['required'],
            'billing_zip_code' => ['required'],
            'billing_address1' => ['required'],
            'checkout_product' => ['required', 'string', 'exists:products,slug'],
            'stripe_token' => ['required', 'string'],
            'recaptcha' => ['required', 'recaptcha']
        ];
    }
}
