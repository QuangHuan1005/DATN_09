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
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        // Lấy thông tin sản phẩm trong giỏ hàng
        $cartItems = [];
        $totalAmount = 0;

        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
            if ($variant) {
                $itemTotal = $variant->price * $item['quantity'];
                $totalAmount += $itemTotal;
                
                $cartItems[] = [
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'itemTotal' => $itemTotal
                ];
            }
        }

        // Lấy thông tin user hiện tại
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

        $cart = Session::get('cart', []);
        $totalAmount = 0;

        // Tính tổng tiền
        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $totalAmount += $variant->price * $item['quantity'];
            }
        }

        $orderId = 'ORDER_' . time() . '_' . Auth::id();
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

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        }
    }

    public function success()
    {
        return view('checkout.success');
    }
}
