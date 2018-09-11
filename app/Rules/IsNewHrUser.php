<?php

namespace App\Rules;

use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Validation\Rule;
use App\User;

class IsNewHrUser implements Rule
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
        if (User::where('email', $value)
            ->join('company_admins', function ($join) {
                $join->on('users.id', '=', 'company_admins.user_id')
                 ->where('company_admins.company_id', '=', Request::route('company')->id);
            })
            ->first()) {
                return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email address is already in use for this organisation.';
    }
}
