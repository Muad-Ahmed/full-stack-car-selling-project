<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request) {}

    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request) {}
}
