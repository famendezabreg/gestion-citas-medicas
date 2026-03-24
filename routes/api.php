<?php

use App\Http\Controllers\Api\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('appointments',  [AppointmentController::class, 'index']);
Route::post('appointments', [AppointmentController::class, 'store']);