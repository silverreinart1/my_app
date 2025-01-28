<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimetableController;

Route::get('/timetable', [TimetableController::class, 'show']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/available', function () {
    return 'Available page content'; 
});


