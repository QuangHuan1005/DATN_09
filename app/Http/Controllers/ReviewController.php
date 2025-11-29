@php
public function store(Request $request, Product $product)
{
    $data = $request->validate([
        'rating'  => ['required', 'integer', 'between:1,5'],
        'content' => ['required', 'string', 'max:2000'],
    ]);

    $userId = auth()->id();

    // 1) Tìm các order_details của sản phẩm này
    //    với điều kiện:
    //    - đơn thuộc user hiện tại
    //    - đơn đã HOÀN THÀNH (order_status_id = 5)
    $completedOrderDetailsQuery = $product->orderDetails()
        ->whereHas('order', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where('order_status_id', 5);  // Hoàn thành
        });

    $hasCompletedOrder = $completedOrderDetailsQuery->exists();

    if (! $hasCompletedOrder) {
        return back()->withErrors([
            'review' => 'Chỉ đơn hàng đã hoàn thành mới được phép đánh giá sản phẩm này.',
        ])->withInput();
    }

    // Lấy ra một order_id cụ thể (đơn hoàn thành gần nhất)
    $orderId = $completedOrderDetailsQuery
        ->orderByDesc('order_id')
        ->value('order_id');

    // 2) Kiểm tra đã review sản phẩm này qua đơn hàng hoàn thành đó hay chưa
    $alreadyReviewed = $product->reviews()
        ->where('order_id', $orderId)
        ->whereHas('order', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->exists();

    if ($alreadyReviewed) {
        return back()->withErrors([
            'review' => 'Bạn đã đánh giá sản phẩm này rồi.',
        ])->withInput();
    }

    // 3) Tạo review gắn với order hoàn thành
    $product->reviews()->create([
        'order_id' => $orderId,
        'rating'   => $data['rating'],
        'content'  => $data['content'],
        'status'   => 1, // hoặc 0 nếu cần duyệt
    ]);

    return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm.');
}
