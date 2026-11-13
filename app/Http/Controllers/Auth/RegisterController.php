<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW REGISTER PAGE
    |--------------------------------------------------------------------------
    */

    public function showRegister()
    {
        return view('auth.register');
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER USER
    |--------------------------------------------------------------------------
    */

    public function register(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        |
        | Laravel checks the information BEFORE it reaches the database.
        |
        */

        $validated = $request->validate([

            /*
            | FULL NAME
            */

            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-zÀ-ÿ]+(?:[ .\'-][A-Za-zÀ-ÿ]+)*$/'
            ],


            /*
            | EMAIL
            */

            'email' => [
                'required',
                'email:rfc',
                'max:255',
                'unique:users,email'
            ],


            /*
            | USERNAME
            */

            'username' => [
                'required',
                'string',
                'min:4',
                'max:30',
                'regex:/^[A-Za-z0-9_]+$/',
                'unique:users,username'
            ],


            /*
            | PHILIPPINE PHONE NUMBER
            |
            | Example:
            | 09123456789
            */

            'phone' => [
                'required',
                'regex:/^09[0-9]{9}$/'
            ],


            /*
            | PASSWORD
            |
            | Requires:
            | - minimum 8 characters
            | - uppercase
            | - lowercase
            | - number
            */

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/'
            ],


            /*
            | TERMS
            */

            'terms' => [
                'accepted'
            ],

        ], [

            /*
            |--------------------------------------------------------------------------
            | ERROR MESSAGES
            |--------------------------------------------------------------------------
            */

            'name.required' =>
                'Please enter your full name.',

            'name.regex' =>
                'Please enter a valid name.',

            'email.required' =>
                'Please enter your email address.',

            'email.email' =>
                'Please enter a valid email address.',

            'email.unique' =>
                'This email address is already registered.',

            'username.required' =>
                'Please enter a username.',

            'username.min' =>
                'Username must contain at least 4 characters.',

            'username.regex' =>
                'Username can only contain letters, numbers, and underscores.',

            'username.unique' =>
                'This username is already taken.',

            'phone.required' =>
                'Please enter your phone number.',

            'phone.regex' =>
                'Please enter a valid Philippine phone number.',

            'password.required' =>
                'Please enter a password.',

            'password.min' =>
                'Password must contain at least 8 characters.',

            'password.confirmed' =>
                'Passwords do not match.',

            'password.regex' =>
                'Password must contain uppercase, lowercase, and a number.',

            'terms.accepted' =>
                'You must agree to the Terms & Privacy Policy.',
                'adoption_agreement' => 'required|accepted',
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREATE ACCOUNT
        |--------------------------------------------------------------------------
        |
        | Hash::make() protects the password.
        |
        | User::create() uses Laravel's database layer.
        | We do not manually build SQL queries.
        |
        */

        User::create([

            'name' =>
                trim($validated['name']),

            'email' =>
                strtolower(trim($validated['email'])),

            'username' =>
                trim($validated['username']),

            'phone' =>
                $validated['phone'],

            'password' =>
                Hash::make($validated['password']),

            /*
            | Normal users cannot access admin dashboard.
            */

            'role' => 'user',
        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT TO LOGIN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('register')
            ->with(
                'success',
                'Account created successfully. You can now log in.'
            );
    }
}