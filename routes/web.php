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

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/search/suggestions', [ProductController::class, 'suggest'])->name('products.suggest');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.category');
    Route::get('/color/{slug}', [ProductController::class, 'showByColor'])->name('products.color');
    Route::get('/size/{slug}', [ProductController::class, 'showBySize'])->name('products.size');
});

// Danh mục sản phẩm
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Blog - Tin tức
Route::prefix('blog')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('blog.index');       // danh sách bài viết
    Route::get('/{slug}', [NewsController::class, 'show'])->name('blog.show');   // chi tiết bài viết
});

// Liên hệ
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');  // trang form liên hệ
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store'); // submit form

/*
|---------------------------
| ADMIN (đặt trong nhóm /admin sẵn có của bạn)
|---------------------------
*/
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    // Quản lý Tin tức
    Route::resource('news', AdminNewsController::class, ['as' => 'admin']);
    // Quản lý liên hệ (xem danh sách & chi tiết, xoá)
    Route::resource('contacts', AdminContactController::class, ['as' => 'admin'])->only(['index', 'show', 'destroy']);
});

// Giỏ hàng
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Đơn hàng người dùng
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Tài khoản cá nhân
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password');
    Route::post('/account/change-password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Người dùng)
|--------------------------------------------------------------------------
*/


// AUTH ROUTES — chuẩn Laravel

// Guest-only
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Forgot / Reset password (CHUẨN tên route)
    Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.store');
});

// Auth-only
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Google login


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
    ->middleware(['auth', 'is_admin'])
    ->name('admin.')
    ->group(function () {
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
        Route::get('product-variants/{type}', [AdminProductController::class, 'variantsByType'])->name('products.variants.type');
        Route::post('product-variants', [AdminProductController::class, 'storeVariant'])->name('products.variants.store');
        Route::get('product-variants/{variant}/edit', [AdminProductController::class, 'editVariant'])->name('products.variants.edit');
        Route::put('product-variants/{variant}', [AdminProductController::class, 'updateVariant'])->name('products.variants.update');
        Route::delete('product-variants/{variant}', [AdminProductController::class, 'destroyVariant'])->name('products.variants.destroy');

        // Đơn hàng
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // Người dùng
        Route::resource('users', AdminUserController::class);
    });
