<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Company;
use Illuminate\Support\Facades\Request;

class IsValidCompanyEmailAddress implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isValidEmail($value);
    }
    
    public function isValidEmail($value)
    {
        $company = Request::route('company');
        $companyEmails = $company->companyEmails;
        foreach ($companyEmails as $email) {
            if(strcasecmp($email->email, $value) === 0) {
                return true;
            }
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
        return 'You have entered an invalid email.';
    }
}
