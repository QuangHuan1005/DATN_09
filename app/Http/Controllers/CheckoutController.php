<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVariant;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\Voucher;
use App\Services\VNPayService;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán
     */
    public function index()
    {
        $user = Auth::user();
        $buyNow = Session::get('buy_now');
        $cart = Session::get('cart', []);

        // 1. Xác định nguồn hàng: Ưu tiên đơn hàng "Mua Ngay"
        $sourceItems = $buyNow ? [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]] : $cart;

        if (empty($sourceItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $cartItems = [];
        $totalAmount = 0;

        // 2. Lấy dữ liệu sản phẩm và tính toán tiền hàng
        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);
            
            if ($variant) {
                // Kiểm tra tồn kho thực tế
                if ($variant->quantity < $item['quantity']) {
                    Session::forget('buy_now'); 
                    return redirect()->route('cart.index')->with('error', "Sản phẩm {$variant->product->name} hiện không đủ số lượng.");
                }

                $price = $variant->sale > 0 ? $variant->sale : $variant->price;
                $qty = max(1, (int)$item['quantity']);
                $itemTotal = $price * $qty;
                
                $totalAmount += $itemTotal;
                
                $cartItems[] = [
                    'variant' => $variant,
                    'quantity' => $qty,
                    'itemTotal' => $itemTotal,
                ];
            }
        }

        /** ================= XỬ LÝ ĐỊA CHỈ ================= */
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        
        // Ưu tiên 1: Lấy ID từ session (Nếu người dùng vừa chọn ở Modal thay đổi địa chỉ)
        $selectedAddressId = session('checkout_address_id'); 

        if ($selectedAddressId) {
            $defaultAddress = $addresses->where('id', $selectedAddressId)->first();
        } 
        
        // Nếu session trống hoặc ID session không tồn tại
        if (!isset($defaultAddress) || !$defaultAddress) {
            $defaultAddress = $addresses->where('is_default', true)->first() ?: $addresses->first();
        }

        $addressCount = $addresses->count();

        /** ================= XỬ LÝ VOUCHER ĐÃ ÁP DỤNG ================= */
        $voucherData = session('applied_voucher');
        $appliedVoucher = null;
        $discountAmount = 0;

        if ($voucherData && isset($voucherData['id'])) {
            $tempVoucher = Voucher::with('products')->find($voucherData['id']);
            
            if ($tempVoucher && $tempVoucher->status == 1 && now()->between($tempVoucher->start_date, $tempVoucher->end_date)) {
                
                // Kiểm tra tính hợp lệ nếu là voucher đổi điểm
                $isValidRewardVoucher = true;
                if ($tempVoucher->points_required > 0) {
                    $isValidRewardVoucher = DB::table('user_vouchers')
                        ->where('user_id', $user->id)
                        ->where('voucher_id', $tempVoucher->id)
                        ->where('is_used', 0)
                        ->exists();
                }

                if ($isValidRewardVoucher) {
                    $eligibleAmount = 0;
                    foreach ($cartItems as $item) {
                        $isApplicable = ($tempVoucher->products->count() == 0 || $tempVoucher->products->pluck('id')->contains($item['variant']->product_id));
                        if ($isApplicable) $eligibleAmount += $item['itemTotal'];
                    }

                    if ($totalAmount >= $tempVoucher->min_order_value && $eligibleAmount > 0) {
                        $appliedVoucher = $tempVoucher;
                        
                        if ($tempVoucher->discount_type === 'percent') {
                            $rawDiscount = $eligibleAmount * ($tempVoucher->discount_value / 100);
                            $discountAmount = ($tempVoucher->sale_price > 0) ? min($rawDiscount, $tempVoucher->sale_price) : $rawDiscount;
                        } else {
                            $discountAmount = min($tempVoucher->discount_value, $eligibleAmount);
                        }
                        
                        Session::put('applied_voucher', ['id' => $tempVoucher->id, 'discount_amount' => round($discountAmount)]);
                    } else {
                        Session::forget('applied_voucher');
                    }
                } else {
                    Session::forget('applied_voucher');
                }
            } else {
                Session::forget('applied_voucher');
            }
        }

        /** ================= PHÍ VẬN CHUYỂN & TỔNG CỘNG ================= */
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        
        if ($appliedVoucher && stripos($appliedVoucher->voucher_code, 'FREESHIP') !== false) {
            $shippingFee = 0;
        }

        $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);

        /** ================= LẤY DANH SÁCH VOUCHER KHẢ DỤNG ================= */
        $vouchers = Voucher::where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereColumn('total_used', '<', 'quantity')
            ->where('min_order_value', '<=', $totalAmount) 
            ->where(function($q) use ($user) {
                $q->where(function($subQ) {
                    $subQ->where('points_required', 0)
                         ->orWhereNull('points_required');
                })
                ->orWhereIn('id', function($sub) use ($user) {
                    $sub->select('voucher_id')
                        ->from('user_vouchers')
                        ->where('user_id', $user->id)
                        ->where('is_used', 0);
                });
            })
            ->get();

        return view('checkout.index', compact(
            'cartItems', 'totalAmount', 'discountAmount', 'shippingFee', 
            'grandTotal', 'appliedVoucher', 'user', 'addresses', 
            'defaultAddress', 'vouchers', 'addressCount'
        ));
    }

    /**
     * Xử lý Mua Ngay từ trang chi tiết
     */
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
        session()->forget('applied_voucher');

        return redirect()->route('checkout.index');
    }

    /**
     * Lưu đơn hàng vào Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:1,2,3,4,5',
            'address_id' => 'required|integer|exists:user_addresses,id',
            'note' => 'nullable|string|max:500',
        ]);

        $buyNow = Session::get('buy_now');
        $cart = Session::get('cart', []);
        $sourceItems = $buyNow ? [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]] : $cart;

        if (empty($sourceItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        return DB::transaction(function () use ($sourceItems, $validated) {

            $totalAmount = 0;
            $eligibleAmountForVoucher = 0;
            $variantsToOrder = [];

            $voucherData = session('applied_voucher');
            $appliedVoucher = $voucherData ? Voucher::find($voucherData['id']) : null;

            foreach ($sourceItems as $variantId => $item) {
                $variant = ProductVariant::lockForUpdate()->find($variantId);
                if (!$variant || $variant->quantity < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$variant->product->name} không đủ tồn kho.");
                }

                $price = $variant->sale > 0 ? $variant->sale : $variant->price;
                $qty = (int)$item['quantity'];
                $lineTotal = $price * $qty;
                $totalAmount += $lineTotal;

                if ($appliedVoucher) {
                    $isApplicable = ($appliedVoucher->products->count() == 0 || $appliedVoucher->products->pluck('id')->contains($variant->product_id));
                    if ($isApplicable) $eligibleAmountForVoucher += $lineTotal;
                }

                $variantsToOrder[] = [
                    'variant' => $variant,
                    'quantity' => $qty,
                    'price' => $price
                ];
            }

            // Tính discount
            $finalDiscount = 0;
            if ($appliedVoucher) {
                if ($appliedVoucher->discount_type === 'percent') {
                    $raw = $eligibleAmountForVoucher * ($appliedVoucher->discount_value / 100);
                    $finalDiscount = ($appliedVoucher->sale_price > 0) ? min($raw, $appliedVoucher->sale_price) : $raw;
                } else {
                    $finalDiscount = min($appliedVoucher->discount_value, $eligibleAmountForVoucher);
                }
            }

            $shippingFee = $totalAmount > 300000 ? 0 : 30000;
            $grandTotal = max(0, $totalAmount + $shippingFee - $finalDiscount);

            $address = UserAddress::find($validated['address_id']);

            // 1. Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD' . time() . rand(10,99),
                'order_status_id' => 1,
                'subtotal' => $totalAmount,
                'discount' => $finalDiscount,
                'shipping_fee' => $shippingFee,
                'total_amount' => $grandTotal,
                'voucher_id' => $appliedVoucher?->id,
                'name' => $address->name,
                'address' => "{$address->address}, {$address->ward}, {$address->district}, {$address->province}",
                'phone' => $address->phone,
                'payment_method_id' => $validated['payment_method'],
                'note' => $validated['note'] ?? null,
            ]);

            // 2. Chi tiết đơn hàng & Trừ kho
            foreach ($variantsToOrder as $item) {
                $item['variant']->decrement('quantity', $item['quantity']);
                $order->details()->create([
                    'product_variant_id' => $item['variant']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // 3. Cập nhật Voucher
            if ($appliedVoucher) {
                $appliedVoucher->increment('total_used');
            }

            // 4. Xóa session
            Session::forget(['cart', 'buy_now', 'applied_voucher']);

            // 5. Xử lý redirect VNPay
            if ($validated['payment_method'] == '2') {
                $vnpayService = new VNPayService();
                $result = $vnpayService->createPayment($order->order_code, $grandTotal, "Thanh toán đơn hàng " . $order->order_code);
                if ($result['success']) {
                    return redirect($result['payment_url']);
                }
            }

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        });
    }

    /**
     * Áp dụng Voucher
     */
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string'
        ]);

        $voucher = Voucher::with('products')
            ->where('voucher_code', $request->voucher_code)
            ->where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereColumn('total_used', '<', 'quantity')
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher không hợp lệ hoặc đã hết lượt sử dụng'
            ]);
        }

        // Kiểm tra quyền sở hữu voucher đổi điểm
        if ($voucher->points_required > 0) {
            $user = Auth::user();
            $hasOwned = DB::table('user_vouchers')
                ->where('user_id', $user->id)
                ->where('voucher_id', $voucher->id)
                ->where('is_used', 0)
                ->exists();

            if (!$hasOwned) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Bạn chưa đổi điểm để nhận voucher này hoặc mã đã được sử dụng.'
                ]);
            }
        }

        $buyNow = session('buy_now');
        $cart   = session('cart', []);
        $sourceItems = $buyNow ? [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]] : $cart;

        if (empty($sourceItems)) {
            return response()->json(['success' => false, 'message' => 'Không có sản phẩm để áp dụng voucher']);
        }

        $totalAmount = 0;
        $eligibleAmount = 0;

        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) continue;

            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $qty = (int)$item['quantity'];
            $itemTotal = $price * $qty;
            $totalAmount += $itemTotal;

            $isApplicable = !$voucher->products()->exists() || $voucher->products->pluck('id')->contains($variant->product_id);
            if ($isApplicable) $eligibleAmount += $itemTotal;
        }

        if ($voucher->min_order_value > 0 && $totalAmount < $voucher->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher->min_order_value) . ' đ'
            ]);
        }

        if ($eligibleAmount <= 0) {
            return response()->json(['success' => false, 'message' => 'Voucher không áp dụng cho sản phẩm trong đơn hàng']);
        }

        if ($voucher->discount_type === 'percent') {
            $rawDiscount = $eligibleAmount * $voucher->discount_value / 100;
            $discountAmount = ($voucher->sale_price > 0) ? min($rawDiscount, $voucher->sale_price) : $rawDiscount;
        } else {
            $discountAmount = min($voucher->discount_value, $eligibleAmount);
        }

        session([
            'applied_voucher' => [
                'id' => $voucher->id,
                'discount_amount' => round($discountAmount)
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công. Đã giảm ' . number_format(round($discountAmount)) . ' đ',
            'discount_amount' => round($discountAmount)
        ]);
    }

    public function removeVoucher()
    {
        session()->forget('applied_voucher');
        return response()->json(['success' => true, 'message' => 'Đã bỏ mã giảm giá']);
    }

    public function success()
    {
        return view('checkout.success');
    }
}