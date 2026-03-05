<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;

Route::get('/', function () {
    return redirect('/owners');
});

Route::resource('owners', OwnerController::class);

Auth::routes();
