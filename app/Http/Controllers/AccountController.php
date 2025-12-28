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
    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                // Đảm bảo username là duy nhất, trừ chính user hiện tại, và không bị xóa mềm
                Rule::unique('users', 'username')->ignore($user->id)->whereNull('deleted_at'),
                'regex:/^[a-zA-Z0-9_.-]+$/', // chỉ chữ/số/gạch dưới/gạch nối/dấu chấm
            ],
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]*$/'],
            'email'     => [
                'required',
                'email',
                'max:255',
                // Đảm bảo email là duy nhất, trừ chính user hiện tại
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ], [
            'username.regex' => 'Username chỉ gồm chữ, số, dấu chấm, gạch dưới hoặc gạch nối.',
            'phone.regex'    => 'Số điện thoại chỉ chứa 0-9, +, -, khoảng trắng, ().',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($user->image) {
                // Xóa ảnh đại diện cũ (nếu có)
                Storage::delete('public/' . $user->image);
            }
            // Lưu ảnh mới
            $imagePath = $request->file('image')->store('avatars', 'public');
            $data['image'] = $imagePath;
        }
        
        $user->update($data);
        
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