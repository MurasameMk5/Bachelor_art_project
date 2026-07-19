<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommissionController;

Route::get('/commissions', [CommissionController::class, 'index']);
