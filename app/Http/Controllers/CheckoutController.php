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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail; // Nhớ import
use App\Mail\OrderConfirmationMail;  // Nhớ import

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

        /** ================= 1. XÁC ĐỊNH NGUỒN HÀNG ================= */
        if ($buyNow) {
            $sourceItems = [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]];
        } else {
            $selectedIds = $request->query('selected_items');

            if ($selectedIds) {
                $idArray = array_map('strval', explode(',', $selectedIds));
                $sourceItems = array_filter($cart, function ($key) use ($idArray) {
                    return in_array((string)$key, $idArray);
                }, ARRAY_FILTER_USE_KEY);

                Session::put('selected_items_for_checkout', $idArray);
            } else {
                $idArray = Session::get('selected_items_for_checkout');
                if ($idArray) {
                    $idArray = array_map('strval', $idArray);
                    $sourceItems = array_filter($cart, function ($key) use ($idArray) {
                        return in_array((string)$key, $idArray);
                    }, ARRAY_FILTER_USE_KEY);
                } else {
                    $sourceItems = $cart;
                }
            }
        }

        if (empty($sourceItems)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống hoặc chưa chọn sản phẩm.');
        }

        /** ================= 2. XỬ LÝ DỮ LIỆU SẢN PHẨM & TÍNH TOÁN ================= */
        $cartItems = [];
        $totalAmount = 0;

        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with(['product', 'color', 'size'])->find($variantId);

            if ($variant) {
                if ($variant->quantity < $item['quantity']) {
                    return redirect()->route('cart.index')->with('error', "Sản phẩm {$variant->product->name} không đủ số lượng.");
                }

                $price = (float)($variant->sale > 0 ? $variant->sale : $variant->price);
                $qty = (int)$item['quantity'];
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
        $defaultAddress = $selectedAddressId ? $addresses->where('id', $selectedAddressId)->first() : null;

        if (!$defaultAddress) {
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
                $eligibleAmount = 0;
                foreach ($cartItems as $item) {
                    $isApplicable = ($tempVoucher->products->count() == 0 || $tempVoucher->products->pluck('id')->contains($item['variant']->product_id));
                    if ($isApplicable) $eligibleAmount += $item['itemTotal'];
                }

                if ($totalAmount >= $tempVoucher->min_order_value && $eligibleAmount > 0) {
                    $appliedVoucher = $tempVoucher;
                    if ($tempVoucher->discount_type === 'percent') {
                        $raw = $eligibleAmount * ($tempVoucher->discount_value / 100);
                        $discountAmount = ($tempVoucher->sale_price > 0) ? min($raw, $tempVoucher->sale_price) : $raw;
                    } else {
                        $discountAmount = min($tempVoucher->discount_value, $eligibleAmount);
                    }
                    session(['applied_voucher' => ['id' => $tempVoucher->id, 'discount_amount' => round($discountAmount)]]);
                } else {
                    Session::forget('applied_voucher');
                }
            }
        }

        $shippingFee = $totalAmount > 300000 ? 0 : 30000;
        if ($appliedVoucher && stripos($appliedVoucher->voucher_code, 'FREESHIP') !== false) {
            $shippingFee = 0;
        }
        $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);

        $vouchers = Voucher::where('status', 1)
            ->where('start_date', '<=', now())->where('end_date', '>=', now())
            ->whereColumn('total_used', '<', 'quantity')
            ->where('min_order_value', '<=', $totalAmount)
            ->get();

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
            'vouchers',
            'addressCount'
        ));
    }

    /**
     * Xử lý Mua Ngay
     */
    public function buyNow(Request $request)
    {
        $data = $request->validate([
            'product_variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'quantity'           => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::findOrFail($data['product_variant_id']);
        if ($variant->quantity < $data['quantity']) {
            return back()->with('error', 'Sản phẩm vượt quá tồn kho.');
        }

        Session::put('buy_now', ['variant_id' => $variant->id, 'quantity' => (int)$data['quantity']]);
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
            $orderResult = DB::transaction(function () use ($sourceItems, $validated, $cart, $buyNow, $request) {
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
                    'note'              => $request->input('note'), // Dùng input('note') để an toàn nếu key ko tồn tại
                    'payment_status_id' => 1,
                ]);

                $orderCode = 'ORD' . $order->id;
                $order->update(['order_code' => $orderCode]);

                foreach ($variantsToOrder as $item) {
                    $item['variant']->decrement('quantity', $item['quantity']);
                    $order->details()->create([
                        'product_variant_id' => $item['variant']->id,
                        'quantity'           => $item['quantity'],
                        'price'              => $item['price'],
                    ]);
                }
                if ($validated['payment_method'] != 2) {
                    $userEmail = Auth::user()->email;
                    if ($userEmail) {
                        Mail::to($userEmail)->send(new OrderConfirmationMail($order));
                    }
                }

                if ($appliedVoucher) $appliedVoucher->increment('total_used');

                if ($buyNow) {
                    Session::forget('buy_now');
                } else {
                    $selectedIds = Session::get('selected_items_for_checkout');
                    if ($selectedIds) {
                        foreach ($selectedIds as $id) {
                            unset($cart[$id]);
                        }
                        Session::put('cart', $cart);
                    } else {
                        Session::forget('cart');
                    }
                }
                Session::forget(['applied_voucher', 'selected_items_for_checkout']);

                return [
                    'order_code' => $orderCode,
                    'grand_total' => $grandTotal,
                    'payment_method' => $validated['payment_method']
                ];
            });

            if ($orderResult['payment_method'] == '2') {
                $vnpayService = new VNPayService();
                $result = $vnpayService->createPayment(
                    $orderResult['order_code'],
                    $orderResult['grand_total'],
                    "Thanh toan don hang " . $orderResult['order_code']
                );
                if ($result['success']) return redirect()->away($result['payment_url']);
            }

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function vnpayReturn(Request $request)
    {
        // 1. Kiểm tra dữ liệu trả về từ VNPay
        if ($request->vnp_ResponseCode == "00") {
            // --- THANH TOÁN THÀNH CÔNG ---

            // Tìm đơn hàng theo mã (vnp_TxnRef thường là order_code)
            $orderCode = $request->vnp_TxnRef;
            $order = Order::where('order_code', $orderCode)->first();

            if ($order) {
                // Cập nhật trạng thái đơn hàng -> Đã thanh toán
                // Giả sử payment_status_id = 2 là "Đã thanh toán"
                $order->update(['payment_status_id' => 2]);

                // === GỬI MAIL XÁC NHẬN TẠI ĐÂY ===
                $user = $order->user; // Hoặc lấy email từ Auth::user() nếu user đang login
                $emailToSend = $user ? $user->email : null; // Cần xử lý trường hợp khách vãng lai nếu có

                if ($emailToSend) {
                    Mail::to($emailToSend)->send(new OrderConfirmationMail($order));
                }
            }

            return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công! Đã gửi email xác nhận.');
        } else {
            // --- THANH TOÁN THẤT BẠI ---

            // Có thể bạn muốn xóa đơn hàng tạm hoặc cập nhật trạng thái "Hủy/Thất bại"
            $orderCode = $request->vnp_TxnRef;
            Order::where('order_code', $orderCode)->update(['payment_status_id' => 3]); // Ví dụ 3 là thất bại

            return redirect()->route('checkout.index')->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy.');
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

        $buyNow = session('buy_now');
        $cart = session('cart', []);

        if ($buyNow) {
            $sourceItems = [$buyNow['variant_id'] => ['quantity' => $buyNow['quantity']]];
        } else {
            $selectedIds = session('selected_items_for_checkout');
            $sourceItems = $selectedIds ? array_filter($cart, fn($k) => in_array((string)$k, $selectedIds), ARRAY_FILTER_USE_KEY) : $cart;
        }

        if (empty($sourceItems)) {
            return response()->json(['success' => false, 'message' => 'Không có sản phẩm để áp dụng']);
        }

        $totalAmount = 0;
        $eligibleAmount = 0;
        $hasEligibleProduct = false; // Biến kiểm tra có SP hợp lệ không
        $isSpecificVoucher = $voucher->products()->exists(); // Kiểm tra voucher có giới hạn SP không

        foreach ($sourceItems as $variantId => $item) {
            $variant = ProductVariant::with('product')->find($variantId);
            if (!$variant) continue;

            $price = $variant->sale > 0 ? $variant->sale : $variant->price;
            $itemTotal = $price * (int)$item['quantity'];
            $totalAmount += $itemTotal;

            // Kiểm tra nếu voucher áp dụng cho toàn sàn (không có SP giới hạn)
            // hoặc SP này nằm trong danh sách được áp dụng của voucher
            if (!$isSpecificVoucher || $voucher->products->pluck('id')->contains($variant->product_id)) {
                $eligibleAmount += $itemTotal;
                $hasEligibleProduct = true;
            }
        }

        // --- BƯỚC FIX LỖI: Chặn nếu không có sản phẩm nào hợp lệ ---
        if ($isSpecificVoucher && !$hasEligibleProduct) {
            return response()->json([
                'success' => false,
                'message' => 'Mã này không áp dụng cho các sản phẩm hiện có trong đơn hàng của bạn'
            ]);
        }

        if ($voucher->min_order_value > 0 && $totalAmount < $voucher->min_order_value) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng tối thiểu ' . number_format($voucher->min_order_value) . ' đ']);
        }

        // Tính toán số tiền giảm
        $discountAmount = ($voucher->discount_type === 'percent')
            ? min($eligibleAmount * $voucher->discount_value / 100, $voucher->sale_price > 0 ? $voucher->sale_price : 999999999)
            : min($voucher->discount_value, $eligibleAmount);

        // Chốt chặn cuối cùng: Nếu số tiền giảm vẫn bằng 0 thì không cho áp dụng
        if ($discountAmount <= 0) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng không đủ điều kiện để giảm giá']);
        }

        session(['applied_voucher' => [
            'id' => $voucher->id,
            'voucher_code' => $voucher->voucher_code,
            'discount_amount' => round($discountAmount)
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Giảm ' . number_format(round($discountAmount)) . ' đ',
            'discount_amount' => round($discountAmount)
        ]);
    }

    /**
     * Chuẩn hóa URL ảnh
     */
    private function normalizeImageUrl($product, $variant = null): string
    {
        $raw = null;
        if ($variant && !empty($variant->image)) {
            $raw = $variant->image;
        } elseif (!empty($product->image)) {
            $raw = $product->image;
        } elseif (!empty($product->images)) {
            $images = is_string($product->images) ? json_decode($product->images, true) : $product->images;
            if (is_array($images)) {
                $first = $images[0] ?? null;
                $raw = is_string($first) ? $first : ($first['url'] ?? null);
            }
        }

        $raw = $raw ? ltrim($raw, '/') : '';
        if ($raw && preg_match('#^https?://#i', $raw)) {
            return $raw;
        }

        $rel = Str::startsWith($raw, 'storage/') ? Str::after($raw, 'storage/') : $raw;
        $file = basename($rel);
        $candidates = ['products/' . $file, ltrim($rel, '/'), 'product_images/' . $file];

        foreach ($candidates as $relPath) {
            if (Storage::disk('public')->exists($relPath)) {
                return asset('storage/' . $relPath);
            }
        }
        return asset('images/placeholder.png');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
