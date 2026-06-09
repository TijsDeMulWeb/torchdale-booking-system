<?php

use App\Http\Controllers\Order\IndexOrderController;
use App\Http\Controllers\Order\ShowCheckoutController;
use App\Http\Controllers\Order\ShowOrderInvoiceController;
use App\Http\Controllers\Order\StoreOrderController;
use App\Http\Controllers\AccountSetup\ShowAccountSetupController;
use App\Http\Controllers\AccountSetup\StoreAccountSetupController;
use App\Http\Controllers\PasswordSetup\ShowPasswordSetupController;
use App\Http\Controllers\PasswordSetup\StorePasswordSetupController;
use App\Http\Controllers\Admin\AcceptEscaperoomRequestController;
use App\Http\Controllers\Admin\DenyEscaperoomRequestController;
use App\Http\Controllers\Admin\LogoutAdminController;
use App\Http\Controllers\Admin\ShowAdminDashboardController;
use App\Http\Controllers\Admin\ShowAdminLoginController;
use App\Http\Controllers\Admin\StoreAdminLoginController;
use App\Http\Controllers\ApiKey\DeleteApiKeyController;
use App\Http\Controllers\ApiKey\IndexApiKeyController;
use App\Http\Controllers\ApiKey\StoreApiKeyController;
use App\Http\Controllers\ApiKey\UpdateApiKeyController;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Controllers\Category\EditCategoryController;
use App\Http\Controllers\Category\StoreCategoryController;
use App\Http\Controllers\Category\UpdateCategoryController;
use App\Http\Controllers\Chatbot\EditChatbotController;
use App\Http\Controllers\Chatbot\ShowChatbotController;
use App\Http\Controllers\Chatbot\UpdateChatbotController;
use App\Http\Controllers\Coupon\CreateCouponController;
use App\Http\Controllers\Coupon\SearchCouponController;
use App\Http\Controllers\Coupon\DeleteCouponController;
use App\Http\Controllers\Coupon\EditCouponController;
use App\Http\Controllers\Coupon\IndexCouponController;
use App\Http\Controllers\Coupon\StoreCouponController;
use App\Http\Controllers\Coupon\UpdateCouponController;
use App\Http\Controllers\Customer\SearchCustomerController;
use App\Http\Controllers\Customer\BanCustomerController;
use App\Http\Controllers\Customer\EditCustomerController;
use App\Http\Controllers\Customer\IndexCustomerController;
use App\Http\Controllers\Customer\ShowAppointmentCustomerController;
use App\Http\Controllers\Customer\ShowCustomerController;
use App\Http\Controllers\Customer\ShowGiftCardCustomerController;
use App\Http\Controllers\Customer\ShowMessageCustomerController;
use App\Http\Controllers\Customer\ShowPurchasesCustomerController;
use App\Http\Controllers\Customer\UnbanCustomerController;
use App\Http\Controllers\Customer\UpdateCustomerController;
use App\Http\Controllers\Dashboard\BlockTimeSlotController;
use App\Http\Controllers\Dashboard\BlockTimeSlotRangeController;
use App\Http\Controllers\Dashboard\ShowDashboardController;
use App\Http\Controllers\Dashboard\UnblockTimeSlotController;
use App\Http\Controllers\Dashboard\UnblockTimeSlotRangeController;
use App\Http\Controllers\Escaperoom\EditEscaperoomController;
use App\Http\Controllers\Escaperoom\ShowEscaperoomController;
use App\Http\Controllers\Escaperoom\UpdateEscaperoomController;
use App\Http\Controllers\EscaperoomAddress\CreateEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\DeleteEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\EditEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\StoreEscaperoomAddressController;
use App\Http\Controllers\EscaperoomAddress\UpdateEscaperoomAddressController;
use App\Http\Controllers\GiftCard\IndexGiftCardController;
use App\Http\Controllers\GiftCard\CreateGiftCardController;
use App\Http\Controllers\GiftCard\EditGiftCardController;
use App\Http\Controllers\GiftCard\DeleteGiftCardController;
use App\Http\Controllers\GiftCard\UpdateGiftCardController;
use App\Http\Controllers\GiftCard\StoreGiftCardController;
use App\Http\Controllers\Login\ShowLoginController;
use App\Http\Controllers\Login\StoreLoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Product\CreateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\Product\IndexProductController;
use App\Http\Controllers\Product\EditProductController;
use App\Http\Controllers\Product\StoreProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Category\IndexCategoryController;
use App\Http\Controllers\ProductImage\DeleteProductImageController;
use App\Http\Controllers\ProductImage\StoreProductImageController;
use App\Http\Controllers\Profile\DeleteProfileController;
use App\Http\Controllers\Profile\ShowProfileController;
use App\Http\Controllers\Profile\UpdatePasswordController;
use App\Http\Controllers\Profile\UpdateProfileController;
use App\Http\Controllers\Register\ShowRegisterController;
use App\Http\Controllers\Register\StoreRegisterController;
use App\Http\Controllers\Room\CreateRoomController;
use App\Http\Controllers\Room\DeleteRoomController;
use App\Http\Controllers\Room\DeleteRoomTimeSlotController;
use App\Http\Controllers\Room\EditRoomController;
use App\Http\Controllers\Room\IndexRoomController;
use App\Http\Controllers\Room\ShowRoomPriceController;
use App\Http\Controllers\Room\ShowRoomTimeSlotController;
use App\Http\Controllers\Room\StoreRoomController;
use App\Http\Controllers\Room\StoreRoomPriceController;
use App\Http\Controllers\Room\StoreRoomTimeSlotController;
use App\Http\Controllers\Room\UpdateRoomController;
use App\Http\Controllers\Room\UpdateRoomTimeSlotController;
use App\Http\Controllers\WidgetSettings\ShowWidgetSettingsController;
use App\Http\Controllers\WidgetSettings\UpdateWidgetSettingsController;
use App\Http\Controllers\User\CreateUserController;
use App\Http\Controllers\User\DeleteUserController;
use App\Http\Controllers\User\ResendUserInvitationController;
use App\Http\Controllers\User\EditUserController;
use App\Http\Controllers\User\IndexUserController;
use App\Http\Controllers\User\StoreUserController;
use App\Http\Controllers\User\UpdateUserController;
use App\Http\Controllers\Webhook\MollieWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/mollie', MollieWebhookController::class)->name('webhook.mollie');

Route::middleware('guest')->group(function () {
    Route::get('/login', ShowLoginController::class)->name('login');
    Route::post('/login', StoreLoginController::class)->name('login.store');
    Route::get('/register', ShowRegisterController::class)->name('register');
    Route::post('/register', StoreRegisterController::class)->name('register.store');

    Route::get('/account-setup', ShowAccountSetupController::class)->name('accountSetup.show');
    Route::post('/account-setup', StoreAccountSetupController::class)->name('accountSetup.store');

    Route::middleware('signed')->group(function () {
        Route::get('/password-setup/{user}', ShowPasswordSetupController::class)->name('passwordSetup.show');
        Route::post('/password-setup/{user}', StorePasswordSetupController::class)->name('passwordSetup.store');
    });
});

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('/login', ShowAdminLoginController::class)->name('admin.login');
    Route::post('/login', StoreAdminLoginController::class)->name('admin.login.store');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/', ShowAdminDashboardController::class)->name('admin.dashboard.show');
    Route::post('/logout', LogoutAdminController::class)->name('admin.logout');
    Route::post('/escaperoom-requests/{escaperoomRequest}/accept', AcceptEscaperoomRequestController::class)->name('admin.escaperoomRequests.accept');
    Route::post('/escaperoom-requests/{escaperoomRequest}/deny', DenyEscaperoomRequestController::class)->name('admin.escaperoomRequests.deny');
});

Route::middleware('auth')->group(function () {
    Route::get('/', ShowDashboardController::class)->name('dashboard.show');
    Route::post('/', LogoutController::class)->name('logout');

    // Dashboard routes
    Route::post('/dashboard/time-slots/block', BlockTimeSlotController::class)->name('dashboard.timeslots.block');
    Route::post('/dashboard/time-slots/block-range', BlockTimeSlotRangeController::class)->name('dashboard.timeslots.blockRange');
    Route::delete('/dashboard/time-slots/{timeSlot}/unblock', UnblockTimeSlotController::class)->name('dashboard.timeslots.unblock');
    Route::post('/dashboard/time-slots/unblock-range', UnblockTimeSlotRangeController::class)->name('dashboard.timeslots.unblockRange');
    Route::post('/dashboard/time-slots/book', \App\Http\Controllers\Dashboard\StoreManualBookingController::class)->name('dashboard.timeslots.book');
    Route::get('/dashboard/time-slots/{timeSlot}/booking', \App\Http\Controllers\Dashboard\GetBookingDetailsController::class)->name('dashboard.timeslots.bookingDetails');
    Route::post('/dashboard/time-slots/{timeSlot}/cancel', \App\Http\Controllers\Dashboard\CancelBookingController::class)->name('dashboard.timeslots.cancel');
    Route::post('/dashboard/time-slots/{timeSlot}/invoice', \App\Http\Controllers\Dashboard\SendBookingInvoiceController::class)->name('dashboard.timeslots.sendInvoice');
    Route::post('/dashboard/time-slots/{timeSlot}/mark-onsite-paid', \App\Http\Controllers\Dashboard\MarkOnsitePaymentController::class)->name('dashboard.timeslots.markOnsitePaid');
    Route::get('/dashboard/room-price', \App\Http\Controllers\Dashboard\GetRoomPriceController::class)->name('dashboard.roomPrice');

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
    Route::get('/users/create', CreateUserController::class)->name('users.create');
    Route::post('/users/create', StoreUserController::class)->name('users.store');
    Route::get('/users/{id}/edit', EditUserController::class)->name('users.edit');
    Route::put('/users/{id}/edit', UpdateUserController::class)->name('users.update');
    Route::delete('/users/{id}/delete', DeleteUserController::class)->name('users.destroy');
    Route::post('/users/{id}/resend-invitation', ResendUserInvitationController::class)->name('users.resendInvitation');

    // Profile routes
    Route::get('/profile', ShowProfileController::class)->name('profile.show');
    Route::put('/profile/{id}/edit', UpdateProfileController::class)->name('profile.update');
    Route::put('/profile/{id}/password', UpdatePasswordController::class)->name('profile.password');
    Route::delete('/profile/{id}/delete', DeleteProfileController::class)->name('profile.destroy');

    // Products routes
    Route::get('/products', IndexProductController::class)->name('products.index');
    Route::get('/products/{id}/edit', EditProductController::class)->name('products.edit');
    Route::put('/products/{id}/edit', UpdateProductController::class)->name('products.update');
    Route::get('/products/create', CreateProductController::class)->name('products.create');
    Route::post('/products/create', StoreProductController::class)->name('products.store');
    Route::delete('/products/{id}/delete', DeleteProductController::class)->name('products.destroy');

    // Product Images routes
    Route::post('/products/{id}/images/create', StoreProductImageController::class)->name('products.images.store');
    Route::delete('/products/{id}/images/{imageId}/delete', DeleteProductImageController::class)->name('products.images.destroy');

    // Categories routes
    Route::get('/categories', IndexCategoryController::class)->name('categories.index');
    Route::get('/categories/{id}/edit', EditCategoryController::class)->name('categories.edit');
    Route::put('/categories/{id}/edit', UpdateCategoryController::class)->name('categories.update');
    Route::post('/categories/create', StoreCategoryController::class)->name('categories.store');
    Route::delete('/categories/{id}/delete', DeleteCategoryController::class)->name('categories.destroy');

    // Coupons routes
    Route::get('/coupons/search', SearchCouponController::class)->name('coupons.search');
    Route::get('/coupons', IndexCouponController::class)->name('coupons.index');
    Route::get('/coupons/create', CreateCouponController::class)->name('coupons.create');
    Route::post('/coupons/create', StoreCouponController::class)->name('coupons.store');
    Route::get('/coupons/{id}/edit', EditCouponController::class)->name('coupons.edit');
    Route::put('/coupons/{id}/edit', UpdateCouponController::class)->name('coupons.update');
    Route::delete('/coupons/{id}/delete', DeleteCouponController::class)->name('coupons.destroy');

    // GiftCards routes
    Route::get('/gift-cards', IndexGiftCardController::class)->name('giftCards.index');
    Route::get('/gift-cards/{id}/edit', EditGiftCardController::class)->name('giftCards.edit');
    Route::put('/gift-cards/{id}/edit', UpdateGiftCardController::class)->name('giftCards.update');
    Route::get('/gift-cards/create', CreateGiftCardController::class)->name('giftCards.create');
    Route::post('/gift-cards/create', StoreGiftCardController::class)->name('giftCards.store');
    Route::delete('/gift-cards/{id}/delete', DeleteGiftCardController::class)->name('giftCards.destroy');

    // Rooms routes
    Route::get('/rooms', IndexRoomController::class)->name('rooms.index');
    Route::get('/rooms/create', CreateRoomController::class)->name('rooms.create');
    Route::post('/rooms/create', StoreRoomController::class)->name('rooms.store');
    Route::get('/rooms/{id}/edit', EditRoomController::class)->name('rooms.edit');
    Route::put('/rooms/{id}/edit', UpdateRoomController::class)->name('rooms.update');
    Route::delete('/rooms/{id}/delete', DeleteRoomController::class)->name('rooms.destroy');

    // Rooms prices routes
    Route::get('/rooms/{id}/prices', ShowRoomPriceController::class)->name('rooms.prices.show');
    Route::post('/rooms/{id}/prices', StoreRoomPriceController::class)->name('rooms.prices.store');

    // Rooms time slots routes
    Route::get('/rooms/{id}/timeslots', ShowRoomTimeSlotController::class)->name('rooms.timeslots.show');
    Route::delete('/rooms/{id}/timeslots/{timeslot}/delete', DeleteRoomTimeSlotController::class)->name('rooms.timeslots.destroy');
    Route::post('/rooms/{id}/timeslots/create', StoreRoomTimeSlotController::class)->name('rooms.timeslots.store');
    Route::put('/rooms/{id}/timeslots/{timeslot}/edit', UpdateRoomTimeSlotController::class)->name('rooms.timeslots.update');

    // Customer routes
    Route::get('/customers/search', SearchCustomerController::class)->name('customers.search');
    Route::post('/customers/quick-store', \App\Http\Controllers\Customer\QuickStoreCustomerController::class)->name('customers.quickStore');
    Route::get('/customers', IndexCustomerController::class)->name('customers.index');
    Route::get('/customers/{id}/overview', ShowCustomerController::class)->name('customers.show.overview');
    Route::get('/customers/{id}/overview/edit', EditCustomerController::class)->name('customers.edit.overview');
    Route::put('/customers/{id}/overview/edit', UpdateCustomerController::class)->name('customers.update.overview');
    Route::get('/customers/{id}/appointments', ShowAppointmentCustomerController::class)->name('customers.show.appointments');
    Route::get('/customers/{id}/messages', ShowMessageCustomerController::class)->name('customers.show.messages');
    Route::get('/customers/{id}/purchases', ShowPurchasesCustomerController::class)->name('customers.show.purchases');
    Route::get('/customers/{id}/gift-cards', ShowGiftCardCustomerController::class)->name('customers.show.gift-cards');
    Route::post('/customers/{id}/ban', BanCustomerController::class)->name('customers.ban');
    Route::post('/customers/{id}/unban', UnbanCustomerController::class)->name('customers.unban');

    // Widget Settings routes
    Route::get('/widget-settings', ShowWidgetSettingsController::class)->name('widgetSettings.show');
    Route::put('/widget-settings', UpdateWidgetSettingsController::class)->name('widgetSettings.update');

    // Orders routes
    Route::middleware('mollie.key')->group(function () {
        Route::get('/orders', IndexOrderController::class)->name('orders.index');
        Route::get('/orders/checkout', ShowCheckoutController::class)->name('orders.checkout');
        Route::post('/orders/checkout', StoreOrderController::class)->name('orders.store');
    });
    Route::get('/orders/open-orders', \App\Http\Controllers\Order\OpenOrdersController::class)->name('orders.open-orders');
    Route::get('/orders/gift-vouchers', \App\Http\Controllers\Order\GiftVoucherController::class)->name('orders.gift-vouchers');
    Route::post('/orders/gift-vouchers', \App\Http\Controllers\Order\StoreManualGiftVoucherController::class)->name('orders.gift-vouchers.store');
    Route::patch('/orders/gift-vouchers/{voucher}/delivery', \App\Http\Controllers\Order\UpdateGiftVoucherDeliveryController::class)->name('orders.gift-vouchers.delivery');
    Route::get('/orders/{order}/invoice', ShowOrderInvoiceController::class)->name('orders.invoice');

    // API Keys routes
    Route::get('/api-keys', IndexApiKeyController::class)->name('apiKeys.index');
    Route::post('/api-keys/create', StoreApiKeyController::class)->name('apiKeys.create');
    Route::patch('/api-keys/{id}/update', UpdateApiKeyController::class)->name('apiKeys.update');
    Route::delete('/api-keys/{id}/delete', DeleteApiKeyController::class)->name('apiKeys.destroy');
});