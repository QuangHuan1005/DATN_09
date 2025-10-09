@extends('master')

@section('content')
<body
    class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">

    <div class="site-wrapper">
        <div class="kitify-site-wrapper elementor-459kitify">
            @include('layouts.header')

            <div id="site-content" class="site-content-wrapper">
                <div class="nova-container">
                    <div class="grid-x">
                        <div class="cell small-12">
                            <div class="site-content">
                                <div class="page-header-content">
                                    <nav class="woocommerce-breadcrumb">
                                        <a href="{{ url('/') }}">Home</a>
                                        <span class="delimiter">/</span>Register
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

                                                        <div id="nova-register-form" class="cell large-4">
                                                            <h2 class="page-title">Đăng ký</h2>

                                                            {{-- Hiển thị thông báo lỗi và thành công --}}
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

                                                            {{-- Form đăng ký --}}
                                                            <form method="POST" action="{{ route('register') }}"
                                                                class="woocommerce-form woocommerce-form-register register">
                                                                @csrf

                                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                                    <input type="text"
                                                                        class="woocommerce-Input woocommerce-Input--text input-text"
                                                                        name="name" id="reg_name"
                                                                        placeholder="Họ tên"
                                                                        value="{{ old('name') }}" required />
                                                                </p>

                                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                                    <input type="email"
                                                                        class="woocommerce-Input woocommerce-Input--text input-text"
                                                                        name="email" id="reg_email"
                                                                        placeholder="Địa chỉ email"
                                                                        value="{{ old('email') }}" required />
                                                                </p>

                                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                                    <input type="password"
                                                                        class="woocommerce-Input woocommerce-Input--text input-text"
                                                                        name="password" id="reg_password"
                                                                        placeholder="Mật khẩu" required />
                                                                </p>

                                                                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                                    <input type="password"
                                                                        class="woocommerce-Input woocommerce-Input--text input-text"
                                                                        name="password_confirmation"
                                                                        id="reg_password_confirmation"
                                                                        placeholder="Nhập lại mật khẩu" required />
                                                                </p>

                                                                <div class="woocommerce-privacy-policy-text">
                                                                    <p>
                                                                        Dữ liệu cá nhân của bạn sẽ được sử dụng để hỗ trợ
                                                                        trải nghiệm của bạn trên trang web này, để quản lý
                                                                        tài khoản của bạn và theo
                                                                        <a href="#" class="woocommerce-privacy-policy-link"
                                                                            target="_blank">chính sách bảo mật</a>.
                                                                    </p>
                                                                </div>

                                                                <p class="form-actions">
                                                                    <button type="submit"
                                                                        class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit">
                                                                        Đăng ký
                                                                    </button>
                                                                </p>

                                                                <p class="form-actions-extra">
                                                                    Đã có tài khoản?
                                                                    <a href="{{ route('login') }}" class="login-control">Đăng nhập</a>
                                                                </p>

                                                                <hr>
                                                                <p style="text-align:center;">
                                                                    <a href="{{ route('auth.google') }}" class="button">
                                                                        Đăng nhập bằng Google
                                                                    </a>
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
