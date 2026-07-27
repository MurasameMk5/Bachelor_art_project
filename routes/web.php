<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StorefrontComponentController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/dashboard', [OrderController::class, 'index'])->middleware(['auth:sanctum', 'can:artist']);

Route::get('/storefront',[StorefrontController::class, 'showArtist'])->middleware(['auth:sanctum', 'can:artist']);
Route::post('/storefront/components', [StorefrontComponentController::class, 'insert'])->middleware(['auth:sanctum']);
Route::match(['PUT', 'PATCH'], '/storefront/components/{component}', [StorefrontComponentController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/storefront/components/{component}', [StorefrontComponentController::class, 'delete'])->middleware(['auth:sanctum']);
Route::get('/request', function () {
    return Inertia::render('Request');
})->middleware(['auth:sanctum', 'can:artist']);

Route::get('/order/{order}', [OrderController::class, 'show'])->middleware('auth:sanctum');

Route::get('/{storefront:slug}', [StorefrontController::class, 'showClient']);
Route::get('/{storefrontSlug}/{commission}', [CommissionController::class, 'show'])->middleware('auth:sanctum');

Route::get('/profile', [UserController::class, 'show'])->middleware('auth:sanctum');
