<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|string|max:255',
            'password' => 'required|string',
        ];
        $messages = [
            'email.required' => "Vui lòng nhập địa chỉ email.",
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ];
        $credentials = $request->validate($rules, $messages);
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->password === $credentials['password']) {
            if ($user->role_id !== 1 && $user->role_id !== 2) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Bạn không có quyền truy cập quản trị.',
                ])->onlyInput('email');
            }

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }
}
