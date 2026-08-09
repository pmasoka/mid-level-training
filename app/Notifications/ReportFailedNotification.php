<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportFailedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $month
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Monthly Report Generation Failed')
            ->greeting('Hello!')
            ->line(
                "Unfortunately, we were unable to generate your {$this->month} monthly 
                activity report."
            )
            ->line('Please try requesting the report again later.');
    }
}