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
            'notification.email' => 'required|email',
            'notification.period' => ['required', Rule::in(FancyNotificationPeriod::getValues())],
            'reason' => 'required_if:ticket_in_progress,true'
        ];
    }
}
