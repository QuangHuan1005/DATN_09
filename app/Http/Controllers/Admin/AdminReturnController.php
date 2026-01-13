<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminReturnController extends Controller
{
    /**
     * Hiển thị danh sách yêu cầu hoàn hàng
     * Tích hợp tìm kiếm và lọc trạng thái
     */
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

        // Lọc theo trạng thái hệ thống
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $returns = $query->latest()->paginate(15);

        // Danh sách trạng thái dùng cho View Filter (Tiếng Việt)
        $statuses = [
            ['value' => 'pending',           'label' => 'Chờ duyệt'],
            ['value' => 'approved',          'label' => 'Đã duyệt'],
            ['value' => 'returning',         'label' => 'Đang trả hàng'],
            ['value' => 'received',          'label' => 'Đã nhận/Kiểm tra'],
            ['value' => 'refund_processing', 'label' => 'Đang xử lý hoàn tiền'],
            ['value' => 'completed',         'label' => 'Hoàn tất'],
            ['value' => 'rejected',          'label' => 'Bị từ chối'],
        ];

        return view('admin.returns.index', compact('returns', 'statuses'));
    }

    /**
     * Xem chi tiết yêu cầu hoàn hàng
     */
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

    /**
     * Cập nhật trạng thái quy trình hoàn hàng
     * Xử lý logic cộng kho và cập nhật đơn hàng khi hoàn tất
     */
   public function updateStatus(Request $request, OrderReturn $return)
    {
        // 1. Cấu hình Validation (Admin KHÔNG được chọn completed)
        $rules = [
            'status' => 'required|in:pending,approved,returning,received,refund_processing,rejected',
            'admin_refund_proof' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];

        // Nếu từ chối, bắt buộc nhập lý do
        if ($request->status === 'rejected') {
            $rules['rejection_reason'] = 'required|string|min:5|max:1000';
        }

        // Nếu chuyển sang trạng thái "Đang xử lý hoàn tiền", bắt buộc phải tải biên lai
        if ($request->status === 'refund_processing' && !$return->admin_refund_proof) {
            $rules['admin_refund_proof'] = 'required|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($rules, [
            'rejection_reason.required' => 'Vui lòng nhập lý do từ chối yêu cầu.',
            'admin_refund_proof.required' => 'Vui lòng tải lên ảnh minh chứng đã hoàn tiền (Biên lai).',
            'admin_refund_proof.image' => 'Minh chứng phải là định dạng ảnh.',
        ]);

        try {
            DB::beginTransaction();

            // Chặn tuyệt đối nếu Admin cố tình gửi status 'completed' qua request
            if ($request->status === 'completed') {
                return redirect()->back()->with('error', 'Trạng thái này chỉ được xác nhận bởi khách hàng!');
            }

            $updateData = ['status' => $request->status];

            if ($request->status === 'rejected') {
                $updateData['rejection_reason'] = $request->rejection_reason;
            }

            // Xử lý upload biên lai chuyển tiền
            if ($request->hasFile('admin_refund_proof')) {
                if ($return->admin_refund_proof) {
                    Storage::disk('public')->delete($return->admin_refund_proof);
                }

                $file = $request->file('admin_refund_proof');
                $fileName = 'receipt_' . time() . '_' . $return->id . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('refunds', $fileName, 'public');
                $updateData['admin_refund_proof'] = $path;
            }

            // Cập nhật Model Hoàn hàng
            $return->update($updateData);

            // Ghi Log lịch sử thao tác
            if (class_exists(\App\Models\OrderReturnStatusLog::class)) {
                \App\Models\OrderReturnStatusLog::create([
                    'order_return_id' => $return->id,
                    'status'          => $request->status,
                    'actor_type'      => 'admin',
                    'actor_id'        => auth('admin')->id() ?? auth()->id(),
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công. Chờ khách hàng xác nhận nhận tiền!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}