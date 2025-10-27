<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Đây là guard mặc định và password broker mặc định cho ứng dụng.
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
    | Bạn có thể định nghĩa nhiều guard để phân tách đăng nhập admin và client.
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
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Các provider xác định cách lấy dữ liệu người dùng từ DB.
    | Tách riêng provider cho admin nếu muốn.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Nếu bạn dùng cùng bảng users
            // Nếu muốn tách bảng admin riêng, tạo model Admin và bảng admins
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Cấu hình cho việc reset password, có thể tách riêng admin nếu muốn.
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
            'table' => 'password_reset_tokens', // hoặc bảng riêng nếu muốn
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
