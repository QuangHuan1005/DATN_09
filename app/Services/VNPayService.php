<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VNPayService
{
    private $tmnCode;
    private $hashSecret;
    private $url;
    private $queryUrl;
    private $returnUrl;
    private $ipnUrl;
    private $version;
    private $locale;

    public function __construct()
    {
        $this->tmnCode = config('vnpay.tmn_code');
        $this->hashSecret = config('vnpay.hash_secret');
        $this->url = config('vnpay.url');
        $this->queryUrl = config('vnpay.query_url');

        // Không tạo URL trong constructor, sẽ tạo khi cần
        $this->returnUrl = config('vnpay.return_url');
        $this->ipnUrl = config('vnpay.ipn_url');

        $this->version = config('vnpay.version', '2.1.0');
        $this->locale = config('vnpay.locale', 'vn');
    }

    /**
     * Lấy return URL (tạo khi cần)
     */
    private function getReturnUrl()
    {
        if ($this->returnUrl) {
            return $this->returnUrl;
        }
        // Tạo URL khi có request
        try {
            if (app()->bound('request') && request()) {
                return url('/payment/vnpay/return');
            }
        } catch (\Exception $e) {
            // Ignore
        }
        // Fallback
        $appUrl = config('app.url', 'http://localhost');
        return rtrim($appUrl, '/') . '/payment/vnpay/return';
    }

    /**
     * Lấy IPN URL (tạo khi cần)
     */
    private function getIpnUrl()
    {
        if ($this->ipnUrl) {
            return $this->ipnUrl;
        }
        // Tạo URL khi có request
        try {
            if (app()->bound('request') && request()) {
                return url('/payment/vnpay/ipn');
            }
        } catch (\Exception $e) {
            // Ignore
        }
        // Fallback
        $appUrl = config('app.url', 'http://localhost');
        return rtrim($appUrl, '/') . '/payment/vnpay/ipn';
    }

    /**
     * Tạo URL thanh toán VNPay
     * 
     * @param string $orderId Mã đơn hàng
     * @param int $amount Số tiền (VND)
     * @param string $orderDescription Mô tả đơn hàng
     * @param string $orderType Loại đơn hàng (default: 'other')
     * @param string $bankCode Mã ngân hàng (optional)
     * @return array ['success' => bool, 'payment_url' => string, 'message' => string]
     */
    public function createPayment($orderId, $amount, $orderDescription = '', $orderType = 'other', $bankCode = '')
    {
        try {
            // Validate config
            if (empty($this->tmnCode) || empty($this->hashSecret)) {
                return [
                    'success' => false,
                    'message' => 'VNPay chưa được cấu hình. Vui lòng kiểm tra file .env'
                ];
            }

            $vnp_TxnRef = $orderId; // Mã giao dịch
            $vnp_Amount = $amount * 100; // VNPay yêu cầu số tiền nhân 100
            $vnp_OrderInfo = $orderDescription ?: 'Thanh toan don hang ' . $orderId;
            $vnp_OrderType = $orderType;
            $vnp_CreateDate = date('YmdHis');
            $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes')); // Hết hạn sau 15 phút
            $vnp_IpAddr = request()->ip();

            $inputData = [
                'vnp_Version' => $this->version,
                'vnp_TmnCode' => $this->tmnCode,
                'vnp_Amount' => $vnp_Amount,
                'vnp_Command' => 'pay',
                'vnp_CreateDate' => $vnp_CreateDate,
                'vnp_CurrCode' => 'VND',
                'vnp_IpAddr' => $vnp_IpAddr,
                'vnp_Locale' => $this->locale,
                'vnp_OrderInfo' => $vnp_OrderInfo,
                'vnp_OrderType' => $vnp_OrderType,
                'vnp_ReturnUrl' => $this->getReturnUrl(),
                'vnp_TxnRef' => $vnp_TxnRef,
                'vnp_ExpireDate' => $vnp_ExpireDate,
            ];

            // Thêm bankCode nếu có
            if (!empty($bankCode)) {
                $inputData['vnp_BankCode'] = $bankCode;
            }

            // Sắp xếp mảng theo key
            ksort($inputData);

            // Tạo query string
            $query = http_build_query($inputData);

            // Tạo hash
            $hashData = $query;
            $vnp_SecureHash = hash_hmac('sha512', $hashData, $this->hashSecret);
            $inputData['vnp_SecureHash'] = $vnp_SecureHash;

            // Tạo payment URL
            $paymentUrl = $this->url . '?' . http_build_query($inputData);

            Log::info('VNPay Payment URL Created', [
                'order_id' => $orderId,
                'amount' => $amount,
                'payment_url' => $paymentUrl
            ]);

            return [
                'success' => true,
                'payment_url' => $paymentUrl,
                'order_id' => $vnp_TxnRef,
                'amount' => $amount
            ];
        } catch (\Exception $e) {
            Log::error('VNPay create payment error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo thanh toán VNPay: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Xác thực callback từ VNPay
     * 
     * @param array $data Dữ liệu từ VNPay callback
     * @return bool
     */
    public function verifyCallback($data)
    {
        try {
            $vnp_SecureHash = $data['vnp_SecureHash'] ?? '';
            unset($data['vnp_SecureHash']);

            ksort($data);
            $query = http_build_query($data);
            $hashData = $query;
            $vnp_HashSecret = $this->hashSecret;
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            return hash_equals($vnp_SecureHash, $secureHash);
        } catch (\Exception $e) {
            Log::error('VNPay verify callback error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra trạng thái thanh toán từ VNPay
     * 
     * @param string $orderId Mã đơn hàng
     * @param string $transDate Ngày giao dịch (YmdHis)
     * @return array|null
     */
    public function queryTransaction($orderId, $transDate)
    {
        try {
            $vnp_TxnRef = $orderId;
            $vnp_Version = $this->version;
            $vnp_Command = 'querydr';
            $vnp_TmnCode = $this->tmnCode;
            $vnp_TransactionDate = $transDate;
            $vnp_CreateDate = date('YmdHis');
            $vnp_IpAddr = request()->ip();

            $inputData = [
                'vnp_Version' => $vnp_Version,
                'vnp_Command' => $vnp_Command,
                'vnp_TmnCode' => $vnp_TmnCode,
                'vnp_TxnRef' => $vnp_TxnRef,
                'vnp_OrderInfo' => 'Kiem tra giao dich',
                'vnp_TransactionDate' => $vnp_TransactionDate,
                'vnp_CreateDate' => $vnp_CreateDate,
                'vnp_IpAddr' => $vnp_IpAddr,
            ];

            ksort($inputData);
            $query = http_build_query($inputData);
            $hashData = $query;
            $vnp_SecureHash = hash_hmac('sha512', $hashData, $this->hashSecret);
            $inputData['vnp_SecureHash'] = $vnp_SecureHash;

            $response = Http::timeout(30)->post($this->queryUrl, $inputData);

            if ($response->successful()) {
                $result = $response->body();
                parse_str($result, $data);
                return $data;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('VNPay query transaction error: ' . $e->getMessage());
            return null;
        }
    }
}
