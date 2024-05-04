<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function loadRegister()
    {
        if(Auth::check()){
            return redirect('/home');        
        }
        return view('register');
    }

    public function userRegister(Request $request)
    {
        $request->validate([
            'name'=> 'string|required|min:1',
            'email'=> 'string|required|email|max:100|unique:users',
            'password'=> 'string|required|min:8|confirmed'
        ]);
         
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/home')->with('success','Your Registration has been successful');


    }
    
    public function loadLogin()
    {
        if(Auth::check()){
            return redirect('/');        
        }
        return view('login');
    }
    public function userLogin(Request $request)
    {
        $request->validate([            
            'email'=> 'string|required|email',
            'password'=> 'string|required'
        ]);

        $userCredential = $request->only('email','password');

        if(Auth::attempt($userCredential))
        {
            return redirect('/view')->with('loggedinmessage','You have logged in successfully!!');
        }
        else{
            return back()->with('error','Your password and email is incorrect');
        }

    }
    public function home()
    {
        if(Auth::check()){
            return view('view');        
        }
        else{
            return redirect('/login');            
        }
        
    }
    public function logout(Request $request){
        
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
