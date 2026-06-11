<?php

use App\Http\Controllers\Order\IndexOrderController;
use App\Http\Controllers\Order\ShowCheckoutController;
use App\Http\Controllers\Order\ShowOrderInvoiceController;
use App\Http\Controllers\Order\ShowOrderPaymentLinkController;
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
use App\Http\Controllers\MailTemplate\MailTemplateController;
use App\Http\Controllers\Role\CreateRoleController;
use App\Http\Controllers\Role\DeleteRoleController;
use App\Http\Controllers\Role\EditRoleController;
use App\Http\Controllers\Role\IndexRoleController;
use App\Http\Controllers\Role\StoreRoleController;
use App\Http\Controllers\Role\UpdateRoleController;
use App\Http\Controllers\Webhook\MollieWebhookController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/mollie', MollieWebhookController::class)->name('webhook.mollie');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
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

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', ShowDashboardController::class)->name('dashboard.show');
        Route::post('/', LogoutController::class)->name('logout');

        // Dashboard routes
        Route::middleware('permission:view dashboard')->group(function () {
            Route::get('/dashboard/time-slots/{timeSlot}/booking', \App\Http\Controllers\Dashboard\GetBookingDetailsController::class)->name('dashboard.timeslots.bookingDetails');
            Route::get('/dashboard/room-price', \App\Http\Controllers\Dashboard\GetRoomPriceController::class)->name('dashboard.roomPrice');
        });
        Route::middleware('permission:manage bookings')->group(function () {
            Route::post('/dashboard/time-slots/block', BlockTimeSlotController::class)->name('dashboard.timeslots.block');
            Route::post('/dashboard/time-slots/block-range', BlockTimeSlotRangeController::class)->name('dashboard.timeslots.blockRange');
            Route::delete('/dashboard/time-slots/{timeSlot}/unblock', UnblockTimeSlotController::class)->name('dashboard.timeslots.unblock');
            Route::post('/dashboard/time-slots/unblock-range', UnblockTimeSlotRangeController::class)->name('dashboard.timeslots.unblockRange');
            Route::post('/dashboard/time-slots/book', \App\Http\Controllers\Dashboard\StoreManualBookingController::class)->name('dashboard.timeslots.book');
            Route::post('/dashboard/time-slots/{timeSlot}/cancel', \App\Http\Controllers\Dashboard\CancelBookingController::class)->name('dashboard.timeslots.cancel');
            Route::post('/dashboard/time-slots/{timeSlot}/invoice', \App\Http\Controllers\Dashboard\SendBookingInvoiceController::class)->name('dashboard.timeslots.sendInvoice');
            Route::post('/dashboard/time-slots/{timeSlot}/mark-onsite-paid', \App\Http\Controllers\Dashboard\MarkOnsitePaymentController::class)->name('dashboard.timeslots.markOnsitePaid');
        });

        // Chatbot routes
        Route::middleware('permission:view chatbot')->group(function () {
            Route::get('/chatbot', ShowChatbotController::class)->name('chatbot.show');
        });
        Route::middleware('permission:edit chatbot')->group(function () {
            Route::get('/chatbot/edit', EditChatbotController::class)->name('chatbot.edit');
            Route::put('/chatbot/edit', UpdateChatbotController::class)->name('chatbot.update');
        });

        // Escaperoom routes
        Route::middleware('permission:view settings')->group(function () {
            Route::get('/escaperoom', ShowEscaperoomController::class)->name('escaperoom.show');
        });
        Route::middleware('permission:edit settings')->group(function () {
            Route::get('/escaperoom/edit', EditEscaperoomController::class)->name('escaperoom.edit');
            Route::put('/escaperoom/edit', UpdateEscaperoomController::class)->name('escaperoom.update');

            // EscaperoomAddress routes
            Route::get('/escaperoom-address/create', CreateEscaperoomAddressController::class)->name('escaperoomAddress.create');
            Route::post('/escaperoom-address/create', StoreEscaperoomAddressController::class)->name('escaperoomAddress.store');
            Route::get('/escaperoom-address/{id}/edit', EditEscaperoomAddressController::class)->name('escaperoomAddress.edit');
            Route::put('/escaperoom-address/{id}/edit', UpdateEscaperoomAddressController::class)->name('escaperoomAddress.update');
            Route::delete('/escaperoom-address/{id}/delete', DeleteEscaperoomAddressController::class)->name('escaperoomAddress.destroy');
        });

        // Employees routes
        Route::middleware('permission:view users')->group(function () {
            Route::get('/users', IndexUserController::class)->name('users.index');
        });
        Route::middleware('permission:create users')->group(function () {
            Route::get('/users/create', CreateUserController::class)->name('users.create');
            Route::post('/users/create', StoreUserController::class)->name('users.store');
        });
        Route::middleware('permission:edit users')->group(function () {
            Route::get('/users/{id}/edit', EditUserController::class)->name('users.edit');
            Route::put('/users/{id}/edit', UpdateUserController::class)->name('users.update');
            Route::post('/users/{id}/resend-invitation', ResendUserInvitationController::class)->name('users.resendInvitation');
        });
        Route::middleware('permission:delete users')->group(function () {
            Route::delete('/users/{id}/delete', DeleteUserController::class)->name('users.destroy');
        });

        // Roles & permissions routes
        Route::middleware('permission:view roles')->group(function () {
            Route::get('/roles', IndexRoleController::class)->name('roles.index');
        });
        Route::middleware('permission:create roles')->group(function () {
            Route::get('/roles/create', CreateRoleController::class)->name('roles.create');
            Route::post('/roles', StoreRoleController::class)->name('roles.store');
        });
        Route::middleware('permission:edit roles')->group(function () {
            Route::get('/roles/{role}/edit', EditRoleController::class)->name('roles.edit');
            Route::put('/roles/{role}', UpdateRoleController::class)->name('roles.update');
        });
        Route::middleware('permission:delete roles')->group(function () {
            Route::delete('/roles/{role}', DeleteRoleController::class)->name('roles.destroy');
        });

        // Profile routes
        Route::get('/profile', ShowProfileController::class)->name('profile.show');
        Route::put('/profile/{id}/edit', UpdateProfileController::class)->name('profile.update');
        Route::put('/profile/{id}/password', UpdatePasswordController::class)->name('profile.password');
        Route::delete('/profile/{id}/delete', DeleteProfileController::class)->name('profile.destroy');

        // Products routes
        Route::middleware('permission:view products')->group(function () {
            Route::get('/products', IndexProductController::class)->name('products.index');
            Route::get('/categories', IndexCategoryController::class)->name('categories.index');
        });
        Route::middleware('permission:create products')->group(function () {
            Route::get('/products/create', CreateProductController::class)->name('products.create');
            Route::post('/products/create', StoreProductController::class)->name('products.store');
            Route::post('/categories/create', StoreCategoryController::class)->name('categories.store');
        });
        Route::middleware('permission:edit products')->group(function () {
            Route::get('/products/{id}/edit', EditProductController::class)->name('products.edit');
            Route::put('/products/{id}/edit', UpdateProductController::class)->name('products.update');

            // Product Images routes
            Route::post('/products/{id}/images/create', StoreProductImageController::class)->name('products.images.store');
            Route::delete('/products/{id}/images/{imageId}/delete', DeleteProductImageController::class)->name('products.images.destroy');

            // Categories routes
            Route::get('/categories/{id}/edit', EditCategoryController::class)->name('categories.edit');
            Route::put('/categories/{id}/edit', UpdateCategoryController::class)->name('categories.update');
        });
        Route::middleware('permission:delete products')->group(function () {
            Route::delete('/products/{id}/delete', DeleteProductController::class)->name('products.destroy');
            Route::delete('/categories/{id}/delete', DeleteCategoryController::class)->name('categories.destroy');
        });

        // Coupons routes
        Route::middleware('permission:view coupons')->group(function () {
            Route::get('/coupons/search', SearchCouponController::class)->name('coupons.search');
            Route::get('/coupons', IndexCouponController::class)->name('coupons.index');
        });
        Route::middleware('permission:create coupons')->group(function () {
            Route::get('/coupons/create', CreateCouponController::class)->name('coupons.create');
            Route::post('/coupons/create', StoreCouponController::class)->name('coupons.store');
        });
        Route::middleware('permission:edit coupons')->group(function () {
            Route::get('/coupons/{id}/edit', EditCouponController::class)->name('coupons.edit');
            Route::put('/coupons/{id}/edit', UpdateCouponController::class)->name('coupons.update');
        });
        Route::middleware('permission:delete coupons')->group(function () {
            Route::delete('/coupons/{id}/delete', DeleteCouponController::class)->name('coupons.destroy');
        });

        // Mail templates
        Route::middleware('permission:view mail templates')->group(function () {
            Route::get('/mail-templates/{type}', [MailTemplateController::class, 'index'])->name('mail-templates.index')->where('type', 'product|gift-card');

            // Room-specific mail templates (subtype = confirmation | reminder | cancellation)
            Route::get('/rooms/{room}/mail-templates', function (\App\Models\Room $room) {
                return redirect()->route('mail-templates.room.index', [$room, 'confirmation']);
            })->name('mail-templates.room.index.default');
            Route::get('/rooms/{room}/mail-templates/{subtype}', [MailTemplateController::class, 'roomIndex'])->name('mail-templates.room.index')->where('subtype', 'confirmation|reminder|cancellation');
        });
        Route::middleware('permission:edit mail templates')->group(function () {
            Route::post('/mail-templates/{type}/upload-image', [MailTemplateController::class, 'uploadImage'])->name('mail-templates.upload-image')->where('type', 'product|gift-card');
            Route::get('/mail-templates/{type}/create', [MailTemplateController::class, 'create'])->name('mail-templates.create')->where('type', 'product|gift-card');
            Route::post('/mail-templates/{type}', [MailTemplateController::class, 'store'])->name('mail-templates.store')->where('type', 'product|gift-card');
            Route::get('/mail-templates/{type}/{template}/edit', [MailTemplateController::class, 'edit'])->name('mail-templates.edit')->where('type', 'product|gift-card');
            Route::put('/mail-templates/{type}/{template}', [MailTemplateController::class, 'update'])->name('mail-templates.update')->where('type', 'product|gift-card');
            Route::delete('/mail-templates/{type}/{template}', [MailTemplateController::class, 'destroy'])->name('mail-templates.destroy')->where('type', 'product|gift-card');

            Route::post('/rooms/{room}/mail-templates/{subtype}/upload-image', [MailTemplateController::class, 'roomUploadImage'])->name('mail-templates.room.upload-image')->where('subtype', 'confirmation|reminder|cancellation');
            Route::get('/rooms/{room}/mail-templates/{subtype}/create', [MailTemplateController::class, 'roomCreate'])->name('mail-templates.room.create')->where('subtype', 'confirmation|reminder|cancellation');
            Route::post('/rooms/{room}/mail-templates/{subtype}', [MailTemplateController::class, 'roomStore'])->name('mail-templates.room.store')->where('subtype', 'confirmation|reminder|cancellation');
            Route::get('/rooms/{room}/mail-templates/{subtype}/{template}/edit', [MailTemplateController::class, 'roomEdit'])->name('mail-templates.room.edit')->where('subtype', 'confirmation|reminder|cancellation');
            Route::put('/rooms/{room}/mail-templates/{subtype}/{template}', [MailTemplateController::class, 'roomUpdate'])->name('mail-templates.room.update')->where('subtype', 'confirmation|reminder|cancellation');
            Route::delete('/rooms/{room}/mail-templates/{subtype}/{template}', [MailTemplateController::class, 'roomDestroy'])->name('mail-templates.room.destroy')->where('subtype', 'confirmation|reminder|cancellation');
        });

        // GiftCards routes
        Route::middleware('permission:view gift cards')->group(function () {
            Route::get('/gift-cards', IndexGiftCardController::class)->name('giftCards.index');
        });
        Route::middleware('permission:create gift cards')->group(function () {
            Route::get('/gift-cards/create', CreateGiftCardController::class)->name('giftCards.create');
            Route::post('/gift-cards/create', StoreGiftCardController::class)->name('giftCards.store');
        });
        Route::middleware('permission:edit gift cards')->group(function () {
            Route::get('/gift-cards/{id}/edit', EditGiftCardController::class)->name('giftCards.edit');
            Route::put('/gift-cards/{id}/edit', UpdateGiftCardController::class)->name('giftCards.update');
        });
        Route::middleware('permission:delete gift cards')->group(function () {
            Route::delete('/gift-cards/{id}/delete', DeleteGiftCardController::class)->name('giftCards.destroy');
        });

        // Rooms routes
        Route::middleware('permission:view rooms')->group(function () {
            Route::get('/rooms', IndexRoomController::class)->name('rooms.index');
            Route::get('/rooms/{id}/prices', ShowRoomPriceController::class)->name('rooms.prices.show');
            Route::get('/rooms/{id}/timeslots', ShowRoomTimeSlotController::class)->name('rooms.timeslots.show');
        });
        Route::middleware('permission:create rooms')->group(function () {
            Route::get('/rooms/create', CreateRoomController::class)->name('rooms.create');
            Route::post('/rooms/create', StoreRoomController::class)->name('rooms.store');
        });
        Route::middleware('permission:edit rooms')->group(function () {
            Route::get('/rooms/{id}/edit', EditRoomController::class)->name('rooms.edit');
            Route::put('/rooms/{id}/edit', UpdateRoomController::class)->name('rooms.update');

            // Rooms prices routes
            Route::post('/rooms/{id}/prices', StoreRoomPriceController::class)->name('rooms.prices.store');

            // Rooms time slots routes
            Route::delete('/rooms/{id}/timeslots/{timeslot}/delete', DeleteRoomTimeSlotController::class)->name('rooms.timeslots.destroy');
            Route::post('/rooms/{id}/timeslots/create', StoreRoomTimeSlotController::class)->name('rooms.timeslots.store');
            Route::put('/rooms/{id}/timeslots/{timeslot}/edit', UpdateRoomTimeSlotController::class)->name('rooms.timeslots.update');
        });
        Route::middleware('permission:delete rooms')->group(function () {
            Route::delete('/rooms/{id}/delete', DeleteRoomController::class)->name('rooms.destroy');
        });

        // Customer routes
        Route::middleware('permission:view customers')->group(function () {
            Route::get('/customers/search', SearchCustomerController::class)->name('customers.search');
            Route::get('/customers', IndexCustomerController::class)->name('customers.index');
            Route::get('/customers/{id}/overview', ShowCustomerController::class)->name('customers.show.overview');
            Route::get('/customers/{id}/appointments', ShowAppointmentCustomerController::class)->name('customers.show.appointments');
            Route::get('/customers/{id}/messages', ShowMessageCustomerController::class)->name('customers.show.messages');
            Route::get('/customers/{id}/purchases', ShowPurchasesCustomerController::class)->name('customers.show.purchases');
            Route::get('/customers/{id}/gift-cards', ShowGiftCardCustomerController::class)->name('customers.show.gift-cards');
        });
        Route::middleware('permission:create customers')->group(function () {
            Route::post('/customers/quick-store', \App\Http\Controllers\Customer\QuickStoreCustomerController::class)->name('customers.quickStore');
        });
        Route::middleware('permission:edit customers')->group(function () {
            Route::get('/customers/{id}/overview/edit', EditCustomerController::class)->name('customers.edit.overview');
            Route::put('/customers/{id}/overview/edit', UpdateCustomerController::class)->name('customers.update.overview');
            Route::post('/customers/{id}/ban', BanCustomerController::class)->name('customers.ban');
            Route::post('/customers/{id}/unban', UnbanCustomerController::class)->name('customers.unban');
        });

        // Widget Settings routes
        Route::middleware('permission:view widgets')->group(function () {
            Route::get('/widget-settings', ShowWidgetSettingsController::class)->name('widgetSettings.show');
        });
        Route::middleware('permission:edit widgets')->group(function () {
            Route::put('/widget-settings', UpdateWidgetSettingsController::class)->name('widgetSettings.update');
        });

        // Orders routes
        Route::middleware('permission:view orders')->group(function () {
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
            Route::get('/orders/{order}/payment-link', ShowOrderPaymentLinkController::class)->name('orders.payment-link');
        });

        // API Keys routes
        Route::middleware('permission:view settings')->group(function () {
            Route::get('/api-keys', IndexApiKeyController::class)->name('apiKeys.index');
        });
        Route::middleware('permission:edit settings')->group(function () {
            Route::post('/api-keys/create', StoreApiKeyController::class)->name('apiKeys.create');
            Route::patch('/api-keys/{id}/update', UpdateApiKeyController::class)->name('apiKeys.update');
            Route::delete('/api-keys/{id}/delete', DeleteApiKeyController::class)->name('apiKeys.destroy');
        });
    });});
