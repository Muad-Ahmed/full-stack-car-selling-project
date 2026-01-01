<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string']
    ]);

    if (Auth::attempt($credentials)) {
        // If that was successful, regenerate session
        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('success', 'Welcome Back');
    }

    return  redirect()->back()->withErrors([
        'email' => 'The provided credentials do not match our records'
    ])->onlyInput('email');
}
}
