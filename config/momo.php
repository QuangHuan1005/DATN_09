<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Momo Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Cấu hình cho thanh toán Momo
    |
    */

    // Thông tin đối tác (lấy từ Momo Developer Portal)
    'partner_code' => env('MOMO_PARTNER_CODE', 'MOMO_PARTNER_CODE'),
    'access_key' => env('MOMO_ACCESS_KEY', 'MOMO_ACCESS_KEY'),
    'secret_key' => env('MOMO_SECRET_KEY', 'MOMO_SECRET_KEY'),

    // URL endpoints
    'endpoint' => env('MOMO_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/create'),
    'query_endpoint' => env('MOMO_QUERY_ENDPOINT', 'https://test-payment.momo.vn/v2/gateway/api/query'),
    
    // Callback URLs
    'return_url' => env('MOMO_RETURN_URL', 'http://localhost:8000/payment/momo/return'),
    'notify_url' => env('MOMO_NOTIFY_URL', 'http://localhost:8000/payment/momo/notify'),

    // Environment
    'environment' => env('MOMO_ENVIRONMENT', 'demo'), // demo, sandbox hoặc production
    
    // Sandbox credentials (có thể sử dụng mà không cần đăng ký)
    'sandbox' => [
        'partner_code' => 'MOMO_PARTNER_CODE',
        'access_key' => 'MOMO_ACCESS_KEY', 
        'secret_key' => 'MOMO_SECRET_KEY',
        'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',
    ],
];
