<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login_form()
    {
        return view('login.login');
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->hasRole('super_admin')){
                $request->session()->regenerate();
                Alert::success('Login Successful', 'Welcome back, Super Admin!');
                return redirect()->intended('dash');
            } elseif (Auth::user()->hasRole('school_admin')) {
                $request->session()->regenerate();
                Alert::success('Login Successful', 'Welcome back, School Admin!');
                return redirect()->intended('dash');
            } elseif (Auth::user()->hasRole('teacher')) {
                $request->session()->regenerate();
                Alert::success('Login Successful', 'Welcome back, Teacher!');
                return redirect()->intended('teacher/home');
            } elseif (Auth::user()->hasRole('student')) {
                $request->session()->regenerate();
                Alert::success('Login Successful', 'Welcome back, Student!');
                return redirect()->intended('dash');
            }
            
            // Alert::success('Login Successful', 'Welcome back!');
            // return redirect()->intended('dash');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
