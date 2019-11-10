<?php

namespace App\Http\Requests;

use App\Enums\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OperatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->operator) {
            return $this->user()->can(Permission::UPDATE_OPERATOR);
        }

        return $this->user()->can(Permission::CREATE_OPERATOR);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $unique_email = Rule::unique('users');

        if ($this->operator) {
            $unique_email->ignore($this->operator);
        }

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'email', $unique_email]
        ];
    }
}
