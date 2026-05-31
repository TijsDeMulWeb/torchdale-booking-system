<?php

use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Middleware\AuthenticateEscaperoom;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateEscaperoom::class])->group(function () {
    Route::post('/chat', ChatbotController::class)->name('chat.index');
    Route::get('/products', ProductController::class)->name('products.index');
    Route::get('/product-categories', ProductCategoryController::class)->name('product-categories.index');
    Route::get('/rooms', RoomController::class)->name('rooms.index');
});
