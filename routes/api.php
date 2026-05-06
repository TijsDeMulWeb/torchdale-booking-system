<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Middleware\AuthenticateEscaperoom;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateEscaperoom::class])->group(function () {
    Route::post('/chat', ChatbotController::class)->name('chat.index');
});
