<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Services\MomoPaymentService;
use App\Services\DemoPaymentService;

class CheckoutController extends Controller
{
    public function index()
    {
        // ⚡ 1) Ưu tiên “Mua ngay”: nếu có session buy_now thì bỏ qua giỏ
        if ($buyNow = Session::get('buy_now')) {
            $variant = ProductVariant::with(['product', 'color', 'size'])
                        ->find($buyNow['variant_id']);

            if (!$variant) {
                Session::forget('buy_now');
                return redirect()->route('cart.index')->with('error', 'Biến thể không tồn tại.');
            }

            $qty = max(1, (int) $buyNow['quantity']);
            // Nếu bạn muốn tính theo giá sale, đổi dòng dưới thành:
            // $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $price = $variant->price;
            $itemTotal   = $price * $qty;
            $totalAmount = $itemTotal;

            $cartItems = [[
                'variant'   => $variant,
                'quantity'  => $qty,
                'itemTotal' => $itemTotal,
            ]];

            $user = Auth::user();
            return view('checkout.index', compact('cartItems', 'totalAmount', 'user'));
        }

        // 🛒 2) Luồng giỏ hàng như cũ
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cartItems   = [];
        $totalAmount = 0;

        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
            if ($variant) {
                $itemTotal    = $variant->price * $item['quantity']; // muốn ưu tiên sale thì đổi giống trên
                $totalAmount += $itemTotal;
                $cartItems[]  = [
                    'variant'  => $variant,
                    'quantity' => $item['quantity'],
                    'itemTotal'=> $itemTotal,
                ];
            }
        }

        $user = Auth::user();
        return view('checkout.index', compact('cartItems', 'totalAmount', 'user'));
    }

    public function store(Request $request)
    {
        // Xử lý đặt hàng
        $validated = $request->validate([
            'shipping_method' => 'required|in:1,2,3',
            'payment_method' => 'required|in:1,2,3,4,5',
            'address_id' => 'required|integer',
            'receive_vat' => 'boolean',
            'order_vat_email' => 'nullable|email',
            'order_vat_tax_code' => 'nullable|string',
            'order_vat_company_name' => 'nullable|string',
            'order_vat_address' => 'nullable|string',
            'order_vat_note' => 'nullable|string',
        ]);

        // ⚡ Ưu tiên mua ngay
    $buyNow = Session::get('buy_now');
    $totalAmount = 0;

    if ($buyNow) {
        $variant = ProductVariant::with('product')->find($buyNow['variant_id']);
        if (!$variant) {
            return back()->with('error', 'Biến thể không tồn tại.');
        }

        $qty = max(1, (int) $buyNow['quantity']);

        // Kiểm tra tồn kho (nếu có cột quantity)
        if (isset($variant->quantity) && $qty > (int) $variant->quantity) {
            return back()->with('error', 'Sản phẩm không đủ tồn kho.');
        }

        $totalAmount = $variant->price * $qty; // giữ nguyên logic giá như bạn đang dùng

    } else {
        // === Luồng cũ: tính từ giỏ hàng ===
        $cart = Session::get('cart', []);
        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $totalAmount += $variant->price * $item['quantity'];
            }
        }
    }

    $orderId   = 'ORDER_' . time() . '_' . Auth::id();
    $orderInfo = 'Thanh toan don hang ' . $orderId;

        // Xử lý theo phương thức thanh toán
        if ($validated['payment_method'] == '2') { // ATM
            // Lưu thông tin đơn hàng tạm thời
            Session::put('pending_order', [
                'orderId' => $orderId,
                'totalAmount' => $totalAmount,
                'orderInfo' => $orderInfo,
                'payment_method' => 'atm'
            ]);

            // Chuyển đến trang thanh toán ATM
            return redirect()->route('payment.atm', ['order_id' => $orderId]);
        } elseif ($validated['payment_method'] == '5') { // Momo
            // Kiểm tra xem có phải demo mode không
            $isDemo = config('momo.environment') === 'demo' || !config('momo.partner_code') || config('momo.partner_code') === 'MOMO_PARTNER_CODE';

            if ($isDemo) {
                // Sử dụng demo service
                $demoService = new DemoPaymentService();
                $result = $demoService->createPayment($orderId, $totalAmount, $orderInfo);
            } else {
                // Sử dụng Momo service thật
                $momoService = new MomoPaymentService();
                $result = $momoService->createPayment($orderId, $totalAmount, $orderInfo);
            }

            if ($result['success']) {
                // Lưu thông tin đơn hàng tạm thời
                Session::put('pending_order', [
                    'orderId' => $orderId,
                    'totalAmount' => $totalAmount,
                    'orderInfo' => $orderInfo,
                    'payment_method' => 'momo',
                    'momo_data' => $result,
                    'isDemo' => $isDemo
                ]);

                // Chuyển đến trang QR code
                return redirect()->route('payment.momo.qr', [
                    'order_id' => $result['orderId'],
                    'qr_code_url' => $result['qrCodeUrl'],
                    'pay_url' => $result['payUrl']
                ]);
            } else {
                return redirect()->back()->with('error', 'Không thể tạo thanh toán Momo: ' . $result['message']);
            }
        } else {
            // Các phương thức thanh toán khác (COD, thẻ tín dụng, etc.)
            // TODO: Tạo đơn hàng trong database
            // TODO: Xử lý thanh toán
            // TODO: Gửi email xác nhận

            // Xóa giỏ hàng sau khi đặt hàng thành công
            Session::forget('cart');
            Session::forget('buy_now');
            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        }
    }

    public function success()
    {
        Session::forget('buy_now');
        return view('checkout.success');
    }

    public function buyNow(Request $request)
    {
        // Form chi tiết sản phẩm gửi lên 2 field: product_variant_id & quantity
        $data = $request->validate([
            'product_variant_id' => ['required','integer','exists:product_variants,id'],
            'quantity'           => ['required','integer','min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        // Kiểm tra tồn kho nếu có cột quantity
        if (isset($variant->quantity) && (int)$data['quantity'] > (int)$variant->quantity) {
            return back()->with('error', 'Sản phẩm vượt quá tồn kho.');
        }

        // Lưu đơn tạm "mua ngay" (KHÔNG đụng tới giỏ hàng)
        Session::put('buy_now', [
            'variant_id' => $variant->id,
            'quantity'   => (int) $data['quantity'],
        ]);

        return redirect()->route('checkout.index');
    }

}
