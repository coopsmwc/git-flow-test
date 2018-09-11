<?php

namespace App\Http\Controllers\Auth\Company;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class LoginController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
        parent::__construct($request);
    }

    /**
     * Show company login form.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request, Company $company)
    {
        if (Auth::user()) {
            Auth::logout();
        }
        $request->session()->put('company', $company);

        return view('auth.company.mps-company-login', ['stub' => $company->stub, 'company' => $company]);
    }

    public function login(Request $request, Company $company)
    {
        $this->validateLogin($request, $company);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request, $company);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \App\User
     */
    protected function validateLogin(Request $request, Company $company)
    {
        $companyUser = User::where('email', $request->input('email'))
            ->join('company_admins', function ($join) use ($company) {
                $join->on('users.id', '=', 'company_admins.user_id')
                 ->where('company_admins.company_id', '=', $company->id);
            })
            ->first();

        $request->request->add(['id' => $companyUser ? $companyUser->user_id : 0]);
        $this->validate($request, [
            $this->username() => 'required|string',
            'password'        => 'required|string',
            'id'              => 'exists:users',
        ],
            ['exists' => 'These credentials do not match our records.']
        );
    }

    /**
     * Send login response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \App\User
     */
    protected function sendLoginResponse(Request $request, Company $company)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        $request->session()->put('company', $company); // add company to session
        
        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->route('company-admin-home',
            [$company->stub]);
    }

    /**
     * Perform logout.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \App\User
     */
    public function logout(Request $request, Company $company)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect("/{$company->stub}");
    }
}
