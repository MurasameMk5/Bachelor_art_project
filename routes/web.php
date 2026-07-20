<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth');

Route::get('/storefront', function () {
    return Inertia::render('Storefront');
})->middleware('auth');
Route::get('/request', function () {
    return Inertia::render('Request');
})->middleware('auth');
Route::get('/order/{id}', function ($id) {
    return Inertia::render('Order', ['id' => $id]);
})->middleware('auth');
