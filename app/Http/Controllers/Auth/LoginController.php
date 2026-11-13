<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SHOW LOGIN PAGE
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                'ends_with:@gmail.com',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | LOGIN NOTIFICATION EMAIL
            |--------------------------------------------------------------------------
            */

            try {
                Mail::to($user->email)->send(
                    new LoginNotificationMail(
                        $user,
                        now()->format('F d, Y h:i A'),
                        $request->ip(),
                        $request->userAgent() ?? 'Unknown device'
                    )
                );
            } catch (\Throwable $e) {
                logger()->error(
                    'Login notification email failed: ' . $e->getMessage()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | REDIRECT BASED ON ROLE
            |--------------------------------------------------------------------------
            */

            return $this->redirectByRole($user, $request);
        }

        return back()
            ->withErrors([
                'email' => 'The email or password is incorrect.',
            ])
            ->withInput($request->only('email'));
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE-BASED REDIRECT
    |--------------------------------------------------------------------------
    */

    private function redirectByRole($user, ?Request $request = null)
    {
        $role = strtolower(trim((string) $user->role));

        $routes = [
            'owner' => 'admin.dashboard',
            'admin' => 'admin.dashboard',
            'rescue_staff' => 'admin.report-animal',
            'shelter_staff' => 'admin.manage-animals',
            'adoption_staff' => 'admin.manage-adoptions',
            'user' => 'home',
        ];

        if (!isset($routes[$role])) {
            if ($request) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Your account role is not recognized.',
                    ]);
            }

            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account role is not recognized.',
                ]);
        }

        $routeName = $routes[$role];

        return redirect()
            ->route($routeName)
            ->with(
                'success',
                'Welcome back, ' . $user->name . '!'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'You have been logged out.');
    }
}
