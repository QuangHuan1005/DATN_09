<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use App\Models\OrderCancelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng của user
     */
    public function index(Request $request)
    {
        $statusId = (int) $request->query('status_id', 0);

        $statuses = OrderStatus::orderBy('id')->get(['id', 'name']);

        $counts = Order::query()
            ->where('user_id', Auth::id())
            ->selectRaw('order_status_id, COUNT(*) as c')
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id');

        $orders = Order::query()
            ->with(['status', 'paymentStatus', 'payment.method', 'details'])
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
        $order = Order::query()
            ->with([
                'status', 'paymentStatus', 'payment.method', 'invoice', 'voucher',
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
                'eta'          => $d->estimated_delivery,
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
     * Hủy đơn hàng - Phía người dùng
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

        if (!$order->cancelable) {
            return back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
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

            $newPaymentStatus = 1;
            $cancelRequestStatusId = 2;
            $cancelRequestStatusStr = 'accepted';

            if ($paymentMethodId !== 1 && $paymentStatusId === 2) {
                $newPaymentStatus = 3;
                $cancelRequestStatusId = 4;
                $cancelRequestStatusStr = 'refunded';
            }

            // --- THU HỒI ĐIỂM ---
            // Nếu đơn đã ở trạng thái Hoàn thành (ID 5) trước đó, cần trừ lại điểm đã cộng
            if ((int)$order->order_status_id === 5) {
                $pointsToDeduct = (int) floor($order->subtotal / 100);
                if ($pointsToDeduct > 0) {
                    DB::table('users')->where('id', Auth::id())->decrement('points', $pointsToDeduct);
                }
            }

            OrderCancelRequest::create([
                'order_id'      => $order->id,
                'user_id'       => Auth::id(),
                'canceled_by'   => 'customer',
                'reason_user'   => trim($request->input('reason')),
                'status'        => $cancelRequestStatusStr,
                'status_id'     => $cancelRequestStatusId,
                'refund_image'  => $fileName,
            ]);

            $order->order_status_id = 6; // Hủy
            $order->payment_status_id = $newPaymentStatus;
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
     * Người dùng xác nhận "Đã nhận được hàng" -> Tích điểm (100đ = 1 điểm)
     */
    public function complete(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Chỉ cho phép hoàn thành nếu đơn hàng đang ở trạng thái "Đã giao hàng" (ID 4)
        if ((int)$order->order_status_id !== 4) {
            return back()->with('error', 'Chỉ có thể hoàn thành khi đơn hàng ở trạng thái Đã giao hàng.');
        }

        DB::beginTransaction();
        try {
            // 1. Cập nhật trạng thái đơn hàng
            $order->order_status_id = 5; // Hoàn thành
            $order->payment_status_id = 2; // Đã thanh toán 
            $order->save();

            // 2. Logic Tích Điểm (100đ tiền hàng = 1 điểm)
            $pointsToEarn = (int) floor($order->subtotal / 100); 

            if ($pointsToEarn > 0) {
                DB::table('users')->where('id', Auth::id())->increment('points', $pointsToEarn);
            }

            // 3. Ghi log lịch sử trạng thái
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
     * Hiển thị trang đánh giá đơn hàng
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