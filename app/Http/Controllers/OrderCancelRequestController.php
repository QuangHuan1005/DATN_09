<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderCancelRequest; // Model yêu cầu hủy
use App\Models\OrderStatusLog; // Log trạng thái
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log để ghi lỗi

class OrderCancelRequestController extends Controller
{
    /**
     * Khách hàng gửi yêu cầu hủy đơn hàng.
     * Tương ứng với Route POST /orders/{id}/cancel
     */
    public function store(Request $request, $order_id)
    {
        // 1. Tìm đơn hàng
        $order = Order::with('details.productVariant') 
                      ->where('id', $order_id)
                      ->where('user_id', Auth::id())
                      ->first();
        
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.');
        }
        // 2. Kiểm tra tính hợp lệ của việc hủy (Cần accessor 'cancelable' trong Order Model)
        // Nếu không có accessor, bạn có thể kiểm tra trực tiếp trạng thái ở đây.
        if (!($order->cancelable ?? ($order->order_status_id < 4))) { // Giả định: chỉ hủy được trước trạng thái đã giao
            return back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        // 3. Kiểm tra xem yêu cầu hủy đã tồn tại chưa
        if (OrderCancelRequest::where('order_id', $order_id)->exists()) {
            return back()->with('error', 'Đơn hàng này đã có yêu cầu hủy đang chờ xử lý.');
        }

        DB::beginTransaction();

        try {
            // A. TẠO BẢN GHI YÊU CẦU HỦY
            OrderCancelRequest::create([
                'order_id'    => $order->id,
                'user_id'     => Auth::id(),
                'reason_user' => trim($request->input('reason', 'Khách yêu cầu hủy')),
                'status_id'      => 1, // 1: Đang chờ xử lý (Pending)
            ]);
            
            // B. Cập nhật trạng thái đơn hàng (để đánh dấu đang chờ hủy)
            $order->order_status_id = 6; // Ví dụ: 6 = Yêu cầu Hủy
            
            // C. Logic hoàn tiền (Tuỳ chọn: nếu xử lý tự động)
            // ... (Giữ nguyên logic của bạn nếu có)
            
            // D. Hoàn trả tồn kho (Giữ nguyên logic của bạn)
            foreach (collect($order->details) as $item) {
                 $variant = $item->productVariant; 
                 if ($variant) {
                      $variant->increment('quantity', $item->quantity);
                 }
            }

            // E. Ghi log trạng thái
            OrderStatusLog::create([
                'order_id'        => $order->id,
                'order_status_id' => 6,
                'actor_type'      => 'user',
            ]);
            
            $order->save();
            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Yêu cầu hủy đơn hàng đã được gửi đi và tồn kho đã được hoàn lại.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Client Cancel Request Error for Order #{$order_id}: " . $e->getMessage()); 
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi gửi yêu cầu hủy.');
        }
    }
}