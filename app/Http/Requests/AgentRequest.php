<?php

namespace App\Http\Requests;

use App\Enums\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->agent) {
            return $this->user()->can(Permission::UPDATE_AGENT);
        }

        return $this->user()->can(Permission::CREATE_AGENT);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $unique_email = Rule::unique('users');

        if ($this->agent) {
            $unique_email->ignore($this->agent);
        }

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', $unique_email]
        ];
    }
}
