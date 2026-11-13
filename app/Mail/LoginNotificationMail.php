<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoginNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginTime;
    public $ipAddress;
    public $userAgent;

    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct($user, $loginTime, $ipAddress, $userAgent)
    {
        $this->user      = $user;
        $this->loginTime = $loginTime;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }


    /*
    |--------------------------------------------------------------------------
    | ENVELOPE — EMAIL SUBJECT & FROM
    |--------------------------------------------------------------------------
    */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Login to Your Account — Animal Rescue PH',
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CONTENT — EMAIL BODY
    |--------------------------------------------------------------------------
    */

    public function content(): Content
    {
        return new Content(
            view: 'emails.login-notification',
        );
    }
}