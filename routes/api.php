<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/tags', [TagController::class, 'index']);

Route::middleware('auth')->post(
    '/reports/request',
    [ReportController::class, 'request']
);

Route::post(
    '/posts/{post}/tags/attach',
    [TagController::class, 'attachToPost']
);

Route::post(
    '/posts/{post}/tags/sync',
    [TagController::class, 'syncPost']
);
