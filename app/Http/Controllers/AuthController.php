<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect to admin dashboard if user is admin
            if (Auth::user()->is_admin ?? false) {
                return redirect()->intended(route('admin.dashboard'));
            }
            
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Xử lý đăng ký
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        return view('auth.forgot-password');
        // Gửi link reset password
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        // Xử lý đổi mật khẩu
    }

    public function logout()
    {
        // Xử lý đăng xuất
    }
}
