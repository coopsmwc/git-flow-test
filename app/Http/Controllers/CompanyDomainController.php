<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyDomain;
use Illuminate\Http\Request;
use App\Rules\IsValidDomain;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyDomainController extends Controller
{
    public $stub = 'company.domain';
    public $view = 'domain';
    public $redirect = 'company-company-manage-users';
    
    // Set the resource route for sales or company views
    public function getStub()
    {
        if (isCompanyUser()) {
            $this->stub = 'domain';
        }
        return $this->stub;
    }
    
    public function getRedirect()
    {
        if (isCompanyUser()) {
            $this->redirect = 'company-manage-users';
        }
        return $this->redirect;
    }
    
    /**
     * Display a listing of the resource.
     *
     * \Illuminate\Http\Request  $request
     * @param Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company, $view = 'mmlayouts.view.list')
    {
        $params = [
            'list' => $company->companyDomains,
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub, 
            'heading' => 'Allowed Email Domains',
            'new' => 'Add Email Domain'
        ];
        
        if (!Auth::user()->company) {
            $params['companyName'] = $company->name;
        }
        
        return view($view, $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Company $company)
    {   
        return view('mmlayouts.view.create', 
            [
                'heading' => 'Add Email Domain', 
                'stub' => $this->getStub(),
                'view' => $this->view,
                'redirect' => $this->getRedirect(),
                'company' => $company->stub,
                'create' => 'Create Email Domain',
                'hash' => '#domains'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Company $company
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $companyDomain =  new CompanyDomain;
        $companyDomain = $this->load($request, $companyDomain);
        $companyDomain->company_id = $company->id;
        $companyDomain->save();

        return redirect(route($this->getRedirect(), [$company->stub]).'#domains');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @param  CompanyDomain $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, CompanyDomain $domain)
    {
        $params = [
            'heading' => 'Edit Domain', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub,
            'obj' => $domain,
            'edit' => true,
            'redirect' => $this->getRedirect(),
            'hash' => '#domains'
        ];
        
        return view('mmlayouts.view.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @param  CompanyDomain $domain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, CompanyDomain $domain)
    {
        if ($domain->domain !== $request->domain) {
            $validator = $this->getValidator($request);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $domain = $this->load($request, $domain);
        $domain->save();

        return redirect(route($this->getRedirect(), [$company->stub]).'#domains');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @param  CompanyDomain $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Company $company, CompanyDomain $domain)
    {
        CompanyDomain::destroy($domain->id);

        return redirect()->route($this->getRedirect(), [$company]);
    }

    /**
     * Load CompanyDomain data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CompanyDomain $obj
     * @return CompanyDomain
     */
    public function load(Request $request, CompanyDomain $obj)
    {
        $obj->domain = $request->domain;
        $obj->description = $request->description;

        return $obj;
    }

    /**
     * Get Validator.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidator(Request $request)
    {
        //$request->request->add(['dns' => checkdnsrr($request->input('domain'), "ANY")]);
        $there = CompanyDomain::where('domain', $request->input('domain'))->first();
        $request->request->add(['there' => !$there ? 1 : 0]);
        return $validator = Validator::make($request->all(), [
                'domain' => [
                    'bail',
                    'required',
                    'regex:/[^@]*\..+/',
                    new IsValidDomain
                ],
                //'dns' => 'in:1',
                'there' => 'in:1'
            ],
            [
                //'dns.in' => 'This email domain does not exist.', 
                'there.in' => 'This email domain has already been entered.'
            ]   
        );
    }
}
