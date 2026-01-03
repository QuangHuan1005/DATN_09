<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
     * 📌 1. RETURN URL (Xử lý khi khách được redirect về từ VNPay)
     */
    public function return(Request $request)
{
    Log::info("VNPay RETURN Callback", [$request->all()]);

    if (!$this->vnpayService->verifyCallback($request->all())) {
         return redirect()->route('orders.index')->with('error', 'Chữ ký không hợp lệ!');
    }

    $orderCode = $request->get('vnp_TxnRef');
    $responseCode = trim($request->get('vnp_ResponseCode')); 
    $order = Order::where('order_code', $orderCode)->first();

    if ($order && $responseCode === "00") {
        // CẬP NHẬT NGAY TẠI ĐÂY ĐỂ TRANG WEB THAY ĐỔI TRẠNG THÁI
        if ($order->payment_status_id == 1) {
            $order->update([
                'payment_status_id' => 2, // Đã thanh toán
                'order_status_id'   => 1  // Đã xác nhận
            ]);
        }
        return redirect()->route('checkout.success')->with('success', 'Thanh toán thành công!');
    }

    return redirect()->route('orders.index')->with('error', 'Giao dịch không thành công.');
}


    /**
     * 📌 2. IPN URL (Server-to-Server - Cập nhật dữ liệu chính xác)
     */
    public function ipn(Request $request)
    {
        try {
            Log::info("VNPay IPN Callback", [$request->all()]);

            // 1. Kiểm tra chữ ký (Bắt buộc)
            if (!$this->vnpayService->verifyCallback($request->all())) {
                return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
            }

            $orderCode = $request->get('vnp_TxnRef');
            $vnpAmount = $request->get('vnp_Amount');
            $responseCode = trim($request->get('vnp_ResponseCode'));

            $order = Order::where('order_code', $orderCode)->first();

            // 2. Kiểm tra đơn hàng tồn tại
            if (!$order) {
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }

            // 3. Kiểm tra số tiền (Tránh bị sửa số tiền khi thanh toán)
            if (($order->total_amount * 100) != $vnpAmount) {
                return response()->json(['RspCode' => '04', 'Message' => 'Invalid amount']);
            }

            // 4. Kiểm tra trạng thái đơn hàng (Tránh cập nhật trùng lặp)
            if ($order->payment_status_id == 2) {
                return response()->json(['RspCode' => '02', 'Message' => 'Order already confirmed']);
            }

            // THỰC HIỆN CẬP NHẬT
            DB::beginTransaction();

            if ($responseCode === "00") {
                // ✅ THANH TOÁN THÀNH CÔNG
                $order->update([
                    'payment_status_id' => 2, // Đã thanh toán
                    'order_status_id' => 1
                ]);

                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'payment_method_id' => 2,
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'payment_amount' => $vnpAmount / 100,
                        'status' => 1
                    ]
                );

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => 1,
                    'actor_type' => 'system',
                    'note' => 'VNPay xác nhận thanh toán thành công.'
                ]);

                DB::commit();
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);

            } else {
                // ❌ THANH TOÁN THẤT BẠI
                // Lưu ý: Không nên hủy đơn ngay tại đây nếu khách vẫn còn thời gian 30p để "Thanh toán lại"
                // Chỉ ghi log hoặc cập nhật trạng thái lỗi thanh toán.
                
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'payment_method_id' => 2,
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'payment_amount' => $vnpAmount / 100,
                        'status' => 0
                    ]
                );

                DB::commit();
                return response()->json(['RspCode' => '00', 'Message' => 'Payment Failed Recorded']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("VNPay IPN Exception: " . $e->getMessage());
            return response()->json(['RspCode' => '99', 'Message' => 'System error']);
        }
    }
}