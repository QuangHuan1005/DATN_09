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
use App\Http\Controllers\WishlistController;

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

// 🗂️ Danh mục
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// 📰 Blog / Tin tức
Route::prefix('blog')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('blog.show');
});

// ✉️ Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 🛒 Giỏ hàng
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// 💳 Thanh toán
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
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

Route::prefix('admin')
    // ->middleware(['auth', 'is_admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Danh mục
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // Sản phẩm
        Route::resource('products', AdminProductController::class);
        Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');

        // Biến thể sản phẩm
        Route::get('product-variants', [AdminProductController::class, 'variants'])->name('products.variants');
        Route::get('products/{productId}/variants', [AdminProductController::class, 'productVariants'])->name('products.variants.product');
        Route::get('product-variants/{type}', [AdminProductController::class, 'variantsByType'])->name('products.variants.type');
        Route::post('product-variants', [AdminProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::get('product-variants/{variant}/edit', [AdminProductController::class, 'editVariant'])->name('products.variants.edit');
        Route::put('product-variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
        Route::delete('product-variants/{variant}', [AdminProductController::class, 'destroyVariant'])->name('products.variants.destroy');

        // Voucher
        Route::resource('vouchers', AdminVoucherController::class);

        // Đơn hàng
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::delete('orders/{id}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('orders/{id}/status', [AdminOrderController::class, 'update'])->name('orders.status');

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
    });
