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
use App\Models\Voucher;
use App\Services\DemoPaymentService;
use App\Services\VNPayService;

class CheckoutController extends Controller
{
    public function index()
{
    /** -------------------------------------------------------------
     * 1) ƯU TIÊN "MUA NGAY"
     * ------------------------------------------------------------- */
    if ($buyNow = Session::get('buy_now')) {

        $variant = ProductVariant::with(['product', 'color', 'size'])
                    ->find($buyNow['variant_id']);

        if (!$variant) {
            Session::forget('buy_now');
            return redirect()->route('cart.index')->with('error', 'Biến thể không tồn tại.');
        }

        $qty = max(1, (int)$buyNow['quantity']);
        $price = $variant->sale > 0 ? $variant->sale : $variant->price;
        $itemTotal = $price * $qty;

        $cartItems = [[
            'variant'   => $variant,
            'quantity'  => $qty,
            'itemTotal' => $itemTotal,
        ]];

        $totalAmount = $itemTotal;

        // Voucher
        $appliedVoucherId = session('applied_voucher_id');
        $appliedVoucher = $appliedVoucherId
            ? Voucher::with('products')->find($appliedVoucherId)
            : null;

        $discountAmount = 0;

        if ($appliedVoucher) {
            $voucherProducts = $appliedVoucher->products->pluck('id')->toArray();
            $productId       = $variant->product->id;

            // Nếu voucher gắn sản phẩm → chỉ áp dụng cho sản phẩm đó
            if (empty($voucherProducts) || in_array($productId, $voucherProducts)) {

                if ($appliedVoucher->discount_type === 'percent') {
                    $discountAmount = $totalAmount * $appliedVoucher->discount_value / 100;
                } else {
                    $discountAmount = min($appliedVoucher->discount_value, $totalAmount);
                }
            }
        }

        // Shipping + grand total
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        $grandTotal = $totalAmount + $shippingFee - $discountAmount;

        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        $defaultAddress = $addresses->where('is_default', true)->first();
        $addressCount = $addresses->count();

        return view('checkout.index', compact(
            'cartItems', 'totalAmount', 'user',
            'defaultAddress', 'addresses', 'addressCount',
            'appliedVoucher', 'shippingFee', 'grandTotal',
            'discountAmount'
        ));
    }

    /** -------------------------------------------------------------
     * 2) CHECKOUT TỪ GIỎ HÀNG
     * ------------------------------------------------------------- */
    $cart = Session::get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index')
            ->with('error', 'Giỏ hàng trống');
    }

    $cartItems = [];
    $totalAmount = 0;

    foreach ($cart as $variantId => $item) {
        $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
        if ($variant) {

            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $itemTotal = $price * $item['quantity'];

            $cartItems[] = [
                'variant'  => $variant,
                'quantity' => $item['quantity'],
                'itemTotal'=> $itemTotal,
            ];

            $totalAmount += $itemTotal;
        }
    }

    // Voucher
    $appliedVoucherId = session('applied_voucher_id');
    $appliedVoucher = $appliedVoucherId
        ? Voucher::with('products')->find($appliedVoucherId)
        : null;

    $discountAmount = 0;

    if ($appliedVoucher) {

        $voucherProducts = $appliedVoucher->products->pluck('id')->toArray();

      foreach ($cartItems as $item) {
    $productId = $item['variant']->product->id;
    $itemTotal = $item['itemTotal'];

    // Nếu voucher chỉ áp dụng cho 1 số sản phẩm
    if (!empty($voucherProducts) && !in_array($productId, $voucherProducts)) {
        continue;
    }

    // Áp dụng giảm giá CHỈ CHO 1 SẢN PHẨM đầu tiên hợp lệ
    if ($appliedVoucher->discount_type === 'percent') {
        $discountAmount = $itemTotal * $appliedVoucher->discount_value / 100;
    } else {
        $discountAmount = min($appliedVoucher->discount_value, $itemTotal);
    }

    break; // ❗ Chỉ áp dụng cho 1 sản phẩm → dừng luôn
}

    }

    // Shipping + grand total
    $shippingFee = $totalAmount > 300000 ? 0 : 30000;
    $grandTotal = $totalAmount + $shippingFee - $discountAmount;

    $user = Auth::user();
    $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
    $defaultAddress = $addresses->where('is_default', true)->first();
    $addressCount = $addresses->count();

    return view('checkout.index', compact(
        'cartItems', 'totalAmount', 'user',
        'defaultAddress', 'addresses', 'addressCount',
        'appliedVoucher', 'shippingFee', 'grandTotal',
        'discountAmount'
    ));
}

  public function store(Request $request)
    {

        // Xử lý đặt hàng
        $validated = $request->validate([
            'payment_method' => 'required|in:1,2,3,4,5',
            'address_id' => 'required|integer',
            'receive_vat' => 'boolean',
            'order_vat_email' => 'nullable|email',
            'order_vat_tax_code' => 'nullable|string',
            'order_vat_company_name' => 'nullable|string',
            'order_vat_address' => 'nullable|string',
            'order_vat_note' => 'nullable|string',
        ]);

        // ⚡ Tính tổng tiền cho luồng Mua ngay hoặc Giỏ hàng
        $buyNow = Session::get('buy_now');
        $totalAmount = 0;
        $variantsToOrder = []; // Dùng để lưu các biến thể cần tạo chi tiết đơn hàng

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
            
            // Thêm vào mảng variantsToOrder
            $variantsToOrder[] = [
                'variant' => $variant,
                'quantity' => $qty,
                'price' => $price,
            ];

        } else {
            // === Luồng cũ: tính từ giỏ hàng ===
            $cart = Session::get('cart', []);
            foreach ($cart as $variantId => $item) {
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    // Ưu tiên giá sale
                    $price = ($variant->sale > 0) ? $variant->sale : $variant->price;
                    $totalAmount += $price * $item['quantity'];
                    
                    // Thêm vào mảng variantsToOrder
                    $variantsToOrder[] = [
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                        'price' => $price,
                    ];
                }
            }
        }

        // Tạo order_code với timestamp nano + random - đảm bảo unique hoàn toàn
        $next = Order::max('id') + 1;

$orderId = 'ORD' . str_pad($next, 4, '0', STR_PAD_LEFT);

        $orderInfo = 'Thanh toan don hang ' . $orderId;

        // Lấy thông tin địa chỉ giao hàng
        $address = \App\Models\UserAddress::find($validated['address_id']);
        if (!$address) {
            return redirect()->back()->with('error', 'Địa chỉ giao hàng không tồn tại');
        }

        // Tạo đơn hàng trong transaction để đảm bảo atomicity
        $order = \Illuminate\Support\Facades\DB::transaction(function () use ($orderId, $totalAmount, $address, $validated, $variantsToOrder) {
            // Tạo đơn hàng trước
            $orderData = [
                
                'user_id' => Auth::id(),
                'order_code' => $orderId,
                'order_status_id' => 1, // Chờ xác nhận
                'total_amount' => $totalAmount,
                'subtotal' => $totalAmount,
                'discount' => 0,
                'name' => $address->name,
                'address' => $address->address . ', ' . $address->ward . ', ' . $address->district . ', ' . $address->province,
                'phone' => $address->phone,
                'payment_status_id' => 1, // 1 = chưa thanh toán
                'payment_method_id' => $validated['payment_method'],

            ];

            $order = Order::create($orderData);

            // Tạo log trạng thái đơn hàng
            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'system',
            ]);

            // TẠO CHI TIẾT ĐƠN HÀNG (CHỈ MỘT LẦN VỚI GIÁ ĐÃ TÍNH TOÁN)
            foreach ($variantsToOrder as $item) {
                $order->details()->create([
                    'product_variant_id' => $item['variant']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
            // --- KẾT THÚC KHỐI TẠO CHI TIẾT ĐƠN HÀNG ---

            return $order;
        });

        // Xử lý theo phương thức thanh toán
        if ($validated['payment_method'] == '2') { // 💳 Xử lý VNPay
        try {
            $vnpayService = new VNPayService();
            $result = $vnpayService->createPayment($orderId, $totalAmount, $orderInfo);

            if ($result['success']) {
                // Đơn hàng đã được tạo với trạng thái chờ xác nhận (order_status_id = 1)
                Session::put('pending_order', [
                    'order_id' => $order->id,
                    'order_code' => $orderId,
                    'totalAmount' => $totalAmount,
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
        } catch (\Exception $e) {
            // Ghi lại lỗi và xóa đơn hàng đã tạo
            \Log::error("VNPay Payment Creation Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $order->delete();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi hệ thống khi chuyển đến cổng VNPay. Vui lòng thử lại sau.');
        }
    } 
    // KHỐI ELSEIF CHO MOMO ĐÃ BỊ XÓA BỎ
    
    else { 
        // 📦 Xử lý các phương thức thanh toán khác (COD, Thẻ tín dụng offline, v.v.)
        // Logic tạo chi tiết đơn hàng đã được thực hiện ở trên trong transaction.
        
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
