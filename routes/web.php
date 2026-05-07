<?php

use App\Http\Controllers\Chatbot\EditChatbotController;
use App\Http\Controllers\Chatbot\ShowChatbotController;
use App\Http\Controllers\Chatbot\UpdateChatbotController;
use App\Http\Controllers\Dashboard\ShowDashboardController;
use App\Http\Controllers\Escaperoom\EditEscaperoomController;
use App\Http\Controllers\Escaperoom\ShowEscaperoomController;
use App\Http\Controllers\Escaperoom\UpdateEscaperoomController;
use App\Http\Controllers\EscaperoomAddress\CreateEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\DeleteEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\EditEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\StoreEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\UpdateEscaperoomAddressController;
use App\Http\Controllers\Login\ShowLoginController;
use App\Http\Controllers\Login\StoreLoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\User\EditUserController;
use App\Http\Controllers\User\IndexUserController;
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
    Route::put('/chatbot/edit', UpdateChatbotController::class)->name('chatbot.update');

    // Escaperoom routes
    Route::get('/escaperoom', ShowEscaperoomController::class)->name('escaperoom.show');
    Route::get('/escaperoom/edit', EditEscaperoomController::class)->name('escaperoom.edit');
    Route::put('/escaperoom/edit', UpdateEscaperoomController::class)->name('escaperoom.update');

    // EscaperoomAddress routes
    Route::get('/escaperoom-address/create', CreateEscaperoomAddressController::class)->name('escaperoomAddress.create');
    Route::post('/escaperoom-address/create', StoreEscaperoomAddressController::class)->name('escaperoomAddress.store');
    Route::get('/escaperoom-address/{id}/edit', EditEscaperoomAddressController::class)->name('escaperoomAddress.edit');
    Route::put('/escaperoom-address/{id}/edit', UpdateEscaperoomAddressController::class)->name('escaperoomAddress.update');
    Route::delete('/escaperoom-address/{id}/delete', DeleteEscaperoomAddressController::class)->name('escaperoomAddress.destroy');

    // Employees routes
    Route::get('/users', IndexUserController::class)->name('users.index');
    Route::get('/users/{id}/edit', EditUserController::class)->name('users.edit');
});