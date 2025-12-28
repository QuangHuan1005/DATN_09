<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\VNPayService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderStatusLog;

class VNPayController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * ============================================
     *  📌 1. RETURN URL (User Redirect After Payment)
     * ============================================
     */
    public function return(Request $request)
    {
        Log::info("VNPay RETURN Callback", [$request->all()]);

        // Kiểm tra chữ ký
        if (!$this->vnpayService->verifyCallback($request->all())) {
            return redirect()->route('checkout.success')->with('error', 'Sai chữ ký VNPay!');
        }

        $orderCode = $request->get('vnp_TxnRef');
        $responseCode = $request->get('vnp_ResponseCode');

        // Lấy đơn hàng
        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            return redirect()->route('checkout.success')->with('error', 'Không tìm thấy đơn hàng!');
        }

        // VNPay ResponseCode == "00" => thanh toán thành công
        if ($responseCode === "00") {
            $order->update([
                'payment_status_id' => 3, // Đã thanh toán
                'order_status_id'    => 2  // Đã xác nhận
            ]);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => 2,
                'actor_type' => 'system'
            ]);

            return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công!');
        }

        // Ngược lại thất bại
        return redirect()->route('checkout.success')->with('error', 'Thanh toán thất bại hoặc bị hủy!');
    }


    /**
     * ============================================
     *  📌 2. IPN URL (Server → Server, Quan trọng nhất)
     * ============================================
     */
    public function ipn(Request $request)
    {
        try {
            Log::info("VNPay IPN Callback", [$request->all()]);

            // Kiểm tra chữ ký an toàn
            if (!$this->vnpayService->verifyCallback($request->all())) {
                Log::error("VNPay IPN: Invalid signature");
                return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
            }

            $orderCode = $request->get('vnp_TxnRef');
            $amount = $request->get('vnp_Amount'); // đơn vị = *100
            $responseCode = $request->get('vnp_ResponseCode');

            // Lấy đơn hàng
            $order = Order::where('order_code', $orderCode)->first();

            if (!$order) {
                Log::error("VNPay IPN: Order not found", ['order_code' => $orderCode]);
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }

            // Đã xử lý trước đó → tránh xử lý lại nhiều lần
            if ($order->payment_status_id == 3) {
                return response()->json(['RspCode' => '00', 'Message' => 'Order already confirmed']);
            }

            // === Thanh toán thành công ===
            if ($responseCode == "00") {

                $order->update([
                    'payment_status_id' => 3, // Completed
                    'order_status_id'    => 2  // Confirmed
                ]);

                // Cập nhật thông tin Payment
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'payment_method_id' => 2,
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'payment_amount' => is_numeric($amount) ? ($amount / 100) : 0,
                        'status' => 1 // Completed
                    ]
                );

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => 2,
                    'actor_type' => 'system'
                ]);

                Log::info("VNPay IPN: Payment successful", ['order_code' => $orderCode]);

                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
            }

            // === Thanh toán thất bại ===
            $order->update(['order_status_id' => 6]); // Huỷ đơn

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method_id' => 2,
                    'payment_code' => $request->get('vnp_TransactionNo'),
                    'payment_amount' => is_numeric($amount) ? ($amount / 100) : 0,
                    'status' => 0 // Failed
                ]
            );

            Log::info("VNPay IPN: Payment failed", [
                'order_code' => $orderCode,
                'response_code' => $responseCode
            ]);

            return response()->json(['RspCode' => '00', 'Message' => 'Payment Failed']);
        } catch (\Exception $e) {
            Log::error("VNPay IPN Exception: " . $e->getMessage());
            return response()->json(['RspCode' => '99', 'Message' => 'System error']);
        }
    }
}
