<?php

use App\Http\Controllers\Login\ShowLoginController;
use App\Http\Controllers\Login\StoreLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', ShowLoginController::class)->name('login.show');
    Route::post('/', StoreLoginController::class)->name('login.store');
});