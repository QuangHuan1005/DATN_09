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
    public function index(Request $request)
    {
        $user = Auth::user();
        $buyNow = Session::get('buy_now');
        $cart = Session::get('cart', []);

        /** ================= 1. XÁC ĐỊNH NGUỒN HÀNG (LỌC THEO CHECKBOX) ================= */
        if ($buyNow) {
            // Trường hợp 1: Mua ngay (từ nút Buy Now trang chi tiết)
            $sourceItems = [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]];
        } else {
            // Trường hợp 2: Thanh toán từ giỏ hàng - Lấy danh sách ID được tick từ URL
            $selectedIds = $request->query('selected_items');

            if ($selectedIds) {
                $idArray = explode(',', $selectedIds);
                // Lọc giỏ hàng: Chỉ lấy những sản phẩm được tick
                $sourceItems = array_filter($cart, function($key) use ($idArray) {
                    return in_array((string)$key, $idArray);
                }, ARRAY_FILTER_USE_KEY);
                
                // Lưu danh sách ID đã chọn vào Session để dùng cho bước "store"
                Session::put('selected_items_for_checkout', $idArray);
            } else {
                // Nếu truy cập trực tiếp, kiểm tra session cũ hoặc lấy cả giỏ
                $idArray = Session::get('selected_items_for_checkout');
                if ($idArray) {
                    $sourceItems = array_filter($cart, function($key) use ($idArray) {
                        return in_array((string)$key, $idArray);
                    }, ARRAY_FILTER_USE_KEY);
                } else {
                    $sourceItems = $cart;
                }
            }
        }

        if (empty($sourceItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống hoặc bạn chưa chọn sản phẩm.');
        }

        $cartItems = [];
        $totalAmount = 0;

        /** ================= 2. LẤY DỮ LIỆU SẢN PHẨM VÀ TÍNH TOÁN ================= */
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
                    'image_url' => $this->normalizeImageUrl($variant->product, $variant),
                ];
            }
        }

        /** ================= 3. XỬ LÝ ĐỊA CHỈ ================= */
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->get();
        $selectedAddressId = session('checkout_address_id'); 

        if ($selectedAddressId) {
            $defaultAddress = $addresses->where('id', $selectedAddressId)->first();
        } 
        
        if (!isset($defaultAddress) || !$defaultAddress) {
            $defaultAddress = $addresses->where('is_default', true)->first() ?: $addresses->first();
        }

        $addressCount = $addresses->count();

        /** ================= 4. XỬ LÝ VOUCHER ĐÃ ÁP DỤNG ================= */
        $voucherData = session('applied_voucher');
        $appliedVoucher = null;
        $discountAmount = 0;

        if ($voucherData && isset($voucherData['id'])) {
            $tempVoucher = Voucher::with('products')->find($voucherData['id']);
            
            if ($tempVoucher && $tempVoucher->status == 1 && now()->between($tempVoucher->start_date, $tempVoucher->end_date)) {
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

        /** ================= 5. PHÍ VẬN CHUYỂN & TỔNG CỘNG ================= */
        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        
        if ($appliedVoucher && stripos($appliedVoucher->voucher_code, 'FREESHIP') !== false) {
            $shippingFee = 0;
        }

        $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);

        /** ================= 6. LẤY DANH SÁCH VOUCHER KHẢ DỤNG ================= */
        $vouchers = Voucher::where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereColumn('total_used', '<', 'quantity')
            ->where('min_order_value', '<=', $totalAmount) 
            ->where(function($q) use ($user) {
                $q->where(function($subQ) {
                    $subQ->where('points_required', 0)->orWhereNull('points_required');
                })
                ->orWhereIn('id', function($sub) use ($user) {
                    $sub->select('voucher_id')->from('user_vouchers')->where('user_id', $user->id)->where('is_used', 0);
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
     * Xử lý Mua Ngay
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
        session()->forget(['applied_voucher', 'selected_items_for_checkout']);

        return redirect()->route('checkout.index');
    }

    /**
     * Lưu đơn hàng vào Database
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'payment_method' => 'required|in:1,2,3,4,5',
        'address_id'     => 'required|integer|exists:user_addresses,id',
        'note'           => 'nullable|string|max:500',
    ]);

    $buyNow = Session::get('buy_now');
    $cart = Session::get('cart', []);
    
    // Xác định nguồn hàng
    if ($buyNow) {
        $sourceItems = [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]];
    } else {
        $selectedIds = Session::get('selected_items_for_checkout');
        $sourceItems = $selectedIds ? array_filter($cart, fn($k) => in_array((string)$k, $selectedIds), ARRAY_FILTER_USE_KEY) : $cart;
    }

    if (empty($sourceItems)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống hoặc chưa chọn sản phẩm.');
    }

    try {
        // LUU Ý: Biến $orderResult sẽ nhận giá trị trả về từ transaction
        $orderResult = DB::transaction(function () use ($sourceItems, $validated, $cart, $buyNow) {
            $totalAmount = 0;
            $eligibleAmountForVoucher = 0;
            $variantsToOrder = [];
            $voucherData = session('applied_voucher');
            $appliedVoucher = $voucherData ? Voucher::find($voucherData['id']) : null;

            foreach ($sourceItems as $variantId => $item) {
                $variant = ProductVariant::lockForUpdate()->find($variantId);
                if (!$variant || $variant->quantity < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$variant->product->name} không đủ số lượng.");
                }

                $price = $variant->sale > 0 ? $variant->sale : $variant->price;
                $qty = (int)$item['quantity'];
                $lineTotal = $price * $qty;
                $totalAmount += $lineTotal;

                if ($appliedVoucher) {
                    $isApplicable = ($appliedVoucher->products->count() == 0 || $appliedVoucher->products->pluck('id')->contains($variant->product_id));
                    if ($isApplicable) $eligibleAmountForVoucher += $lineTotal;
                }

                $variantsToOrder[] = ['variant' => $variant, 'quantity' => $qty, 'price' => $price];
            }

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

            // Tạo đơn hàng - Sửa 'payment_status' thành 'payment_status_id'
            $order = Order::create([
                'user_id'           => Auth::id(),
                'order_code'        => 'TEMP',
                'order_status_id'   => 1,
                'subtotal'          => $totalAmount,
                'discount'          => $finalDiscount,
                'shipping_fee'      => $shippingFee,
                'total_amount'      => $grandTotal,
                'voucher_id'        => $appliedVoucher?->id,
                'name'              => $address->name,
                'address'           => "{$address->address}, {$address->ward}, {$address->district}, {$address->province}",
                'phone'             => $address->phone,
                'payment_method_id' => $validated['payment_method'],
                'note'              => $validated['note'] ?? null,
                'payment_status_id' => 1, // 1: Chưa thanh toán
            ]);

            $orderCode = 'ORD' . str_pad($order->id, 7, '0', STR_PAD_LEFT);
            $order->update(['order_code' => $orderCode]);

            foreach ($variantsToOrder as $item) {
                $item['variant']->decrement('quantity', $item['quantity']);
                $order->details()->create([
                    'product_variant_id' => $item['variant']->id,
                    'quantity'           => $item['quantity'],
                    'price'              => $item['price'],
                ]);
            }

            if ($appliedVoucher) $appliedVoucher->increment('total_used');

            // Dọn dẹp giỏ hàng
            if ($buyNow) {
                Session::forget('buy_now');
            } else {
                $selectedIds = Session::get('selected_items_for_checkout');
                if ($selectedIds) {
                    foreach ($selectedIds as $id) { unset($cart[$id]); }
                    Session::put('cart', $cart);
                } else {
                    Session::forget('cart');
                }
            }
            Session::forget(['applied_voucher', 'selected_items_for_checkout']);

            // TRẢ VỀ DỮ LIỆU ĐỂ DÙNG BÊN NGOÀI TRANSACTION
            return [
                'order_code' => $orderCode,
                'grand_total' => $grandTotal,
                'payment_method' => $validated['payment_method']
            ];
        });

        // 6. XỬ LÝ ĐIỀU HƯỚNG SAU KHI TRANSACTION THÀNH CÔNG (NẰM NGOÀI CLOSURE)
        if ($orderResult['payment_method'] == '2') {
            $vnpayService = new VNPayService();
            $result = $vnpayService->createPayment(
                $orderResult['order_code'], 
                $orderResult['grand_total'], 
                "Thanh toan don hang " . $orderResult['order_code']
            );

            if ($result['success']) {
                return redirect()->away($result['payment_url']);
            }
        }

        return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}

    /**
     * Áp dụng Voucher
     */
    public function applyVoucher(Request $request)
    {
        $request->validate(['voucher_code' => 'required|string']);

        $voucher = Voucher::with('products')
            ->where('voucher_code', $request->voucher_code)
            ->where('status', 1)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->whereColumn('total_used', '<', 'quantity')
            ->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Voucher không hợp lệ hoặc hết lượt']);
        }

        if ($voucher->points_required > 0) {
            $user = Auth::user();
            $hasOwned = DB::table('user_vouchers')->where('user_id', $user->id)->where('voucher_id', $voucher->id)->where('is_used', 0)->exists();
            if (!$hasOwned) { return response()->json(['success' => false, 'message' => 'Bạn chưa đổi điểm nhận voucher này']); }
        }

        $buyNow = session('buy_now');
        $cart   = session('cart', []);
        
        if ($buyNow) {
            $sourceItems = [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]];
        } else {
            $selectedIds = Session::get('selected_items_for_checkout');
            if ($selectedIds) {
                $sourceItems = array_filter($cart, function($key) use ($selectedIds) {
                    return in_array((string)$key, $selectedIds);
                }, ARRAY_FILTER_USE_KEY);
            } else { $sourceItems = $cart; }
        }

        if (empty($sourceItems)) { return response()->json(['success' => false, 'message' => 'Không có sản phẩm để áp dụng']); }

        $totalAmount = 0; $eligibleAmount = 0;
        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) continue;
            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $qty = (int)$item['quantity'];
            $itemTotal = $price * $qty;
            $totalAmount += $itemTotal;
            if (!$voucher->products()->exists() || $voucher->products->pluck('id')->contains($variant->product_id)) { $eligibleAmount += $itemTotal; }
        }

        if ($voucher->min_order_value > 0 && $totalAmount < $voucher->min_order_value) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng tối thiểu ' . number_format($voucher->min_order_value) . ' đ']);
        }

        if ($eligibleAmount <= 0) { return response()->json(['success' => false, 'message' => 'Voucher không áp dụng cho sản phẩm này']); }

        $discountAmount = ($voucher->discount_type === 'percent') 
            ? min($eligibleAmount * $voucher->discount_value / 100, $voucher->sale_price > 0 ? $voucher->sale_price : 999999999)
            : min($voucher->discount_value, $eligibleAmount);

        session(['applied_voucher' => ['id' => $voucher->id, 'discount_amount' => round($discountAmount)]]);

        return response()->json([
            'success' => true,
            'message' => 'Giảm ' . number_format(round($discountAmount)) . ' đ',
            'discount_amount' => round($discountAmount)
        ]);
    }

    public function removeVoucher()
    {
        session()->forget('applied_voucher');
        return response()->json(['success' => true, 'message' => 'Đã bỏ mã giảm giá']);
    }

    /**
     * Chuẩn hóa URL ảnh
     */
    private function normalizeImageUrl($product, $variant = null): string
    {
        $raw = null;
        if ($variant && !empty($variant->image)) { $raw = $variant->image; } 
        elseif (!empty($product->image)) { $raw = $product->image; } 
        elseif (!empty($product->images)) {
            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            if (is_array($images)) {
                $first = $images[0] ?? null;
                $raw = is_string($first) ? $first : ($first['url'] ?? null);
            }
        }

        $raw = $raw ? ltrim($raw, '/') : '';
        if ($raw && preg_match('#^https?://#i', $raw)) { return $raw; }

        $rel = \Illuminate\Support\Str::startsWith($raw, 'storage/') ? \Illuminate\Support\Str::after($raw, 'storage/') : $raw;
        $file = basename($rel);
        $candidates = ['products/'.$file, ltrim($rel, '/'), 'product_images/'.$file];

        foreach ($candidates as $relPath) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relPath)) {
                return asset('storage/'.$relPath);
            }
        }
        foreach ($candidates as $relPath) {
            if (is_file(public_path($relPath))) { return asset($relPath); }
        }
        return asset('images/placeholder.png');
    }

    public function success()
    {
        return view('checkout.success');
    }
}