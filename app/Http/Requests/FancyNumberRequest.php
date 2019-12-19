<?php

namespace App\Http\Requests;

use App\Enums\DIDNumberType;
use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FancyNumberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole(Role::USER);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required',
            'number_type' => ['required', Rule::in(DIDNumberType::getValues())],
            'did.id' => ['uuid', Rule::requiredIf($this->input('number_type') === DIDNumberType::FANCY)],
            'did.number' => [Rule::requiredIf($this->input('number_type') === DIDNumberType::FANCY)]
        ];
    }
}
