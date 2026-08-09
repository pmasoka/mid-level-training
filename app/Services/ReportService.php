<?php

namespace App\Services;

use App\Models\User;

class ReportService
{
    public function generate(User $user, string $month): array
    {
        // Your actual report-generation logic goes here.

        return [
            'user_id' => $user->id,
            'month' => $month,
            'generated_at' => now(),
            'data' => [],
        ];
    }
}