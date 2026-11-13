<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | OTP EXPIRY — IN MINUTES
    |--------------------------------------------------------------------------
    */

    protected $otpExpiry = 10;


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
    | SEND OTP TO EMAIL
    |--------------------------------------------------------------------------
    */

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email',
                'ends_with:@gmail.com',
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


        $email = strtolower(trim($request->email));

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE 6-DIGIT OTP
        |--------------------------------------------------------------------------
        */

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);


        /*
        |--------------------------------------------------------------------------
        | DELETE OLD OTPs FOR THIS EMAIL
        |--------------------------------------------------------------------------
        */

        DB::table('password_reset_otps')
            ->where('email', $email)
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | STORE NEW OTP
        |--------------------------------------------------------------------------
        */

        DB::table('password_reset_otps')->insert([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes($this->otpExpiry),
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEND OTP VIA EMAIL
        |--------------------------------------------------------------------------
        */

        try {

            Mail::to($email)->send(
                new PasswordResetOtpMail(
                    $user,
                    $otp,
                    $this->otpExpiry
                )
            );

        } catch (\Exception $e) {

            logger()->error('OTP email failed: ' . $e->getMessage());

            return back()->withErrors([
                'email' => 'Unable to send OTP email. Please try again later.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | STORE EMAIL IN SESSION + REDIRECT TO VERIFY PAGE
        |--------------------------------------------------------------------------
        */

        session([
            'otp_email' => $email,
        ]);


        return redirect()
            ->route('password.verify')
            ->with(
                'success',
                'A 6-digit OTP has been sent to your email.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW OTP VERIFICATION FORM
    |--------------------------------------------------------------------------
    */

    public function showVerifyForm()
    {
        if (!session('otp_email')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Please enter your email first.',
                ]);
        }

        return view('auth.verify-otp', [
            'email' => session('otp_email'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY OTP
    |--------------------------------------------------------------------------
    */

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ], [
            'otp.required' => 'Please enter the OTP code.',
            'otp.digits'   => 'OTP must be exactly 6 digits.',
        ]);


        $email = session('otp_email');

        if (!$email) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Session expired. Please enter your email again.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | FIND OTP
        |--------------------------------------------------------------------------
        */

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->first();


        if (!$record) {
            return back()->withErrors([
                'otp' => 'Invalid OTP code. Please try again.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK EXPIRY
        |--------------------------------------------------------------------------
        */

        if (now()->greaterThan($record->expires_at)) {
            DB::table('password_reset_otps')
                ->where('email', $email)
                ->delete();

            return back()->withErrors([
                'otp' => 'OTP has expired. Please request a new one.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | MARK AS VERIFIED
        |--------------------------------------------------------------------------
        */

        session([
            'otp_verified' => true,
        ]);


        return redirect()->route('password.reset.form');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW RESET PASSWORD FORM
    |--------------------------------------------------------------------------
    */

    public function showResetForm()
    {
        if (!session('otp_verified') || !session('otp_email')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Please verify your OTP first.',
                ]);
        }

        return view('auth.reset-password', [
            'email' => session('otp_email'),
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function resetPassword(Request $request)
    {
        if (!session('otp_verified') || !session('otp_email')) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Session expired. Please start over.',
                ]);
        }


        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
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


        $email = session('otp_email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'Account not found.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PASSWORD
        |--------------------------------------------------------------------------
        */

        $user->update([
            'password' => Hash::make($request->password),
        ]);


        /*
        |--------------------------------------------------------------------------
        | CLEAR OTP RECORDS
        |--------------------------------------------------------------------------
        */

        DB::table('password_reset_otps')
            ->where('email', $email)
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | CLEAR SESSION
        |--------------------------------------------------------------------------
        */

        session()->forget([
            'otp_email',
            'otp_verified',
        ]);


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Password reset successfully! You can now log in with your new password.'
            );
    }
}