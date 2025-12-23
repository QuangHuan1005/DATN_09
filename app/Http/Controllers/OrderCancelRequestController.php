<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancelRequest;
use App\Models\UserBankAccount; // Thêm Model này
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderCancelRequestController extends Controller
{
    public function store(Request $request, $order_id)
    {
        $order = Order::where('id', $order_id)
                      ->where('user_id', Auth::id())
                      ->first();
        
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        if (OrderCancelRequest::where('order_id', $order_id)->exists()) {
            return back()->with('error', 'Yêu cầu hủy đã tồn tại.');
        }

        // Logic kiểm tra thanh toán Online
        $isPaid = in_array((int)$order->payment_status_id, [2, 3]);
        $isOnline = (int)$order->payment_method_id !== 1;

        $bankData = [
            'bank_name' => null,
            'account_number' => null,
            'account_holder' => null,
        ];

        if ($isOnline && $isPaid) {
            // Nếu chọn bank có sẵn
            if ($request->user_bank_account_id && $request->user_bank_account_id !== 'new') {
                $bank = UserBankAccount::where('id', $request->user_bank_account_id)
                                      ->where('user_id', Auth::id())
                                      ->first();
                if (!$bank) return back()->with('error', 'Tài khoản ngân hàng không hợp lệ.');
                
                $bankData['bank_name'] = $bank->bank_name;
                $bankData['account_number'] = $bank->account_number;
                $bankData['account_holder'] = $bank->account_holder;
            } else {
                // Nếu nhập bank mới -> Validate các trường input
                $request->validate([
                    'bank_name'      => 'required|string',
                    'account_number' => 'required|string',
                    'account_holder' => 'required|string',
                ]);
                $bankData['bank_name'] = $request->bank_name;
                $bankData['account_number'] = $request->account_number;
                $bankData['account_holder'] = $request->account_holder;
            }
        }

        $request->validate(['reason' => 'required|min:5']);

        DB::beginTransaction();
        try {
            OrderCancelRequest::create([
                'order_id'       => $order->id,
                'user_id'        => Auth::id(),
                'reason_user'    => trim($request->reason),
                'status_id'      => 1, // Chờ xử lý
                'status'         => 'pending',
                'canceled_by'    => 'customer', 
                'bank_name'      => $bankData['bank_name'],
                'account_number' => $bankData['account_number'],
                'account_holder' => $bankData['account_holder'],
            ]);
            
            $order->update(['is_cancel_requested' => 1]); 

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'user',
                'actor_id' => Auth::id(),
                'note' => 'Gửi yêu cầu hủy đơn: ' . $request->reason,
            ]);
            
            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Đã gửi yêu cầu hủy thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}