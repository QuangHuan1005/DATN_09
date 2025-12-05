<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class VnPayController extends Controller
{
    public function createPayment(Request $request)
    {
        // 1. Lấy thông tin giỏ hàng / đơn hàng
        // Ở đây giả sử bạn đã tạo Order trước rồi và truyền vào
        $order = Order::findOrFail($request->order_id);

        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url        = config('vnpay.vnp_Url');
        $vnp_Returnurl  = config('vnpay.vnp_ReturnUrl');

        // 2. Thông tin bắt buộc VNPAY
        $vnp_TxnRef    = $order->order_code;            // mã đơn hàng của bạn, unique
        $vnp_OrderInfo = 'Thanh toan don hang #' . $order->order_code;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount    = $order->total_amount * 100;    // VNPay yêu cầu *100 :contentReference[oaicite:3]{index=3}
        $vnp_Locale    = 'vn';
        $vnp_BankCode  = $request->input('bank_code');  // có thể cho user chọn hoặc để null
        $vnp_IpAddr    = $request->ip();

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => $vnp_OrderType,
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);

        $query    = "";
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            $query    .= urlencode($key) . "=" . urlencode($value) . '&';
            $hashdata .= ($hashdata ? '&' : '') . $key . "=" . $value;
        }

        $vnp_Url = $vnp_Url . "?" . $query;

        if (!empty($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url      .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }

        // Lưu trạng thái chờ thanh toán cho đơn hàng
        $order->update([
            'payment_method' => 'vnpay',
            'payment_status' => 'pending',
        ]);

        return redirect()->away($vnp_Url);
    }
    public function return(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData      = $request->all();

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = collect($inputData)
            ->map(fn($v, $k) => $k . '=' . $v)
            ->implode('&');

        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);

        $isValid = $secureHash === $vnp_SecureHash;
        $isSuccess = $request->vnp_ResponseCode == '00'; // thành công theo VNPAY :contentReference[oaicite:4]{index=4}

        // Tại đây chỉ hiển thị kết quả, không cập nhật DB
        // Cập nhật DB ở IPN.
        return view('payments.vnpay_return', [
            'isValid'   => $isValid,
            'isSuccess' => $isSuccess,
            'data'      => $request->all(),
        ]);
    }
    public function ipn(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData      = $request->all();

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? null;
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        ksort($inputData);
        $hashData = collect($inputData)
            ->map(fn($v, $k) => $k . '=' . $v)
            ->implode('&');

        $secureHash = hash('sha256', $vnp_HashSecret . $hashData);

        if ($secureHash !== $vnp_SecureHash) {
            return response('INVALID_HASH', 400);
        }

        $orderCode = $request->vnp_TxnRef ?? null;
        $amount    = $request->vnp_Amount / 100;

        $order = Order::where('order_code', $orderCode)->first();

        if (!$order) {
            return response('ORDER_NOT_FOUND', 404);
        }

        // Check số tiền
        if ((float)$order->total_amount !== (float)$amount) {
            return response('INVALID_AMOUNT', 400);
        }

        // vnp_ResponseCode == "00" là thành công
        if ($request->vnp_ResponseCode == "00") {
            // chỉ update nếu đang pending
            if ($order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'confirmed', // tùy logic của bạn
                    'paid_at'        => now(),
                ]);
            }

            return response('OK', 200);
        } else {
            $order->update([
                'payment_status' => 'failed',
            ]);
            return response('FAILED', 200);
        }
    }
}
