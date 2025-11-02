<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Services\MomoPaymentService;
use App\Services\DemoPaymentService;
use App\Services\VNPayService;
use App\Models\Voucher;

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

        // Lấy địa chỉ mặc định từ user hoặc địa chỉ đầu tiên (chỉ các địa chỉ chưa bị xóa)
        $defaultAddress = $user->addresses()
            ->where('is_default', true)
            ->first();
        
        // Nếu không có địa chỉ mặc định, lấy địa chỉ đầu tiên
        if (!$defaultAddress) {
            $defaultAddress = $user->addresses()->first();
        }
        
        // Nếu vẫn không có, tạo địa chỉ mặc định từ thông tin user
        if (!$defaultAddress) {
            $defaultAddress = (object)[
                'id' => 0,
                'name' => $user->name ?? 'Khách hàng',
                'phone' => $user->phone ?? 'Chưa cập nhật',
                'address' => $user->address ?? 'Chưa cập nhật địa chỉ',
                'is_default' => true,
            ];
        }
        
        // Lấy tất cả địa chỉ của user (chỉ các địa chỉ chưa bị xóa)
        $addresses = $user->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
    // Đếm số địa chỉ hiện tại
    $addressCount = $addresses->count();

    // Phí vận chuyển cố định: 30,000 VNĐ
    $shippingFee = 30000;
    
    // Lấy voucher đang active (nếu có trong session) - PHẢI GIỐNG HỆT store()
    $appliedVoucher = null;
    $discountAmount = 0;
    $voucherCode = Session::get('applied_voucher_code');
    if ($voucherCode) {
        $appliedVoucher = Voucher::where('voucher_code', $voucherCode)->first();
        if ($appliedVoucher) {
            // Kiểm tra xem database có cột discount_type và discount_value không
            $hasDiscountType = Schema::hasColumn('vouchers', 'discount_type');
            $hasDiscountValue = Schema::hasColumn('vouchers', 'discount_value');
            
            // Tính toán giảm giá (GIỐNG HỆT store())
            $isFreeship = false;
            $voucherCodeUpper = strtoupper($appliedVoucher->voucher_code ?? '');
            $description = strtolower($appliedVoucher->description ?? '');
            
            // Kiểm tra freeship
            if (stripos($voucherCodeUpper, 'FREESHIP') !== false || stripos($description, 'miễn phí vận chuyển') !== false) {
                $isFreeship = true;
                $discountAmount = $shippingFee;
                $shippingFee = 0;
            } elseif ($hasDiscountType && $hasDiscountValue) {
                // Database mới có discount_type và discount_value
                if ($appliedVoucher->discount_type === 'percent') {
                    $grandTotalBeforeDiscount = $totalAmount + $shippingFee;
                    $discountAmount = ($grandTotalBeforeDiscount * $appliedVoucher->discount_value / 100);
                } elseif ($appliedVoucher->discount_type === 'fixed') {
                    $discountAmount = $appliedVoucher->discount_value;
                }
            } else {
                // Database cũ - chỉ có sale_price
                if ($appliedVoucher->sale_price > 0 && $totalAmount >= $appliedVoucher->min_order_value) {
                    $discountAmount = $appliedVoucher->sale_price;
                }
                
                // Nếu vẫn = 0, thử extract từ description
                if ($discountAmount == 0 && !empty($appliedVoucher->description)) {
                    $desc = $appliedVoucher->description;
                    if (preg_match('/giảm\s+(\d+)(k|nghìn|000)/iu', $desc, $matches)) {
                        $discountAmount = intval($matches[1]) * 1000;
                    } elseif (preg_match('/giảm\s+(\d+)\s*đ/u', $desc, $matches)) {
                        $discountAmount = intval($matches[1]);
                    } elseif (preg_match('/(\d+)\s*(k|nghìn|000)/iu', $desc, $matches)) {
                        $discountAmount = intval($matches[1]) * 1000;
                    }
                }
            }
            
            // Giới hạn discount không vượt quá tổng đơn
            $discountAmount = min($discountAmount, $totalAmount + $shippingFee);
        }
    }
    
    $grandTotal = $totalAmount + $shippingFee - $discountAmount;

    return view('checkout.index', compact('cartItems', 'totalAmount', 'shippingFee', 'grandTotal', 'user', 'defaultAddress', 'addresses', 'addressCount', 'appliedVoucher', 'discountAmount'));
}

/**
 * Lấy danh sách voucher đang active
 */
public function getAvailableVouchers(Request $request)
{
    try {
        $today = now();
        
        // Lấy tất cả voucher có status = 1
        $query = Voucher::where('status', 1);
        
        // Lọc theo ngày bắt đầu
        $query->where(function($q) use ($today) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $today);
        });
        
        // Lọc theo ngày kết thúc
        $query->where(function($q) use ($today) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $today);
        });
        
        // Lọc theo số lượng còn lại
        $query->whereRaw('COALESCE(total_used, 0) < COALESCE(quantity, 999999)');
        
        $allVouchers = $query->get();
        
        \Log::info('Total vouchers found: ' . $allVouchers->count());
        
        $vouchers = $allVouchers->map(function($voucher) {
            $discountText = '';
            
            // Kiểm tra nếu có discount_type (có thể không có trong DB cũ)
            $hasDiscountType = Schema::hasColumn('vouchers', 'discount_type');
            $discountType = $hasDiscountType ? ($voucher->discount_type ?? 'fixed') : 'fixed';
            
            // Kiểm tra discount_value
            $hasDiscountValue = Schema::hasColumn('vouchers', 'discount_value');
            $discountValue = $hasDiscountValue ? ($voucher->discount_value ?? 0) : 0;
            
            // Xác định loại giảm giá dựa vào code hoặc description
            $voucherCode = strtoupper($voucher->voucher_code ?? '');
            $description = $voucher->description ?? '';
            
            if (stripos($voucherCode, 'FREESHIP') !== false || stripos($description, 'Miễn phí vận chuyển') !== false) {
                $discountText = 'Miễn phí vận chuyển';
            } elseif ($discountType === 'percent' && $discountValue > 0) {
                $discountText = 'Giảm ' . $discountValue . '% trên tổng tiền';
            } elseif ($discountValue > 0) {
                $discountText = 'Giảm ' . number_format($discountValue, 0, ',', '.') . 'đ';
            } else {
                // Fallback: dùng description hoặc mặc định
                $discountText = !empty($description) ? $description : 'Mã giảm giá';
            }
            
            return [
                'id' => $voucher->id,
                'code' => $voucher->voucher_code,
                'description' => $description,
                'discount_type' => $discountType,
                'discount_value' => $discountValue,
                'discount_text' => $discountText,
                'min_order_value' => $voucher->min_order_value ?? 0,
                'min_order_text' => ($voucher->min_order_value ?? 0) > 0 ? 'Đơn từ ' . number_format($voucher->min_order_value, 0, ',', '.') . 'đ' : '',
            ];
        });

        \Log::info('Returning vouchers: ' . $vouchers->count());

        return response()->json([
            'success' => true,
            'vouchers' => $vouchers,
            'count' => $vouchers->count(),
            'debug' => [
                'today' => $today->toDateTimeString(),
                'total_in_db' => Voucher::count(),
            ]
        ]);
    } catch (\Exception $e) {
        \Log::error('Error getting vouchers: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            'vouchers' => [],
            'count' => 0
        ], 500);
    }
}

/**
 * Áp dụng voucher
 */
public function applyVoucher(Request $request)
{
    $request->validate([
        'voucher_code' => 'required|string',
    ]);

    $voucher = Voucher::where('voucher_code', $request->voucher_code)->first();
    
    if (!$voucher) {
        return response()->json([
            'success' => false,
            'message' => 'Mã giảm giá không tồn tại'
        ], 404);
    }

    // Kiểm tra voucher còn hạn không
    $today = now()->toDateString();
    if ($voucher->status != 1 || $voucher->start_date > $today || $voucher->end_date < $today) {
        return response()->json([
            'success' => false,
            'message' => 'Mã giảm giá đã hết hạn'
        ], 400);
    }

    // Kiểm tra số lượng
    if ($voucher->total_used >= $voucher->quantity) {
        return response()->json([
            'success' => false,
            'message' => 'Mã giảm giá đã hết lượt sử dụng'
        ], 400);
    }

    // Tính tổng tiền đơn hàng
    $cart = Session::get('cart', []);
    $totalAmount = 0;
    foreach ($cart as $variantId => $item) {
        $variant = ProductVariant::find($variantId);
        if ($variant) {
            $totalAmount += $variant->price * $item['quantity'];
        }
    }

    // Kiểm tra giá trị đơn hàng tối thiểu
    if ($totalAmount < $voucher->min_order_value) {
        return response()->json([
            'success' => false,
            'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($voucher->min_order_value) . 'đ để sử dụng mã này'
        ], 400);
    }

    // Lưu voucher vào session
    Session::put('applied_voucher_code', $voucher->voucher_code);
    Session::put('applied_voucher_id', $voucher->id);

    // Tính toán giảm giá
    $shippingFee = 30000;
    $discountAmount = 0;
    $isFreeship = false;

    // Kiểm tra discount_type (có thể không có trong DB cũ)
    $hasDiscountType = Schema::hasColumn('vouchers', 'discount_type');
    $discountType = $hasDiscountType ? ($voucher->discount_type ?? 'fixed') : 'fixed';
    $discountValue = Schema::hasColumn('vouchers', 'discount_value') ? ($voucher->discount_value ?? 0) : 0;
    
    // Nếu không có discount_value, thử extract từ description
    if ($discountValue == 0 && !empty($voucher->description)) {
        // Tìm số tiền giảm trong description (ví dụ: "Giảm 50k", "Giảm 100000đ")
        $description = $voucher->description;
        if (preg_match('/giảm\s+(\d+)(k|nghìn|000)/iu', $description, $matches)) {
            // Tìm "giảm Xk" hoặc "giảm Xnghìn"
            $discountValue = intval($matches[1]) * 1000;
        } elseif (preg_match('/giảm\s+(\d+)\s*đ/u', $description, $matches)) {
            // Tìm "giảm Xđ"
            $discountValue = intval($matches[1]);
        } elseif (preg_match('/(\d+)\s*(k|nghìn|000)/iu', $description, $matches)) {
            // Tìm số có đơn vị k/nghìn
            $discountValue = intval($matches[1]) * 1000;
        }
        
        // Nếu vẫn không có, có thể sale_price là giá trị giảm (không phải giá sau giảm)
        if ($discountValue == 0 && $voucher->sale_price > 0 && $voucher->sale_price < $voucher->min_order_value) {
            // Nếu sale_price nhỏ hơn min_order_value, có thể đây là giá trị giảm
            $discountValue = $voucher->sale_price;
        }
    }

    // Kiểm tra nếu là freeship
    $voucherCode = strtoupper($voucher->voucher_code ?? '');
    $description = strtolower($voucher->description ?? '');
    
    if (stripos($voucherCode, 'FREESHIP') !== false || stripos($description, 'miễn phí vận chuyển') !== false) {
        $isFreeship = true;
        $discountAmount = $shippingFee;
        $shippingFee = 0;
    } elseif ($discountType === 'percent' && $discountValue > 0) {
        // Giảm theo phần trăm trên tổng tiền (bao gồm phí ship)
        $grandTotalBeforeDiscount = $totalAmount + $shippingFee;
        $discountAmount = ($grandTotalBeforeDiscount * $discountValue / 100);
    } elseif ($discountValue > 0) {
        // Giảm cố định (fixed)
        $discountAmount = min($discountValue, $totalAmount + $shippingFee); // Không giảm quá tổng tiền
    }

    $grandTotal = max(0, $totalAmount + $shippingFee - $discountAmount);
    
    \Log::info('Voucher calculation', [
        'code' => $voucher->voucher_code,
        'discount_type' => $discountType,
        'discount_value' => $discountValue,
        'total_amount' => $totalAmount,
        'shipping_fee' => $shippingFee,
        'discount_amount' => $discountAmount,
        'grand_total' => $grandTotal,
        'is_freeship' => $isFreeship
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Áp dụng mã giảm giá thành công!',
        'voucher' => [
            'code' => $voucher->voucher_code,
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'is_freeship' => $isFreeship,
        ],
        'discount_amount' => round($discountAmount, 2),
        'grand_total' => round(max(0, $grandTotal), 2),
        'shipping_fee' => $isFreeship ? 0 : $shippingFee,
        'total_amount' => $totalAmount,
    ]);
}

/**
 * Xóa voucher đã áp dụng
 */
public function removeVoucher()
{
    Session::forget('applied_voucher_code');
    Session::forget('applied_voucher_id');

    // Tính lại tổng tiền
    $cart = Session::get('cart', []);
    $totalAmount = 0;
    foreach ($cart as $variantId => $item) {
        $variant = ProductVariant::find($variantId);
        if ($variant) {
            $totalAmount += $variant->price * $item['quantity'];
        }
    }
    $shippingFee = 30000;
    $grandTotal = $totalAmount + $shippingFee;

    return response()->json([
        'success' => true,
        'message' => 'Đã xóa mã giảm giá',
        'grand_total' => $grandTotal,
        'shipping_fee' => $shippingFee,
    ]);
    }

    public function store(Request $request)
    {
        \Log::info('Checkout store called', [
            'request_data' => $request->all(),
            'payment_method' => $request->input('payment_method'),
            'shipping_method' => $request->input('shipping_method'),
            'address_id' => $request->input('address_id'),
        ]);
        
        try {
        // Xử lý đặt hàng
            // Đảm bảo address_id có giá trị, mặc định là 0
            $addressId = $request->input('address_id');
            if ($addressId === null || $addressId === '') {
                $request->merge(['address_id' => 0]);
            }
            
        $validated = $request->validate([
            'shipping_method' => 'required|in:1,2,3',
                'payment_method' => 'required|in:2,3', // 2 = VNPay, 3 = COD (Thanh toán khi giao hàng)
                'address_id' => 'required|integer|min:0', // 0 là hợp lệ (địa chỉ mặc định từ user)
                'receive_vat' => 'nullable|boolean',
            'order_vat_email' => 'nullable|email',
            'order_vat_tax_code' => 'nullable|string',
            'order_vat_company_name' => 'nullable|string',
            'order_vat_address' => 'nullable|string',
            'order_vat_note' => 'nullable|string',
        ]);
            
            \Log::info('Validation passed', ['validated' => $validated]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Error in store method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }

        $cart = Session::get('cart', []);
        $totalAmount = 0;

        // Tính tổng tiền
        foreach ($cart as $variantId => $item) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $totalAmount += $variant->price * $item['quantity'];
            }
        }

        // Phí vận chuyển cố định: 30,000 VNĐ
        $shippingFee = 30000;
        
        // Kiểm tra voucher đã áp dụng (PHẢI DÙNG CÙNG LOGIC VỚI index())
        $discountAmount = 0;
        $appliedVoucherCode = Session::get('applied_voucher_code');
        if ($appliedVoucherCode) {
            $voucher = Voucher::where('voucher_code', $appliedVoucherCode)->first();
            if ($voucher) {
                // Kiểm tra xem database có cột discount_type và discount_value không
                $hasDiscountType = Schema::hasColumn('vouchers', 'discount_type');
                $hasDiscountValue = Schema::hasColumn('vouchers', 'discount_value');
                
                // Tính toán giảm giá (GIỐNG HỆT index())
                $isFreeship = false;
                $voucherCode = strtoupper($voucher->voucher_code ?? '');
                $description = strtolower($voucher->description ?? '');
                
                // Kiểm tra freeship
                if (stripos($voucherCode, 'FREESHIP') !== false || stripos($description, 'miễn phí vận chuyển') !== false) {
                    $isFreeship = true;
                    $discountAmount = $shippingFee; // 30,000
                    $shippingFee = 0; // Miễn phí vận chuyển
                } elseif ($hasDiscountType && $hasDiscountValue) {
                    // Database mới có discount_type và discount_value
                    if ($voucher->discount_type === 'percent') {
                        $grandTotalBeforeDiscount = $totalAmount + $shippingFee;
                        $discountAmount = ($grandTotalBeforeDiscount * $voucher->discount_value / 100);
                    } elseif ($voucher->discount_type === 'fixed') {
                        $discountAmount = $voucher->discount_value;
                    }
                } else {
                    // Database cũ - chỉ có sale_price
                    // Logic: sale_price là giá trị giảm (nếu đơn >= min_order_value)
                    if ($voucher->sale_price > 0 && $totalAmount >= $voucher->min_order_value) {
                        $discountAmount = $voucher->sale_price;
                    }
                    
                    // Nếu vẫn = 0, thử extract từ description
                    if ($discountAmount == 0 && !empty($voucher->description)) {
                        $desc = $voucher->description;
                        if (preg_match('/giảm\s+(\d+)(k|nghìn|000)/iu', $desc, $matches)) {
                            $discountAmount = intval($matches[1]) * 1000;
                        } elseif (preg_match('/giảm\s+(\d+)\s*đ/u', $desc, $matches)) {
                            $discountAmount = intval($matches[1]);
                        } elseif (preg_match('/(\d+)\s*(k|nghìn|000)/iu', $desc, $matches)) {
                            $discountAmount = intval($matches[1]) * 1000;
                        }
                    }
                }
                
                // Giới hạn discount không vượt quá tổng đơn
                $discountAmount = min($discountAmount, $totalAmount + $shippingFee);
                
                // Tăng total_used của voucher
                $voucher->increment('total_used');
                
                \Log::info('Voucher applied in store', [
                    'code' => $appliedVoucherCode,
                    'has_discount_type' => $hasDiscountType,
                    'has_discount_value' => $hasDiscountValue,
                    'discount_type' => $hasDiscountType ? $voucher->discount_type : 'N/A',
                    'discount_value' => $hasDiscountValue ? $voucher->discount_value : 'N/A',
                    'sale_price' => $voucher->sale_price,
                    'calculated_discount' => $discountAmount
                ]);
            }
        }
        
        // Tính tổng cuối cùng (PHẢI GIỐNG index())
        $grandTotal = $totalAmount + $shippingFee - $discountAmount;
        
        // Log để debug
        \Log::info('Store method calculation', [
            'totalAmount' => $totalAmount,
            'shippingFee' => $shippingFee,
            'discountAmount' => $discountAmount,
            'grandTotal' => $grandTotal,
            'voucher_code' => $appliedVoucherCode,
            'formula' => "$totalAmount + $shippingFee - $discountAmount = $grandTotal"
        ]);

        $orderId = 'ORDER_' . time() . '_' . Auth::id();
        $orderInfo = 'Thanh toan don hang ' . $orderId;

        // Xử lý theo phương thức thanh toán
        if ($validated['payment_method'] == '2') { // VNPay
            // Tạo thanh toán VNPay (tổng tiền bao gồm cả phí vận chuyển)
            $vnpayService = new VNPayService();
            $result = $vnpayService->createPayment(
                $orderId,
                $grandTotal,
                $orderInfo,
                'other'
            );

            if ($result['success']) {
            // Lưu thông tin đơn hàng tạm thời
            Session::put('pending_order', [
                'orderId' => $orderId,
                'totalAmount' => $totalAmount,
                    'shippingFee' => $shippingFee,
                    'grandTotal' => $grandTotal,
                'orderInfo' => $orderInfo,
                    'payment_method' => 'vnpay'
                ]);

                // Redirect đến trang thanh toán VNPay
                return redirect($result['payment_url']);
            } else {
                return redirect()->back()->with('error', $result['message'] ?? 'Không thể tạo thanh toán VNPay');
            }
        } elseif ($validated['payment_method'] == '5') { // Momo (giữ lại cho tương thích ngược)
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
            // COD (Thanh toán khi giao hàng) - payment_method = 3
            // LƯU Ý: $totalAmount, $shippingFee, $discountAmount, $grandTotal đã được tính ở trên
            // KHÔNG được tính lại ở đây!
            \Log::info('Processing COD order', [
                'orderId' => $orderId,
                'totalAmount' => $totalAmount,
                'shippingFee' => $shippingFee,
                'discountAmount' => $discountAmount,
                'grandTotal' => $grandTotal,
                'address_id' => $validated['address_id'],
                'formula_check' => "$totalAmount + $shippingFee - $discountAmount = " . ($totalAmount + $shippingFee - $discountAmount)
            ]);

            try {
                // Lấy thông tin địa chỉ giao hàng
                $shippingAddress = null;
                $addressName = '';
                $addressFull = '';
                $addressPhone = '';
                $addressId = $validated['address_id'];
                
                \Log::info('Getting shipping address', [
                    'address_id' => $addressId,
                    'address_id_type' => gettype($addressId)
                ]);
                
                if ($addressId == 0) {
                    // address_id = 0: Địa chỉ mặc định từ user
                    // NHƯNG ưu tiên lấy từ user_addresses nếu có địa chỉ mặc định
                    $user = Auth::user();
                    
                    // Ưu tiên: Lấy địa chỉ mặc định từ user_addresses trước
                    $defaultAddress = $user->addresses()->where('is_default', true)->first();
                    if (!$defaultAddress) {
                        $defaultAddress = $user->addresses()->first();
                    }
                    
                    if ($defaultAddress) {
                        // Dùng địa chỉ từ user_addresses (ưu tiên hơn users table)
                        $shippingAddress = $defaultAddress;
                        $addressName = $shippingAddress->name;
                        $addressFull = $shippingAddress->address ?? '';
                        if ($shippingAddress->ward) {
                            $addressFull .= ', ' . $shippingAddress->ward;
                        }
                        if ($shippingAddress->district) {
                            $addressFull .= ', ' . $shippingAddress->district;
                        }
                        if ($shippingAddress->province) {
                            $addressFull .= ', ' . $shippingAddress->province;
                        }
                        $addressPhone = $shippingAddress->phone ?? '';
                        
                        \Log::info('Using default address from user_addresses (address_id=0)', [
                            'address_id' => $defaultAddress->id,
                            'name' => $addressName,
                            'phone' => $addressPhone,
                            'address' => $addressFull
                        ]);
                    } else {
                        // Fallback: Dùng địa chỉ từ bảng users (nếu không có địa chỉ nào trong user_addresses)
                        $addressName = $user->name ?? 'Khách hàng';
                        $addressFull = $user->address ?? '';
                        $addressPhone = $user->phone ?? '';
                        
                        \Log::info('Using user table address (address_id=0, no addresses in user_addresses)', [
                            'name' => $addressName,
                            'phone' => $addressPhone,
                            'address' => $addressFull
                        ]);
                    }
                } else {
                    // Địa chỉ từ user_addresses (phải lấy cả địa chỉ đã bị soft delete để kiểm tra)
                    $shippingAddress = UserAddress::withTrashed()->where('id', $addressId)->where('user_id', Auth::id())->first();
                    
                    if (!$shippingAddress) {
                        \Log::warning('Shipping address not found', [
                            'address_id' => $addressId,
                            'user_id' => Auth::id()
                        ]);
                        
                        // Fallback: lấy địa chỉ mặc định từ user hoặc địa chỉ đầu tiên
                        $user = Auth::user();
                        $defaultAddr = $user->addresses()->where('is_default', true)->first();
                        if (!$defaultAddr) {
                            $defaultAddr = $user->addresses()->first();
                        }
                        
                        if ($defaultAddr) {
                            $shippingAddress = $defaultAddr;
                            \Log::info('Using fallback default address', ['address_id' => $defaultAddr->id]);
                        } else {
                            // Cuối cùng: dùng địa chỉ từ user table
                            $addressName = $user->name ?? 'Khách hàng';
                            $addressFull = $user->address ?? '';
                            $addressPhone = $user->phone ?? '';
                            \Log::info('Using user table address as final fallback');
                        }
                    }
                    
                    if ($shippingAddress) {
                        $addressName = $shippingAddress->name;
                        $addressFull = $shippingAddress->address ?? '';
                        if ($shippingAddress->ward) {
                            $addressFull .= ', ' . $shippingAddress->ward;
                        }
                        if ($shippingAddress->district) {
                            $addressFull .= ', ' . $shippingAddress->district;
                        }
                        if ($shippingAddress->province) {
                            $addressFull .= ', ' . $shippingAddress->province;
                        }
                        $addressPhone = $shippingAddress->phone ?? '';
                        
                        \Log::info('Using user_addresses address', [
                            'address_id' => $shippingAddress->id,
                            'name' => $addressName,
                            'phone' => $addressPhone,
                            'address' => $addressFull,
                            'is_deleted' => $shippingAddress->trashed()
                        ]);
                    }
                }
                
                // Đảm bảo có địa chỉ
                if (empty($addressName) || empty($addressFull)) {
                    \Log::error('Missing shipping address information', [
                        'address_id' => $addressId,
                        'address_name' => $addressName,
                        'address_full' => $addressFull
                    ]);
                    return redirect()->back()->with('error', 'Vui lòng chọn địa chỉ giao hàng hợp lệ');
                }
                
                // Lấy voucher_id nếu có
                $voucherId = null;
                $appliedVoucherId = Session::get('applied_voucher_id');
                if ($appliedVoucherId) {
                    $voucherId = $appliedVoucherId;
                }
                
                // Tạo order_code (định dạng: ORD + timestamp + user_id)
                $orderCode = 'ORD' . date('YmdHis') . Auth::id();
                
                // Xác nhận lại giá trị trước khi lưu (để đảm bảo đúng)
                $finalSubtotal = $totalAmount;
                $finalDiscount = $discountAmount;
                $finalShippingFee = $shippingFee;
                $finalGrandTotal = $totalAmount + $shippingFee - $discountAmount;
                
                // Validate: đảm bảo grandTotal đúng
                if (abs($finalGrandTotal - $grandTotal) > 0.01) {
                    \Log::warning('Grand total mismatch', [
                        'calculated' => $finalGrandTotal,
                        'expected' => $grandTotal,
                        'difference' => abs($finalGrandTotal - $grandTotal)
                    ]);
                    // Dùng giá trị tính lại để đảm bảo đúng
                    $grandTotal = $finalGrandTotal;
                }
                
                // Tạo đơn hàng
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'payment_status_id' => 1, // 1 = Chờ thanh toán (COD)
                    'order_status_id' => Order::STATUS_PENDING, // 1 = Chờ xác nhận
                    'voucher_id' => $voucherId,
                    'order_code' => $orderCode,
                    'name' => $addressName,
                    'address' => $addressFull,
                    'phone' => $addressPhone,
                    'subtotal' => $finalSubtotal,
                    'discount' => $finalDiscount,
                    'total_amount' => $finalGrandTotal,
                    'note' => $request->input('note'),
                ]);
                
                \Log::info('Order created', [
                    'order_id' => $order->id,
                    'order_code' => $orderCode,
                    'subtotal' => $finalSubtotal,
                    'shipping_fee' => $finalShippingFee,
                    'discount' => $finalDiscount,
                    'total_amount' => $finalGrandTotal,
                    'formula' => "$finalSubtotal + $finalShippingFee - $finalDiscount = $finalGrandTotal",
                    'formula_check' => ($finalSubtotal + $finalShippingFee - $finalDiscount) == $finalGrandTotal,
                    'voucher_code' => $appliedVoucherCode
                ]);
                
                // Tạo chi tiết đơn hàng từ giỏ hàng
                foreach ($cart as $variantId => $item) {
                    $variant = ProductVariant::find($variantId);
                    if ($variant) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_variant_id' => $variantId,
                            'price' => $variant->price,
                            'quantity' => $item['quantity'],
                            'status' => 1, // 1 = Chờ giao
                        ]);
                    }
                }
                
                \Log::info('Order details created', ['order_id' => $order->id, 'details_count' => count($cart)]);
                
                // Tạo payment record (COD)
                Payment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => 3, // 3 = COD
                    'payment_code' => 'COD_' . $orderCode,
                    'payment_amount' => $grandTotal,
                    'status' => 1, // 1 = Chờ thanh toán
                ]);
                
                \Log::info('Payment record created', ['order_id' => $order->id]);
                
                // Gửi email xác nhận đơn hàng
                try {
                    $order->load(['details.productVariant.product', 'details.productVariant.size', 'details.productVariant.color', 'status', 'voucher']);
                    $userEmail = Auth::user()->email ?? $order->user->email ?? null;
                    
                    if ($userEmail) {
                        Mail::to($userEmail)->send(new OrderConfirmation($order));
                        \Log::info('Order confirmation email sent', [
                            'order_id' => $order->id,
                            'email' => $userEmail
                        ]);
                    } else {
                        \Log::warning('Cannot send order confirmation email: no user email', [
                            'order_id' => $order->id,
                            'user_id' => Auth::id()
                        ]);
                    }
                } catch (\Exception $emailException) {
                    // Không fail đơn hàng nếu email lỗi
                    \Log::error('Failed to send order confirmation email', [
                        'order_id' => $order->id,
                        'error' => $emailException->getMessage()
                    ]);
                }
                
            } catch (\Exception $e) {
                \Log::error('Error creating order', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đơn hàng: ' . $e->getMessage());
            }

            // Xóa giỏ hàng sau khi đặt hàng thành công
            Session::forget('cart');
            Session::forget('applied_voucher_code');
            Session::forget('applied_voucher_id');

            return redirect()->route('checkout.success')->with('success', 'Đặt hàng thành công!');
        }
    }

    public function success()
    {
        return view('checkout.success');
    }

    /**
     * Thêm địa chỉ mới
     */
    public function addAddress(Request $request)
    {
        $user = Auth::user();
        
        // Kiểm tra số lượng địa chỉ (tối đa 5)
        $addressCount = $user->addresses()->count();
        if ($addressCount >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn chỉ có thể thêm tối đa 5 địa chỉ.'
            ], 400);
        }

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'province' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'ward' => 'nullable|string|max:255',
                'is_default' => 'nullable|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        }

        // Xử lý is_default: convert "1" thành true
        if ($request->has('is_default')) {
            $validated['is_default'] = $request->input('is_default') == '1' || $request->input('is_default') === true || $request->input('is_default') == 1;
        } else {
            $validated['is_default'] = false;
        }

        // Nếu set là mặc định, bỏ mặc định của các địa chỉ khác (chỉ các địa chỉ chưa bị xóa)
        if ($validated['is_default']) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address = $user->addresses()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm địa chỉ thành công!',
            'address' => $address
        ]);
    }

    /**
     * Cập nhật địa chỉ
     */
    public function updateAddress(Request $request, $id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);
        
        // Log để debug
        \Log::info('Update Address Request', [
            'id' => $id,
            'user_id' => $user->id,
            'method' => $request->method(),
            'all_data' => $request->all(),
            'has_method' => $request->has('_method'),
            '_method' => $request->input('_method'),
        ]);

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string',
                'province' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'ward' => 'nullable|string|max:255',
                'is_default' => 'nullable|boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        }

        // Xử lý is_default: convert "1" thành true
        if ($request->has('is_default')) {
            $validated['is_default'] = $request->input('is_default') == '1' || $request->input('is_default') === true || $request->input('is_default') == 1;
        } else {
            $validated['is_default'] = $address->is_default; // Giữ nguyên giá trị cũ
        }

        // Nếu set là mặc định, bỏ mặc định của các địa chỉ khác
        if ($validated['is_default']) {
            $user->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        }

        // Log trước khi update
        \Log::info('Before update', [
            'old_address' => $address->toArray(),
            'validated_data' => $validated
        ]);

        $address->update($validated);
        
        // Log sau khi update
        \Log::info('After update', [
            'new_address' => $address->fresh()->toArray()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sửa địa chỉ thành công!',
            'address' => $address->fresh()
        ]);
    }

    /**
     * Xóa địa chỉ
     */
    public function deleteAddress($id)
    {
        $user = Auth::user();
        
        // Tìm địa chỉ (chỉ trong các địa chỉ chưa bị xóa)
        $address = $user->addresses()->findOrFail($id);
        
        // Log trước khi xóa
        \Log::info('=== Delete Address ===', [
            'id' => $id,
            'user_id' => $user->id,
            'address_before' => $address->toArray(),
            'deleted_at_before' => $address->deleted_at
        ]);
        
        // Soft delete
        $address->delete();
        
        // Log sau khi xóa
        $address->refresh();
        \Log::info('After delete', [
            'deleted_at_after' => $address->deleted_at,
            'address_fresh' => $address->fresh()
        ]);
        
        // Kiểm tra lại: đếm số địa chỉ sau khi xóa
        $remainingCount = $user->addresses()->count();
        \Log::info('Remaining addresses count', ['count' => $remainingCount]);

        return response()->json([
            'success' => true,
            'message' => 'Xóa địa chỉ thành công!',
            'remaining_count' => $remainingCount
        ]);
    }

    /**
     * Đặt địa chỉ làm mặc định
     */
    public function setDefaultAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        // Bỏ mặc định của tất cả địa chỉ khác (chỉ các địa chỉ chưa bị xóa)
        $user->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        
        // Đặt địa chỉ này làm mặc định
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt địa chỉ mặc định thành công!',
            'address' => $address->fresh()
        ]);
    }

    /**
     * Lấy thông tin địa chỉ để sửa
     */
    public function getAddress($id)
    {
        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    /**
     * Lấy danh sách địa chỉ dạng JSON để reload
     */
    public function getAddresses()
    {
        $user = Auth::user();
        // Chỉ lấy các địa chỉ chưa bị xóa (soft delete)
        $addresses = $user->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses,
            'count' => $addresses->count()
        ]);
    }

    /**
     * Lấy thông tin user để sửa địa chỉ mặc định
     */
    public function getUserInfo()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->address,
            ]
        ]);
    }

    /**
     * Cập nhật thông tin user (địa chỉ mặc định)
     */
    public function updateUserInfo(Request $request)
    {
        $user = Auth::user();
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Sửa địa chỉ mặc định thành công!',
            'user' => $user->fresh()
        ]);
    }

    /**
     * Xóa địa chỉ mặc định (làm trống địa chỉ của user)
     */
    public function clearUserAddress()
    {
        $user = Auth::user();
        
        $user->update([
            'address' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa địa chỉ mặc định!',
            'user' => $user->fresh() // Trả về user mới để cập nhật UI
        ]);
    }
}
