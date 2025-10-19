<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Ranking;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng (không gồm admin)
     */
   public function index(Request $request)
{
    $query = User::withTrashed()->where('role_id', '!=', 1);

    // 🔍 Tìm kiếm theo tên, email hoặc số điện thoại
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%");
        });
    }

    // 📌 Lọc theo vai trò (role_id)
    if ($role = $request->input('role_id')) {
        $query->where('role_id', $role);
    }

    // 📄 Phân trang
    $users = $query->orderByDesc('created_at')->paginate(3)->withQueryString();

    $roles = Role::all();

    return view('admin.users.index', compact('users', 'roles'));
}


    /**
     * Hiển thị form sửa người dùng
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Không cho sửa user admin khác
        if ($user->isAdmin()) {
            abort(403, 'Bạn không được phép sửa tài khoản Admin khác');
        }

        $roles = Role::all();
      //  $rankings = Ranking::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Xử lý cập nhật người dùng
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            abort(403, 'Bạn không được phép sửa tài khoản Admin khác');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'ranking_id' => 'nullable|exists:rankings,id',
            'is_locked' => 'nullable|boolean',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        // Cập nhật thông tin cơ bản
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->role_id = $validated['role_id'];
        $user->ranking_id = $validated['ranking_id'] ?? null;
        $user->is_locked = $validated['is_locked'] ?? false;

        // Thay đổi mật khẩu nếu có
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/users'), $filename);
            $user->image = $filename;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công');
    }

    /**
     * Khóa hoặc mở khóa tài khoản người dùng
     */
    public function toggleLock($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Không thể khóa tài khoản Admin!');
        }

        $user->is_locked = !$user->is_locked;
        $user->save();

        return redirect()->back()->with('success', 'Thay đổi trạng thái khóa tài khoản thành công.');
    }

    public function restore($id)
{
    $user = User::withTrashed()->findOrFail($id);

    if ($user->isAdmin()) {
        return redirect()->back()->with('error', 'Không thể khôi phục tài khoản Admin!');
    }

    if ($user->trashed()) {
        $user->restore();
        return redirect()->back()->with('success', 'Khôi phục người dùng thành công.');
    }

    return redirect()->back()->with('info', 'Người dùng chưa bị ẩn.');
}


    /**
     * (Tuỳ chọn) Xóa mềm người dùng
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Không thể xóa tài khoản Admin!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Ẩn người dùng thành công.');
    }
}
