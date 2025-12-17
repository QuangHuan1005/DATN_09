<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderCancelRequest;
use App\Models\OrderStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminOrderCancelController extends Controller
{
    /**
     * Hiển thị danh sách các yêu cầu hủy (thường là trạng thái Pending).
     */
    public function index()
    {
        $cancelRequests = OrderCancelRequest::with(['order', 'user', 'status'])
            ->where('status_id', 1) // Chỉ lấy các yêu cầu Đang chờ (Pending)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.order_cancellations.index', compact('cancelRequests'));
    }

    /**
     * Xem chi tiết yêu cầu hủy.
     */
    public function show(OrderCancelRequest $request)
    {
        // Tải thêm chi tiết đơn hàng cho trang xem chi tiết
        $request->load([
            'order.details.productVariant',
            'order.status',
            'user',
            'status'
        ]);
        
        return view('admin.order_cancellations.show', compact('request'));
    }

    /**
     * Xử lý yêu cầu hủy (Chấp nhận hoặc Từ chối).
     */
    public function process(Request $request, OrderCancelRequest $cancelRequest)
    {
        $request->validate([
            'action' => ['required', 'in:accept,reject'], // Phải là 'accept' hoặc 'reject'
            'reason_admin' => ['nullable', 'string', 'max:500'],
        ]);

        $action = $request->input('action');
        
        // Chỉ xử lý các yêu cầu đang chờ
        if ($cancelRequest->status_id != 1) {
            return back()->with('error', 'Yêu cầu hủy này đã được xử lý trước đó.');
        }

        DB::beginTransaction();
        try {
            $newStatusId = ($action === 'accept') ? 2 : 3; // 2: Accepted, 3: Rejected
            $orderStatusId = ($action === 'accept') ? 6 : $cancelRequest->order->order_status_id; // 6: Đã Hủy (Nếu chấp nhận)
            $logStatusText = ($action === 'accept') ? 'Yêu cầu hủy được Admin chấp nhận.' : 'Yêu cầu hủy bị Admin từ chối.';
            
            // 1. Cập nhật Yêu cầu Hủy
            $cancelRequest->update([
                'status_id' => $newStatusId,
                'reason_admin' => $request->input('reason_admin'),
            ]);

            // 2. Cập nhật trạng thái Đơn hàng và Log (CHỈ KHI CHẤP NHẬN)
            if ($action === 'accept') {
                $order = $cancelRequest->order;
                $order->order_status_id = $orderStatusId;
                $order->save();
                
                // Ghi log trạng thái đơn hàng (sử dụng ID Admin đang đăng nhập)
                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => $orderStatusId, // ID 6 (Đã Hủy)
                    'actor_type' => 'admin',
                    'actor_id' => Auth::guard('admin')->id(), // Giả định bạn dùng guard 'admin'
                    'note' => $logStatusText,
                ]);
                
                // Lưu ý: Logic hoàn trả tồn kho đã nằm trong OrderCancelRequestController@store của user
                // Nếu bạn muốn hoàn trả tồn kho sau khi admin duyệt (accept), bạn phải di chuyển logic đó về đây.
                // Hiện tại, tồn kho đã được hoàn trả khi user gửi yêu cầu.
            }
            
            DB::commit();

            return redirect()->route('admin.order-cancellations.index')
                ->with('success', $logStatusText);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Admin Cancel Request Processing Error: " . $e->getMessage()); 
            return back()->with('error', 'Đã xảy ra lỗi hệ thống khi xử lý yêu cầu.');
        }
    }
}