@extends('master')
@section('content')

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">
        <div class="site-wrapper">
            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb">
                                            <a href="/">Home</a><span class="delimiter">/</span>Tài khoản của tôi
                                        </nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')


                                                <div class="woocommerce-MyAccount-content">
                                                    {{-- <div class="woocommerce-notices-wrapper">
                                                        <div class="woocommerce-info">
                                                            Your account with Mixtas is using a temporary password. We
                                                            emailed you a link to change your password. </div>
                                                    </div> --}}

                                                    <p>
                                                        Xin chào,
                                                        <strong>{{ $user->name }}!</strong> (nếu
                                                        không phải
                                                        <strong>{{ Str::afterLast(Auth::user()->name, ' ') }}</strong>?

                                                        <a href=""
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                                            Đăng xuất</a>)

                                                    <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                                        style="display:none;">
                                                        @csrf
                                                    </form>

                                                    </p>

                                                    <p>
                                                        Từ bảng điều khiển tài khoản của bạn, bạn có thể xem <a
                                                            href="https://mixtas.novaworks.net/my-account/orders/">đơn hàng
                                                            gần đây</a>, <a
                                                            href="https://mixtas.novaworks.net/my-account/edit-address/">địa
                                                            chỉ giao hàng
                                                            và thanh toán </a>
                                                        <a href="">chỉnh
                                                            sửa mật khẩu</a> và <a
                                                            href="https://mixtas.novaworks.net/my-account/edit-account/">thông
                                                            tin tài khoản của bạn</a>.
                                                    </p>

                                                </div>

                                            </div>
                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        @endsection
