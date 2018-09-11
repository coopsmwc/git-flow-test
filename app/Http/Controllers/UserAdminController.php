<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAdminController extends Controller
{
    public $stub = 'sales-admin';
    public $view = 'user';
    public $roles = [1 => 'Super User', 3 => 'Sales Admin', 4 => 'Finance'];
    
    // Set the resource route for sales or company views
    public function getStub()
    {
        return $this->stub;
    }

    /**
     * Show the list for resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $salesAdmins = User::salesAdmins()->get();

        return view('mmlayouts.view.list', 
            [
                'list' => $salesAdmins, 
                'stub' => $this->getStub(),
                'view' => $this->view,
                'roles' => $this->roles,
                'heading' => 'Sales administrators',
                'new' => 'New Sales Admin User'
            ]
        );
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('mmlayouts.view.create', 
            [
                'heading' => 'New Sales Admin User', 
                'stub' => $this->getStub(),
                'view' => $this->view,
                'create' => 'Create',
                'redirect' => 'sales-admins'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $request->request->add(['name' => $request->input('name')]);
        $user = new User;
        $user = $this->load($request, $user);
        $user->save();
        
        return redirect()->route('sales-admins');
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
            $params['email'] = 'required|string|email|max:255|unique:users';
        }
        
        if ($create) {
            $params['password'] = 'required|string|min:6';
        }

        return Validator::make($data, $params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $sales_admin
     * @return \Illuminate\Http\Response
     */
    public function edit(User $sales_admin)
    {
        $params = [
            'heading' => 'Edit sales user', 
            'stub' => $this->getStub(),
            'view' => $this->view,
            'obj'  => $sales_admin,
            'edit' => true,
            'redirect' => 'sales-admins'
        ];

        return view('mmlayouts.view.edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $sales_admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $sales_admin)
    {
        $unique = $sales_admin->email !== $request->email;
        $this->validator($request->all(), $unique, false)->validate();

        $sales_admin = $this->load($request, $sales_admin);
        $sales_admin->save();
        
        return redirect()->route('sales-admins');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $sales_admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $sales_admin)
    {
        User::destroy($sales_admin->id);

        return redirect()->route('sales-admins');
    }

    /**
     * Load User data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $obj
     * @return User
     */
    public function load(Request $request, User $obj)
    {
        $obj->email = $request->email;
        if ($request->has('password') && strlen($request->input('password'))) {
            $obj->password = Hash::make($request->password);
        }
        $obj->type = $request->type;
        $obj->name = $request->name;

        return $obj;
    }
}
