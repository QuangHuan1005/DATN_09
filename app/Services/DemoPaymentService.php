<?php

namespace App\Services;

class DemoPaymentService
{
    /**
     * Tạo thanh toán demo (không cần Momo thật)
     */
    public function createPayment($orderId, $amount, $orderInfo)
    {
        // Tạo QR code demo bằng QR Server API
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode("MOMO_DEMO_ORDER_{$orderId}_AMOUNT_{$amount}");
        
        // Tạo pay URL demo
        $payUrl = route('payment.momo.qr', [
            'order_id' => $orderId,
            'qr_code_url' => $qrCodeUrl,
            'pay_url' => route('payment.momo.qr', [
                'order_id' => $orderId,
                'qr_code_url' => $qrCodeUrl,
                'pay_url' => '#'
            ])
        ]);

        return [
            'success' => true,
            'payUrl' => $payUrl,
            'qrCodeUrl' => $qrCodeUrl,
            'orderId' => $orderId,
            'requestId' => time(),
            'isDemo' => true
        ];
    }

    /**
     * Simulate thanh toán thành công sau 30 giây
     */
    public function simulatePayment($orderId)
    {
        // Trong demo mode, luôn trả về thành công
        return [
            'resultCode' => 0,
            'message' => 'Thanh toán thành công (Demo)',
            'orderId' => $orderId,
            'amount' => 100000,
            'isDemo' => true
        ];
    }
}
