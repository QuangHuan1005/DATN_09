<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Hiển thị trang tạo đánh giá
     */
    public function create(Request $request)
    {
        // 1. Lấy thông tin từ URL query string
        $orderId   = $request->input('order_id');
        $productId = $request->input('product_id');
        $variantId = $request->input('product_variant_id'); // Lấy thêm variant_id

        // 2. Xác thực cơ bản đầu vào
        if (!$orderId || !$productId || !$variantId) {
            return back()->with('error', 'Thiếu thông tin cần thiết để thực hiện đánh giá.');
        }

        // 3. Xác thực quyền sở hữu đơn hàng và trạng thái
        $order = Order::where('id', $orderId)
                      ->where('user_id', Auth::id())
                      ->first();

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng hoặc bạn không có quyền đánh giá.');
        }

        if ($order->order_status_id != 5) {
            return redirect()->route('orders.show', $orderId)
                             ->with('error', 'Bạn chỉ có thể đánh giá những đơn hàng đã hoàn thành.');
        }

        // 4. Lấy thông tin chi tiết Sản phẩm và Biến thể để hiển thị lên View
        // Điều này giúp fix lỗi "Undefined variable $product"
        $product = Product::find($productId);
        $productVariant = ProductVariant::with(['color', 'size'])->find($variantId);

        if (!$product || !$productVariant) {
            return back()->with('error', 'Dữ liệu sản phẩm không hợp lệ.');
        }

        // 5. Kiểm tra xem biến thể này trong đơn hàng này đã được đánh giá chưa
        $exists = Review::where('order_id', $orderId)
                        ->where('product_variant_id', $variantId)
                        ->exists();

        if ($exists) {
            return redirect()->route('orders.show', $orderId)
                             ->with('error', 'Bạn đã gửi đánh giá cho sản phẩm này rồi.');
        }

        // 6. Trả về view với đầy đủ các biến cần thiết
        return view('reviews.create', [
            'order'          => $order,
            'product'        => $product,
            'productVariant' => $productVariant,
            'orderId'        => $orderId,
            'productId'      => $productId,
        ]);
    }

    /**
     * Lưu dữ liệu đánh giá vào Database
     */
    public function store(Request $request)
    {
        // 1. Xác thực dữ liệu form
        $request->validate([
            'order_id'           => 'required|integer',
            'product_id'         => 'required|integer',
            'product_variant_id' => 'required|integer',
            'rating'             => 'required|integer|min:1|max:5',
            'content'            => 'nullable|string|max:1000',
        ]);

        $orderId   = $request->order_id;
        $productId = $request->product_id;
        $variantId = $request->product_variant_id;
        $userId    = Auth::id();

        // 2. Kiểm tra lại quyền sở hữu đơn hàng một lần nữa trước khi lưu
        $order = Order::where('id', $orderId)
                      ->where('user_id', $userId)
                      ->where('order_status_id', 5)
                      ->first();

        if (!$order) {
            return back()->with('error', 'Hành động không hợp lệ.');
        }

        // 3. Kiểm tra trùng lặp (Mỗi biến thể trong 1 đơn hàng chỉ đánh giá 1 lần)
        $exists = Review::where('order_id', $orderId)
                        ->where('product_variant_id', $variantId)
                        ->exists();

        if ($exists) {
            return redirect()->route('orders.show', $orderId)
                             ->with('error', 'Sản phẩm này đã được bạn đánh giá trước đó.');
        }

        // 4. Tiến hành tạo đánh giá
        Review::create([
            'order_id'           => $orderId,
            'product_id'         => $productId,
            'product_variant_id' => $variantId, // Lưu thêm variant_id để tách biệt đánh giá
            'rating'             => $request->rating,
            'content'            => $request->content,
            'status'             => 1, // Mặc định là hiển thị ngay
        ]);

        // 5. Thành công và quay lại trang chi tiết đơn hàng
        return redirect()->route('orders.show', $orderId)
                         ->with('success', 'Cảm ơn bạn! Đánh giá của bạn đã được ghi lại.');
    }
}