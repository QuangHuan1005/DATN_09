<?php

return [
    /*
    |--------------------------------------------------------------------------
    | VNPay Payment Configuration
    |--------------------------------------------------------------------------
    |
    | Cấu hình cho thanh toán VNPay
    |
    */

    // Thông tin đối tác (lấy từ VNPay Merchant Portal)
    'tmn_code' => env('VNPAY_TMN_CODE', ''),
    'hash_secret' => env('VNPAY_HASH_SECRET', ''),

    // URL endpoints
    // Sandbox: https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
    // Production: https://www.vnpay.vn/paymentv2/vpcpay.html
    'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),

    // Query API
    // Sandbox: https://sandbox.vnpayment.vn/merchant_webapi/merchant.html
    // Production: https://www.vnpay.vn/merchant_webapi/merchant.html
    'query_url' => env('VNPAY_QUERY_URL', 'https://sandbox.vnpayment.vn/merchant_webapi/merchant.html'),

    // Callback URLs (sử dụng env hoặc để service tự tạo)
    'return_url' => env('VNPAY_RETURN_URL'),
    'ipn_url' => env('VNPAY_IPN_URL'),

    // Environment
    'environment' => env('VNPAY_ENVIRONMENT', 'sandbox'), // sandbox hoặc production

    // Version API
    'version' => env('VNPAY_VERSION', '2.1.0'),

    // Locale
    'locale' => env('VNPAY_LOCALE', 'vn'), // vn, en
];
