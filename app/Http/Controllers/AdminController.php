<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function landing()
    {
        if (Auth::user()) {
            if (! isCompanyUser()) {
                return redirect()->route('companies');
            } else {
                Auth::logout();
                return redirect('/login');
            }
        }
    }
    
    /**
     * Show the change password form.
     *
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function showChangePasswordForm(Company $company)
    {
        return view('auth.passwords.change');
    }

    /**
     * Process the change password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, Company $company)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
 
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully !");
    }
}
