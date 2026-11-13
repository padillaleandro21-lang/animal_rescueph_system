<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW RESET PASSWORD FORM
    |--------------------------------------------------------------------------
    */

    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        $request->validate([

            'token' => ['required'],

            'email' => [
                'required',
                'email',
                'ends_with:@gmail.com'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/'
            ],

        ], [

            'password.required' =>
                'Please enter your new password.',

            'password.min' =>
                'Password must contain at least 8 characters.',

            'password.confirmed' =>
                'Passwords do not match.',

            'password.regex' =>
                'Password must contain uppercase, lowercase, and a number.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | RESET THE PASSWORD
        |--------------------------------------------------------------------------
        */

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),

            function ($user, $password) {

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );


        if ($status === Password::PASSWORD_RESET) {

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Password reset successfully! You can now log in with your new password.'
                );
        }


        return back()->withErrors([
            'email' => __($status)
        ]);
    }
}