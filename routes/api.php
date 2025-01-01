<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\CurrentUserController;
use App\Http\Controllers\Api\Auth\LoginByEmailAndPasswordController;
use App\Http\Controllers\Api\PingController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', PingController::class);
Route::post('/auth/login', LoginByEmailAndPasswordController::class);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get('/auth/user', CurrentUserController::class);
});
