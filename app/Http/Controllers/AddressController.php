<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'addresses' => $addresses
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'address' => 'required|string|max:500',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'is_default' => 'boolean'
        ], [
            'phone.regex' => 'Số điện thoại chỉ chứa 0-9, +, -, khoảng trắng, ().',
        ]);

        $user = Auth::user();

        // Nếu địa chỉ mới là mặc định, cập nhật các địa chỉ khác thành không mặc định
        if ($request->is_default) {
            UserAddress::where('user_id', $user->id)->update(['is_default' => false]);
        }

        // Nếu đây là địa chỉ đầu tiên, tự động đặt làm mặc định
        $hasDefaultAddress = UserAddress::where('user_id', $user->id)->where('is_default', true)->exists();
        if (!$hasDefaultAddress) {
            $request->merge(['is_default' => true]);
        }

        $address = UserAddress::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'is_default' => $request->is_default ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm địa chỉ thành công!',
            'address' => $address
        ]);
    }

    public function update(Request $request, UserAddress $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]*$/',
            'address' => 'required|string|max:500',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'is_default' => 'boolean'
        ], [
            'phone.regex' => 'Số điện thoại chỉ chứa 0-9, +, -, khoảng trắng, ().',
        ]);

        // Nếu địa chỉ được cập nhật là mặc định, cập nhật các địa chỉ khác thành không mặc định
        if ($request->is_default) {
            UserAddress::where('user_id', Auth::id())
                      ->where('id', '!=', $address->id)
                      ->update(['is_default' => false]);
        }

        $address->update($request->only([
            'name', 'phone', 'address', 'province', 'district', 'ward', 'is_default'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật địa chỉ thành công!',
            'address' => $address
        ]);
    }

    public function destroy(UserAddress $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập.'], 403);
        }

        // Không cho phép xóa địa chỉ mặc định
        if ($address->is_default) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa địa chỉ mặc định. Vui lòng đặt địa chỉ khác làm mặc định trước.'
            ]);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa địa chỉ thành công!'
        ]);
    }

    public function show(UserAddress $address)
    {
        // Đảm bảo người dùng sở hữu địa chỉ này
        if ($address->user_id !== Auth::id()) {
            return response()->json(['message' => 'Không có quyền truy cập địa chỉ này.'], 403);
        }

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function setDefault(UserAddress $address)
    {
        // Kiểm tra quyền sở hữu
        if ($address->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập.'], 403);
        }

        // Cập nhật tất cả địa chỉ khác thành không mặc định
        UserAddress::where('user_id', Auth::id())
                  ->where('id', '!=', $address->id)
                  ->update(['is_default' => false]);

        // Đặt địa chỉ này làm mặc định
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt địa chỉ mặc định thành công!'
        ]);
    }
}
