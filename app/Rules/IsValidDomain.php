<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\RestrictedDomain;

class IsValidDomain implements Rule
{
    
    public $restrictedDomains;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->restrictedDomains = RestrictedDomain::all();

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
        return $this->isValidDomain($value);
    }
    
    public function isValidDomain($value)
    {
        foreach ($this->restrictedDomains as $restricted) {
            if (preg_match('/^'.$restricted->domain.'/i', $value)) {
                return false;
            }
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
        return 'You have entered an invalid email domain.';
    }
}
