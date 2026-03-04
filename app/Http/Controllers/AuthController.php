<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful');
    }

    // Show Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){

            if(Auth::user()->role == 'Admin'){
                return redirect('/admin/dashboard');
            }else{
                return redirect('/user/dashboard');
            }
        }

        return back()->with('error','Invalid credentials');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}