<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Middleware\EnsureHashIsValid;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/register', [RegistrationController::class, 'store'])->name('registration.store');

Route::get('/dashboard/expired', [DashboardController::class, 'expired'])->name('dashboard.expired');

Route::prefix('dashboard/{hash}')
    ->middleware(EnsureHashIsValid::class)
    ->controller(DashboardController::class)
    ->group(function () {
        Route::get('/', 'index')->name('dashboard.index');

        Route::prefix('link')->group(function () {
            Route::get('/regenerate', 'regenerateLink')->name('dashboard.link.regenerate');;
            Route::get('/deactivate', 'deactivateLink')->name('dashboard.link.deactivate');;
        });

        Route::post('play', 'play')->name('dashboard.play');
        Route::get('history', 'history')->name('dashboard.history');
    });

