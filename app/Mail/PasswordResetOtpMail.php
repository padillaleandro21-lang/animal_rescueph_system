<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $otp;
    public $expiresIn;

    public function __construct($user, $otp, $expiresIn = 10)
    {
        $this->user      = $user;
        $this->otp       = $otp;
        $this->expiresIn = $expiresIn;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset OTP — Animal Rescue PH',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-otp',
        );
    }
}