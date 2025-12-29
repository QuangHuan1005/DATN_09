<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class AdminReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = OrderReturn::with([
            'order.user',
            'order.details.product',
            'user',
            'refundAccount'
        ]);

        // Tìm kiếm theo mã đơn hoặc tên khách hàng
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('order', function ($q) use ($keyword) {
                $q->where('order_code', 'like', "%{$keyword}%")
                  ->orWhereHas('user', function ($uq) use ($keyword) {
                      $uq->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        // Lọc theo trạng thái hoàn hàng
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns = $query->latest()->paginate(15);

        // Danh sách trạng thái hoàn hàng
        $statuses = [
            ['value' => 'pending', 'label' => 'Chờ xác nhận', 'color' => 'warning'],
            ['value' => 'approved', 'label' => 'Đã chấp nhận', 'color' => 'success'],
            ['value' => 'waiting_for_return', 'label' => 'Chờ người dùng gửi hàng', 'color' => 'info'],
            ['value' => 'returned', 'label' => 'Đã nhận hàng', 'color' => 'primary'],
            ['value' => 'refunded', 'label' => 'Đã hoàn tiền', 'color' => 'success'],
            ['value' => 'rejected', 'label' => 'Từ chối', 'color' => 'danger'],
        ];

        return view('admin.returns.index', compact('returns', 'statuses'));
    }

    public function show(OrderReturn $return)
    {
        $return->load([
            'order.details.product',
            'order.details.productVariant.color',
            'order.details.productVariant.size',
            'order.user',
            'user',
            'refundAccount'
        ]);

        return view('admin.returns.show', compact('return'));
    }

    public function updateStatus(Request $request, OrderReturn $return)
    {
        // Validation rules
        $rules = [
            'status' => 'required|in:pending,waiting_for_return,returned,approved,rejected,refunded'
        ];

        // Nếu chọn từ chối, bắt buộc phải có lý do
        if ($request->status === 'rejected') {
            $rules['rejection_reason'] = 'required|string|min:5|max:1000';
        }

        $validated = $request->validate($rules, [
            'rejection_reason.required' => 'Vui lòng chọn hoặc nhập lý do từ chối!',
            'rejection_reason.min' => 'Lý do từ chối phải có ít nhất 5 ký tự!',
            'rejection_reason.max' => 'Lý do từ chối không được quá 1000 ký tự!'
        ]);

        // Cập nhật trạng thái
        $updateData = [
            'status' => $request->status
        ];

        // Nếu từ chối, lưu lý do vào cột rejection_reason
        if ($request->status === 'rejected') {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        $return->update($updateData);

        // Cập nhật trạng thái đơn hàng tương ứng
        if ($request->status === 'refunded') {
    // 1. Cập nhật trạng thái Đơn hàng
    $return->order->update([
        'order_status_id' => 7, // Hoàn hàng
        'payment_status_id' => 3 // Hoàn tiền
    ]);

    // 2. XỬ LÝ CỘNG LẠI TỒN KHO (Tăng Stock)
    
    // Tải models cần thiết
    // use App\Models\Product; // Nếu bạn không dùng biến thể

    // Chuyển chuỗi JSON sản phẩm hoàn trả thành mảng PHP
    $returnedItems = json_decode($return->product_details, true);

    if ($returnedItems) {
        foreach ($returnedItems as $item) {
            $variantId = $item['product_variant_id'];
            $quantity = $item['quantity'];

            // Đảm bảo có ID biến thể và số lượng hợp lệ
            if ($variantId && $quantity > 0) {
                // Sử dụng increment để tăng số lượng tồn kho
                ProductVariant::where('id', $variantId)
                              ->increment('quantity', $quantity);

                // Ghi log (tùy chọn): Nếu bạn có log tồn kho, nên thêm ở đây
            } 
            // Nếu bạn có trường hợp sản phẩm không có biến thể:
            /*
            elseif (!$variantId && $item['product_id'] && $quantity > 0) {
                \App\Models\Product::where('id', $item['product_id'])
                                   ->increment('stock', $quantity);
            }
            */
        }
    }
    // KẾT THÚC XỬ LÝ CỘNG LẠI TỒN KHO
}

        // Tạo log trạng thái (nếu có model OrderReturnStatusLog)
        if (class_exists(\App\Models\OrderReturnStatusLog::class)) {
            \App\Models\OrderReturnStatusLog::create([
                'order_return_id' => $return->id,
                'status' => $request->status,
                'actor_type' => 'admin',
                'actor_id' => auth('admin')->id(),
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
}