<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị</title>
    <link rel="stylesheet" href="{{ asset('css/adminLogin.css') }}">
    <style>
        .error-messages {
            color: #ff4d4f;
            font-size: 15px;
            display: block;
            margin-top: 5px;
            margin-left: 2px;
        }

        .input-wrapper input.is-invalid {
            border-color: #ff4d4f !important;
        }

        .form-general-error {
            background-color: #ffeaea;
            border: 1px solid #ff4d4f;
            color: #ff4d4f;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Đăng nhập Quản trị</h2>
                <p>Nhập thông tin để truy cập hệ thống quản lý</p>
            </div>
            @error('email')
                @if ($message != 'Vui lòng nhập địa chỉ email.' && $message != 'Địa chỉ email không đúng định dạng.')
                    <div class="form-general-error">
                        {{ $message }}
                    </div>
                @endif
            @enderror
            <form class="login-form" method="POST" action="{{ route('admin.login') }}" novalidate>
                @csrf
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" required
                            autocomplete="email">
                        <label for="email">Địa chỉ Email</label>
                    </div>
                    @error('email')
                        @php
                            $isValidationError = ($message == 'Vui lòng nhập địa chỉ email.' || $message == 'Địa chỉ email không đúng định dạng.');
                        @endphp
                        @if ($isValidationError)
                            <span class="error-messages">{{ $message }}</span>
                        @endif
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required
                            autocomplete="current-password">
                        <label for="password">Mật khẩu</label>
                        <button type="button" class="password-toggle" id="passwordToggle"
                            aria-label="Hiện/Ẩn mật khẩu">
                            <span class="eye-icon"></span>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-messages">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-options">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkbox-label">
                            <span class="checkmark"></span>
                            Nhớ đăng nhập
                        </span>
                    </label>
                    <a href="{{ route('forgot-password') }}" class="forgot-password">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Đăng nhập</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

            <div class="signup-link">
                <p>Không có tài khoản? (Liên hệ Admin)</p>
            </div>

        </div>
    </div>

    <script>
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        if (passwordToggle) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('is-visible');
            });
        }

        const inputs = document.querySelectorAll('.input-wrapper input');
        inputs.forEach(input => {
            if (input.value.length > 0) {
                input.classList.add('has-value');
            }
            input.addEventListener('input', () => {
                if (input.value.length > 0) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });

            input.addEventListener('change', () => {
                if (input.value.length > 0) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        });
    </script>
</body>

</html>
