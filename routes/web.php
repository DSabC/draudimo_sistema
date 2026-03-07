<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return redirect('/owners');
});

Route::get('/home', function () {
    return redirect()->route('owners.index');
});

Route::resource('owners', OwnerController::class);

Route::resource('cars', CarController::class);

Auth::routes();
