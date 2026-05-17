<?php

use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\OwnerApiController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::apiResource('owners', OwnerApiController::class);
    Route::apiResource('cars', CarApiController::class);
});
