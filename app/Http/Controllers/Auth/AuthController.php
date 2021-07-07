<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Admin;

class AuthController extends Controller
{
    //
    function get_login(){
        return view('Admin.Auth.login');
    }
    function Admin_login(Request $req){
    $user= Admin::where(["email"=>$req->email])->first();
    if(!$user ||!Hash::check($req->password,$user->password)){
        return redirect('/')->with('error','Incorrect email and password'); 
    }else{
        $req->session()->put('user',$user);
        return redirect('/index')->with('success','Your Login has been Successfully');
    }
}
}
