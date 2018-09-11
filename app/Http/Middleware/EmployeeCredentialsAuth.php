<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmployeeCredentialsAuth
{
    /**
     * Handle an incoming request to ensure there is an active company licence.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return redirect()->route('company-logout', [$request->route('company')]);
        }

        $company = $request->route('company');
        
        if (!$company) {
            abort(404);
        }
        // Company must be active
        if ($company->status !== 'ACTIVE' || $company->licence_status !== 'ACTIVE') {
            abort(404);
        }
        // Must be between licence dates
        if ($company->licence_start_date && 
            (time() < $company->getLicenceStartDateTimestamp() || time() > $company->getLicenceEndDateTimestamp())) 
        {
            abort(404);
        }

        return $next($request);
    }
}
