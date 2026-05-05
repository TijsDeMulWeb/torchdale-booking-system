<?php

use App\Http\Controllers\Login\ShowLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', ShowLoginController::class)->name('login.show');
});