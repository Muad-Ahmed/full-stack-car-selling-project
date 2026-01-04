<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        // Will be called when user clicks on the verification link in email
    }

    public function notice()
    {
        // Will be called if we setup verified middleware, so that only
        // verified users to be able to access certain routes
    }

    public function send(Request $request)
    {
        // Will be called, if user loses his/her verification link and wants 
        // to resend the verification email
    }
}
