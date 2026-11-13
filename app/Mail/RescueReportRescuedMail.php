<?php

namespace App\Mail;

use App\Models\AnimalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescueReportRescuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public AnimalReport $report;

    public function __construct(AnimalReport $report)
    {
        $this->report = $report;
    }

    public function build()
    {
        return $this
            ->subject('Animal Rescue Completed - Animal Rescue PH')
            ->view('emails.rescue-rescued');
    }
}