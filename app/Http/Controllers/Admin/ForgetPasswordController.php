<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{

 public function forget_password(){
  
    $data['menu'] = 'forget_passwords';
    $data['submenu'] = 'forget_password';

    $user = User::WHERE('type','admin')->first();
 
 
    return view('backend.forget_password.forget_password', compact('data','user'));

 }

 public function update_forget_password(Request $request){

    $request->validate([
        'password'=>'required',
        'cpassword'=>'required'
    ]);

    $user = User::find($request->id);
    $user->password = $request->password;
    

    if($request->password === $request->cpassword){

    $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password Updated Success');
    }else{
        return redirect()->back()->with('error', 'Password & Confirm Password Not Matches');

    }

 }

}