<?php

namespace App\Rules;

use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\Rule;

class ValidEmployeeCredentials implements Rule
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
        $company = Request::route('company');
        if ($value['passkey'] === $company->employee_register_passkey) {
                return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your registration passcode has not been recognized.';
    }
}
