<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderCancelRequest;
use App\Models\OrderStatusLog;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminOrderCancelController extends Controller
{
    /**
     * Hiển thị danh sách yêu cầu hủy đơn hàng
     */
    public function index(Request $request)
    {
        // Thêm nạp chồng phương thức thanh toán của đơn hàng
        $query = OrderCancelRequest::with(['order.paymentMethod', 'user', 'cancelStatus']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('order', function ($o) use ($search) {
                    $o->where('order_code', 'like', "%{$search}%");
                })->orWhereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $cancelRequests = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.order_cancellations.index', compact('cancelRequests'));
    }

    /**
     * Xem chi tiết một yêu cầu hủy
     */
    public function show($id)
    {
        $request = OrderCancelRequest::with([
            'order.details.productVariant.product',
            'order.details.productVariant.size',
            'order.details.productVariant.color',
            'order.status',
            'user',
            'cancelStatus'
        ])->findOrFail($id);

        $order = $request->order;
        $lines = $order->details;

        $calc_subtotal = $lines->sum(function ($line) {
            return $line->quantity * $line->price;
        });
        $calc_discount = $order->discount ?? 0;
        $calc_total = $calc_subtotal - $calc_discount;

        return view('admin.order_cancellations.show', compact(
            'request',
            'order',
            'lines',
            'calc_subtotal',
            'calc_discount',
            'calc_total'
        ));
    }

    /**
     * Xử lý Chấp nhận hoặc Từ chối yêu cầu hủy (Giai đoạn 1)
     */
    public function process(Request $request, $id, InventoryService $inv)
    {
        $cancelRequest = OrderCancelRequest::with('order')->findOrFail($id);

        $request->validate([
            'action' => ['required', 'in:accept,reject'],
            'reason_admin' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'reason_admin.required' => 'Vui lòng nhập lý do phản hồi cho khách hàng.',
            'reason_admin.min' => 'Lý do phản hồi phải có ít nhất 5 ký tự.',
        ]);

        $action = $request->input('action');
        $order = $cancelRequest->order;

        DB::beginTransaction();
        try {
            if ($action === 'accept') {
                $oldStatus = $order->order_status_id;
                $paymentMethodId = (int) $order->payment_method_id;
                $paymentStatusId = (int) $order->payment_status_id;

                // KIỂM TRA PHƯƠNG THỨC THANH TOÁN
                // Giả sử ID 1 là COD
                if ($paymentMethodId === 1) {
                    // TRƯỜNG HỢP COD: Kết thúc yêu cầu ngay lập tức
                    $cancelRequest->update([
                        'status_id'    => 2, // Đổi từ 4 thành 2 (Accepted/Canceled)
                        'status'       => 'accepted', // Đổi từ 'refunded' thành 'accepted'
                        'reason_admin' => $request->input('reason_admin'),
                    ]);

                    $order->update([
                        'order_status_id' => 6, // Đã Hủy
                        'payment_status_id' => 1, // Vẫn là Chưa thanh toán
                        'is_cancel_requested' => 0,
                    ]);
                    $msg = 'Đã chấp nhận và hủy đơn hàng COD thành công.';
                } else {
                    // TRƯỜNG HỢP ONLINE/CHUYỂN KHOẢN
                    // Nếu khách ĐÃ thanh toán rồi thì mới cần bước xác nhận hoàn tiền (Giai đoạn 2)
                    if ($paymentStatusId === 2 || $paymentStatusId === 3) {
                        $cancelRequest->update([
                            'status_id'    => 2, // Chờ admin xác nhận đã chuyển khoản trả khách
                            'status'       => 'accepted',
                            'reason_admin' => $request->input('reason_admin'),
                        ]);
                        $msg = 'Đã chấp nhận yêu cầu hủy. Vui lòng thực hiện hoàn tiền cho khách và tải minh chứng.';
                    } else {
                        // Nếu là đơn Online nhưng khách CHƯA thanh toán (ví dụ hủy ngay lúc đặt)
                        $cancelRequest->update([
                            'status_id'    => 2,
                            'status'       => 'accepted',
                            'reason_admin' => $request->input('reason_admin'),
                        ]);
                        $msg = 'Đã chấp nhận yêu cầu hủy đơn hàng (Chưa thanh toán).';
                    }

                    $order->update([
                        'order_status_id' => 6,
                        'is_cancel_requested' => 0,
                    ]);
                }

                // Hoàn kho cho đơn hàng nếu đơn hàng chưa ở trạng thái Giao hàng/Hoàn thành
                if (in_array($oldStatus, [1, 2, 3])) {
                    $inv->restoreForOrder($order);
                }
            } else {
                // TỪ CHỐI HỦY
                $cancelRequest->update([
                    'status_id'    => 3,
                    'status'       => 'rejected',
                    'reason_admin' => $request->input('reason_admin'),
                ]);
                if ($order) {
                    $order->update(['is_cancel_requested' => 0]);
                }
                $msg = 'Đã từ chối yêu cầu hủy đơn hàng.';
            }

            // Ghi log lịch sử trạng thái
            if ($order) {
                OrderStatusLog::create([
                    'order_id'         => $order->id,
                    'order_status_id'  => $order->order_status_id,
                    'actor_type'       => 'admin',
                    'actor_id'         => Auth::id(),
                    'note'             => ($action === 'accept' ? "Duyệt hủy: " : "Từ chối hủy: ") . $request->input('reason_admin'),
                ]);
            }

            DB::commit();
            return redirect()->route('admin.order-cancellations.show', $id)->with('success', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi xử lý yêu cầu hủy #" . $id . ": " . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Xác nhận đã chuyển khoản hoàn tiền xong (Giai đoạn 2 - Chỉ dành cho thanh toán Online)
     */
    public function confirmRefund(Request $request, $id)
    {
        $request->validate([
            'refund_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'refund_image.required' => 'Vui lòng tải lên ảnh minh chứng đã chuyển khoản hoàn tiền.',
            'refund_image.image' => 'File tải lên phải là hình ảnh.',
        ]);

        $cancelRequest = OrderCancelRequest::with('order')->findOrFail($id);
        $order = $cancelRequest->order;

        DB::beginTransaction();
        try {
            if ($request->hasFile('refund_image')) {
                $file = $request->file('refund_image');
                $filename = 'refund_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
                // Lưu vào thư mục public/refunds để dễ dàng hiển thị ra view
                $file->move(public_path('storage/refunds'), $filename);
                $cancelRequest->refund_image = $filename;
            }

            $cancelRequest->status_id = 4; // 4: Đã hoàn tiền (Refunded)
            $cancelRequest->status = 'refunded';
            $cancelRequest->save();

            if ($order) {
                $order->update(['payment_status_id' => 3]); // Cập nhật trạng thái thanh toán đơn hàng là Đã hoàn tiền

                OrderStatusLog::create([
                    'order_id' => $order->id,
                    'order_status_id' => $order->order_status_id,
                    'actor_type' => 'admin',
                    'actor_id' => Auth::id(),
                    'note' => "Xác nhận đã hoàn tiền qua minh chứng ảnh thành công.",
                ]);
            }

            DB::commit();
            return back()->with('success', 'Xác nhận hoàn tiền thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi xác nhận hoàn tiền yêu cầu #" . $id . ": " . $e->getMessage());
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}