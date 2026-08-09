<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateMonthlyReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function request(Request $request): JsonResponse
    {
        $request->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        GenerateMonthlyReport::dispatch(
            $request->user(),
            $request->input('month')
        );

        return response()->json([
            'message' => 'Monthly report generation has been queued.',
        ], 202);
    }
}