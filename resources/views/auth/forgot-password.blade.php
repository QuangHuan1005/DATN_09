@extends('master')

@section('content')
<body
    class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-lost-password woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">
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
                                        <span class="delimiter">/</span>Forgot Password
                                    </nav>
                                </div>

                                <article id="post-11" class="post-11 page type-page status-publish hentry">
                                    <div class="entry-content">
                                        <div class="woocommerce">
                                            <div class="container">
                                                <div class="woocommerce-notices-wrapper"></div>

                                                {{-- Hiển thị thông báo --}}
                                                @if (session('success'))
                                                    <div style="color:green; margin-bottom:10px;">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                                @if (session('error'))
                                                    <div style="color:red; margin-bottom:10px;">
                                                        {{ session('error') }}
                                                    </div>
                                                @endif
                                                @if ($errors->any())
                                                    <div style="color:red; margin-bottom:10px;">
                                                        @foreach ($errors->all() as $error)
                                                            <p>{{ $error }}</p>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                {{-- Form gửi link đặt lại mật khẩu --}}
                                                <form method="POST" action="{{ route('forgot-password.email') }}"
                                                    class="woocommerce-ResetPassword lost_reset_password">
                                                    @csrf

                                                    <p>Quên mật khẩu? Vui lòng nhập địa chỉ email của bạn, chúng tôi sẽ gửi
                                                        liên kết để đặt lại mật khẩu.</p>

                                                    <p class="woocommerce-form-row form-row form-row-first">
                                                        <label for="email">Địa chỉ Email&nbsp;
                                                            <span class="required" aria-hidden="true">*</span>
                                                        </label>
                                                        <input class="woocommerce-Input woocommerce-Input--text input-text"
                                                            type="email" name="email" id="email"
                                                            value="{{ old('email') }}"
                                                            placeholder="Nhập email của bạn..." required />
                                                    </p>

                                                    <div class="clear"></div>

                                                    <p class="woocommerce-form-row form-row">
                                                        <button type="submit" class="woocommerce-Button button">
                                                            Gửi liên kết đặt lại mật khẩu
                                                        </button>
                                                    </p>

                                                    <p class="form-actions-extra">
                                                        <a href="{{ route('login') }}" class="button" style="margin-top:10px;">
                                                            Quay lại đăng nhập
                                                        </a>
                                                    </p>
                                                </form>
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
