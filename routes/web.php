<?php

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
});
Route::get('/sign-in', function () {
    return Inertia::render('SignIn');
});
Route::get('/sign-up', function () {
    return Inertia::render('SignUp');
});
Route::get('/storefront', function () {
    return Inertia::render('Storefront');
});
Route::get('/request', function () {
    return Inertia::render('Request');
});
Route::get('/order/{id}', function ($id) {
    return Inertia::render('Order', ['id' => $id]);
});
