<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MomoPaymentService;
use App\Services\DemoPaymentService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $momoService;
    protected $demoService;

    public function __construct()
    {
        $this->momoService = new MomoPaymentService();
        $this->demoService = new DemoPaymentService();
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
}
