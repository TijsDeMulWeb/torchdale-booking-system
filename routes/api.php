<?php

use App\Http\Controllers\Api\ProductCategoriesController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Middleware\AuthenticateEscaperoom;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateEscaperoom::class])->group(function () {
    Route::post('/chat', ChatbotController::class)->name('chat.index');
    Route::get('/products', ProductController::class)->name('products.index');
    Route::get('/product-categories', ProductCategoriesController::class)->name('product-categories.index');
});
