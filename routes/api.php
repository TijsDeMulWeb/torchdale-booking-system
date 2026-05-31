<?php

use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\ChatbotController;
use App\Http\Middleware\AuthenticateEscaperoom;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateEscaperoom::class])->group(function () {
    Route::post('/chat', ChatbotController::class)->name('chat.index');
    Route::get('/product-categories', ProductCategoryController::class)->name('product-categories.index');
    Route::get('/room-addresses', RoomController::class)->name('room-addresses.index');
});
