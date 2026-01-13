<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Voucher;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log; // <-- Đã thêm: Cần thiết cho Log::error()


class AccountController extends Controller
{
    // Trang chính "Tài khoản của tôi"
    public function index()
    {
        $user = Auth::user();
        return view('account.dashboard', compact('user'));
    }


    // Trang danh sách đơn hàng
    public function orders()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('account.orders', compact('orders'));
    }

    public function address()
    {
        $user = Auth::user();
        return view('account.addresses', compact('user'));
    }

    // Trang chỉnh sửa hồ sơ
    public function edit()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    // Cập nhật thông tin hồ sơ
   // Cập nhật thông tin hồ sơ & Địa chỉ Checkout
   /**
     * Cập nhật thông tin hồ sơ & Địa chỉ Checkout
     * Giữ nguyên 100% logic cũ và bổ sung xử lý Session + Database khi đặt địa chỉ mặc định.
     */
   public function update(Request $request)
{
    $user = Auth::user();

    // TRƯỜNG HỢP 1: Cập nhật nhanh address_id từ trang Checkout (Giữ nguyên)
    if ($request->has('address_id')) {
        try {
            $addressId = $request->address_id;
            $exists = $user->addresses()->where('id', $addressId)->exists();
            
            if (!$exists && $addressId != 0) {
                return response()->json(['success' => false, 'message' => 'Địa chỉ không hợp lệ.'], 403);
            }

            session(['checkout_address_id' => $addressId]);
            
            if ($addressId != 0) {
                $user->addresses()->update(['is_default' => 0]); 
                $user->addresses()->where('id', $addressId)->update(['is_default' => 1]);
            }

            return response()->json([
                'success' => true, 
                'message' => 'Đã thay đổi địa chỉ giao hàng mặc định.',
                'address_id' => $addressId
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    // TRƯỜNG HỢP 2: Cập nhật hồ sơ bình thường & Thông tin ngân hàng
    $request->validate([
        'name'           => ['required', 'string', 'max:255'],
        'phone'          => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
        'email'          => [
            'required', 'email', 'max:255',
            \Illuminate\Validation\Rule::unique('users', 'email')->ignore($user->id),
        ],
        // Thêm validate cho thông tin ngân hàng
        'bank_name'      => ['required', 'string', 'max:100'],
        'account_number' => ['required', 'string', 'max:30'],
        'account_holder' => ['required', 'string', 'max:100'],
    ], [
        'phone.regex'             => 'Số điện thoại chỉ chứa 0-9, +, -, khoảng trắng, ().',
        'bank_name.required'      => 'Vui lòng nhập tên ngân hàng.',
        'account_number.required' => 'Vui lòng nhập số tài khoản.',
        'account_holder.required' => 'Vui lòng nhập tên chủ tài khoản.',
    ]);

    // 1. Cập nhật thông tin bảng Users
    $data = $request->only(['name', 'phone', 'email']);
    
    if ($request->hasFile('image')) {
        if ($user->image) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $user->image);
        }
        $data['image'] = $request->file('image')->store('avatars', 'public');
    }
    
    $user->update($data);

    // 2. Cập nhật thông tin bảng UserBankAccount (Thông tin ngân hàng)
    // Sử dụng updateOrCreate để tự động tạo mới nếu chưa có hoặc cập nhật nếu đã tồn tại
    $user->bankAccount()->updateOrCreate(
        ['user_id' => $user->id], // Điều kiện tìm kiếm theo user_id
        [
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => strtoupper($request->account_holder), // Viết hoa tên chủ tài khoản cho chuyên nghiệp
            'is_default'     => 1
        ]
    );

    return redirect()->route('account.profile')->with('success', 'Cập nhật thông tin thành công!');
}


    // Trang đổi mật khẩu
    public function changePassword()
    {
        return view('account.password');
    }

    // Xử lý đổi mật khẩu
    public function updatePassword(Request $request)
    {
        // 1. Validate dữ liệu nhập vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // phải có new_password_confirmation
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        // 2. Lấy user hiện tại
        $user = Auth::user();

        // 3. Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // 4. Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 5. Gửi thông báo thành công
        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Checkout-specific methods
    public function getUserInfo()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function clearAddress()
    {
        $user = Auth::user();
        $user->update([
            'address' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa địa chỉ mặc định',
            'user' => $user
        ]);
    }

    public function getVouchers()
    {
        $user = Auth::user();
        $today = now();

        // Lấy tất cả voucher đang hoạt động, còn hạn, còn số lượng
        $vouchers = Voucher::where('status', 1) // Active
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->whereRaw('total_used < quantity') // Còn số lượng
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($voucher) {
                // Format discount text
                $discountText = '';
                if ($voucher->discount_type === 'percent') {
                    $discountText = 'Giảm ' . number_format($voucher->discount_value, 0) . '%';
                } else {
                    $discountText = 'Giảm ' . number_format($voucher->discount_value, 0) . 'đ';
                }

                // Format min order value
                if ($voucher->min_order_value > 0) {
                    $discountText .= ' (Đơn tối thiểu ' . number_format($voucher->min_order_value, 0) . 'đ)';
                }

                return [
                    'id' => $voucher->id,
                    'code' => $voucher->voucher_code,
                    'discount_type' => $voucher->discount_type,
                    'discount_value' => $voucher->discount_value,
                    'min_order_value' => $voucher->min_order_value,
                    'discount_text' => $discountText,
                    'description' => $voucher->description,
                    'quantity' => $voucher->quantity,
                    'total_used' => $voucher->total_used,
                    'remaining' => $voucher->quantity - $voucher->total_used,
                    'start_date' => $voucher->start_date,
                    'end_date' => $voucher->end_date,
                ];
            });

        return response()->json([
            'success' => true,
            'vouchers' => $vouchers
        ]);
    }

   
}