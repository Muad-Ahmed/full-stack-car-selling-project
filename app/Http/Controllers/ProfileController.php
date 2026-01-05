<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . $request->user()->id]
        ];

        $user = $request->user();

        // Add email field into rules if the user is not signed up with Google or Facebook
        if (!$user->isOauthUser()) {
            $rules['email'] = [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ];
        }

        // Perform validation
        $data = $request->validate($rules);

        // Fill the user data
        $user->fill($data);

        // Define success message
        $success = 'Your profile was updated';
        // If the email is changed we need to send email verification and we need to mark the user with
        // email_verified_at=null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $success = 'Email Verification was sent. Please verify!';
        }

        // Save the user
        $user->save();

        // Redirect user back to profile page with success message
        return redirect()->route('profile.index')
            ->with('success', $success);
    }

    public function updatePassword(Request $request) {}
}
