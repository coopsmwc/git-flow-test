<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Rules\IsValidCompanyDomain;
use App\Services\Facades\MPSBackend;
use GuzzleHttp\Client as GuzzleClient;
use App\Rules\ValidEmployeeCredentials;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Show the employee login form.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        // Set your own Google Recaptcha site key for testing in the .env file
        $googleRecapchtaSiteKey = env('APP_DEBUG',
            false) ? env('GOOGLE_RECAPTCHA_SITE_KEY_TEST') : env('GOOGLE_RECAPTCHA_SITE_KEY');

        return view('mmlayouts.view.employee.credentials',
            ['googleRecapchtaSiteKey' => $googleRecapchtaSiteKey, 'company' => $company]);
    }

    /**
     * Validates that the recaptcha response is correct and that the
     * organisations login credentials are correct. Then redirects to App
     * register page.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function credentials(Request $request, Company $company)
    {
        if ( ! $request->input('g-recaptcha-response')) {
            return redirect()->back()->with("error",
                "Please check the \"I'm not a robot\" box before clicking submit.");
        }

        // Set your own Google Recaptcha secret key for testing in the .env file
        $params = [
            'form_params' =>
                [
                    'secret'   => env('APP_DEBUG',
                        false) ? env('GOOGLE_RECAPTCHA_SECRET_TEST') : env('GOOGLE_RECAPTCHA_SECRET'),
                    'response' => $request->input('g-recaptcha-response'),
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                ]
        ];

        $guzzleClient = new GuzzleClient;
        $response = $guzzleClient->request('POST', "https://www.google.com/recaptcha/api/siteverify", $params);
        $response = json_decode($response->getBody()->getContents(), true);
        if ( ! $response['success']) {
            return redirect()->back()->with("error", "Your request has been rejected. Please try again.");
        }

        $request->request->add([
            'credentials' => [
                'passkey' => $request->input('passkey')
            ]
        ]);
        Validator::make($request->all(), [
            'credentials' => [
                new ValidEmployeeCredentials
            ]
        ])->validate();

        // set to authenticate employee
        $request->session()->put('employee_auth', true);

        return redirect()->route('mps-employee-register', [$company->stub]);
    }

    /**
     * Show employee registration form.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function mpsShowRegisterForm(Request $request, Company $company)
    {
        // MPSAP-618 - check authenticated
        if ( ! $request->session()->get('employee_auth')) {
            return redirect()->route('employee-register', [$company->stub]);
        }

        return view('mmlayouts.view.employee.employee-account',
            [
                'company' => $company,
                'obj'     => $company,
            ]
        );
    }

    /**
     * Process employee registration form.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function mpsEmployeeRegister(Request $request, Company $company)
    {
        // First validate the email address
        Validator::make($request->all(), ['email' => 'bail|required|string|email|max:255'])->validate();
        
        if ( ! $this->isAllowedEmailAddress($request, $company)) {
            preg_match('/@(.*)/', $request->input('email'), $matches);
            $request->request->add(['emailDomain' => isset($matches[1]) ? $matches[1] : '']);
            Validator::make($request->all(), ['emailDomain' => [new IsValidCompanyDomain]])->validate();
        }
        
        // Then do all the rest
        $this->validator($request->all())->validate();

        try {
            MPSBackend::createUser(
                $request->input('email'), $request->input('password'),
                $company->stub, $company->getLicenceEndDateTimestamp(), $request->input('optin')
            );
        } catch (\Exception $e) {
            $key = ($e->getCode() === 12) ? 'email' : 'error';
            if ($e->getCode() !== 12) {
                Log::error('Registration failure - '.$e->getCode().':'.$e->getMessage());
            }
            return redirect()->back()->withInput()->withErrors([$key => $e->getMessage()]);
        }

        return redirect()->route('mps-employee-registered', ['company' => $company]);
    }

    /**
     * Show registration confirmation page.
     *
     * @param Request $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function registrationConfirm(Request $request, Company $company)
    {
        // Log out the employee, we must prevent them pressing back to add more
        $request->session()->forget('employee_auth');

        return view('mmlayouts.view.employee.employee-registered',
            [
                'company' => $company->stub,
                'obj'     => $company,
            ]
        );
    }

    /**
     * Check email address is allowed.
     *
     * @param Request $request
     * @param Company $company
     * @return bool
     */
    protected function isAllowedEmailAddress(Request $request, Company $company)
    {
        foreach ($company->companyEmails as $email) {
            if(strcasecmp($email->email, $request->input('email')) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Validate user credentials.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $params = [
            'email'    => 'bail|required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'gdpr'     => 'required|in:1',
            'terms'    => 'required|in:1',
            'optin'    => 'required',
        ];

        return Validator::make($data, $params, ['in' => 'Please check this box to continue.']);
    }
    
    /**
     * Remove end user form
     * @param Request $request
     * @param Company $company
     * @return type
     */
    public function employeeRemove(Request $request, Company $company)
    {
        $params = [
            'company' => $company,
            'obj'     => $company,
            'hash' => '#removeusers'
        ];
        
        return view('mmlayouts.view.employee.delete',  $params);
    }
    
    /**
     * Call api service to remove the users organisation subscription
     * @param Request $request
     * @param Company $company
     * @return type
     */
    public function remove(Request $request, Company $company)
    {
        $response = MPSBackend::removeUser($request->input('email'), $company->stub);
        $request->request->add(['email' => Hash::make($request->input('email'))]);
        
        $this->auditAdd(
            $request,
            [
                'type' => 'UNSUBSCRIBED',
                'user_id' => Auth::User()->id,
                'company_id' => session('company')->id,
                'details' => json_encode([
                    'request' => $request->all(), 
                    'reponse' => $response
                ])
            ]
        );
        
        return redirect(route('company-manage-users', [$company->stub]).'#removeusers');
    }
}
