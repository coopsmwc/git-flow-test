<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class IsValidCompanyDomain implements Rule
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
        return $this->isValidDomain($value);
    }
    
    public function isValidDomain($value)
    {
        $company = Request::route('company');
        $companyDomains = $company->companyDomains;
        foreach ($companyDomains as $domain) {
            if(strcasecmp($domain->domain, $value) === 0) {
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
        return 'This email address is invalid for use with your organisations licence.';
    }
}
