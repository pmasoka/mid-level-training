<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyReportGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public mixed $report
    ) {
    }

    public function build(): static
    {
        return $this
            ->subject('Your Monthly Activity Report')
            ->view('emails.monthly-report');
    }
}