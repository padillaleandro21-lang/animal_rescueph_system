<?php

namespace App\Mail;

use App\Models\AdoptionApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdoptionRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public AdoptionApplication $application;

    public function __construct(
        AdoptionApplication $application
    ) {
        $this->application = $application;
    }

    public function build()
    {
        return $this
            ->subject(
                'Adoption Application Update - Animal Rescue PH'
            )
            ->view('emails.adoption-rejected');
    }
}