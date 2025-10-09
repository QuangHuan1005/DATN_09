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

// Sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
});

// Danh mục sản phẩm
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Giỏ hàng
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Thanh toán
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Đơn hàng người dùng (có thể thêm middleware 'auth')
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Tài khoản cá nhân (có thể thêm middleware 'auth')
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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); 
Route::post('/login', [AuthController::class, 'login']); 
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); 
Route::post('/register', [AuthController::class, 'register']); 
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot-password'); 
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password.email'); 
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('forgot-password.reset'); 
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('forgot-password.update'); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// ==========================
// GOOGLE LOGIN ROUTES
// ==========================
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (tách biệt theo prefix và namespace)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    // Nếu bạn đã tạo middleware auth + is_admin thì bật lại
    // ->middleware(['auth', 'is_admin']) 
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Danh mục (CRUD + restore + force delete)
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{id}/restore', [AdminCategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('categories/{id}/force-delete', [AdminCategoryController::class, 'forceDelete'])->name('categories.forceDelete');

        // Sản phẩm
        Route::resource('products', AdminProductController::class);

        // Đơn hàng
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);

        // Người dùng
        Route::resource('users', AdminUserController::class);
    });
