<?php
/* 
 * Global helpers.
 * 
 * Checks if the user is logged in, has company in the route and is
 * a organisation HR user
 */
if (! function_exists('isCompanyUser')) {
    function isCompanyUser() {
        if (Auth::user()) {
            if (session()->has('company') && Auth::user()->type === 2) {
                return true;
            }
        }
        return false;
    }
}

