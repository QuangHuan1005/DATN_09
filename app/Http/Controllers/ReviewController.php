<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Lưu đánh giá
    public function store(Request $request, $productId, $orderId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
        ]);

        // Kiểm tra xem user đã đánh giá sản phẩm này trong đơn chưa
        $exists = Review::where('user_id', Auth::id())
            ->where('order_id', $orderId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        Review::create([
            'user_id'    => Auth::id(),
            'order_id'   => $orderId,
            'product_id' => $productId,
            'rating'     => $request->rating,
            'content'    => $request['content'] ?? Null,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}
