<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- Cần phải thêm
use App\Services\VNPayService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderStatusLog;

class VNPayController extends Controller
{
    protected $vnpayService;
    
    // ID Phương thức Thanh toán
    const PAYMENT_METHOD_VNPAY = 2; // Giả sử ID 2 là VNPay (Bạn đang hardcode 2)

    // ID Trạng thái Đơn hàng
    const STATUS_SUCCESSFULLY_PAID = 2;       // ID 2: Xác nhận (Sau khi thanh toán thành công)
    const STATUS_FAILED_PAYMENT = 6;          // ID 6: Hủy (Khi thanh toán thất bại)
    const STATUS_PENDING_CONFIRMATION = 1;    // ID 1: Chờ xác nhận (Trạng thái khởi tạo)
    
    // ID Trạng thái Thanh toán (payment_status_id)
    const PAYMENT_STATUS_PAID = 2;            // ID 2: Đã thanh toán
    const PAYMENT_STATUS_UNPAID = 1;          // ID 1: Chưa thanh toán

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    /**
     * Xử lý callback từ VNPay khi người dùng thanh toán xong (Sau khi họ quay lại)
     */
    public function return(Request $request)
    {
        // BẮT ĐẦU DB TRANSACTION ĐỂ ĐẢM BẢO TÍNH TOÀN VẸN
        DB::beginTransaction();
        try {
            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            $vnp_TxnRef = $request->get('vnp_TxnRef');
            $vnp_Amount = $request->get('vnp_Amount');
            $vnp_TransactionNo = $request->get('vnp_TransactionNo');
            $amount_paid = $vnp_Amount / 100;

            Log::info('--- VNPay Return Callback ---', [
                'TxnRef' => $vnp_TxnRef,
                'ResponseCode' => $vnp_ResponseCode,
                'Paid_ID_Value' => self::PAYMENT_STATUS_PAID, // <-- LOGGING DEBUG GIÁ TRỊ HẰNG SỐ
                'all_params' => $request->all()
            ]);

            // 1. Kiểm tra chữ ký
            if (!$this->vnpayService->verifyCallback($request->all())) {
                Log::error('VNPay Return: Invalid signature');
                DB::rollBack();
                return redirect('/checkout')->with('error', 'Chữ ký giao dịch không hợp lệ. Vui lòng kiểm tra lại đơn hàng.');
            }

            // 2. Tìm đơn hàng
            $order = Order::where('order_code', $vnp_TxnRef)->first();

            if (!$order) {
                Log::error('VNPay Return: Order not found', ['order_code' => $vnp_TxnRef]);
                DB::rollBack();
                return redirect('/checkout')->with('error', 'Không tìm thấy đơn hàng của bạn.');
            }
            
            // 3. Xử lý Logic Thanh toán Thành công (Response Code = 00)
            if ($vnp_ResponseCode == '00') {
                // KIỂM TRA IDEMPOTENCY: Tránh cập nhật đơn hàng 2 lần (do user refresh hoặc cả IPN và Return cùng chạy)
                if ($order->payment_status_id == self::PAYMENT_STATUS_PAID) {
                    Log::warning('VNPay Return: Order already marked as paid. Skipping update.', ['order_id' => $order->id]);
                    DB::commit(); 
                    return redirect()->route('checkout.success', ['order_id' => $order->id])
                        ->with('success', 'Đơn hàng đã được thanh toán và xử lý trước đó.');
                }
                
                // Cập nhật cả order_status_id và payment_status_id
                $order->update([
                    'order_status_id' => self::STATUS_SUCCESSFULLY_PAID, 
                    'payment_status_id' => self::PAYMENT_STATUS_PAID
                ]); 

                // Tạo log trạng thái
                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => self::STATUS_SUCCESSFULLY_PAID,
                    'actor_type' => 'system',
                ]);

                // Tạo bản ghi thanh toán
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => self::PAYMENT_METHOD_VNPAY, 
                    'payment_code' => $vnp_TransactionNo,
                    'payment_amount' => $amount_paid,
                    'status' => 1, // Completed/Success (Cột 'status' trong Payments table)
                ]);

                Log::info('VNPay Return: Payment successful. DB committed.', ['order_code' => $vnp_TxnRef]);
                DB::commit();

                return redirect()->route('checkout.success', ['order_id' => $order->id])
                    ->with('success', 'Thanh toán VNPay thành công! Đơn hàng đang được xử lý.');
            } else {
                // Thanh toán thất bại (Hoặc đang chờ xử lý khác)
                
                // Cập nhật trạng thái đơn hàng sang Hủy và trạng thái thanh toán (Unpaid)
                $order->update([
                    'order_status_id' => self::STATUS_FAILED_PAYMENT, 
                    'payment_status_id' => self::PAYMENT_STATUS_UNPAID 
                ]); 

                Payment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => self::PAYMENT_METHOD_VNPAY, 
                    'payment_code' => $vnp_TransactionNo,
                    'payment_amount' => $amount_paid,
                    'status' => 0, // Failed
                ]);
                
                Log::info('VNPay Return: Payment failed. DB committed.', [
                    'order_code' => $vnp_TxnRef,
                    'response_code' => $vnp_ResponseCode
                ]);
                DB::commit();

                return redirect('/checkout')->with('error', 'Thanh toán VNPay thất bại. Mã lỗi: ' . $vnp_ResponseCode . '. Đơn hàng đã được hủy.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VNPay Return Exception: ' . $e->getMessage() . ' on line ' . $e->getLine());
            return redirect('/checkout')->with('error', 'Có lỗi xảy ra khi xử lý thanh toán VNPay');
        }
    }

    /**
     * Xử lý IPN (Instant Payment Notification) từ VNPay (Server to Server)
     */
    public function ipn(Request $request)
    {
        // BẮT ĐẦU DB TRANSACTION CHO IPN
        DB::beginTransaction();
        try {
            $vnp_ResponseCode = $request->get('vnp_ResponseCode');
            $vnp_TxnRef = $request->get('vnp_TxnRef');
            $vnp_Amount = $request->get('vnp_Amount');
            $vnp_TransactionNo = $request->get('vnp_TransactionNo');
            $amount_paid = $vnp_Amount / 100;

            Log::info('--- VNPay IPN Callback ---', ['TxnRef' => $vnp_TxnRef, 'ResponseCode' => $vnp_ResponseCode, 'all_params' => $request->all()]);

            // 1. Kiểm tra chữ ký
            if (!$this->vnpayService->verifyCallback($request->all())) {
                Log::error('VNPay IPN: Invalid signature');
                DB::rollBack();
                return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
            }

            // 2. Tìm đơn hàng
            $order = Order::where('order_code', $vnp_TxnRef)->first();

            if (!$order) {
                Log::error('VNPay IPN: Order not found', ['order_code' => $vnp_TxnRef]);
                DB::rollBack();
                return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
            }

            // 3. Kiểm tra số tiền
            // Bạn nên thêm logic kiểm tra số tiền $order->total_amount * 100 == $vnp_Amount 
            // Nếu không khớp, trả về 04 (Invalid amount)

            // 4. Cập nhật trạng thái dựa trên kết quả thanh toán
            if ($vnp_ResponseCode == '00') {
                // Thanh toán thành công
                
                // KIỂM TRA IDEMPOTENCY: Chỉ cập nhật nếu đơn hàng chưa được đánh dấu là Đã thanh toán
                if ($order->payment_status_id == self::PAYMENT_STATUS_PAID) { 
                    Log::warning('VNPay IPN: Order already paid. Skipping update.');
                    DB::commit();
                    return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                }

                // Cập nhật cả order_status_id và payment_status_id
                $order->update([
                    'order_status_id' => self::STATUS_SUCCESSFULLY_PAID, 
                    'payment_status_id' => self::PAYMENT_STATUS_PAID 
                ]); 

                // Tạo log trạng thái
                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => self::STATUS_SUCCESSFULLY_PAID,
                    'actor_type' => 'system',
                ]);

                // Tạo Payment record (hoặc cập nhật nếu đã tồn tại)
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => self::PAYMENT_METHOD_VNPAY, 
                    'payment_code' => $vnp_TransactionNo,
                    'payment_amount' => $amount_paid,
                    'status' => 1, // Completed
                ]);
                
                Log::info('VNPay IPN: Payment successful. DB committed.', ['order_code' => $vnp_TxnRef]);
                DB::commit();
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
                
            } else {
                // Thanh toán thất bại hoặc các mã lỗi khác
                
                // Chỉ cập nhật nếu đơn hàng vẫn đang chờ thanh toán (chưa bị hủy hoặc đã thanh toán)
                if ($order->payment_status_id == self::PAYMENT_STATUS_UNPAID) {
                    $order->update([
                        'order_status_id' => self::STATUS_FAILED_PAYMENT, 
                        'payment_status_id' => self::PAYMENT_STATUS_UNPAID 
                    ]); 

                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method_id' => self::PAYMENT_METHOD_VNPAY, 
                        'payment_code' => $vnp_TransactionNo,
                        'payment_amount' => $amount_paid,
                        'status' => 0, // Failed
                    ]);
                    Log::info('VNPay IPN: Payment failed. DB committed.', ['order_code' => $vnp_TxnRef]);
                } else {
                    Log::warning('VNPay IPN: Failed status received, but order status is already high. Skipping update.', ['order_code' => $vnp_TxnRef]);
                }

                DB::commit();
                return response()->json(['RspCode' => '00', 'Message' => 'Confirm Failed']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VNPay IPN Exception: ' . $e->getMessage() . ' on line ' . $e->getLine());
            return response()->json(['RspCode' => '99', 'Message' => 'Unknown error']);
        }
    }
}