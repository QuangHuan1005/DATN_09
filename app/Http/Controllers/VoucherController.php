<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\ProductVariant;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string'
        ]);

        $now = Carbon::now();

        // 1. Tìm voucher hợp lệ
        $voucher = Voucher::with('products')
            ->where('voucher_code', $request->voucher_code)
            ->where('status', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->first();

        if (!$voucher) {
            return back()->with('error', 'Voucher không tồn tại hoặc đã hết hạn.');
        }

        if ($voucher->quantity <= 0) {
            return back()->with('error', 'Voucher này đã hết lượt sử dụng.');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // 2. Kiểm tra tổng giá trị đơn hàng tối thiểu
        $totalCartValue = 0;
        foreach ($cart as $item) {
            $price = ($item['sale'] > 0) ? $item['sale'] : $item['price'];
            $totalCartValue += $price * $item['quantity'];
        }

        if ($totalCartValue < $voucher->min_order_value) {
            return back()->with('error', 'Đơn tối thiểu để dùng mã là ' . number_format($voucher->min_order_value) . 'đ');
        }

        $discountAmount = 0;
        $appliedProductId = null;
        $voucherProductIds = $voucher->products->pluck('id')->toArray();

        // 3. Tính toán giảm giá chi tiết
        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::find($variantId);
            if (!$variant) continue;

            $productId = $variant->product_id;

            // Kiểm tra tính hợp lệ của sản phẩm áp dụng
            if (!empty($voucherProductIds)) {
                if (!in_array($productId, $voucherProductIds)) {
                    continue;
                }
            }

            $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
            $itemTotal = $price * $item['quantity'];

            // Logic tính tiền giảm: PERCENT vs FIXED
            if ($voucher->discount_type === 'percent') {
                $calculatedDiscount = $itemTotal * ($voucher->discount_value / 100);
                
                // Áp dụng "Giảm tối đa" nếu có cấu hình
                if ($voucher->sale_price > 0) {
                    $calculatedDiscount = min($calculatedDiscount, $voucher->sale_price);
                }
                
                // Đảm bảo không giảm quá giá trị món hàng
                $discountAmount += min($calculatedDiscount, $itemTotal);
            } else {
                // Giảm tiền cố định: Không được giảm quá giá trị món hàng
                $discountAmount += min($voucher->discount_value, $itemTotal);
            }

            $appliedProductId = $productId;
            // Nếu bạn chỉ muốn áp dụng cho 1 sản phẩm đầu tiên thỏa mãn thì giữ break
            break; 
        }

        if ($discountAmount <= 0) {
            return back()->with('error', 'Voucher không phù hợp với các sản phẩm trong giỏ hàng.');
        }

        // 4. Lưu kết quả vào Session
        session([
            'applied_voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->voucher_code,
                'discount_amount' => $discountAmount,
                'applied_product_id' => $appliedProductId
            ]
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công! Bạn được giảm ' . number_format($discountAmount) . 'đ');
    }

    public function remove()
    {
        session()->forget('applied_voucher');
        return back()->with('success', 'Đã gỡ bỏ mã giảm giá.');
    }
}