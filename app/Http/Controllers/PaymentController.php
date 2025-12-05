<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MomoPaymentService;
use App\Services\DemoPaymentService;
use App\Services\VNPayService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $momoService;
    protected $demoService;
    protected $vnpayService;

    public function __construct()
    {
        $this->momoService = new MomoPaymentService();
        $this->demoService = new DemoPaymentService();
        $this->vnpayService = new VNPayService();
    }

    /**
     * Tạo thanh toán Momo
     */
    public function createMomoPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|numeric|min:1000',
            'order_info' => 'required|string',
        ]);

        $orderId = $request->order_id;
        $amount = $request->amount;
        $orderInfo = $request->order_info;

        // Kiểm tra xem có phải demo mode không
        $isDemo = config('momo.environment') === 'demo' || !config('momo.partner_code') || config('momo.partner_code') === 'MOMO_PARTNER_CODE';

        if ($isDemo) {
            $result = $this->demoService->createPayment($orderId, $amount, $orderInfo);
        } else {
            $result = $this->momoService->createPayment($orderId, $amount, $orderInfo);
        }

        if ($result['success']) {
            // Lưu thông tin thanh toán vào session
            Session::put('momo_payment', [
                'orderId' => $result['orderId'],
                'requestId' => $result['requestId'],
                'amount' => $amount,
                'orderInfo' => $orderInfo,
                'isDemo' => $isDemo
            ]);

            return response()->json([
                'success' => true,
                'payUrl' => $result['payUrl'],
                'qrCodeUrl' => $result['qrCodeUrl'],
                'orderId' => $result['orderId']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }

    /**
     * Trang hiển thị QR code Momo
     */
    public function showMomoQR(Request $request)
    {
        $orderId = $request->get('order_id');
        $qrCodeUrl = $request->get('qr_code_url');
        $payUrl = $request->get('pay_url');

        if (!$orderId || !$qrCodeUrl) {
            return redirect()->route('checkout.index')->with('error', 'Thông tin thanh toán không hợp lệ');
        }

        return view('payment.momo-qr', compact('orderId', 'qrCodeUrl', 'payUrl'));
    }

    /**
     * Xử lý callback từ Momo (return URL)
     */
    public function momoReturn(Request $request)
    {
        $resultCode = $request->get('resultCode');
        $orderId = $request->get('orderId');
        $amount = $request->get('amount');

        if ($resultCode == 0) {
            // Thanh toán thành công
            return redirect()->route('checkout.success')->with('success', 'Thanh toán thành công!');
        } else {
            // Thanh toán thất bại
            return redirect()->route('checkout.index')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Xử lý IPN từ Momo (notify URL)
     */
    public function momoNotify(Request $request)
    {
        $data = $request->all();

        // Xác thực chữ ký
        if (!$this->momoService->verifyCallback($data)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $resultCode = $data['resultCode'] ?? -1;
        $orderId = $data['orderId'] ?? '';
        $amount = $data['amount'] ?? 0;

        if ($resultCode == 0) {
            // Thanh toán thành công - cập nhật database
            // TODO: Cập nhật trạng thái đơn hàng trong database
            Log::info("Momo payment successful: Order {$orderId}, Amount: {$amount}");
        } else {
            // Thanh toán thất bại
            Log::info("Momo payment failed: Order {$orderId}, Result: {$resultCode}");
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Kiểm tra trạng thái thanh toán
     */
    public function checkPaymentStatus(Request $request)
    {
        $orderId = $request->get('order_id');
        $requestId = $request->get('request_id');

        if (!$orderId) {
            return response()->json(['error' => 'Missing order_id parameter'], 400);
        }

        // Kiểm tra xem có phải demo mode không
        $isDemo = config('momo.environment') === 'demo' || !config('momo.partner_code') || config('momo.partner_code') === 'MOMO_PARTNER_CODE';

        if ($isDemo) {
            // Demo mode - luôn trả về chưa thanh toán để test
            return response()->json([
                'resultCode' => 1006,
                'message' => 'Chưa thanh toán (Demo)',
                'orderId' => $orderId
            ]);
        } else {
            // Momo thật
            if (!$requestId) {
                return response()->json(['error' => 'Missing request_id parameter'], 400);
            }

            $status = $this->momoService->checkPaymentStatus($orderId, $requestId);
            return response()->json($status);
        }
    }

    /**
     * Trang thanh toán ATM
     */
    public function showATM(Request $request)
    {
        $orderId = $request->get('order_id');

        if (!$orderId) {
            return redirect()->route('checkout.index')->with('error', 'Thông tin đơn hàng không hợp lệ');
        }

        return view('payment.atm', compact('orderId'));
    }

    /**
     * Xử lý thanh toán ATM
     */
    public function processATM(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'card_number' => 'required|string|min:16',
            'card_name' => 'required|string',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|min:3',
        ]);

        $bank = $request->bank;
        $cardNumber = $request->card_number;
        $cardName = $request->card_name;
        $expiryDate = $request->expiry_date;
        $cvv = $request->cvv;

        // TODO: Tích hợp với payment gateway thật (VNPay, OnePay, etc.)
        // Hiện tại chỉ là demo

        // Simulate payment processing
        $success = true; // Trong thực tế, đây sẽ là kết quả từ payment gateway

        if ($success) {
            // Thanh toán thành công
            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công!',
                'redirect_url' => route('checkout.success')
            ]);
        } else {
            // Thanh toán thất bại
            return response()->json([
                'success' => false,
                'message' => 'Thanh toán thất bại. Vui lòng thử lại.'
            ], 400);
        }
    }

    /**
     * Xử lý callback khi người dùng quay lại từ VNPay
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $data = $request->all();

        // Verify signature
        $isValid = $this->vnpayService->verifyCallback($data);

        if (!$isValid) {
            Log::warning('VNPay return callback signature invalid', $data);
            return redirect()->route('checkout.index')
                ->with('error', 'Xác thực thanh toán không thành công. Vui lòng thử lại.');
        }

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_Amount = $request->input('vnp_Amount') / 100; // VNPay trả về số tiền nhân 100
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');
        $vnp_BankCode = $request->input('vnp_BankCode');
        $vnp_PayDate = $request->input('vnp_PayDate');

        Log::info('VNPay Return Callback', [
            'vnp_ResponseCode' => $vnp_ResponseCode,
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_Amount' => $vnp_Amount,
            'vnp_TransactionStatus' => $vnp_TransactionStatus,
        ]);

        // ResponseCode = '00' và TransactionStatus = '00' nghĩa là thanh toán thành công
        if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {
            // Lấy thông tin đơn hàng từ session
            $pendingOrder = Session::get('pending_order');

            if ($pendingOrder && $pendingOrder['orderId'] == $vnp_TxnRef) {
                // TODO: Tạo đơn hàng trong database
                // TODO: Cập nhật trạng thái thanh toán

                // Xóa giỏ hàng và pending order
                Session::forget('cart');
                Session::forget('pending_order');

                return redirect()->route('checkout.success')
                    ->with('success', 'Thanh toán thành công! Cảm ơn bạn đã mua hàng.');
            } else {
                return redirect()->route('checkout.index')
                    ->with('error', 'Không tìm thấy thông tin đơn hàng.');
            }
        } else {
            // Thanh toán thất bại
            $errorMessage = $this->getVNPayErrorMessage($vnp_ResponseCode);

            return redirect()->route('checkout.index')
                ->with('error', 'Thanh toán thất bại: ' . $errorMessage);
        }
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ VNPay
     * VNPay sẽ gọi URL này để thông báo kết quả thanh toán
     */
    public function vnpayIpn(Request $request)
    {
        $data = $request->all();

        // Verify signature
        $isValid = $this->vnpayService->verifyCallback($data);

        if (!$isValid) {
            Log::warning('VNPay IPN signature invalid', $data);
            return response()->json([
                'RspCode' => '97',
                'Message' => 'Checksum failed'
            ], 400);
        }

        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_Amount = $request->input('vnp_Amount') / 100;
        $vnp_TransactionStatus = $request->input('vnp_TransactionStatus');
        $vnp_BankCode = $request->input('vnp_BankCode');

        Log::info('VNPay IPN Callback', [
            'vnp_ResponseCode' => $vnp_ResponseCode,
            'vnp_TxnRef' => $vnp_TxnRef,
            'vnp_Amount' => $vnp_Amount,
            'vnp_TransactionStatus' => $vnp_TransactionStatus,
        ]);

        // ResponseCode = '00' và TransactionStatus = '00' nghĩa là thanh toán thành công
        if ($vnp_ResponseCode == '00' && $vnp_TransactionStatus == '00') {
            // TODO: Cập nhật đơn hàng trong database
            // TODO: Gửi email xác nhận cho khách hàng

            return response()->json([
                'RspCode' => '00',
                'Message' => 'Success'
            ]);
        } else {
            // Thanh toán thất bại
            return response()->json([
                'RspCode' => $vnp_ResponseCode,
                'Message' => $this->getVNPayErrorMessage($vnp_ResponseCode)
            ]);
        }
    }

    /**
     * Lấy thông báo lỗi từ mã response của VNPay
     */
    private function getVNPayErrorMessage($responseCode)
    {
        $messages = [
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Thẻ/Tài khoản chưa đăng ký dịch vụ InternetBanking',
            '10' => 'Xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Đã hết hạn chờ thanh toán. Xin vui lòng thực hiện lại giao dịch.',
            '12' => 'Thẻ/Tài khoản bị khóa.',
            '13' => 'Nhập sai mật khẩu xác thực giao dịch (OTP). Xin vui lòng thực hiện lại giao dịch.',
            '51' => 'Tài khoản không đủ số dư để thực hiện giao dịch.',
            '65' => 'Tài khoản đã vượt quá hạn mức giao dịch trong ngày.',
            '75' => 'Ngân hàng thanh toán đang bảo trì.',
            '79' => 'Nhập sai mật khẩu thanh toán quá số lần quy định.',
            '99' => 'Lỗi không xác định',
        ];

        return $messages[$responseCode] ?? 'Lỗi không xác định (Mã: ' . $responseCode . ')';
    }
}
