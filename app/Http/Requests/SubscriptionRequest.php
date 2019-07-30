<?php

namespace App\Http\Requests;

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
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['same:password'],
            'country' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required'],
            'address' => ['required', 'string'],
            'addons.*' => 'exists:addons,code',
            'checkout_product' => ['required', 'string', 'exists:products,slug'],
            'stripe_token' => ['required', 'string']
        ];
    }
}
