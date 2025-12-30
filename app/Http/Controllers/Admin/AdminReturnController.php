<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // 1. Cấu hình Validation rules
        $rules = [
            'status' => 'required|in:pending,waiting_for_return,returned,approved,rejected,refunded',
            'admin_refund_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ];

        // Nếu chọn từ chối, bắt buộc phải có lý do
        if ($request->status === 'rejected') {
            $rules['rejection_reason'] = 'required|string|min:5|max:1000';
        }

        $request->validate($rules, [
            'rejection_reason.required' => 'Vui lòng chọn hoặc nhập lý do từ chối!',
            'rejection_reason.min' => 'Lý do từ chối phải có ít nhất 5 ký tự!',
            'rejection_reason.max' => 'Lý do từ chối không được quá 1000 ký tự!',
            'admin_refund_proof.image' => 'Tệp tải lên phải là hình ảnh!',
            'admin_refund_proof.mimes' => 'Định dạng ảnh không hợp lệ!',
            'admin_refund_proof.max' => 'Dung lượng ảnh tối đa là 2MB!'
        ]);

        // 2. Chuẩn bị dữ liệu cập nhật trạng thái
        $updateData = [
            'status' => $request->status
        ];

        // Nếu từ chối, lưu lý do vào cột rejection_reason
        if ($request->status === 'rejected') {
            $updateData['rejection_reason'] = $request->rejection_reason;
        }

        // 3. XỬ LÝ TẢI LÊN BIÊN LAI HOÀN TIỀN (CHỈ DÀNH CHO ADMIN)
        if ($request->hasFile('admin_refund_proof')) {
            // Xóa ảnh cũ nếu có để tiết kiệm dung lượng
            if ($return->admin_refund_proof) {
                Storage::disk('public')->delete($return->admin_refund_proof);
            }

            $file = $request->file('admin_refund_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Lưu vào thư mục public/refunds bên trong storage
            $path = $file->storeAs('refunds', $fileName, 'public');
            
            // Lưu đường dẫn vào mảng cập nhật
            $updateData['admin_refund_proof'] = $path;
        }

        // 4. Thực hiện cập nhật Model OrderReturn
        $return->update($updateData);

        // 5. Cập nhật trạng thái đơn hàng tương ứng khi hoàn tiền thành công
        if ($request->status === 'refunded') {
            // Cập nhật trạng thái Đơn hàng
            $return->order->update([
                'order_status_id' => 7, // Hoàn hàng
                'payment_status_id' => 3 // Hoàn tiền
            ]);

            // 6. XỬ LÝ CỘNG LẠI TỒN KHO (Tăng Stock)
            // Chuyển chuỗi JSON sản phẩm hoàn trả thành mảng PHP
            $returnedItems = is_array($return->product_details) ? $return->product_details : json_decode($return->product_details, true);

            if ($returnedItems) {
                foreach ($returnedItems as $item) {
                    $variantId = $item['product_variant_id'] ?? null;
                    $quantity = $item['quantity'] ?? 0;

                    // Đảm bảo có ID biến thể và số lượng hợp lệ
                    if ($variantId && $quantity > 0) {
                        // Sử dụng increment để tăng số lượng tồn kho
                        ProductVariant::where('id', $variantId)
                                      ->increment('quantity', $quantity);
                    } 
                }
            }
        }

        // 7. Tạo log trạng thái (nếu có model OrderReturnStatusLog)
        if (class_exists(\App\Models\OrderReturnStatusLog::class)) {
            \App\Models\OrderReturnStatusLog::create([
                'order_return_id' => $return->id,
                'status' => $request->status,
                'actor_type' => 'admin',
                'actor_id' => auth('admin')->id() ?? auth()->id(), // Thêm fallback nếu auth admin không lấy được
            ]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái và minh chứng hoàn tiền thành công!');
    }
}