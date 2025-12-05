<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;


class OrderController extends Controller
{
    // Danh sách đơn hàng của user
    public function index(Request $request)
    {
        $statusId = (int) $request->query('status_id', 0);

        // Lấy danh sách trạng thái để render filter
        $statuses = OrderStatus::orderBy('id')->get(['id', 'name']);

        // Đếm số đơn theo trạng thái (để hiện số trên tab)
        $counts = Order::query()
            ->where('user_id', Auth::id())
            ->selectRaw('order_status_id, COUNT(*) as c')
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id'); // [status_id => count]

        $orders = Order::query()
            ->with(['status', 'paymentStatus', 'paymentMethod', 'details']) // eager để tính SL
            ->where('user_id', Auth::id())
            ->when($statusId > 0, fn($q) => $q->where('order_status_id', $statusId))
            ->latest('created_at')                 // mới nhất lên đầu
            ->paginate(5)                          // <= chỉ 5 đơn mỗi trang
            ->withQueryString();                   // giữ ?status_id khi next page

        return view('orders.index', compact('orders', 'statuses', 'statusId', 'counts'));
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::query()
            ->with([
                'status',
                'paymentStatus',
                'payment.paymentMethod',
                'invoice',
                'voucher',
                'user:id,name,email',
                'details.productVariant.product:id,name',
                'details.productVariant.color:id,name,color_code',
                'details.productVariant.size:id,name,size_code',
                'details.productVariant.product.photoAlbums:id,product_id,image',

                'statusLogs', // <= THÊM DÒNG NÀY
            ])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Chuẩn hóa dữ liệu hiển thị dòng SP
        $lines = $order->details->map(function ($d) {
            $v = $d->productVariant;
            $image = null;

            // 1. Ưu tiên ảnh lưu ở product_variants.image
            if ($v && $v->image) {
                $image = asset('storage/' . $v->image);
            }
            // 2. Nếu biến thể không có ảnh riêng, lấy ảnh đầu tiên của album sản phẩm
            elseif ($v && $v->product && $v->product->photoAlbums->isNotEmpty()) {
                $image = asset('storage/products/' . $v->product->photoAlbums->first()->image);
            }
            // 3. (optional) fallback ảnh no-image
            // else {
            //     $image = asset('assets/images/no-image.png');
            // }

            $variantText = [];
            if ($v?->size?->name)  $variantText[] = "Size: {$v->size->size_code}";
            if ($v?->color?->name) $variantText[] = "Màu: {$v->color->name}";

            return (object)[
                'product_id'   => $v?->product?->id,
                'product_name' => $v?->product?->name ?? 'Sản phẩm',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'         => $image, // <-- dùng biến image ở trên
                'unit_price'   => (int)$d->price,
                'qty'          => (int)$d->quantity,
                'line_total'   => (int)($d->price * $d->quantity),
                'eta'          => $d->estimated_delivery,
            ];
        });



        // Tính tạm tính/tổng (nếu muốn dựa hoàn toàn DB thì dùng cột đã có)
        $calc_subtotal = $lines->sum('line_total');
        $calc_discount = (int)$order->discount;
        $calc_total    = (int)$order->total_amount;
        // Tính shipping fee: total_amount = subtotal + shipping_fee - discount
        // => shipping_fee = total_amount - subtotal + discount
        $calc_shipping_fee = max(0, $calc_total - $calc_subtotal + $calc_discount);

        return view('orders.show', [
            'order'         => $order,
            'lines'         => $lines,
            'calc_subtotal' => $calc_subtotal,
            'calc_discount' => $calc_discount,
            'calc_shipping_fee' => $calc_shipping_fee,
            'calc_total'    => $calc_total,
        ]);
    }

    // (Tuỳ chọn) Hủy đơn – thêm route POST nếu bạn muốn bật thao tác này
    public function cancel(Request $request, $id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$order) return back()->with('error', 'Không tìm thấy đơn hàng.');

        if (!$order->cancelable) {
            return back()->with('error', 'Đơn hàng không thể hủy ở trạng thái hiện tại.');
        }

        // Đổi trạng thái: Hủy (id = 6 theo seed của bạn)
        $order->order_status_id = 6; // Hủy
        // Nếu đã thanh toán (payment_status_id = 2) → chuyển sang Hoàn tiền (3)
        if ((int)$order->payment_status_id === 2) {
            $order->payment_status_id = 3; // Hoàn tiền
            // TODO: ghi nhận giao dịch hoàn về ví nếu bạn có module ví
        }
        $order->note = trim($request->input('reason', 'Khách yêu cầu hủy'));
        $order->save();
        OrderStatusLog::create([
            'order_id'        => $order->id,
            'order_status_id' => 6,          // Hủy
            'actor_type'      => 'user',     // khách tự hủy trên giao diện
        ]);


        return redirect()->route('orders.show', $order->id)->with('success', 'Đã hủy đơn hàng.');
    }

    /**
     * Người dùng xác nhận "Hoàn thành" đơn hàng.
     * Chỉ cho phép khi trạng thái hiện tại là 4 = ĐÃ GIAO HÀNG.
     */
    public function complete(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        if ((int)$order->order_status_id !== 4) {
            return back()->with('error', 'Chỉ có thể hoàn thành khi đơn đang ở trạng thái Đã giao hàng.');
        }

        $order->order_status_id = 5; // Hoàn thành
        $order->save();
        OrderStatusLog::create([
            'order_id'        => $order->id,
            'order_status_id' => 5,
            'actor_type'      => 'user', // khách nhấn nút "Hoàn thành"
        ]);


        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Đơn hàng đã chuyển sang trạng thái Hoàn thành.');
    }
}
