<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\ProductVariant;

class VoucherController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required'
        ]);

        $voucher = Voucher::with('products')
            ->where('voucher_code', $request->voucher_code)
            ->where('status', 1)
            ->first();

        if (!$voucher) {
            return back()->with('error', 'Voucher không tồn tại');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống');
        }

        $discountAmount = 0;
        $appliedProductId = null;

        foreach ($cart as $variantId => $item) {

            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) continue;

            $productId = $variant->product_id;

            // ❌ Voucher áp riêng sản phẩm → bắt buộc khớp
            if ($voucher->products()->exists()) {
                if (!$voucher->products->pluck('id')->contains($productId)) {
                    continue;
                }
            }

            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $itemTotal = $price * $item['quantity'];

            $discountAmount = $voucher->discount_type === 'percent'
                ? $itemTotal * $voucher->discount_value / 100
                : min($voucher->discount_value, $itemTotal);

            // ⭐ CHÌA KHÓA
            $appliedProductId = $productId;
            break;
        }

        if ($discountAmount <= 0) {
            return back()->with('error', 'Voucher không áp dụng cho sản phẩm nào');
        }

        session([
            'applied_voucher' => [
                'id' => $voucher->id,
                'discount_amount' => $discountAmount,
                'applied_product_id' => $appliedProductId
            ]
        ]);

        return back()->with('success', 'Áp dụng voucher thành công');
    }
}
