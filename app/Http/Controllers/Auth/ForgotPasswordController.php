<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW FORGOT PASSWORD FORM
    |--------------------------------------------------------------------------
    */

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }


    /*
    |--------------------------------------------------------------------------
    | SEND RESET LINK TO EMAIL
    |--------------------------------------------------------------------------
    */

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
                'ends_with:@gmail.com'
            ],
        ], [

            'email.required' =>
                'Please enter your email address.',

            'email.email' =>
                'Please enter a valid email address.',

            'email.exists' =>
                'No account found with this email address.',

            'email.ends_with' =>
                'Please use a Gmail address ending with @gmail.com.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEND RESET LINK
        |--------------------------------------------------------------------------
        |
        | Laravel generates a signed token, saves it in password_reset_tokens
        | table, and sends an email with a reset link.
        |
        */

        $status = Password::sendResetLink(
            $request->only('email')
        );


        if ($status === Password::RESET_LINK_SENT) {

            return back()->with(
                'success',
                'Password reset link has been sent to your email.'
            );
        }


        return back()->withErrors([
            'email' => __($status)
        ]);
    }
}