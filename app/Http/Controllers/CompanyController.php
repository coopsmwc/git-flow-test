<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\User;

class CompanyController extends Controller
{

    public $stub = 'company.details';

    public $view = 'company';

    public $buttons = [
        'company-company-manage-users'  => [
            'column' => 'stub',
            'text'   => 'Manage organisation users',
            'button' => 'users'
        ]
    ];

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        parent::__construct($request);
    }

    // Set the resource route for sales or company views
    public function getStub()
    {
        if (isCompanyUser()) {
            $this->stub = 'details';
        }

        return $this->stub;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [
            'list'    => Company::all(),
            'stub'    => $this->getStub(),
            'view'    => $this->view,
            'buttons' => $this->buttons,
            'heading' => 'Organisations',
            'new'     => 'New Organisation'
        ];

        return view('mmlayouts.view.list', $params);
    }
    
    public function tabs(Request $request, Company $company)
    {
        $admins = app(\App\Http\Controllers\CompanyAdminController::class)->index($company, 'mmlayouts.view.partials.includes.list');
        $domains = app(\App\Http\Controllers\CompanyDomainController::class)->index($company, 'mmlayouts.view.partials.includes.list');
        $emails = app(\App\Http\Controllers\CompanyEmailController::class)->index($company, 'mmlayouts.view.partials.includes.list');
        $removeUsers = app(\App\Http\Controllers\EmployeeController::class)->employeeRemove($request, $company);
        return view(
            'mmlayouts.view.tabs', 
            [
                'admins' => $admins, 
                'domains' => $domains,
                'emails' => $emails,
                'remove_users' => $removeUsers
            ]
        );
    }
    
    public function manageUsers(Request $request, Company $company) 
    {
        return view(
            'mmlayouts.view.company.manage-users', 
            [
                'tabs' => app(\App\Http\Controllers\CompanyController::class)->tabs($request, $company),
                'scripts' => [
                    '/js/hashtag.js'
                ]
            ]
        );
    }

    /**
     * View company dashboard.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request, Company $company)
    {
        return view('mmlayouts.view.dashboard',
            [
                'company'    => $company,
                'obj'        => $company,
                'domains'    => $company->companyDomains,
                'percentage' => $company->usage(),
                'tabs' => app(\App\Http\Controllers\CompanyController::class)->tabs($request, $company),
                'redirect' => 'companies'
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('mmlayouts.view.create',
            [
                'stub'    => $this->getStub(),
                'view'    => $this->view,
                'heading' => 'New Organisation',
                'create'  => 'Create Organisation',
                'redirect' => 'companies'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $fields = [
            'name'     => 'required|string|unique:companies,name',
            'stub'     => 'required|string|unique:companies,stub',
            'licences' => 'numeric|min:' . config('mps.licences.min'),
            'start-date'   => 'required'
        ];
        // MPSAP-614 - optionally create admin user at same time
        if ($this->createUser($request)) {
            $fields = array_merge($fields, [
                'admin_name'  => 'required|string|max:255',
                'email'      => 'required|string|email|unique:users|max:255',
                'password'   => 'required|string|min:6'
            ]);
        }
        $this->validate($request, $fields,
            [
                'name.unique' => 'This name is already in use.',
                'stub.unique' => 'This link name is already in use.'
            ]
        );

        DB::beginTransaction();

        try {
            $company = new Company;
            $company = $this->load($request, $company);
            $company->licence_status = 'PENDING';
            $company = $this->setLicenceDates($request, $company);
            $company->status = 'ACTIVE';
            $company->save();
            if ($this->createUser($request)) {
                $user = new User;
                $user->fill([
                    'name'     => $request->input('name'),
                    'email'    => $request->input('email'),
                    'type'     => 2,
                    'password' => Hash::make($request->input('password')),
                ])->save();
                $company->companyAdmins()->create([
                    'status'     => 1,
                    'user_id'    => $user->id,
                    'name' => $request->input('admin_name'),
                    'company_id' => $company->id
                ]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception);
        }
        DB::commit();

        return redirect('/companies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @return bool
     */
    public function createUser(Request $request)
    {
        return $request->input('admin_name') ||
            $request->input('email') ||
            $request->input('password');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $params = [
            'stub'    => $this->getStub(),
            'view'    => $this->view,
            'obj'     => $company,
            'heading' => 'Edit Organisation',
            'edit'    => true,
            'redirect' => isCompanyUser() ? 'company-dashboard' : 'companies'
        ];
        
        if (isCompanyUser()) {
            $params['redirect'] = 'company-dashboard';
            $params['company'] = $company->stub;
        }

        return view('mmlayouts.view.edit', $params);
    }
    

    public function credentials(Request $request, Company $company)
    {
        $params = [
            'stub'    => 'company-credentials',
            'view'    => 'company.credentials',
            'obj'     => $company,
            'heading' => 'Edit access credentials to your user portal.',
            'redirect' => isCompanyUser() ? 'company-admin-home' : 'companies'
        ];
        
        if (isCompanyUser()) {
            $params['company'] = $company->stub;
        }

        return view('mmlayouts.view.edit', $params);
    }
    
    public function storeCredentials(Request $request, Company $company)
    {
        $company->employee_register_passkey = $request->register_passkey;
        $company->save();
        
        return redirect()->route('company-admin-home', [$company->stub]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if (! isCompanyUser()) {
            $userCount = $company->userCount();
            $minLicences = $userCount > config('mps.licences.min') ? $userCount : config('mps.licences.min');
            $params = [
                'licences' => "numeric|min:{$minLicences}",
            ];

            if ($company->name !== $request->name) {
                $params['name'] = 'required|string|unique:companies,name';
            }

            if ($company->stub !== $request->stub) {
                $params['stub'] = 'required|string|unique:companies,stub';
            }

            $this->validate($request, $params,
                [
                    'name.unique' => 'This name is already in use.',
                    'stub.unique' => 'This link name is already in use.',
                    'licences.min' => "There are already {$userCount} licences in use."
                ]
            );
        }

        $company = $this->load($request, $company);
        
        if ($request->has('start-date')) {
            $company = $this->setLicenceDates($request, $company);
        }
        
        $company->save();

        if (isCompanyUser()) {
            return redirect('/' . $company->stub);
        }

        if (Route::currentRouteName() === 'company.details.update') {
            return redirect()->route('company-company-dashboard', [$company->stub]);
        }

        return redirect('/companies');
    }

    /**
     * Activate company licence
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function activateLicence(Request $request, Company $company)
    {
        $company->licence_start_date = time();
        $company->licence_end_date = time() + (364 * 24 * 60 * 60);
        $company = $this->setLicenceDates($request, $company);
        $company->save();

        return redirect()->back();
    }
    
    /**
     * 
     * @param Request $request
     * @param Company $company
     * @return Company
     */
    protected function setLicenceDates(Request $request, Company $company)
    {
        if ($request->input('start-date')) {
            $company->licence_start_date = strtotime($request->input('start-date'));
            $company->licence_end_date = strtotime($request->input('start-date')) + (364 * 24 * 60 * 60);
            
            if (time() >= strtotime($request->input('start-date'))) {
                $company->licence_status = 'ACTIVE';
            }
        }
        
        return $company;
    }

    /**
     * Deactivate company licence
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function deactivateLicence(Company $company)
    {
        $company->licence_status = 'PENDING';
        $company->licence_start_date = null;
        $company->licence_end_date = null;
        $company->save();

        return redirect()->back();
    }

    /**
     * Suspend company
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function suspend(Company $company)
    {
        $company->status = 'SUSPENDED';
        $company->save();

        return redirect()->back();
    }

    /**
     * Activate company
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function activate(Company $company)
    {
        $company->status = 'ACTIVE';
        $company->save();

        return redirect()->back();
    }

    /**
     * Auto-renew company
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function autoRenew(Company $company)
    {
        $company->auto_renew = true;
        $company->save();

        return redirect()->back();
    }

    /**
     * Cancel company auto-renew
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function cancelAutoRenew(Company $company)
    {
        $company->auto_renew = false;
        $company->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Company::destroy($company->id);

        return redirect('/companies');
    }

    /**
     * Load company
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $obj
     * @return Company $obj
     */
    public function load(Request $request, Company $obj)
    {
        if (! isCompanyUser()) {
            $obj->name = $request->name;
            $obj->stub = preg_replace('/\s+/', '', $request->stub);
            $obj->licences = $request->licences;
        }
        $obj->employee_register_passkey = $request->register_passkey;

        return $obj;
    }
}
