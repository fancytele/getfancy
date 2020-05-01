<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'notification_email' => 'required|email',
            'notification_period' => ['required'],
            'reason' => 'required_if:ticket_in_progress,true'
        ];
    }
}
