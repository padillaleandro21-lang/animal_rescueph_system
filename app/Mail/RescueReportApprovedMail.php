<?php

namespace App\Mail;

use App\Models\AnimalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RescueReportApprovedMail extends Mailable
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
            ->subject('Animal Rescue Report Approved - Animal Rescue PH')
            ->view('emails.rescue-approved');
    }
}