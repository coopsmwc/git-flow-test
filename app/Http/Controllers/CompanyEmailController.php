<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyEmailController extends Controller
{
    public $stub = 'company.email';
    public $view = 'email';
    public $redirect = 'company-company-manage-users';
    
    // Set the resource route for sales or company views
    public function getStub()
    {
        if (isCompanyUser()) {
            $this->stub = 'email';
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
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company, $view = 'mmlayouts.view.list')
    {
        $params = [
            'list' => $company->companyEmails,
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub, 
            'heading' => 'Allowed Email Addresses',
            'new' => 'Add Email Address'
        ];
        
        if (!isCompanyUser()) {
            $params['companyName'] = $company->name;
        }
        
        return view($view, $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Company $company)
    {   
        $params = [
            'heading' => 'New Email Address', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub,
            'create' => 'Add Email Address',
            'redirect' => $this->getRedirect(),
            'hash' => '#emails'
        ];
        
        return view('mmlayouts.view.create', $params);
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
        $validator = $this->getValidator($request);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $companyEmail =  new CompanyEmail;
        $companyEmail = $this->load($request, $companyEmail);
        $companyEmail->company_id = $company->id;
        $companyEmail->save();

        return redirect(route($this->getRedirect(), [$company->stub]).'#emails');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Company $company
     * @param  CompanyEmail $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, CompanyEmail $email)
    {
        $params = [
            'heading' => 'Edit Email Address', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'company' => $company->stub,
            'obj' => $email,
            'edit' => true,
            'redirect' => $this->getRedirect(),
            'hash' => '#emails'
        ];
        
        return view('mmlayouts.view.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @param  CompanyEmail $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, CompanyEmail $email)
    {
        if ($email->email !== $request->email) {
            $validator = $this->getValidator($request);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }
        }

        $email = $this->load($request, $email);
        $email->save();

        return redirect(route($this->getRedirect(), [$company->stub]).'#emails');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @param  CompanyEmail $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Company $company, CompanyEmail $email)
    {
        CompanyEmail::destroy($email->id);

        return redirect()->route($this->getRedirect(), [$company]);
    }

    /**
     * Load CompanyEmail data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  CompanyEmail $obj
     * @return CompanyEmail
     */
    public function load(Request $request, CompanyEmail $obj)
    {
        $obj->email = $request->email;
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
//echo debug_backtrace()[1]['function']; exit;
        
        return $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255|unique:company_emails'
            ],
            [
                'email.unique' => 'Email address already exists.', 
            ]   
        );
    }
}
