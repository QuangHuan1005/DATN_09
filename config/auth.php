<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Guard mặc định và password broker mặc định cho ứng dụng.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Định nghĩa các guard riêng biệt cho khách hàng, admin, staff.
    |
    */

    'guards' => [
        // Guard mặc định cho khách hàng
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Guard riêng cho admin
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        // Guard riêng cho staff
        'staff' => [
            'driver' => 'session',
            'provider' => 'staffs',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Cấu hình provider cho các loại user khác nhau.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Hoặc App\Models\Admin nếu dùng bảng riêng
        ],

        'staffs' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Hoặc App\Models\Staff nếu dùng bảng riêng
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Cấu hình reset password riêng cho từng loại người dùng.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'staffs' => [
            'provider' => 'staffs',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Thời gian trước khi yêu cầu xác nhận mật khẩu lại.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];
