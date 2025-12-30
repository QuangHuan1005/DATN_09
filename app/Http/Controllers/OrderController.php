<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use App\Models\OrderCancelRequest;
use App\Models\ProductVariant;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Tự động hủy các đơn hàng VNPay quá hạn 30 phút mà chưa thanh toán
     */
    private function autoCancelExpiredOrders()
    {
        $expiryTime = now()->subMinutes(30);

        $expiredOrders = Order::where('payment_method_id', 2)
            ->where('payment_status_id', '!=', 2)
            ->where('order_status_id', 1)
            ->where('created_at', '<', $expiryTime)
            ->get();

        if ($expiredOrders->isNotEmpty()) {
            foreach ($expiredOrders as $order) {
                DB::transaction(function () use ($order) {
                    $order->update([
                        'order_status_id' => 6,
                        'note' => $order->note . ' (Hệ thống tự động hủy do quá hạn thanh toán VNPay)'
                    ]);

                    foreach ($order->details as $detail) {
                        if ($detail->productVariant) {
                            $detail->productVariant->increment('quantity', $detail->quantity);
                        }
                    }

                    OrderStatusLog::create([
                        'order_id'        => $order->id,
                        'order_status_id' => 6,
                        'actor_type'      => 'system',
                        'note'            => 'Hệ thống tự động hủy đơn do khách hàng không hoàn tất thanh toán VNPay trong 30 phút.'
                    ]);
                });
            }
        }
    }

    /**
     * Trang danh sách đơn hàng của khách
     */
    public function index(Request $request)
    {
        $this->autoCancelExpiredOrders();
        
        $statusId = (int) $request->query('status_id', 0);
        $statuses = OrderStatus::orderBy('id')->get(['id', 'name']);

        $counts = Order::query()
            ->where('user_id', Auth::id())
            ->selectRaw('order_status_id, COUNT(*) as c')
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id');

        $orders = Order::query()
            ->with(['status', 'paymentStatus', 'paymentMethod', 'details'])
            ->where('user_id', Auth::id())
            ->when($statusId > 0, fn($q) => $q->where('order_status_id', $statusId))
            ->latest('created_at')
            ->paginate(5)
            ->withQueryString();

        return view('orders.index', compact('orders', 'statuses', 'statusId', 'counts'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function show($id)
    {
        $this->autoCancelExpiredOrders();

        $order = Order::query()
            ->with([
                'status', 'paymentStatus', 'paymentMethod', 'invoice', 'voucher',
                'user:id,name,email',
                'details.productVariant.product:id,name',
                'details.productVariant.color:id,name,color_code',
                'details.productVariant.size:id,name,size_code',
                'statusLogs',
                'cancelRequest',
            ])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $lines = $order->details->map(function ($d) {
            $v = $d->productVariant;
            $variantText = [];
            if ($v?->size?->name)  $variantText[] = "Size: {$v->size->name}";
            if ($v?->color?->name) $variantText[] = "Màu: {$v->color->name}";
            return (object)[
                'product_name' => $v?->product?->name ?? 'Sản phẩm',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'        => $v?->image,
                'unit_price'   => (int)$d->price,
                'qty'          => (int)$d->quantity,
                'line_total'   => (int)($d->price * $d->quantity),
                // FIX LỖI: Thêm trường eta để tránh Undefined property
                'eta'          => $d->estimated_delivery ?? null, 
            ];
        });

        $calc_subtotal = $lines->sum('line_total');
        $calc_discount = (int)$order->discount;
        $calc_total    = (int)$order->total_amount;
        $calc_shipping_fee = max(0, $calc_total - $calc_subtotal + $calc_discount);

        return view('orders.show', [
            'order'             => $order,
            'lines'             => $lines,
            'calc_subtotal'     => $calc_subtotal,
            'calc_discount'     => $calc_discount,
            'calc_shipping_fee' => $calc_shipping_fee,
            'calc_total'        => $calc_total,
        ]);
    }

    /**
     * Thanh toán lại VNPay
     */
    public function repay($orderCode)
    {
        $this->autoCancelExpiredOrders();

        $order = Order::where('order_code', $orderCode)
                      ->where('user_id', Auth::id())
                      ->where('payment_status_id', '!=', 2) 
                      ->where('order_status_id', 1)
                      ->first();

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Đơn hàng không tồn tại hoặc đã quá thời hạn thanh toán.');
        }

        $vnpayService = new VNPayService();
        $result = $vnpayService->createPayment(
            $order->order_code, 
            $order->total_amount, 
            "Thanh toan lai cho don hang " . $order->order_code
        );

        if ($result['success']) {
            return redirect()->away($result['payment_url']);
        }

        return redirect()->back()->with('error', 'Cổng thanh toán đang bảo trì, vui lòng thử lại sau.');
    }

    /**
     * Hủy đơn hàng - Logic Double Check
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::with('details.productVariant')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // --- QUAN TRỌNG: LÀM MỚI DỮ LIỆU TỪ DB ---
        $order->refresh();

        // CHẶN HÀNH VI: Nếu không phải trạng thái 1, 2 thì KHÔNG ĐƯỢC HỦY
        if (!$order->cancelable) {
            return back()->with('error', 'Xin lỗi, trạng thái đơn hàng đã thay đổi (Đang vận chuyển hoặc đã giao), không thể hủy vào lúc này.');
        }

        // CHẶN HÀNH VI: Nếu đã gửi yêu cầu hủy rồi thì không cho gửi nữa
        if ($order->is_cancel_requested == 1) {
            return back()->with('error', 'Yêu cầu hủy đơn hàng của bạn đang được xử lý.');
        }

        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->hasFile('refund_image')) {
                $file = $request->file('refund_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/refunds'), $fileName);
            }

            $paymentMethodId = (int) $order->payment_method_id;
            $paymentStatusId = (int) $order->payment_status_id;

            // Logic mặc định cho yêu cầu hủy
            $cancelRequestStatusId = 1; // Chờ xử lý
            $cancelRequestStatusStr = 'pending';

            /**
             * LƯU Ý: Không nên cập nhật order_status_id = 6 ngay lập tức ở đây 
             * nếu bạn muốn Admin duyệt. Nếu bạn muốn hủy luôn thì giữ nguyên.
             * Dưới đây giữ nguyên logic cập nhật ID 6 của bạn nhưng thêm bảo mật.
             */
            
            OrderCancelRequest::create([
                'order_id'      => $order->id,
                'user_id'       => Auth::id(),
                'canceled_by'   => 'customer',
                'reason_user'   => trim($request->input('reason')),
                'status'        => 'pending',
                'status_id'     => 1, 
                'refund_image'  => $fileName,
            ]);

            // Cập nhật trạng thái đơn hàng (Duyệt hủy ngay)
            $order->order_status_id = 6; 
            $order->is_cancel_requested = 1;
            
            if ($paymentMethodId !== 1 && $paymentStatusId === 2) {
                $order->payment_status_id = 3; // Chờ hoàn tiền
            }
            
            $order->note = $request->input('reason', 'Khách yêu cầu hủy');
            $order->save();

            // --- HOÀN KHO ---
            foreach ($order->details as $item) {
                $variant = $item->productVariant;
                if ($variant) {
                    $variant->increment('quantity', $item->quantity);
                }
            }

            OrderStatusLog::create([
                'order_id'        => $order->id,
                'order_status_id' => 6,
                'actor_type'      => 'user',
                'note'            => 'Người dùng hủy đơn hàng: ' . trim($request->input('reason'))
            ]);

            DB::commit();
            return redirect()->route('orders.show', $order->id)->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi hủy đơn hàng của người dùng #{$id}: " . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra trong quá trình hủy đơn.');
        }
    }

    /**
     * Xác nhận Đã nhận hàng
     */
    public function complete(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Double check status cho nút Hoàn thành
        $order->refresh();

        if ((int)$order->order_status_id !== 4) {
            return back()->with('error', 'Chỉ có thể hoàn thành khi đơn hàng ở trạng thái Đã giao hàng.');
        }

        DB::beginTransaction();
        try {
            $order->order_status_id = 5;
            $order->payment_status_id = 2;
            $order->save();

            $pointsToEarn = (int) floor($order->subtotal / 100); 

            if ($pointsToEarn > 0) {
                DB::table('users')->where('id', Auth::id())->increment('points', $pointsToEarn);
            }

            OrderStatusLog::create([
                'order_id'        => $order->id,
                'order_status_id' => 5,
                'actor_type'      => 'user',
                'note'            => "Người dùng xác nhận đã nhận hàng. Được cộng " . number_format($pointsToEarn) . " điểm."
            ]);

            DB::commit();

            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Đơn hàng hoàn thành. Bạn đã được cộng ' . number_format($pointsToEarn) . ' điểm tích lũy!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi hoàn thành đơn hàng #" . $id . ": " . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng.');
        }
    }

    /**
     * Đánh giá đơn hàng
     */
    public function review($id)
    {
        $order = Order::with([
            'details.productVariant.product:id,name',
            'details.productVariant.color:id,name',
            'details.productVariant.size:id,name'
        ])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

        if ((int)$order->order_status_id !== 5) {
            return redirect()->route('orders.show', $id)
                             ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã hoàn thành.');
        }

        $uniqueDetails = $order->details->unique(function ($item) {
            return $item->productVariant->product_id;
        });

        return view('orders.review', [
            'order' => $order,
            'uniqueDetails' => $uniqueDetails
        ]);
    }
}