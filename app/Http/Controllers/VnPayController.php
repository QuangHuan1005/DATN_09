<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
     * Xử lý callback từ VNPay khi người dùng thanh toán xong
     */
    public function return(Request $request)
    {
        try {
            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            $vnp_TxnRef = $request->get('vnp_TxnRef');
            $vnp_Amount = $request->get('vnp_Amount');
            $vnp_OrderInfo = $request->get('vnp_OrderInfo');

            Log::info('VNPay Return Callback', [
                'vnp_ResponseCode' => $vnp_ResponseCode,
                'vnp_TxnRef' => $vnp_TxnRef,
                'vnp_Amount' => $vnp_Amount,
                'vnp_OrderInfo' => $vnp_OrderInfo,
                'all_params' => $request->all()
            ]);

            // Kiểm tra chữ ký
            if (!$this->vnpayService->verifyCallback($request->all())) {
                Log::error('VNPay Return: Invalid signature');
                return redirect('/checkout')->with('error', 'Chữ ký không hợp lệ');
            }

            // Tìm đơn hàng
            $order = Order::where('order_code', $vnp_TxnRef)->first();

            if (!$order) {
                Log::error('VNPay Return: Order not found', ['order_code' => $vnp_TxnRef]);
                return redirect('/checkout')->with('error', 'Không tìm thấy đơn hàng');
            }

            // Cập nhật trạng thái thanh toán
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công - Đơn hàng vẫn ở trạng thái "Chưa xác nhận" để admin xử lý
                // Nhưng cập nhật payment_status_id = 2 (Đã thanh toán) để hiển thị đúng
                $order->update(['payment_status_id' => 2]);

                // Cập nhật payment record (đã tạo trong CheckoutController)
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'status' => 1, // Completed
                    ]);
                }

                Log::info('VNPay Return: Payment successful', ['order_code' => $vnp_TxnRef]);

                return redirect()->route('checkout.success', ['order_id' => $order->id])
                    ->with('success', 'Thanh toán VNPay thành công!');
            } else {
                // Thanh toán thất bại
                $order->update(['order_status_id' => 6]); // Hủy đơn

                // Cập nhật payment record (đã tạo trong CheckoutController)
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'status' => 0, // Failed
                    ]);
                }

                Log::info('VNPay Return: Payment failed', [
                    'order_code' => $vnp_TxnRef,
                    'response_code' => $vnp_ResponseCode
                ]);

                return redirect('/checkout')->with('error', 'Thanh toán VNPay thất bại. Mã lỗi: ' . $vnp_ResponseCode);
            }
        } catch (\Exception $e) {
            Log::error('VNPay Return Exception: ' . $e->getMessage());
            return redirect('/checkout')->with('error', 'Có lỗi xảy ra khi xử lý thanh toán VNPay');
        }
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ VNPay
     */
    public function ipn(Request $request)
    {
        try {
            Log::info('VNPay IPN Callback', ['all_params' => $request->all()]);

            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            $vnp_TxnRef = $request->get('vnp_TxnRef');
            $vnp_Amount = $request->get('vnp_Amount');

            // Kiểm tra chữ ký
            if (!$this->vnpayService->verifyCallback($request->all())) {
                Log::error('VNPay IPN: Invalid signature');
                return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
            }

            // Tìm đơn hàng
            $order = Order::where('order_code', $vnp_TxnRef)->first();

            if (!$order) {
                Log::error('VNPay IPN: Order not found', ['order_code' => $vnp_TxnRef]);
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }

            // Cập nhật trạng thái dựa trên kết quả thanh toán
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công - Đơn hàng vẫn ở trạng thái "Chưa xác nhận" để admin xử lý
                // Nhưng cập nhật payment_status_id = 2 (Đã thanh toán) để hiển thị đúng
                $order->update(['payment_status_id' => 2]);

                // Cập nhật payment record (đã tạo trong CheckoutController)
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'status' => 1, // Completed
                    ]);
                }

                Log::info('VNPay IPN: Payment successful', ['order_code' => $vnp_TxnRef]);
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
            } else {
                // Thanh toán thất bại
                $order->update(['order_status_id' => 6]); // Hủy đơn

                // Cập nhật payment record (đã tạo trong CheckoutController)
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update([
                        'payment_code' => $request->get('vnp_TransactionNo'),
                        'status' => 0, // Failed
                    ]);
                }

                Log::info('VNPay IPN: Payment failed', [
                    'order_code' => $vnp_TxnRef,
                    'response_code' => $vnp_ResponseCode
                ]);
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Failed']);
            }
        } catch (\Exception $e) {
            Log::error('VNPay IPN Exception: ' . $e->getMessage());
            return response()->json(['RspCode' => '99', 'Message' => 'Unknown error']);
        }
    }
}

