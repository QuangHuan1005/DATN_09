@extends('master')

@section('content')
<body
    class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">

    <div class="site-wrapper">
        <div class="kitify-site-wrapper elementor-459kitify">
            {{-- Header --}}
            @include('layouts.header')

            <div id="site-content" class="site-content-wrapper">
                <div class="nova-container">
                    <div class="grid-x">
                        <div class="cell small-12">
                            <div class="site-content">
                                <div class="page-header-content">
                                    <nav class="woocommerce-breadcrumb">
                                        <a href="{{ url('/') }}">Home</a>
                                        <span class="delimiter">/</span>Login
                                    </nav>
                                </div>

                                <article id="post-11" class="post-11 page type-page status-publish hentry">
                                    <div class="entry-content">
                                        <div class="woocommerce">
                                            <div class="container">
                                                <div class="woocommerce-notices-wrapper"></div>

                                                <div class="nova-login-wrapper no_popup">
                                                    <div class="nova-form-container grid-x grid-padding-x">
                                                        <div class="login-divider cell large-4">
                                                            <div></div>
                                                        </div>

                                                        <div id="nova-login-form" class="cell large-4">
                                                            <h2 class="page-title">Đăng nhập</h2>

                                                            {{-- Thông báo --}}
                                                            @if (session('error'))
                                                                <div style="color:red; margin-bottom:10px;">
                                                                    {{ session('error') }}
                                                                </div>
                                                            @endif
                                                            @if (session('success'))
                                                                <div style="color:green; margin-bottom:10px;">
                                                                    {{ session('success') }}
                                                                </div>
                                                            @endif
                                                            @if ($errors->any())
                                                                <div style="color:red; margin-bottom:10px;">
                                                                    @foreach ($errors->all() as $error)
                                                                        <p>{{ $error }}</p>
                                                                    @endforeach
                                                                </div>
                                                            @endif

                                                            {{-- Form đăng nhập --}}
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

                                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                                    <input type="password"
                                                                        class="woocommerce-Input woocommerce-Input--text input-text"
                                                                        name="password" id="password"
                                                                        placeholder="Mật khẩu" required />
                                                                </p>

                                                                <p class="form-row form-group">
                                                                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline">
                                                                        <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                                                            name="remember" type="checkbox"
                                                                            id="rememberme" />
                                                                        <span>Nhớ mật khẩu</span>
                                                                    </label>
                                                                </p>

                                                                <p class="form-actions">
                                                                    <button type="submit"
                                                                        class="woocommerce-button button woocommerce-form-login__submit"
                                                                        name="login">Đăng nhập</button>

                                                                    <span class="woocommerce-LostPassword lost_password">
                                                                        <a href="{{ route('forgot-password') }}">
                                                                            Quên mật khẩu?
                                                                        </a>
                                                                    </span>
                                                                </p>

                                                                <p class="form-actions-extra">
                                                                    Chưa có tài khoản?
                                                                    <a href="{{ route('register') }}"
                                                                        class="register-control">Đăng ký</a>
                                                                </p>

                                                                <hr>
                                                                <p style="text-align:center;">
                                                                    <a href="{{ route('auth.google') }}"
                                                                        class="button">Đăng nhập bằng Google</a>
                                                                </p>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .entry-content -->
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            @include('layouts.footer')
        </div>
    </div>
@endsection
