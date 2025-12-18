<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatusLog;
use App\Models\Voucher;
use App\Services\VNPayService;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function index()
    {
        $user = Auth::user();

        /** =============================================================
         * 1) ƯU TIÊN "MUA NGAY"
         * ============================================================= */
        if ($buyNow = Session::get('buy_now')) {
            $variant = ProductVariant::with(['product', 'color', 'size'])->find($buyNow['variant_id']);

            if (!$variant) {
                Session::forget('buy_now');
                return redirect()->route('cart.index')->with('error', 'Biến thể không tồn tại.');
            }

            $qty = max(1, (int) $buyNow['quantity']);
            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $itemTotal = $price * $qty;

            $cartItems = [[
                'variant' => $variant,
                'quantity' => $qty,
                'itemTotal' => $itemTotal,
            ]];

            $totalAmount = $itemTotal;

        } else {
            /** =============================================================
             * 2) Checkout từ giỏ hàng
             * ============================================================= */
            $cart = Session::get('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
            }

            $cartItems = [];
            $totalAmount = 0;

            foreach ($cart as $variantId => $item) {
                $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
                if ($variant) {
                    $price = $variant->sale > 0 ? $variant->sale : $variant->price;
                    $itemTotal = $price * $item['quantity'];
                    $totalAmount += $itemTotal;
                    $cartItems[] = [
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                        'itemTotal' => $itemTotal,
                    ];
                }
            }
        }

        /** ================= VOUCHER ================= */
        $cartProductIds = collect($cartItems)->pluck('variant.product.id')->unique()->toArray();
        $today = now();

        $vouchers = Voucher::with('products')
            ->where('status', 1)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereColumn('total_used', '<', 'quantity')
            ->get()
            ->filter(function ($voucher) use ($totalAmount, $cartProductIds) {
                if ($voucher->min_order_value > 0 && $totalAmount < $voucher->min_order_value) {
                    return false;
                }
                if ($voucher->products->count() > 0) {
                    return collect($voucher->products->pluck('id'))->intersect($cartProductIds)->isNotEmpty();
                }
                return true;
            });

        // Voucher đã áp dụng từ session
        $voucherData = session('applied_voucher');
        $appliedVoucher = null;
        $discountAmount = 0;

        if ($voucherData && isset($voucherData['id'])) {
            $tempVoucher = Voucher::with('products')->find($voucherData['id']);
            if ($tempVoucher
                && $tempVoucher->status == 1
                && now()->between($tempVoucher->start_date, $tempVoucher->end_date)
                && $tempVoucher->total_used < $tempVoucher->quantity
            ) {
                if ($tempVoucher->products->count() == 0 || collect($tempVoucher->products->pluck('id'))->intersect($cartProductIds)->isNotEmpty()) {
                    $appliedVoucher = $tempVoucher;
                    $discountAmount = $voucherData['discount_amount'] ?? 0;
                } else {
                    Session::forget('applied_voucher');
                }
            } else {
                Session::forget('applied_voucher');
            }
        }

        /** ================= SHIPPING + GRAND TOTAL ================= */
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        if ($appliedVoucher && stripos($appliedVoucher->voucher_code ?? '', 'FREESHIP') !== false) {
            $shippingFee = 0;
        }
        $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);

        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        $defaultAddress = $addresses->where('is_default', true)->first();
        $addressCount = $addresses->count();

        return view('checkout.index', compact(
            'cartItems',
            'totalAmount',
            'discountAmount',
            'shippingFee',
            'grandTotal',
            'appliedVoucher',
            'user',
            'addresses',
            'defaultAddress',
            'addressCount',
            'vouchers'
        ));
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:1,2,3,4,5',
            'address_id' => 'nullable|integer|exists:user_addresses,id',
            'note' => 'nullable|string',
        ]);

        $buyNow = Session::get('buy_now');
        $cart = Session::get('cart', []);

        if (!$buyNow && empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống, không thể đặt hàng.');
        }

        // Chuẩn bị variants và tính tổng tiền
        $variantsToOrder = [];
        $totalAmount = 0;
        $sourceItems = $buyNow ? [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]] : $cart;

        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with('product')->find($variantId);
            $qty = max(1, (int)$item['quantity']);

            if (!$variant) {
                return back()->with('error', 'Biến thể không tồn tại.');
            }

            if (isset($variant->quantity) && $qty > (int)$variant->quantity) {
                return back()->with('error', 'Sản phẩm ' . $variant->product->name . ' không đủ tồn kho.');
            }

            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $totalAmount += $price * $qty;

            $variantsToOrder[] = [
                'variant' => $variant,
                'quantity' => $qty,
                'price' => $price,
            ];
        }

        // Voucher áp dụng
        $voucherData = session('applied_voucher');
        $appliedVoucher = null;
        $discountAmount = 0;
        $voucherIdToSave = null;

        if ($voucherData && isset($voucherData['id']) && ($voucherData['discount_amount'] ?? 0) > 0) {
            $tempVoucher = Voucher::with('products')->find($voucherData['id']);
            if ($tempVoucher && $tempVoucher->status == 1
                && now()->between($tempVoucher->start_date, $tempVoucher->end_date)
                && $tempVoucher->total_used < $tempVoucher->quantity
            ) {
                $appliedVoucher = $tempVoucher;
                $voucherIdToSave = $voucherData['id'];

                foreach ($variantsToOrder as $item) {
                    $productId = $item['variant']->product->id;

                    if ($appliedVoucher->products->count() > 0
                        && !$appliedVoucher->products->pluck('id')->contains($productId)) {
                        continue;
                    }

                    if ($appliedVoucher->discount_type === 'percent') {
                        $discountAmount = $item['price'] * $item['quantity'] * $appliedVoucher->discount_value / 100;
                    } else {
                        $discountAmount = min($appliedVoucher->discount_value, $item['price'] * $item['quantity']);
                    }

                    break; // chỉ 1 sản phẩm áp dụng
                }

                if ($discountAmount <= 0) {
                    Session::forget('applied_voucher');
                    $appliedVoucher = null;
                    $voucherIdToSave = null;
                }
            } else {
                Session::forget('applied_voucher');
            }
        }

        // Tính phí vận chuyển
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        if ($appliedVoucher && stripos($appliedVoucher->voucher_code ?? '', 'FREESHIP') !== false) {
            $shippingFee = 0;
        }
        $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);

        // Lấy địa chỉ
        $user = Auth::user();
        $address = $validated['address_id'] ? UserAddress::find($validated['address_id']) : $user->addresses()->where('is_default', true)->first();
        if (!$address) $address = $user->addresses()->latest()->first();
        if (!$address) return redirect()->back()->with('error', 'Vui lòng thêm hoặc chọn địa chỉ giao hàng.');

        // Tạo order trong transaction
        $order = DB::transaction(function () use (
            $variantsToOrder, $totalAmount, $discountAmount, $shippingFee, $grandTotal,
            $address, $validated, $appliedVoucher, $voucherIdToSave
        ) {
            $next = Order::max('id') + 1;
            $orderCode = 'ORD' . str_pad($next, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => $orderCode,
                'order_status_id' => 1,
                'subtotal' => $totalAmount,
                'discount' => $discountAmount,
                'total_amount' => $grandTotal,
                'voucher_id' => $voucherIdToSave,
                'name' => $address->name,
                'address' => $address->address . ', ' . $address->ward . ', ' . $address->district . ', ' . $address->province,
                'phone' => $address->phone,
                'payment_method_id' => $validated['payment_method'],
                'note' => $validated['note'] ?? null,
            ]);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_status_id' => $order->order_status_id,
                'actor_type' => 'user',
            ]);

            foreach ($variantsToOrder as $item) {
                $item['variant']->decrement('quantity', $item['quantity']);
                $order->details()->create([
                    'product_variant_id' => $item['variant']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            if ($appliedVoucher) $appliedVoucher->increment('total_used');

            return $order;
        });

        // Xử lý thanh toán
        if ($validated['payment_method'] == '2') { // VNPay
            try {
                $vnpayService = new VNPayService();
                $result = $vnpayService->createPayment($order->order_code, $grandTotal, 'Thanh toan don hang ' . $order->order_code);

                if ($result['success']) {
                    Session::put('pending_order', ['order_id' => $order->id]);
                    return redirect($result['payment_url']);
                } else {
                    // Revert
                    $order->delete();
                    if ($appliedVoucher) $appliedVoucher->decrement('total_used');
                    foreach ($variantsToOrder as $item) $item['variant']->increment('quantity', $item['quantity']);
                    return back()->with('error', 'Không thể tạo thanh toán VNPay: ' . $result['message']);
                }
            } catch (\Exception $e) {
                Log::error("VNPay Payment Creation Error: " . $e->getMessage());
                $order->delete();
                if ($appliedVoucher) $appliedVoucher->decrement('total_used');
                foreach ($variantsToOrder as $item) $item['variant']->increment('quantity', $item['quantity']);
                return back()->with('error', 'Đã xảy ra lỗi khi chuyển đến VNPay.');
            }
        } else {
            // Gửi mail xác nhận
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new \App\Mail\OrderPlacedMail($order));
            }
        }

        // Xóa session
        Session::forget(['cart', 'buy_now', 'applied_voucher']);

        return redirect()->route('checkout.success')->with('order', $order->id);
    }

    public function success()
    {
        Session::forget('buy_now');
        return view('checkout.success');
    }

    public function refreshCsrfToken(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['csrf_token' => csrf_token()]);
        }
        return response('Invalid request', 400);
    }

    public function buyNow(Request $request)
    {
        $data = $request->validate([
            'product_variant_id' => ['required','integer','exists:product_variants,id'],
            'quantity'           => ['required','integer','min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);
        if (isset($variant->quantity) && (int)$data['quantity'] > (int)$variant->quantity) {
            return back()->with('error', 'Sản phẩm vượt quá tồn kho.');
        }

        Session::put('buy_now', [
            'variant_id' => $variant->id,
            'quantity' => (int)$data['quantity'],
        ]);

        return redirect()->route('checkout.index');
    }
}
