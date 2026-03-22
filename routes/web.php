<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return redirect('/owners');
});

Route::get('/home', function () {
    return redirect()->route('owners.index');
});

Auth::routes();

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['lt', 'en'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {

    Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');

    Route::middleware('admin')->group(function () {
        Route::get('/owners/create', [OwnerController::class, 'create'])->name('owners.create');
        Route::post('/owners', [OwnerController::class, 'store'])->name('owners.store');
        Route::get('/owners/{owner}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
        Route::put('/owners/{owner}', [OwnerController::class, 'update'])->name('owners.update');
        Route::delete('/owners/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');

        Route::get('/cars/create', [CarController::class, 'create'])->name('cars.create');
        Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
        Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
        Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    });
});
