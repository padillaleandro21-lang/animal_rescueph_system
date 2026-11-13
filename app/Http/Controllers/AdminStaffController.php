<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminStaffController extends Controller
{
    /**
     * Display staff accounts.
     */
    public function index(): View
    {
        $user = Auth::user();

        abort_unless(
            $user && strtolower(trim((string) $user->role)) === 'owner',
            403,
            'Only the owner can manage staff accounts.'
        );

        $staff = User::whereIn('role', [
            'owner',
            'admin',
            'rescue_staff',
            'shelter_staff',
            'adoption_staff',
        ])->orderBy('name')->get();

        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Create a staff account.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        abort_unless(
            $user && strtolower(trim((string) $user->role)) === 'owner',
            403,
            'Only the owner can create staff accounts.'
        );

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                Rule::in([
                    'rescue_staff',
                    'shelter_staff',
                    'adoption_staff',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $email = strtolower(trim($validated['email']));

        // Generate values for existing required user fields.
        $username = $email;

        // Avoid duplicate usernames if username is unique.
        if (User::where('username', $username)->exists()) {
            return back()
                ->withInput($request->except([
                    'password',
                    'password_confirmation',
                ]))
                ->withErrors([
                    'email' => 'This email is already being used as a username.',
                ])
                ->with('open_staff_form', true);
        }

        User::create([
            'name' => explode('@', $email)[0],
            'email' => $email,
            'username' => $username,
            'phone' => 'N/A',
            'role' => $validated['role'],
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff account created successfully.');
    }
}
