<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimesheetController;
use App\Http\Middleware\PassportAuthMiddleware;
use Illuminate\Support\Facades\Route;

// Register Route
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Login Route
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout Route (auth:api middleware ensures only authenticated users can access)
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::middleware([PassportAuthMiddleware::class])->group(function () {
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('timesheets', TimesheetController::class);
    Route::apiResource('attributes', AttributeController::class);
});
