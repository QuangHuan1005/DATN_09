<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancelRequest;
use App\Models\UserBankAccount;
use App\Models\OrderStatusLog;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderCancelRequestController extends Controller
{
    /**
     * Xử lý khách hàng xác nhận đã nhận được tiền hoàn (AJAX)
     * Route: orders.cancel.confirm_received
     */
  /**
     * Xử lý khách hàng xác nhận đã nhận được tiền hoàn (AJAX)
     */
    public function confirmReceived(Request $request, $id)
    {
        try {
            // 1. Tìm đơn hàng và kiểm tra quyền sở hữu
            // Lưu ý: Dùng with('cancelRequest') để load quan hệ ngay từ đầu
            $order = Order::with('cancelRequest')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order || !$order->cancelRequest) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Không tìm thấy yêu cầu hủy đơn hàng.'
                ], 404);
            }

            // 2. Kiểm tra điều kiện xác nhận
            // Phải ở trạng thái "Đã hoàn tiền" (ID=4)
            if ((int)$order->cancelRequest->status_id !== 4) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Yêu cầu chưa ở trạng thái đã hoàn tiền để xác nhận.'
                ], 400);
            }

            // Nếu đã xác nhận rồi thì không cho xác nhận lại
            if ($order->cancelRequest->is_customer_confirmed) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Bạn đã xác nhận nhận tiền cho đơn hàng này rồi.'
                ], 400);
            }

            // 3. Tiến hành cập nhật Database
            DB::beginTransaction();
            
            // CẬP NHẬT TRỰC TIẾP QUA MODEL ĐỂ ĐẢM BẢO LƯU THÀNH CÔNG
            $cancelReq = $order->cancelRequest;
            $cancelReq->is_customer_confirmed = true;
            $cancelReq->customer_confirmed_at = now();
            
            // Quan trọng: Sử dụng save() hoặc update() và kiểm tra kết quả
            if (!$cancelReq->save()) {
                throw new \Exception("Không thể lưu trạng thái xác nhận vào Database.");
            }

            // Ghi log hành động khách hàng xác nhận
            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'user',
                'actor_id' => Auth::id(),
                'note' => 'Khách hàng đã xác nhận nhận được tiền hoàn lại qua tài khoản ngân hàng.',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xác nhận nhận tiền thành công. Cảm ơn bạn!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xác nhận nhận tiền đơn #' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xử lý gửi yêu cầu hủy đơn hàng hoặc hủy trực tiếp tùy theo trạng thái
     */
    public function store(Request $request, $order_id)
    {
        // ... (Giữ nguyên toàn bộ logic store bạn đã gửi)
        $order = Order::with(['details.productVariant', 'voucher'])
            ->where('id', $order_id)
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        $existingRequest = OrderCancelRequest::where('order_id', $order_id)->first();

        if ($existingRequest) {
            if ($existingRequest->status_id == 1) {
                return back()->with('error', 'Yêu cầu hủy đơn hàng này đang trong quá trình xử lý, vui lòng chờ.');
            }
            if ($existingRequest->status_id == 3) {
                return back()->with('error', 'Yêu cầu hủy của bạn đã bị từ chối trước đó.');
            }
            if ($existingRequest->status_id == 2) {
                return back()->with('error', 'Đơn hàng này đã được xác nhận hủy.');
            }
        }

        if (!in_array($order->order_status_id, [1, 2])) {
            return back()->with('error', 'Đơn hàng không thể thực hiện hủy.');
        }

        $isPaid = in_array((int)$order->payment_status_id, [2, 3]); 
        $isOnline = (int)$order->payment_method_id !== 1; 

        $bankData = ['bank_name' => null, 'account_number' => null, 'account_holder' => null];

        if ($isOnline && $isPaid) {
            if ($request->user_bank_account_id && $request->user_bank_account_id !== 'new') {
                $bank = UserBankAccount::where('id', $request->user_bank_account_id)
                    ->where('user_id', Auth::id())
                    ->first();
                if (!$bank) return back()->with('error', 'Thông tin ngân hàng không hợp lệ.');
                $bankData = [
                    'bank_name' => $bank->bank_name,
                    'account_number' => $bank->account_number,
                    'account_holder' => $bank->account_holder
                ];
            } else {
                $request->validate([
                    'bank_name' => 'required|string|max:255',
                    'account_number' => 'required|string|max:50',
                    'account_holder' => 'required|string|max:255',
                ]);
                $bankData = $request->only(['bank_name', 'account_number', 'account_holder']);
            }
        }

        $request->validate(['reason' => 'required|string|min:10|max:500']);

        DB::beginTransaction();
        try {
            $shouldAutoApprove = (!$isPaid && $order->order_status_id == 1);

            if ($shouldAutoApprove) {
                OrderCancelRequest::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'reason_user' => trim($request->reason),
                    'status_id' => 2, 
                    'status' => 'accepted',
                    'canceled_by' => 'customer',
                ]);

                foreach ($order->details as $detail) {
                    if ($detail->productVariant) {
                        $detail->productVariant->increment('quantity', $detail->quantity);
                    }
                }

                if ($order->voucher_id) {
                    $voucher = Voucher::find($order->voucher_id);
                    if ($voucher) $voucher->decrement('total_used');
                }

                $order->update(['order_status_id' => 6, 'is_cancel_requested' => 0]);
                $logNote = 'Hệ thống tự động hủy đơn và hoàn trả Voucher: ' . $request->reason;
                $redirectMsg = 'Đơn hàng của bạn đã được hủy thành công.';
            } else {
                OrderCancelRequest::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'reason_user' => trim($request->reason),
                    'status_id' => 1, 
                    'status' => 'pending',
                    'canceled_by' => 'customer',
                    'bank_name' => $bankData['bank_name'],
                    'account_number' => $bankData['account_number'],
                    'account_holder' => $bankData['account_holder'],
                ]);

                $order->update(['is_cancel_requested' => 1]);
                $logNote = 'Khách hàng gửi yêu cầu hủy đơn (Đang chờ duyệt): ' . $request->reason;
                $redirectMsg = 'Yêu cầu hủy đơn đã được gửi.';
            }

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'user',
                'actor_id' => Auth::id(),
                'note' => $logNote,
            ]);
            
            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', $redirectMsg);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xử lý hủy đơn #' . $order_id . ': ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }
}