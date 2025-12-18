<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB; // <--- Cần thêm dòng này


class OrderController extends Controller
{
    // Danh sách đơn hàng của user
    public function index(Request $request)
    {
        $statusId = (int) $request->query('status_id', 0);

        // Lấy danh sách trạng thái để render filter
        $statuses = OrderStatus::orderBy('id')->get(['id','name']);

        // Đếm số đơn theo trạng thái (để hiện số trên tab)
        $counts = \App\Models\Order::query()
            ->where('user_id', Auth::id())
            ->selectRaw('order_status_id, COUNT(*) as c')
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id'); // [status_id => count]

        $orders = \App\Models\Order::query()
            ->with(['status','paymentStatus','payment.method','details']) // eager để tính SL
            ->where('user_id', Auth::id())
            ->when($statusId > 0, fn($q) => $q->where('order_status_id', $statusId))
            ->latest('created_at')                 // mới nhất lên đầu
            ->paginate(5)                          // <= chỉ 5 đơn mỗi trang
            ->withQueryString();                   // giữ ?status_id khi next page

        return view('orders.index', compact('orders','statuses','statusId','counts'));
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
       $order = Order::query()
        ->with([
            'status','paymentStatus','payment.method','invoice','voucher',
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

        // Chuẩn hóa dữ liệu hiển thị dòng SP
        $lines = $order->details->map(function ($d) {
            $v = $d->productVariant;
            $variantText = [];
            if ($v?->size?->name)  $variantText[] = "Size: {$v->size->name}";
            if ($v?->color?->name) $variantText[] = "Màu: {$v->color->name}";
            return (object)[
                'product_name' => $v?->product?->name ?? 'Sản phẩm',
                'variant_text' => $variantText ? implode(' · ', $variantText) : null,
                'image'        => $v?->image, // chuỗi path lưu trong DB (vd: shirt1-red.jpg)
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
        // Quan hệ chính xác là 'details' và 'productVariant'
    $order = Order::with('details.productVariant') 
                    ->where('id',$id)
                    ->where('user_id',Auth::id())
                    ->first();
    
    // Kiểm tra đơn hàng có tồn tại và thuộc về người dùng hiện tại không
    if (!$order) {
        return back()->with('error','Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.');
    }

    // Kiểm tra tính hợp lệ của việc hủy đơn (dùng accessor getCancelableAttribute)
    if (!$order->cancelable) {
        return back()->with('error','Đơn hàng không thể hủy ở trạng thái hiện tại.');
    }

    // BẮT ĐẦU TRANSACTION
    DB::beginTransaction();

    try {
        // Cập nhật trạng thái và lý do
        $order->order_status_id = 6; // Hủy
        
        // Logic hoàn tiền
        if ((int)$order->payment_status_id === 2) {
            $order->payment_status_id = 3; // Hoàn tiền
            // TODO: ghi nhận giao dịch hoàn về ví nếu bạn có module ví
        }
        
        // Ghi lại lý do hủy
        $order->note = trim($request->input('reason','Khách yêu cầu hủy'));
        $order->save();
        
        // ===============================================
        //  🎯 HOÀN TRẢ TỒN KHO SẢN PHẨM
        // ===============================================
        // Dùng $order->details và sử dụng collect() để tránh lỗi NULL nếu quan hệ không tải được
        foreach (collect($order->details) as $item) {
            // Sửa tên quan hệ để truy cập biến thể
            $variant = $item->productVariant; 
            
            if ($variant) {
                // Tăng số lượng tồn kho (quantity) của biến thể lên số lượng đã đặt
                // Giả định Model ProductVariant có cột 'quantity'
                $variant->increment('quantity', $item->quantity);
            }
        }
        // ===============================================

        // Ghi log trạng thái
        OrderStatusLog::create([
            'order_id'        => $order->id,
            'order_status_id' => 6,
            'actor_type'      => 'user',
        ]);
        
        DB::commit(); // Hoàn tất giao dịch

        return redirect()->route('orders.show',$order->id)->with('success','Đã hủy đơn hàng thành công và hoàn lại tồn kho.');

    } catch (\Exception $e) {
        DB::rollBack(); // Quay lại nếu có lỗi
        
        // Ghi log chi tiết lỗi để kiểm tra sau này
        \Illuminate\Support\Facades\Log::error("Cancellation Error for Order #{$id}: " . $e->getMessage()); 
        
        // TRẢ VỀ LỖI CHUNG
        return back()->with('error','Đã xảy ra lỗi hệ thống khi hủy đơn hàng. Vui lòng thử lại.');
    }
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

    public function review($id)
    {
        // 1. Lấy đơn hàng cùng các quan hệ cần thiết
        $order = Order::with([
            'details.productVariant.product:id,name',
            'details.productVariant.color:id,name',
            'details.productVariant.size:id,name'
        ])
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

        // 2. Kiểm tra trạng thái: Chỉ cho đánh giá khi đơn đã "Hoàn thành" (status_id = 5)
        if ((int)$order->order_status_id !== 5) {
            return redirect()->route('orders.show', $id)
                             ->with('error', 'Bạn chỉ có thể đánh giá khi đơn hàng đã hoàn thành.');
        }

        // 3. Xử lý gom nhóm: Nếu khách mua cùng 1 sản phẩm nhưng nhiều biến thể (màu/size)
        // hoặc mua số lượng > 1, chúng ta chỉ lấy ra các dòng đại diện cho từng Product ID.
        $uniqueDetails = $order->details->unique(function ($item) {
            return $item->productVariant->product_id;
        });

        return view('orders.review', [
            'order' => $order,
            'uniqueDetails' => $uniqueDetails
        ]);
    }
}
