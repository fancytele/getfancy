<?php

namespace App\Rules;

use App\Enums\Role;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class UnauthorisedEmail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email', '=' , $value)->first();
        return !$user->hasRole(Role::ADMIN);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected :attribute is not accessible';
    }
}
