<?php

use App\Http\Controllers\Chatbot\EditChatbotController;
use App\Http\Controllers\Chatbot\ShowChatbotController;
use App\Http\Controllers\Chatbot\StoreChatbotController;
use App\Http\Controllers\Dashboard\ShowDashboardController;
use App\Http\Controllers\Escaperoom\EditEscaperoomController;
use App\Http\Controllers\Escaperoom\ShowEscaperoomController;
use App\Http\Controllers\Escaperoom\StoreEscaperoomController;
use App\Http\Controllers\EscaperoomAddress\DeleteEscaperoomAddressController;
use App\Http\Controllers\Login\ShowLoginController;
use App\Http\Controllers\Login\StoreLoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', ShowLoginController::class)->name('login');
    Route::post('/login', StoreLoginController::class)->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', ShowDashboardController::class)->name('dashboard.show');
    Route::post('/', LogoutController::class)->name('logout');
    
    // Chatbot routes
    Route::get('/chatbot', ShowChatbotController::class)->name('chatbot.show');
    Route::get('/chatbot/edit', EditChatbotController::class)->name('chatbot.edit');
    Route::put('/chatbot/edit', StoreChatbotController::class)->name('chatbot.update');

    // Escaperoom routes
    Route::get('/escaperoom', ShowEscaperoomController::class)->name('escaperoom.show');
    Route::get('/escaperoom/edit', EditEscaperoomController::class)->name('escaperoom.edit');
    Route::put('/escaperoom/edit', StoreEscaperoomController::class)->name('escaperoom.update');

    Route::delete('/escaperoom-address/{id}/delete', DeleteEscaperoomAddressController::class)->name('escaperoomAddress.destroy');
});