<?php

use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $projects = Project::with(['users', 'attributes.attribute'])->get();

    return view('welcome', compact('projects'));
});
