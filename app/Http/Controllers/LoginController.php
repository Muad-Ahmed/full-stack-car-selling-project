<?php

namespace App\Http\Controllers;

use App\Models\User;
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
                ->with('success', 'Welcome Back, ' . Auth::user()->name);
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records'
        ])->onlyInput('email');
    }

    public function storeDemoUser(Request $request)
    {
        $user = User::where('email', 'demo@test.com')->firstOrFail();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Welcome Back, ' . $user->name);
    }

    public function skipVerification()
    {

        $user = auth()->user();

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('car.create')
            ->with('success', 'Email verified automatically for demo!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
