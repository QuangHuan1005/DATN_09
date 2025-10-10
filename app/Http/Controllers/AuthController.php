<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ĐĂNG KÝ
    |--------------------------------------------------------------------------
    */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Tài khoản đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
        } catch (Exception $e) {
            Log::error('Đăng ký lỗi: ' . $e->getMessage());
            return back()->with('error', 'Đăng ký thất bại, vui lòng thử lại.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ĐĂNG NHẬP / ĐĂNG XUẤT
    |--------------------------------------------------------------------------
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ], [
            'username.required' => 'Vui lòng nhập email hoặc tên đăng nhập.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự.',
        ]);

        // Cho phép đăng nhập bằng email hoặc tên người dùng
        $login_type = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $login_type => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Nếu là admin thì chuyển đến trang admin
            if (Auth::user()->is_admin ?? false) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Chào mừng quản trị viên!');
            }

            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đã đăng xuất.');
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Không thể kết nối đến Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make('google_login_' . now()), // tạo password ẩn
            ]);
        }

        Auth::login($user, true);

        return redirect('/')->with('success', 'Đăng nhập thành công bằng Google.');
    }

    /*
    |--------------------------------------------------------------------------
    | QUÊN / ĐẶT LẠI MẬT KHẨU
    |--------------------------------------------------------------------------
    */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Liên kết đặt lại mật khẩu đã được gửi tới email của bạn.')
            : back()->withErrors(['email' => 'Không thể gửi liên kết, vui lòng thử lại.']);
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
