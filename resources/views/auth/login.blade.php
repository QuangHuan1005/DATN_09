@extends('master')

@section('content')
<div class="site-wrapper">
  <div id="site-content" class="site-content-wrapper">
    <div class="nova-container">
      <nav class="woocommerce-breadcrumb" style="margin:16px 0;">
        <a href="{{ url('/') }}">Home</a> <span class="delimiter">/</span> Đăng nhập
      </nav>

      <div class="nova-login-wrapper no_popup" style="display:flex; justify-content:center;">
        <div class="nova-form-container" style="width:100%; max-width:420px;">
          <h2 class="page-title" style="text-align:center; margin-bottom:18px;">Đăng nhập</h2>

          {{-- Thông báo phiên --}}
          @if (session('error'))
            <div style="color:#d00; margin-bottom:10px;">{{ session('error') }}</div>
          @endif
          @if (session('success'))
            <div style="color:#0a0; margin-bottom:10px;">{{ session('success') }}</div>
          @endif

          {{-- Lỗi validate --}}
          @if ($errors->any())
            <div style="color:#d00; margin-bottom:10px;">
              @foreach ($errors->all() as $error)
                <p style="margin:4px 0;">{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <form class="woocommerce-form woocommerce-form-login login"
                method="POST"
                action="{{ route('login') }}">
            @csrf

            {{-- Controller yêu cầu "username" (email hoặc tên đăng nhập) --}}
            <p class="woocommerce-form-row form-row form-row-wide">
              <input
                type="text"
                name="username"
                id="username"
                class="woocommerce-Input woocommerce-Input--text input-text"
                placeholder="Email hoặc tên đăng nhập"
                value="{{ old('username') }}"
                required
                autocomplete="username">
            </p>

            <p class="woocommerce-form-row form-row form-row-wide" style="position:relative;">
              <input
                type="password"
                name="password"
                id="password"
                class="woocommerce-Input woocommerce-Input--text input-text"
                placeholder="Mật khẩu"
                required
                autocomplete="current-password"
                style="padding-right:40px;">
              <span id="togglePassword"
                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                <i class="fa fa-eye"></i>
              </span>
            </p>

            <p class="form-row form-group" style="display:flex; justify-content:space-between; align-items:center;">
              <label class="woocommerce-form__label woocommerce-form-login__rememberme" style="display:flex; gap:8px; align-items:center;">
                <input class="woocommerce-form__input-checkbox" type="checkbox" name="remember" id="rememberme" value="1"
                  {{ old('remember') ? 'checked' : '' }}>
                <span>Nhớ mật khẩu</span>
              </label>

              <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            </p>

            <p class="form-actions" style="margin-top:8px;">
              <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" style="width:100%;">
                Đăng nhập
              </button>
            </p>

            <p class="form-actions-extra" style="text-align:center; margin-top:10px;">
              Chưa có tài khoản?
              <a href="{{ route('register') }}" class="register-control">Đăng ký</a>
            </p>

            <hr style="margin:18px 0;">
            <p style="text-align:center;">
              <a href="{{ route('auth.google') }}" class="button">Đăng nhập bằng Google</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Toggle mật khẩu --}}
<script>
  const togglePassword = document.querySelector("#togglePassword");
  const passwordField = document.querySelector("#password");
  if (togglePassword && passwordField) {
    togglePassword.addEventListener("click", function () {
      const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
    });
  }
</script>

{{-- Font Awesome (nếu chưa có trong layout) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection
