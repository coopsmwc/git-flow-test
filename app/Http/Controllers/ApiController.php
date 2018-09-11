<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\CompanyAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Company as CompanyResource;
use App\Http\Resources\CompanyAdmin as CompanyAdminResource;
use App\Rules\IsNewHrUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    
    /**
     * Checks if an HR admin user with this email address already exists
     *  and returns the user object.
     * @param Request $request
     * @param Company $company
     * @return type
     */
    public function admins(Request $request, Company $company)
    {
        $admins = User::where('email', $request->input('email'))
            ->leftJoin('company_admins', function ($join) use (&$company) {
                $join->on('users.id', '=', 'company_admins.user_id');
            })->get();
        
        
         foreach ($admins as $user)   {
             if ($user->company_id ===  $company->id) {
                 return  response()->error(['email' => ['This email address is already in use for this organisation.']], 1, 200);
             }
         }
        
        $admins = is_array($admins->toArray()) ? array_merge($admins->toArray()) : null;
        return  response()->success($admins);
    }
    
    /**
     * 
     * @param Request $request
     * @param Company $company
     * @return type
     */
    public function createAdminUser(Request $request, Company $company)
    {
        $validator = $this->getAdminValidator($request);
        if ($validator->fails()) {
            return response()->error($validator->messages(), 1, 200);
        }
        
        DB::transaction(function () use (&$request, &$company) {
            if (! $request->input('exists')) {
                $user = $this->createUser($request->all());
            }
            
            $companyAdmin = CompanyAdmin::create(
                [
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'name' => $request->name,
                    'notes' => $request->notes,
                    'status' => 1
                ]
            );
        });
                
        return  response()->success();
    }
    
    /**
     * 
     * @param Request $request
     * @param Company $company
     * @param CompanyAdmin $administrator
     * @return type
     */
    public function updateAdminUser(Request $request, Company $company, CompanyAdmin $administrator)
    {
        
        $validator = $this->getAdminValidator($request, false, strlen($request->password));
        if ($validator->fails()) {
            return response()->error($validator->messages(), 1, 200);
        }
        
        DB::transaction(function () use (&$request, &$company, &$administrator) {
            if (! $request->input('exists')) {
                $user = $this->createUser($request->all());
            }
            
            $administrator->name = $request->name;
            $administrator->notes = $request->notes;
            if (isset($user)) {
                 $administrator->user_id = $user->id;
            }
            
            $administrator->save();
        });
        
        return  response()->success(new CompanyAdminResource($administrator));
    }
    
    /**
     * 
     * @param Request $request
     * @return type
     */
    protected function getAdminValidator(Request $request, $checkUser = true, $checkPword = true) 
    {
        $params = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ];
        
        if ($checkUser) {
            $params['email'] = [
                new IsNewHrUser
            ];
        }
        
        if ($checkPword) {
            $params['password'] = 'required|string|min:6';
        }
        
        return Validator::make($request->all(), $params);
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
}
