<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MomoPaymentService
{
    private $partnerCode;
    private $accessKey;
    private $secretKey;
    private $endpoint;
    private $returnUrl;
    private $notifyUrl;

    public function __construct()
    {
        $this->partnerCode = config('momo.partner_code');
        $this->accessKey = config('momo.access_key');
        $this->secretKey = config('momo.secret_key');
        $this->endpoint = config('momo.endpoint', 'https://test-payment.momo.vn/v2/gateway/api/create');
        $this->returnUrl = config('momo.return_url');
        $this->notifyUrl = config('momo.notify_url');
    }

    /**
     * Tạo thanh toán Momo
     */
    public function createPayment($orderId, $amount, $orderInfo, $extraData = '')
    {
        $requestId = time() . '';
        $orderId = $orderId . '_' . time();
        
        // Tạo raw signature
        $rawHash = "accessKey={$this->accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$this->notifyUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$this->partnerCode}&redirectUrl={$this->returnUrl}&requestId={$requestId}&requestType=captureWallet";
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'partnerName' => 'Mixtas Store',
            'storeId' => 'MixtasStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $this->returnUrl,
            'ipnUrl' => $this->notifyUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'signature' => $signature
        ];

        try {
            $response = Http::timeout(30)->post($this->endpoint, $data);
            
            if ($response->successful()) {
                $result = $response->json();
                
                if ($result['resultCode'] == 0) {
                    return [
                        'success' => true,
                        'payUrl' => $result['payUrl'],
                        'qrCodeUrl' => $result['qrCodeUrl'] ?? null,
                        'orderId' => $orderId,
                        'requestId' => $requestId
                    ];
                } else {
                    Log::error('Momo payment error: ' . $result['message']);
                    return [
                        'success' => false,
                        'message' => $result['message']
                    ];
                }
            } else {
                Log::error('Momo API error: ' . $response->body());
                return [
                    'success' => false,
                    'message' => 'Lỗi kết nối đến Momo'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Momo payment exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo thanh toán'
            ];
        }
    }

    /**
     * Xác thực callback từ Momo
     */
    public function verifyCallback($data)
    {
        $signature = $data['signature'] ?? '';
        unset($data['signature']);
        
        $rawHash = http_build_query($data);
        $expectedSignature = hash_hmac('sha256', $rawHash, $this->secretKey);
        
        return hash_equals($signature, $expectedSignature);
    }

    /**
     * Kiểm tra trạng thái thanh toán
     */
    public function checkPaymentStatus($orderId, $requestId)
    {
        $rawHash = "accessKey={$this->accessKey}&orderId={$orderId}&partnerCode={$this->partnerCode}&requestId={$requestId}";
        $signature = hash_hmac('sha256', $rawHash, $this->secretKey);

        $data = [
            'partnerCode' => $this->partnerCode,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'signature' => $signature,
            'lang' => 'vi'
        ];

        try {
            $response = Http::timeout(30)->post('https://test-payment.momo.vn/v2/gateway/api/query', $data);
            
            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Momo query error: ' . $e->getMessage());
        }

        return null;
    }
}
