<form class="woocommerce-form woocommerce-form-login login"
      method="POST" action="{{ route('login') }}">
    @csrf

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <input type="email"
            class="woocommerce-Input woocommerce-Input--text input-text"
            name="email" id="email"
            placeholder="Địa chỉ email"
            value="{{ old('email') }}" required />
    </p>

    {{-- Ô nhập mật khẩu có icon --}}
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide"
        style="position: relative;">
        <input type="password"
            class="woocommerce-Input woocommerce-Input--text input-text"
            name="password" id="password"
            placeholder="Mật khẩu" required
            style="padding-right: 40px;" />
        <span id="togglePassword"
            style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888;">
            <i class="fa fa-eye"></i>
        </span>
    </p>

    <p class="form-row form-group" style="margin-top: 10px;">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline">
            <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                name="remember" type="checkbox" id="rememberme" />
            <span>Nhớ mật khẩu</span>
        </label>
    </p>

    <p class="form-actions">
        <button type="submit"
            class="woocommerce-button button woocommerce-form-login__submit"
            name="login">Đăng nhập</button>

        <span class="woocommerce-LostPassword lost_password">
            <a href="{{ route('forgot-password') }}">Quên mật khẩu?</a>
        </span>
    </p>

    <p class="form-actions-extra">
        Chưa có tài khoản?
        <a href="{{ route('register') }}" class="register-control">Đăng ký</a>
    </p>

    <hr>
    <p style="text-align:center;">
        <a href="{{ route('auth.google') }}" class="button">Đăng nhập bằng Google</a>
    </p>
</form>
