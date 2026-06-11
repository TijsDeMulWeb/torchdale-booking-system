<?php

use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\LegalDocumentController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\GiftCardController;
use App\Http\Controllers\Api\RoomAvailabilityController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ValidateCouponController;
use App\Http\Controllers\Api\WidgetConfigController;
use App\Http\Controllers\ChatbotController;
use App\Http\Middleware\AuthenticateEscaperoom;
use Illuminate\Support\Facades\Route;


Route::middleware([AuthenticateEscaperoom::class])->group(function () {
    Route::post('/chat', ChatbotController::class)->name('chat.index');
    Route::get('/product-categories', ProductCategoryController::class)->name('product-categories.index');
    Route::get('/products/{product}', ProductController::class)->name('products.show');
    Route::get('/room-addresses', RoomController::class)->name('room-addresses.index');
    Route::get('/rooms/{room}/availability', RoomAvailabilityController::class)->name('rooms.availability');
    Route::post('/coupon/validate', ValidateCouponController::class)->name('coupon.validate');
    Route::get('/widget-config', WidgetConfigController::class)->name('widget-config.index');
    Route::get('/gift-cards', GiftCardController::class)->name('gift-cards.index');
    Route::get('/legal-documents', LegalDocumentController::class)->name('legal-documents.index');
    Route::post('/checkout', CheckoutController::class)->name('checkout.index');
    Route::get('/orders/{order}/status', OrderStatusController::class)->name('orders.status');
});
