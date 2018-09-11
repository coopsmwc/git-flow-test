<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\CompanyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\IsNewHrUser;
use App\Http\Resources\CompanyAdmin as CompanyAdminResource;

class CompanyAdminController extends Controller
{
    public $stub = 'company.administrator';
    public $view = 'administrator';
    public $redirect = 'company-company-manage-users';
    
    // Set the resource route for sales or company views
    public function getStub()
    {
        if (isCompanyUser()) {
            $this->stub = 'administrator';
        }
        return $this->stub;
    }
    
    public function getRedirect()
    {
        if (isCompanyUser()) {
            $this->redirect = 'company-account-admins';
        }
        return $this->redirect;
    }

    /**
     * Company admin list.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company, $view = 'mmlayouts.view.list')
    {
        $params = [
            'list' => $company->companyAdmins,
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub,           
            'heading' => 'Organisation administrators',
            'new' => 'Add Admin User'
        ];
        
        if (!isCompanyUser()) {
            $params['companyName'] = $company->name;
        }
        
        return view($view, $params);
    }
    
    /**
     * Show company admin list
     * @param Request $request
     * @param Company $company
     * @return type
     */
    public function adminList(Request $request, Company $company) {
        return view(
            'mmlayouts.view.partials.administrator.list', 
            [
                'admins' => app(\App\Http\Controllers\CompanyAdminController::class)->index($company, 'mmlayouts.view.partials.includes.list'),
            ]
        );
    }

    /**
     * Show company dashboard.
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request, Company $company)
    {
        if (Gate::allows('register-user')) {
            print 'authorised'; exit;
        }

        return view('mmlayouts.view.company.dashboard', 
            [
                'company'    => $company,
                'obj'        => $company,
                'domains'    => $company->companyDomains,
                'percentage' => $company->usage(),
                'tabs' => app(\App\Http\Controllers\CompanyController::class)->tabs($request, $company),
                'showUsage'  => (bool) $company->userCount() > 25,
                'scripts' => [
                    '/js/clipboard.js'
                ],
            ]
        );
    }
    
    /**
     * Show the form for creating a new resource.*
     *
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        $params = [
            'heading' => 'New admin user', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'vueComponent' => 'company-admin-form',
            'redirect' => $this->getRedirect(),
            'company' => $company->stub,
            'create' => 'Create Admin User',
            'scripts' => [
                '/js/clipboard.js',
                '/js/hashtag.js',
            ],
            'old' => session('_old_input') ? json_encode(session('_old_input')) : json_encode([]),
            'hash' => '#admins'
        ];
        
        return view('mmlayouts.view.vue.create', $params);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        if (! $request->input('exists', false)) {
            $this->validator($request->all(), true, true)->validate();
        } else {
            $this->validator($request->all(), true, false)->validate();
        }
        
        $request->request->add(['name' => $request->input('name')]);
        
        $user = User::where('email', $request->input('email'))->first();

        DB::transaction(function () use (&$request, &$company, &$user) {
            if (!$user) {
                $user = $this->createUser($request->all());
            }
            $companyAdmin = new CompanyAdmin;
            $companyAdmin = $this->load($request, $companyAdmin);
            $companyAdmin->user_id = $user->id;
            $companyAdmin->company_id = $company->id;
            $companyAdmin->status = 1;
            $companyAdmin->save();
        });

        return redirect(route($this->getRedirect(), [$company->stub]).!isCompanyUser() ? '#admins' : '');
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'type' => $data['type'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @param  bool   $unique
     * @param  bool   $create
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $unique = true, $create = true)
    {
        $params = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];
        
        if ($unique) {
            $params['email'] = [
                new IsNewHrUser
            ];
        }
        
        if ($create) {
            $params['password'] = 'required|string|min:6';
        }

        return Validator::make($data, $params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @param  CompanyAdmin $administrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Company $company, CompanyAdmin $administrator)
    {
        $administrator = new CompanyAdminResource($administrator);
        
        $params = [
            'heading' => 'Edit admin user', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'vueComponent' => 'company-admin-form',
            'company' => $company->stub,
            'obj' => (object) $administrator->toArray($request),
            'edit' => true,
            'redirect' => $this->getRedirect(),
            'scripts' => [
                '/js/clipboard.js',
                '/js/hashtag.js',
            ],
            'old' => session('_old_input') ? json_encode(session('_old_input')) : json_encode([]),
            'hash' => '#admins'
        ];
        
        return view('mmlayouts.view.vue.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @param  CompanyAdmin $administrator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, CompanyAdmin $administrator)
    {
        $user = $administrator->user;
        $unique = $user->email !== $request->email;
        $this->validator($request->all(), $unique, false)->validate();
        
        DB::transaction(function () use (&$request, &$administrator, &$user) {
            $user->email = $request->email;
            if ($request->has('password') && strlen($request->input('password'))) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            $company = $this->load($request, $administrator);
            $company->save();
        });

        return redirect(route($this->getRedirect(), [$company->stub]).!isCompanyUser() ? '#admins' : '');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @param  CompanyAdmin $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, CompanyAdmin $administrator)
    {
        $users = CompanyAdmin::where('user_id', $administrator->user->id)->get();
        //print_r(count($users)); exit;

        DB::transaction(function () use (&$administrator, &$users) {
            CompanyAdmin::destroy($administrator->id);
            if (count($users) === 1) {
                User::destroy($administrator->user->id);
            }
        });

        return redirect()->route($this->getRedirect(), [$company->stub]);
    }

    /**
     * Load CompanyAdmin data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CompanyAdmin $administrator
     * @return CompanyAdmin
     */
    public function load(Request $request, CompanyAdmin $administrator)
    {
        $administrator->name = $request->name;
        $administrator->notes = $request->notes;

        return $administrator;
    }
}
