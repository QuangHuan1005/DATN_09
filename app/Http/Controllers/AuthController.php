<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\PasswordReset;
use Exception;

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
            $user = User::create([
                'role_id'     => 2,              // member
                'ranking_id'  => 1,              // Bronze (nếu có)
                'name'        => $request->name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'is_verified' => 1,              // tùy bạn: auto verify
            ]);

            return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');

        } catch (Exception $e) {
            Log::error('Lỗi đăng ký: ' . $e->getMessage());

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
        $credentials = $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required|string',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();


            // Nếu là admin thì chuyển đến trang admin
            if (Auth::user()->role_id == 1) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Chào mừng quản trị viên!');
            }

            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');

        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
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
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Không thể kết nối đến Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'role_id'     => 2, // member
                'ranking_id'  => 1, // Bronze
                'name'        => $googleUser->getName(),
                'email'       => $googleUser->getEmail(),
                'password'    => Hash::make('google_login_'.now()),
                'is_verified' => 1,
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
            ? back()->with('success', 'Liên kết đặt lại mật khẩu đã được gửi đến email của bạn.')
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
