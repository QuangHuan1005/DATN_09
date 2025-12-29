<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Lưu đánh giá
    public function store(Request $request)
{
    // 1. Xác thực dữ liệu
    $request->validate([
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'nullable|string|max:1000',
    ]);

    $orderId = $request->order_id;
    $productId = $request->product_id;
    $currentUserId = Auth::id(); // Lấy ID người dùng hiện tại

    // 2. Tải và xác thực Đơn hàng (QUAN TRỌNG: Kiểm tra quyền sở hữu)
    $order = Order::where('id', $orderId)
                  ->where('user_id', $currentUserId) // Kiểm tra xem đơn hàng có thuộc về user hiện tại không
                  ->where('order_status_id', 5)     // Giả sử 5 là trạng thái Đã hoàn thành
                  ->first();

    if (!$order) {
        return back()->with('error', 'Đơn hàng không hợp lệ, không thuộc sở hữu của bạn, hoặc chưa đủ điều kiện để đánh giá.');
    }

    // 3. Kiểm tra xem Đơn hàng này đã có đánh giá cho Sản phẩm này chưa.
    // LƯU Ý: VÌ BẠN KHÔNG CÓ CỘT user_id, CHÚNG TA CHỈ KIỂM TRA order_id VÀ product_id.
    // Điều này ngụ ý: MỘT SẢN PHẨM CHỈ CÓ THỂ ĐƯỢC ĐÁNH GIÁ MỘT LẦN TRONG MỘT ĐƠN HÀNG.
    $exists = Review::where('order_id', $orderId) 
        ->where('product_id', $productId)
        ->exists();

    if ($exists) {
        return redirect()->route('orders.show', $orderId)
                         ->with('error', 'Sản phẩm này đã được đánh giá trong đơn hàng này rồi.');
    }

    // 4. Tạo đánh giá (BỎ QUA user_id vì bảng không có)
    Review::create([
        'order_id'   => $orderId,
        'product_id' => $productId,
        'rating'     => $request->rating,
        'content'    => $request->content,
        'status'     => 1,
    ]);

    // 5. Chuyển hướng
    return redirect()->route('orders.show', $orderId)
                     ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');}
    public function create(Request $request)
    {
        // 1. Lấy thông tin từ query string (ví dụ: /reviews/create?order_id=123&product_id=456)
        $orderId = $request->input('order_id');
        $productId = $request->input('product_id');

        // 2. Xác thực cơ bản
        if (!$orderId || !$productId) {
            return back()->with('error', 'Thiếu thông tin đơn hàng hoặc sản phẩm để đánh giá.');
        }

        // 3. (Quan trọng) Xác thực quyền truy cập
        // Lấy đơn hàng và kiểm tra quyền sở hữu/trạng thái hoàn thành
        $order = Order::where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.');
        }

        // Tùy chọn: Kiểm tra xem đơn hàng đã hoàn thành chưa (order_status_id == 5)
        if ($order->order_status_id != 5) {
            return redirect()->route('orders.show', $orderId)
                             ->with('error', 'Chỉ có thể đánh giá đơn hàng đã hoàn thành.');
        }
        
        // Tùy chọn: Lấy thông tin sản phẩm (đảm bảo nó là sản phẩm trong đơn)
        // Đây là bước phức tạp hơn, tạm thời bỏ qua nếu bạn chỉ cần hiển thị ID

        // 4. Hiển thị View
        // Đảm bảo bạn có file resources/views/reviews/create.blade.php
        return view('reviews.create', [
            'orderId' => $orderId,
            'productId' => $productId,
            'order' => $order,
        ]);
    }
}
