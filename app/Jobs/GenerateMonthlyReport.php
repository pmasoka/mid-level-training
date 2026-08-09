<?php

namespace App\Jobs;

use App\Mail\MonthlyReportGenerated;
use App\Models\User;
use App\Notifications\ReportFailedNotification;
use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class GenerateMonthlyReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public array $backoff = [5, 10, 30];

    public function __construct(
        public User $user,
        public string $month,
    ) {
    }

    public function handle(ReportService $reportService): void
    {
        $report = $reportService->generate(
            $this->user,
            $this->month
        );

        Mail::to($this->user->email)
            ->send(new MonthlyReportGenerated($report));
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Monthly report generation failed.', [
            'user_id' => $this->user->id,
            'month' => $this->month,
            'exception' => $exception->getMessage(),
        ]);

        $this->user->notify(
            new ReportFailedNotification($this->month)
        );
    }
}