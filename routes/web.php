<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dd();

    return User::with(['projects', 'timesheets'])->first();
});
