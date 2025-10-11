<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES (CLIENT)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// cartController
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

// Sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');
    Route::get('/color/{slug}', [ProductController::class, 'showByColor'])->name('products.color');
    Route::get('/size/{slug}', [ProductController::class, 'showBySize'])->name('products.size');

// Danh mục sản phẩm
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Giỏ hàng
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// // Thanh toán
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
  
// Đơn hàng người dùng
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Tài khoản cá nhân
Route::prefix('account')->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Đăng nhập / Đăng ký
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('forgot-password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('forgot-password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Quên mật khẩu
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('forgot-password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('forgot-password.update');

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// GOOGLE LOGIN
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')

    // Nếu bạn đã tạo middleware auth + is_admin thì bật lại
    ->middleware(['auth', 'is_admin']) // thêm middleware kiểm tra admin

    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Danh mục
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // Sản phẩm
        Route::resource('products', AdminProductController::class);
        Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');

        // Biến thể sản phẩm
        Route::get('product-variants', [AdminProductController::class, 'variants'])->name('products.variants');
        Route::get('product-variants/{type}', [AdminProductController::class, 'variantsByType'])->name('products.variants.type');
        Route::post('product-variants', [AdminProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::get('product-variants/{variant}/edit', [AdminProductController::class, 'editVariant'])->name('products.variants.edit');
        Route::put('product-variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
        Route::delete('product-variants/{variant}', [AdminProductController::class, 'destroyVariant'])->name('products.variants.destroy');

        // // Đơn hàng
        // Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // // Người dùng
        // Route::resource('users', AdminUserController::class);
    });
