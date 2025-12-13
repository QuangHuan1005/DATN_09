<?php

// app/Http/Controllers/OrderReturnController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderReturnController extends Controller
{
    // Hiển thị form tạo yêu cầu hoàn hàng
    public function create(Order $order)
    {
        // Kiểm tra quyền truy cập - chỉ chủ đơn mới được tạo return request
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này');
        }

        // Kiểm tra trạng thái đơn - chỉ cho phép với đơn đã giao hoặc hoàn thành
        if (!in_array($order->order_status_id, [4, 5])) {
            abort(403, 'Đơn hàng không ở trạng thái cho phép hoàn hàng');
        }

        // Kiểm tra xem đã có return request chưa
        $existingReturn = OrderReturn::where('order_id', $order->id)->first();
        if ($existingReturn) {
            return redirect()->route('orders.return.show', $existingReturn)
                           ->with('error', 'Bạn đã gửi yêu cầu hoàn hàng cho đơn này rồi');
        }

        // Load quan hệ cần thiết
        $order->load([
            'details.product',
            'details.productVariant',
            'status',
            'paymentStatus'
        ]);

        // Lấy danh sách tài khoản ngân hàng của user
        $userBankAccounts = UserBankAccount::where('user_id', Auth::id())
                                          ->orderBy('is_default', 'desc')
                                          ->orderBy('created_at', 'desc')
                                          ->get();

        return view('orders.return.create', compact('order', 'userBankAccounts'));
    }

    // Lưu yêu cầu hoàn hàng
    public function store(Request $request, Order $order)
    {
        // Basic validation (minimal since we use frontend validation)
        $request->validate([
            'reason' => 'string|max:1000',
            'description' => 'nullable|string|max:2000',
            'refund_account_id' => 'exists:user_bank_accounts,id',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Kiểm tra quyền truy cập
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này');
        }

        // Kiểm tra trạng thái đơn
        if (!in_array($order->order_status_id, [4, 5])) {
            abort(403, 'Đơn hàng không ở trạng thái cho phép hoàn hàng');
        }

        // Kiểm tra xem đã có return request chưa
        if (OrderReturn::where('order_id', $order->id)->exists()) {
            return back()->with('error', 'Bạn đã gửi yêu cầu hoàn hàng cho đơn này rồi');
        }

        // Xử lý upload hình ảnh
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/returns'), $imageName);
                $imagePaths[] = 'uploads/returns/' . $imageName;
            }
        }

        // Xử lý product_ids (sản phẩm được chọn để hoàn)
        $productDetails = [];
        $refundAmount = 0;
        
        if ($request->has('product_ids') && is_array($request->product_ids)) {
            // Đơn có nhiều sản phẩm và user đã chọn
            // Format: {detail_id}_{item_number} hoặc {detail_id}
            $selectedProductIds = $request->product_ids;
            
            // ✅ Đếm số lượng mỗi detail_id được chọn
            $detailQuantities = [];
            foreach ($selectedProductIds as $productId) {
                // Parse format: "123_1" hoặc "123"
                $parts = explode('_', $productId);
                $detailId = (int)$parts[0];
                
                if (!isset($detailQuantities[$detailId])) {
                    $detailQuantities[$detailId] = 0;
                }
                $detailQuantities[$detailId]++;
            }
            
            // ✅ Lấy thông tin chi tiết và tính tổng tiền hoàn
            foreach ($detailQuantities as $detailId => $quantity) {
                $detail = $order->details()->find($detailId);
                if ($detail) {
                    $productDetails[] = [
                        'order_detail_id' => $detail->id,
                        'product_id' => $detail->product_id,
                        'product_variant_id' => $detail->product_variant_id,
                        'quantity' => $quantity, // ✅ Số lượng được chọn
                        'price' => $detail->price,
                        'total' => $detail->price * $quantity
                    ];
                    $refundAmount += $detail->price * $quantity;
                }
            }
        } else {
            // Đơn 1 sản phẩm hoặc không có checkbox: hoàn toàn bộ
            foreach ($order->details as $detail) {
                $productDetails[] = [
                    'order_detail_id' => $detail->id,
                    'product_id' => $detail->product_id,
                    'product_variant_id' => $detail->product_variant_id,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total' => $detail->price * $detail->quantity
                ];
                $refundAmount += $detail->price * $detail->quantity;
            }
        }

        // Tạo return request
        $return = OrderReturn::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'refund_account_id' => $request->refund_account_id,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'images' => json_encode($imagePaths),
            'product_details' => json_encode($productDetails),
            'status' => 'pending', // trạng thái mặc định
            'refund_amount' => $refundAmount,
            'return_date' => now()
        ]);

        // Cập nhật trạng thái đơn hàng thành "Hoàn hàng" (ID = 7)
        $order->update([
            'order_status_id' => 7
        ]);

        // Cập nhật trạng thái thanh toán thành "Hoàn tiền" (ID = 3)
        $order->update([
            'payment_status_id' => 3
        ]);

        return redirect()->route('orders.show', $order->id)
                       ->with('success', 'Đã gửi yêu cầu hoàn tiền thành công, vui lòng chờ hệ thống xác nhận.');
    }

    // Hiển thị chi tiết return request
    public function show(OrderReturn $return)
    {
        // Kiểm tra quyền truy cập
        if ($return->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập yêu cầu hoàn hàng này');
        }

        // Load quan hệ
        $return->load([
            'order.details.product',
            'order.details.productVariant',
            'order.status',
            'order.paymentStatus',
            'refundAccount'
        ]);

        return view('orders.return.show', compact('return'));
    }
}

