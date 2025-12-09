<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVoucherController;
// use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\AdminAttributeController;
use App\Http\Controllers\Admin\AdminChatController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\Staff\StaffController;
use Symfony\Component\HttpFoundation\Request;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// 🏠 Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🛍️ Sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/search/suggestions', [ProductController::class, 'suggest'])->name('products.suggest');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');
    Route::get('/color/{slug}', [ProductController::class, 'showByColor'])->name('products.color');
    Route::get('/size/{slug}', [ProductController::class, 'showBySize'])->name('products.size');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// 🗂️ Danh mục
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::middleware('auth')->group(function () {
    Route::get('chat', [ChatsController::class, 'index'])->name('chat');
});

Route::get('/fetch-messages', [ChatsController::class, 'fetchMessagesFromUserToAdmin'])->name('fetch.messagesFromSellerToAdmin');
Route::post('/send-message', [ChatsController::class, 'sendMessageFromUserToAdmin'])->name('send.Messageofsellertoadmin');

// 📰 Blog / Tin tức
Route::prefix('blog')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('blog.show');
});

// ✉️ Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 🛒 Giỏ hàng (chỉ cho user đã đăng nhập)
Route::middleware('auth')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id?}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});


// 💳 Thanh toán
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/refresh-csrf-token', [CheckoutController::class, 'refreshCsrfToken'])->name('refresh.csrf.token');

    // ➕ THÊM MỚI: Mua ngay (chuyển thẳng sang checkout với 1 biến thể & số lượng)
    Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('checkout.buy_now');

    // Address management routes for checkout
    Route::prefix('checkout')->group(function () {
        Route::post('/address/add', [AddressController::class, 'store'])->name('checkout.address.add');
        Route::put('/address/update/{address}', [AddressController::class, 'update'])->name('checkout.address.update');
        Route::delete('/address/delete/{address}', [AddressController::class, 'destroy'])->name('checkout.address.delete');
        Route::get('/address/get/{address}', [AddressController::class, 'show'])->name('checkout.address.get');
        Route::patch('/address/set-default/{address}', [AddressController::class, 'setDefault'])->name('checkout.address.set-default');

        // Address list route for checkout
        Route::get('/addresses/get', [AddressController::class, 'index'])->name('checkout.addresses.get');

        // User info routes
        Route::get('/user-info/get', [AccountController::class, 'getUserInfo'])->name('checkout.user-info.get');
        Route::post('/user-info/update', [AccountController::class, 'update'])->name('checkout.user-info.update');
        Route::post('/user-info/clear-address', [AccountController::class, 'clearAddress'])->name('checkout.user-info.clear-address');

        // Voucher routes
        Route::get('/vouchers/get', [AccountController::class, 'getVouchers'])->name('checkout.vouchers.get');
        Route::post('/voucher/apply', [AccountController::class, 'applyVoucher'])->name('checkout.voucher.apply');
        Route::post('/voucher/remove', [AccountController::class, 'removeVoucher'])->name('checkout.voucher.remove');
    });
});


// 💰 Thanh toán Momo
Route::prefix('payment/momo')->group(function () {
    Route::post('/create', 'App\Http\Controllers\PaymentController@createMomoPayment')->name('payment.momo.create');
    Route::get('/qr', 'App\Http\Controllers\PaymentController@showMomoQR')->name('payment.momo.qr');
    Route::get('/return', 'App\Http\Controllers\PaymentController@momoReturn')->name('payment.momo.return');
    Route::post('/notify', 'App\Http\Controllers\PaymentController@momoNotify')->name('payment.momo.notify');
    Route::get('/status', 'App\Http\Controllers\PaymentController@checkPaymentStatus')->name('payment.momo.status');
});

// 💳 Thanh toán ATM
Route::prefix('payment/atm')->group(function () {
    Route::get('/', 'App\Http\Controllers\PaymentController@showATM')->name('payment.atm');
    Route::post('/process', 'App\Http\Controllers\PaymentController@processATM')->name('payment.atm.process');
});

// 🏦 Thanh toán VNPay
Route::prefix('payment/vnpay')->group(function () {
    Route::get('/return', 'App\Http\Controllers\VNPayController@return')->name('payment.vnpay.return');
    Route::post('/ipn', 'App\Http\Controllers\VNPayController@ipn')->name('payment.vnpay.ipn');
});

// 📦 Đơn hàng người dùng
Route::prefix('orders')->middleware('auth')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');
    // Thêm: người dùng bấm "Hoàn thành" khi đơn đang ở trạng thái ĐÃ GIAO (4)
    Route::post('/{id}/complete', [OrderController::class, 'complete'])->name('orders.complete')->middleware('auth');
});

// 👤 Tài khoản cá nhân
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.dashboard');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/addresses', [AccountController::class, 'address'])->name('account.addresses');
    Route::get('/account/profile', [AccountController::class, 'edit'])->name('account.profile');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password');
    Route::post('/account/change-password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    // Địa chỉ người dùng
    Route::prefix('addresses')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('addresses.index');
        Route::post('/', [AddressController::class, 'store'])->name('addresses.store');
        Route::put('/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::patch('/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
    });

    // Wishlist routes
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::post('/check', [WishlistController::class, 'check'])->name('wishlist.check');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Người dùng)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// 🔑 Đăng nhập Google
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [StaffController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [StaffController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [StaffController::class, 'updateStatus'])->name('orders.status');
});




Route::prefix('admin')
    ->middleware(['auth:admin', 'is_admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('chat', [AdminChatController::class, 'index'])->name('chat');

        Route::get('fetch-messages', [ChatsController::class, 'fetchMessages'])->name('fetchMessages');
        Route::post('send-message', [ChatsController::class, 'sendMessage'])->name('sendMessage');

        // Danh mục
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // Sản phẩm
        Route::resource('products', AdminProductController::class);
        Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');

        // Biến thể sản phẩm
        Route::get('product-variants', [AdminProductController::class, 'variants'])->name('products.variants');
        Route::get('products/{productId}/variants', [AdminProductController::class, 'productVariants'])->name('products.variants.product');
        Route::get('product-variants/{type}', [AdminProductController::class, 'variantsByType'])->name('products.variants.type');
        Route::post('products/{productId}/variants', [AdminProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::post('products/{productId}/variants/bulk', [AdminProductController::class, 'bulkStoreVariants'])->name('products.variants.bulk-store');
        Route::get('product-variants/{variant}/edit', [AdminProductController::class, 'editVariant'])->name('products.variants.edit');
        Route::put('product-variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
        Route::delete('product-variants/{variant}', [AdminProductController::class, 'destroyVariant'])->name('products.variants.destroy');

        // Voucher
        Route::resource('vouchers', AdminVoucherController::class);

        // Đơn hàng
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::delete('orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('orders/{id}/status', [AdminOrderController::class, 'update'])->name('orders.status');

        Route::get('orders/{order}/assign', [AdminOrderController::class, 'assignForm'])->name('orders.assignForm');
        Route::post('orders/{order}/assign', [AdminOrderController::class, 'assignStaff'])->name('orders.assignStaff');


        // Tin tức
        // Route::resource('news', AdminNewsController::class);

        // Liên hệ
        // Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'destroy']);

        // Người dùng
        Route::resource('users', AdminUserController::class);
        Route::post('users/{user}/toggle-lock', [AdminUserController::class, 'toggleLock'])->name('users.toggleLock');
        Route::post('users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore');

        // 📦 Quản lý kho hàng
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::patch('inventory/{variant}', [InventoryController::class, 'updateQuantity'])->name('inventory.update');
        Route::patch('inventory/bulk', [InventoryController::class, 'bulkUpdate'])->name('inventory.bulk');

        // 🎨 Quản lý thuộc tính - Màu sắc
        Route::prefix('attributes/colors')->name('attributes.colors.')->group(function () {
            Route::get('/', [AdminAttributeController::class, 'colorsIndex'])->name('index');
            Route::get('/create', [AdminAttributeController::class, 'colorsCreate'])->name('create');
            Route::post('/', [AdminAttributeController::class, 'colorsStore'])->name('store');
            Route::get('/{color}/edit', [AdminAttributeController::class, 'colorsEdit'])->name('edit');
            Route::put('/{color}', [AdminAttributeController::class, 'colorsUpdate'])->name('update');
            Route::delete('/{color}', [AdminAttributeController::class, 'colorsDestroy'])->name('destroy');
        });

        // 📏 Quản lý thuộc tính - Kích thước
        Route::prefix('attributes/sizes')->name('attributes.sizes.')->group(function () {
            Route::get('/', [AdminAttributeController::class, 'sizesIndex'])->name('index');
            Route::get('/create', [AdminAttributeController::class, 'sizesCreate'])->name('create');
            Route::post('/', [AdminAttributeController::class, 'sizesStore'])->name('store');
            Route::get('/{size}/edit', [AdminAttributeController::class, 'sizesEdit'])->name('edit');
            Route::put('/{size}', [AdminAttributeController::class, 'sizesUpdate'])->name('update');
            Route::delete('/{size}', [AdminAttributeController::class, 'sizesDestroy'])->name('destroy');
        });
    });


Route::post('/chat/admin-typing', function (Request $request) {
    $adminId = auth('admin')->id();
    $sellerId = $request->receiver_id;
    $isTyping = $request->boolean('is_typing', true);

    if ($adminId && $sellerId) {
        broadcast(new \App\Events\AdminTypingEvent($adminId, $sellerId, $isTyping));
    }

    return response()->json(['status' => 'ok']);
})->name('chat.admin.typing');

Route::post('/chat/user-typing', function (Request $request) {
    $sellerId = auth()->id();
    $adminId = $request->receiver_id;
    $isTyping = $request->boolean('is_typing', true);

    if ($sellerId && $adminId) {
        broadcast(new \App\Events\SellerTypingEvent($sellerId, $adminId, $isTyping));
    }

    return response()->json(['status' => 'ok']);
})->name('chat.user.typing');

Route::post('/chat/mark-as-read', [ChatsController::class, 'markAsRead'])->name('chat.markAsRead');

Route::get('/chat/unread-counts', [ChatsController::class, 'getUnreadCounts'])->name('chat.unreadCounts');