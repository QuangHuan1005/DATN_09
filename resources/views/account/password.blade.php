@extends('master')
@section('content')

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-edit-account woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb"><a
                                                href="https://mixtas.novaworks.net">Home</a><span
                                                class="delimiter">/</span><a
                                                href="https://mixtas.novaworks.net/my-account/">My account</a><span
                                                class="delimiter">/</span>Account details</nav>
                                        <h1 class="page-title">My account</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                <nav class="woocommerce-MyAccount-navigation" aria-label="Account pages">
                                                    <ul>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard">
                                                            <a href="https://mixtas.novaworks.net/my-account/">
                                                                Dashboard </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders">
                                                            <a href="https://mixtas.novaworks.net/my-account/orders/">
                                                                Orders </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--downloads">
                                                            <a href="https://mixtas.novaworks.net/my-account/downloads/">
                                                                Downloads </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address">
                                                            <a href="https://mixtas.novaworks.net/my-account/edit-address/">
                                                                Addresses </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account is-active">
                                                            <a href="https://mixtas.novaworks.net/my-account/edit-account/"
                                                                aria-current="page">
                                                                Account details </a>
                                                        </li>
                                                        <li
                                                            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
                                                            <a
                                                                href="https://mixtas.novaworks.net/my-account/customer-logout/?_wpnonce=f339348c3e">
                                                                Log out </a>
                                                        </li>
                                                    </ul>
                                                </nav>

                                                <div class="my-account">
                                                    @if (session('status'))
                                                        <div class="woocommerce-notices-wrapper">
                                                            <div class="woocommerce-info">{{ session('status') }}</div>
                                                        </div>
                                                    @endif

                                                    <form action="{{ route('account.update') }}" method="POST"
                                                        enctype="multipart/form-data" class="shopee-profile-form">
                                                        @csrf
                                                        @method('PUT')

                                                        <div style="display:flex; gap:32px; align-items:flex-start;">

                                                            {{-- Cột trái: Avatar --}}
                                                            <div style="flex:0 0 280px;">
                                                                <div
                                                                    style="border:1px solid #eee; padding:24px; text-align:center; border-radius:8px;">
                                                                    <img id="avatar-preview"
                                                                        src="{{ Auth::user()->avatar_url ?? asset('images/avatar-default.png') }}"
                                                                        alt="Avatar"
                                                                        style="width:160px; height:160px; border-radius:50%; object-fit:cover; display:block; margin:0 auto 12px;">
                                                                    <label for="avatar" class="button"
                                                                        style="display:inline-block; padding:8px 16px; border:1px solid #ccc; border-radius:6px; cursor:pointer;">
                                                                        Chọn ảnh
                                                                    </label>
                                                                    <input type="file" name="avatar" id="avatar"
                                                                        accept="image/*" style="display:none;">
                                                                    <p class="description"
                                                                        style="margin-top:8px; color:#666; font-size:12px;">
                                                                        PNG/JPG ≤ 2MB. Tỷ lệ 1:1 hiển thị đẹp.
                                                                    </p>
                                                                    @error('avatar')
                                                                        <div class="woocommerce-error" style="margin-top:6px;">
                                                                            {{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            {{-- Cột phải: Thông tin --}}
                                                            <div
                                                                style="flex:1; border:1px solid #eee; border-radius:8px; padding:24px;">

                                                                <h3
                                                                    style="margin-top:0; margin-bottom:16px; font-size:18px;">
                                                                    Hồ sơ của tôi</h3>
                                                                <p style="color:#666; margin-top:0;">Quản lý thông tin hồ sơ
                                                                    để bảo mật tài khoản</p>
                                                                <hr
                                                                    style="border:none; border-top:1px solid #f0f0f0; margin:16px 0 24px;">

                                                                {{-- Username --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:16px;">
                                                                    <label for="username"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Username<span
                                                                            class="required">*</span></label>
                                                                    <div style="flex:1;">
                                                                        <input type="text" id="username" name="username"
                                                                            class="input-text"
                                                                            value="{{ old('username', Auth::user()->username) }}"
                                                                            required autocomplete="username"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('username')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                {{-- Họ và tên --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:16px;">
                                                                    <label for="name"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Họ
                                                                        và tên<span class="required">*</span></label>
                                                                    <div style="flex:1;">
                                                                        <input type="text" id="name" name="name"
                                                                            class="input-text"
                                                                            value="{{ old('name', Auth::user()->name) }}"
                                                                            required autocomplete="name"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('name')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                {{-- Email --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:16px;">
                                                                    <label for="email"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Email<span
                                                                            class="required">*</span></label>
                                                                    <div style="flex:1;">
                                                                        <input type="email" id="email"
                                                                            name="email" class="input-text"
                                                                            value="{{ old('email', Auth::user()->email) }}"
                                                                            required autocomplete="email"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('email')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                {{-- Số điện thoại --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:16px;">
                                                                    <label for="phone"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Số
                                                                        điện thoại</label>
                                                                    <div style="flex:1;">
                                                                        <input type="tel" id="phone"
                                                                            name="phone" class="input-text"
                                                                            value="{{ old('phone', Auth::user()->phone) }}"
                                                                            placeholder="VD: 0981234567"
                                                                            autocomplete="tel-national"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('phone')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>


                                                                <hr
                                                                    style="border:none; border-top:1px solid #f0f0f0; margin:16px 0 24px;">

                                                                <h3 style="margin:0 0 16px; font-size:16px;">Đổi mật khẩu
                                                                </h3>

                                                                {{-- Mật khẩu hiện tại --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:12px;">
                                                                    <label for="password_current"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Mật
                                                                        khẩu hiện tại</label>
                                                                    <div style="flex:1;">
                                                                        <input type="password" id="password_current"
                                                                            name="password_current" class="input-text"
                                                                            autocomplete="off"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('password_current')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                {{-- Mật khẩu mới --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:12px;">
                                                                    <label for="password"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Mật
                                                                        khẩu mới</label>
                                                                    <div style="flex:1;">
                                                                        <input type="password" id="password"
                                                                            name="password" class="input-text"
                                                                            autocomplete="off"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                        @error('password')
                                                                            <div class="woocommerce-error">{{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                {{-- Xác nhận mật khẩu --}}
                                                                <div class="form-row"
                                                                    style="display:flex; gap:24px; margin-bottom:20px;">
                                                                    <label for="password_confirmation"
                                                                        style="flex:0 0 180px; text-align:right; line-height:38px;">Nhập
                                                                        lại mật khẩu</label>
                                                                    <div style="flex:1;">
                                                                        <input type="password" id="password_confirmation"
                                                                            name="password_confirmation"
                                                                            class="input-text" autocomplete="off"
                                                                            style="width:100%; height:38px; padding:8px 12px;">
                                                                    </div>
                                                                </div>

                                                                <div style="display:flex; gap:24px;">
                                                                    <div style="flex:0 0 180px;"></div>
                                                                    <div style="flex:1;">
                                                                        <button type="submit"
                                                                            class="woocommerce-Button button"
                                                                            style="height:40px; padding:0 20px;">Lưu thay
                                                                            đổi</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                @push('scripts')
                                                    <script>
                                                        document.getElementById('avatar')?.addEventListener('change', function(e) {
                                                            const [file] = e.target.files || [];
                                                            if (file) {
                                                                const url = URL.createObjectURL(file);
                                                                const img = document.getElementById('avatar-preview');
                                                                if (img) img.src = url;
                                                            }
                                                        });
                                                    </script>
                                                @endpush

                                            </div>
                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div><!-- .site-content-wrapper -->
                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        @endsection
