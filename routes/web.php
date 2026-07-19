<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{any}', function () {
    return view('app'); // Assurez-vous que 'app' correspond au nom de votre fichier Blade (app.blade.php)
})->where('any', '.*');
