<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatusLog;
use App\Services\VNPayService;

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
            // Ưu tiên giá sale
            $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
            $itemTotal   = $price * $qty;
            $totalAmount = $itemTotal;

            $cartItems = [[
                'variant'   => $variant,
                'quantity'  => $qty,
                'itemTotal' => $itemTotal,
            ]];

            $user = Auth::user();
            $defaultAddress = $user->addresses()->where('is_default', true)->first();
            $addresses = $user->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
            $addressCount = $addresses->count();
            $appliedVoucher = Session::get('applied_voucher');

            $shippingFee = $totalAmount > 300000 ? 0 : 30000; // Miễn phí vận chuyển cho đơn > 300k
            $discountAmount = $appliedVoucher ? ($appliedVoucher->discount_type === 'percent' ?
                $totalAmount * $appliedVoucher->discount_value / 100 :
                $appliedVoucher->discount_value) : 0;
            $grandTotal = $totalAmount + $shippingFee - $discountAmount;

            return view('checkout.index', compact('cartItems', 'totalAmount', 'user', 'defaultAddress', 'addresses', 'addressCount', 'appliedVoucher', 'shippingFee', 'grandTotal', 'discountAmount'));
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
                // Ưu tiên giá sale
                $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
                $itemTotal    = $price * $item['quantity'];
                $totalAmount += $itemTotal;
                $cartItems[]  = [
                    'variant'  => $variant,
                    'quantity' => $item['quantity'],
                    'itemTotal' => $itemTotal,
                ];
            }
        }

        $user = Auth::user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        $addressCount = $addresses->count();
        $appliedVoucher = Session::get('applied_voucher');

        $shippingFee = $totalAmount > 300000 ? 0 : 30000; // Miễn phí vận chuyển cho đơn > 300k
        $discountAmount = $appliedVoucher ? ($appliedVoucher->discount_type === 'percent' ?
            $totalAmount * $appliedVoucher->discount_value / 100 :
            $appliedVoucher->discount_value) : 0;
        $grandTotal = $totalAmount + $shippingFee - $discountAmount;

        return view('checkout.index', compact('cartItems', 'totalAmount', 'user', 'defaultAddress', 'addresses', 'addressCount', 'appliedVoucher', 'shippingFee', 'grandTotal', 'discountAmount'));
    }

    public function store(Request $request)
    {
        // Xử lý đặt hàng
        $validated = $request->validate([
            'payment_method' => 'required|in:1,2',
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

            // Ưu tiên giá sale
            $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
            $totalAmount = $price * $qty;
        } else {
            // === Luồng cũ: tính từ giỏ hàng ===
            $cart = Session::get('cart', []);
            foreach ($cart as $variantId => $item) {
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    // Ưu tiên giá sale
                    $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
                    $totalAmount += $price * $item['quantity'];
                }
            }
        }

        // Tính phí ship: Miễn phí cho đơn > 300k, 30k cho đơn <= 300k
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        $subtotal = $totalAmount; // Tổng tiền sản phẩm
        $grandTotal = $subtotal + $shippingFee; // Tổng tiền cuối cùng (bao gồm ship)

        // Tạo order_code với timestamp nano + random - đảm bảo unique hoàn toàn
        $nanoTime = hrtime(true); // High resolution timestamp
        $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true) . microtime(true)), 0, 6));
        $orderId = 'ORD_' . $nanoTime . '_' . $randomPart . '_' . Auth::id();
        $orderInfo = 'Thanh toan don hang ' . $orderId;

        // Lấy thông tin địa chỉ giao hàng
        $address = \App\Models\UserAddress::find($validated['address_id']);
        if (!$address) {
            return redirect()->back()->with('error', 'Địa chỉ giao hàng không tồn tại');
        }

        // Tạo đơn hàng trong transaction để đảm bảo atomicity
        $order = \Illuminate\Support\Facades\DB::transaction(function () use ($orderId, $subtotal, $grandTotal, $shippingFee, $address, $validated, $buyNow) {
            // Tạo đơn hàng trước
            $orderData = [
                'user_id' => Auth::id(),
                'payment_status_id' => 1, // Chưa thanh toán
                'order_code' => $orderId,
                'order_status_id' => 1, // Chờ xác nhận
                'total_amount' => $grandTotal, // Tổng cuối cùng (bao gồm ship)
                'subtotal' => $subtotal, // Tổng tiền sản phẩm
                'shipping_fee' => $shippingFee, // Phí ship
                'discount' => 0,
                'name' => $address->name,
                'address' => $address->address . ', ' . $address->ward . ', ' . $address->district . ', ' . $address->province,
                'phone' => $address->phone,
            ];

            $order = Order::create($orderData);

            // Tạo log trạng thái đơn hàng
            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'system',
            ]);

            // Tạo chi tiết đơn hàng
            if ($buyNow) {
                $variant = ProductVariant::with('product')->find($buyNow['variant_id']);
                $qty = max(1, (int) $buyNow['quantity']);

                // Ưu tiên giá sale
                $price = ($variant->sale > 0) ? $variant->sale : $variant->price;

                $order->details()->create([
                    'product_variant_id' => $variant->id,
                    'quantity' => $qty,
                    'price' => $price,
                ]);
            } else {
                $cart = Session::get('cart', []);
                foreach ($cart as $variantId => $item) {
                    $variant = ProductVariant::with('product')->find($variantId);
                    if ($variant) {
                        // Ưu tiên giá sale
                        $price = ($variant->sale > 0) ? $variant->sale : $variant->price;

                        $order->details()->create([
                            'product_variant_id' => $variant->id,
                            'quantity' => $item['quantity'],
                            'price' => $price,
                        ]);
                    }
                }
            }

            return $order;
        });

        // Tạo payment record cho mọi đơn hàng
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => $validated['payment_method'],
            'payment_code' => ($validated['payment_method'] == 1 ? 'COD_' : 'PAY_') . $orderId,
            'payment_amount' => $grandTotal, // Tổng tiền bao gồm ship
            'status' => ($validated['payment_method'] == 1 ? 0 : 0), // COD: Pending (0), Online: Pending (0)
        ]);

        // Xử lý theo phương thức thanh toán
        if ($validated['payment_method'] == '2') { // VNPay
            // Tạo thanh toán VNPay với tổng tiền bao gồm ship
            $vnpayService = new VNPayService();
            $result = $vnpayService->createPayment($orderId, $grandTotal, $orderInfo);

            if ($result['success']) {
                // Đơn hàng đã được tạo với trạng thái chờ xác nhận (order_status_id = 1)

                // Lưu thông tin đơn hàng tạm thời
                Session::put('pending_order', [
                    'order_id' => $order->id,
                    'order_code' => $orderId,
                    'totalAmount' => $grandTotal, // Tổng tiền bao gồm ship
                    'orderInfo' => $orderInfo,
                    'payment_method' => 'vnpay',
                    'vnpay_data' => $result
                ]);

                // Chuyển hướng đến VNPay
                return redirect($result['payment_url']);
            } else {
                // Xóa đơn hàng nếu tạo thanh toán thất bại
                $order->delete();
                return redirect()->back()->with('error', 'Không thể tạo thanh toán VNPay: ' . $result['message']);
            }
        } elseif ($validated['payment_method'] == '1') { // COD
            // Xóa giỏ hàng sau khi đặt hàng thành công
            Session::forget('cart');
            Session::forget('buy_now');

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } else {
            // Các phương thức thanh toán khác (thẻ tín dụng, etc.)

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

    public function refreshCsrfToken(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'csrf_token' => csrf_token()
            ]);
        }

        return response('Invalid request', 400);
    }

    public function buyNow(Request $request)
    {
        // Form chi tiết sản phẩm gửi lên 2 field: product_variant_id & quantity
        $data = $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        // Kiểm tra tồn kho nếu có cột quantity
        if (isset($variant->quantity) && (int)$data['quantity'] > (int)$variant->quantity) {
            return back()->with('error', 'Sản phẩm vượt quá tồn kho.');
        }

        // XÓA session buy_now cũ trước khi tạo mới (tránh cộng dồn)
        Session::forget('buy_now');

        // Lưu đơn tạm "mua ngay" (KHÔNG đụng tới giỏ hàng)
        Session::put('buy_now', [
            'variant_id' => $variant->id,
            'quantity'   => (int) $data['quantity'],
        ]);

        return redirect()->route('checkout.index');
    }
}
