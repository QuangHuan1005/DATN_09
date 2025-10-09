<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

public function login(Request $request)
{
    $rules = [
        'email' => 'required|email|string|max:255',
        'password' => 'required|string',
    ];

    $messages = [
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Địa chỉ email không đúng định dạng.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ];
    $credentials = $request->validate($rules, $messages); 
    $user = User::where('email', $credentials['email'])->first();

    if ($user && $user->password === $credentials['password']) {
        
        Auth::login($user); 
        $request->session()->regenerate(); 
             return redirect()->intended('/'); 
    }
    
    return back()->withErrors([
        'email' => 'Thông tin đăng nhập không chính xác.', 
    ])->onlyInput('email');
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
