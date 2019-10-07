<?php

namespace App\Http\Requests;

use App\Enums\Permission;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(Permission::CREATE_USER);
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
            'company_name' => ['required'],
            'company_phone' => ['required'],
            'company_country' => ['required'],
            'company_city' => ['required'],
            'company_state' => ['required'],
            'company_zip_code' => ['required'],
            'company_address1' => ['required'],
            'addons.*' => 'exists:addons,code',
            'product' => ['required', 'string', 'exists:products,slug'],
            'billing_country' => ['required'],
            'billing_city' => ['required'],
            'billing_state' => ['required'],
            'billing_zip_code' => ['required'],
            'billing_address1' => ['required'],
            'stripe_token' => ['required', 'string'],
            'number_type' => ['required'],
            'phone_number' => ['required'],
            'did.reservation' => ['required', 'uuid'],
            'did.number' => ['required']
        ];
    }
}
