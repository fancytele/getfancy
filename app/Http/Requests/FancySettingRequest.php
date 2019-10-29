<?php

namespace App\Http\Requests;

use App\Enums\FancyNotificationPeriod;
use App\Enums\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FancySettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(Permission::UPDATE_USER);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notification' => [
                'email' => 'required|email',
                'period' => ['required', Rule::in(FancyNotificationPeriod::getValues())]
            ]
        ];
    }
}
