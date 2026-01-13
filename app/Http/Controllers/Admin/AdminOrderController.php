<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Models\Order;
use App\Models\OrderCancelRequest;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;
use Exception;

class AdminOrderController extends Controller
{
    // ===========================================================
    // HẰNG SỐ TRẠNG THÁI
    // ===========================================================
    const STATUS_PENDING   = 1; // Chờ xác nhận
    const STATUS_CONFIRMED = 2; // Xác nhận
    const STATUS_SHIPPING  = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao (Khách chưa ấn nhận)
    const STATUS_DONE      = 5; // Hoàn thành (Chỉ dành cho Client ấn)
    const STATUS_CANCEL    = 6; // Hủy
    const STATUS_RETURNED  = 7; // Hoàn hàng

    const PAYMENT_STATUS_UNPAID   = 1;
    const PAYMENT_STATUS_PAID     = 2;
    const PAYMENT_STATUS_REFUNDED = 3;

    const PAYMENT_METHOD_COD = 1;

    /**
     * Lấy danh sách trạng thái để hiển thị (Màu sắc CSS)
     * Đã loại bỏ 'Hoàn thành' để Admin không chọn được thủ công
     */
    private function getStatuses()
    {
        return [
            (object)['id' => self::STATUS_PENDING,   'name' => 'Chờ xác nhận', 'color_class' => 'bg-warning text-dark'],
            (object)['id' => self::STATUS_CONFIRMED, 'name' => 'Xác nhận',      'color_class' => 'bg-primary text-white'],
            (object)['id' => self::STATUS_SHIPPING,  'name' => 'Đang giao hàng', 'color_class' => 'bg-info text-white'],
            (object)['id' => self::STATUS_DELIVERED, 'name' => 'Đã giao hàng',  'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_DONE,      'name' => 'Hoàn thành',    'color_class' => 'bg-success text-white'],
            (object)['id' => self::STATUS_CANCEL,    'name' => 'Đã hủy',        'color_class' => 'bg-danger text-white'],
            (object)['id' => self::STATUS_RETURNED,  'name' => 'Hoàn hàng',     'color_class' => 'bg-secondary text-white'],
        ];
    }

    /**
     * Trang danh sách đơn hàng
     * CẬP NHẬT: Thêm logic lọc order_status_id để khớp với Dashboard
     */
public function index(Request $request)
{
    // Khởi tạo query với đầy đủ các quan hệ cần thiết
    $query = Order::with(['status', 'user', 'paymentStatus', 'staff', 'paymentMethod', 'orderReturn'])
        ->withSum('details', 'quantity')
        ->orderByDesc('id');

    // 1. Lọc theo ngày cụ thể (Click từ biểu đồ Line Chart)
    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    // 1b. Lọc theo khoảng ngày (Từ ngày... Đến ngày...)
    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    // 2. Lọc theo tháng và năm (Click từ biểu đồ Bar Chart)
    if ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('created_at', $request->month)
              ->whereYear('created_at', $request->year);
    } elseif ($request->filled('year')) {
        $query->whereYear('created_at', $request->year);
    }

    // 3. XỬ LÝ LỌC TRẠNG THÁI (Đã sửa để nhận diện 5,7)
    $statusInput = $request->input('order_status_id') ?? $request->input('status');
    
    if ($statusInput) {
        // Nếu input là chuỗi có dấu phẩy (ví dụ: "5,7")
        if (is_string($statusInput) && str_contains($statusInput, ',')) {
            $statusIds = explode(',', $statusInput);
            $query->whereIn('order_status_id', $statusIds);
        } else {
            // Nếu chỉ là 1 ID đơn lẻ
            $query->where('order_status_id', $statusInput);
        }
    }

    // 4. Lọc theo trạng thái thanh toán
    if ($request->filled('payment_status')) {
        $query->where('payment_status_id', $request->payment_status);
    }

    // 5. Lọc theo sản phẩm (Click từ biểu đồ Top sản phẩm)
    if ($request->filled('product_id')) {
        $query->whereHas('details.productVariant', function ($q) use ($request) {
            $q->where('product_id', $request->product_id);
        });
    }

    // 6. Tìm kiếm theo từ khóa
    if ($request->filled('keyword')) {
        $kw = $request->keyword;
        $query->where(function ($q) use ($kw) {
            $q->where('order_code', 'like', "%$kw%")
              ->orWhere('name', 'like', "%$kw%");
        });
    }

    $orders = $query->paginate(15); 
    $statuses = $this->getStatuses();

    return view('admin.orders.index', compact('orders', 'statuses'), [
        'pageTitle' => 'Danh sách đơn hàng'
    ]);
}

    /**
     * Chi tiết đơn hàng
     */
    public function show(string $id)
    {
        $order = Order::with([
            'details.productVariant.product',
            'details.productVariant.size',
            'details.productVariant.color',
            'status',
            'user',
            'payment.method',
            'staff',
        ])->findOrFail($id);

        $lines = $order->details->map(function ($d) {
            $v = $d->productVariant;
            $variantText = [];
            if ($v?->size?->name)  $variantText[] = "Size: {$v->size->name}";
            if ($v?->color?->name) $variantText[] = "Màu: {$v->color->name}";
            
            return (object)[
                'product_name' => $v?->product?->name ?? 'Sản phẩm không tồn tại',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'        => $v?->image ?? $v?->product?->image,
                'unit_price'   => (int)$d->price,
                'qty'          => (int)$d->quantity,
                'line_total'   => (int)($d->price * $d->quantity),
            ];
        });

        $calc_subtotal = $lines->sum('line_total');
        $calc_discount = (int)$order->discount;
        $calc_total    = (int)$order->total_amount;
        $statuses = $this->getStatuses();

        return view('admin.orders.show', 
            compact('order', 'lines', 'calc_subtotal', 'calc_discount', 'calc_total', 'statuses'),
            ['pageTitle' => 'Chi tiết đơn hàng #' . $order->order_code]
        );
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function update(Request $request, $id, InventoryService $inv)
    {
        $order = Order::findOrFail($id);
        $oldStatus = (int)$order->order_status_id;
        $newStatus = (int)$request->order_status_id;

        if ($oldStatus === $newStatus) {
            return $this->handleResponse($request, 'Trạng thái đơn hàng không thay đổi.', 'info');
        }

        // Kiểm tra quyền Admin: Không được phép chuyển sang trạng thái "Hoàn thành" thủ công
        if ($newStatus === self::STATUS_DONE) {
            return $this->handleResponse($request, 'Trạng thái "Hoàn thành" chỉ được kích hoạt khi khách hàng xác nhận đã nhận hàng.', 'error', 403);
        }

        if (in_array($oldStatus, [self::STATUS_DONE, self::STATUS_CANCEL, self::STATUS_RETURNED])) {
            return $this->handleResponse($request, 'Đơn hàng đã đóng, không thể thay đổi trạng thái.', 'error', 422);
        }

        if ($order->is_cancel_requested == 1 && $newStatus !== self::STATUS_CANCEL) {
            return $this->handleResponse($request, 'Đơn hàng đang có yêu cầu hủy. Vui lòng xử lý yêu cầu hủy.', 'error', 422);
        }

        // Quy trình chuyển đổi trạng thái của Admin
        $validNextSteps = [
            self::STATUS_PENDING   => [self::STATUS_CONFIRMED, self::STATUS_CANCEL],
            self::STATUS_CONFIRMED => [self::STATUS_SHIPPING, self::STATUS_CANCEL],
            self::STATUS_SHIPPING  => [self::STATUS_DELIVERED, self::STATUS_CANCEL],
            self::STATUS_DELIVERED => [self::STATUS_RETURNED],
        ];

        if (!isset($validNextSteps[$oldStatus]) || !in_array($newStatus, $validNextSteps[$oldStatus])) {
            return $this->handleResponse($request, 'Quy trình chuyển trạng thái không hợp lệ.', 'error', 422);
        }

        if ($newStatus === self::STATUS_CANCEL) {
            $request->validate(['admin_reason' => 'required|min:5']);
        }

        try {
            DB::beginTransaction();

            // 1. XỬ LÝ KHO
            if (in_array($newStatus, [self::STATUS_CANCEL, self::STATUS_RETURNED])) {
                $inv->restoreForOrder($order);
            }

            // 2. XỬ LÝ THANH TOÁN
            if ($newStatus === self::STATUS_CANCEL) {
                $reason = $request->input('admin_reason');
                $order->note = "Admin hủy: " . $reason;
                $order->is_cancel_requested = 0;

                if ((int)$order->payment_method_id !== self::PAYMENT_METHOD_COD) { 
                    if ((int)$order->payment_status_id === self::PAYMENT_STATUS_PAID) {
                        $order->payment_status_id = self::PAYMENT_STATUS_REFUNDED;
                    }
                } else {
                    $order->payment_status_id = self::PAYMENT_STATUS_UNPAID;
                }

                OrderCancelRequest::where('order_id', $order->id)->where('status_id', 1)
                    ->update([
                        'status' => 'accepted',
                        'status_id' => 2,
                        'reason_admin' => "Duyệt trực tiếp từ đơn hàng: " . $reason
                    ]);

            } elseif ($newStatus === self::STATUS_RETURNED) {
                $order->payment_status_id = self::PAYMENT_STATUS_REFUNDED;
                $user = $order->user;
                if ($user && $oldStatus === self::STATUS_DONE) {
                    $pointsToDeduct = floor($order->total_amount / 10000);
                    if ($pointsToDeduct > 0) {
                        $finalDeduct = ($user->points < $pointsToDeduct) ? $user->points : $pointsToDeduct;
                        $user->decrement('points', $finalDeduct);
                        $order->note = ($order->note ? $order->note . " | " : "") . "Thu hồi -" . $finalDeduct . " điểm CP (Hoàn hàng)";
                    }
                }
            } elseif ($newStatus === self::STATUS_DELIVERED) {
                $order->payment_status_id = self::PAYMENT_STATUS_PAID;
            }

            $order->order_status_id = $newStatus;
            $order->save();

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $newStatus,
                'actor_type' => 'admin',
                'actor_id' => auth()->id(),
                'note' => ($newStatus === self::STATUS_CANCEL) ? $request->admin_reason : 'Cập nhật bởi Admin.'
            ]);

            DB::commit();
            return $this->handleResponse($request, 'Cập nhật trạng thái thành công.', 'success');

        } catch (Exception $e) {
            DB::rollBack();
            return $this->handleResponse($request, 'Lỗi hệ thống: ' . $e->getMessage(), 'error', 500);
        }
    }

    /**
     * Hàm hỗ trợ trả về phản hồi cho cả Request thường và AJAX
     */
    private function handleResponse(Request $request, $message, $type = 'success', $code = 200)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => $type,
                'message' => $message
            ], $code);
        }
        return back()->with($type, $message);
    }
}