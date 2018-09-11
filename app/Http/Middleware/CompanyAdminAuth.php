<?php

namespace App\Http\Middleware;

use Closure;
use App\CompanyAdmin;
use App\User;
use Illuminate\Support\Facades\Auth;


class CompanyAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $company = $request->route('company');
        
        if (!$company) {
            abort(404);
        }
        
        if (!Auth::user()) {
            return redirect()->route('company-admin-login', [$request->route('company')]);
        }

        $companyAdminUser = User::where('email', Auth::user()->email)
            ->join('company_admins', function ($join) use ($company) {
                $join->on('users.id', '=', 'company_admins.user_id')
                 ->where('company_admins.company_id', '=', $company->id);
            })
            ->first();
            
        if (!$companyAdminUser) {
            Auth::logout();
            return redirect()->route('company-admin-login', [$request->route('company')]);
        }
        return $next($request);
    }
}
