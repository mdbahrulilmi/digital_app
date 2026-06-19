<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DokuWebhookController;

Route::post('/webhook/doku', [DokuWebhookController::class, 'handle']);
Route::post('/doku/get-access', [DokuWebhookController::class, 'getAccess']);