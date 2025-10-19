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
                                                href="https://mixtas.novaworks.net/my-account/">Tài khoản của tôi</a><span
                                                class="delimiter">/</span>Chi tiết tài khoản</nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
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
                                                <div class="woocommerce-MyAccount-content">
                                                    <div id="flash-success" class="alert alert-success"
                                                        style="display:none">Cập nhật thành công.</div>
                                                    <div id="flash-error" class="alert alert-error" style="display:none">Đã
                                                        có lỗi xảy ra.</div>
                                                    <form class="woocommerce-EditAccountForm edit-account"
                                                        action="{{ route('account.profile') }}"
                                                        enctype="multipart/form-data" method="post">
                                                        @csrf
                                                        @method('PUT')

                                                        <p
                                                            class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                            <label for="account_display_name">Tên đăng nhập&nbsp;<span
                                                                    class="required" aria-hidden="true">*</span></label>
                                                            <input type="text"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="account_display_name" id="account_display_name"
                                                                aria-describedby="account_display_name_description"
                                                                value="{{ auth()->user()->username ?? '' }}"
                                                                aria-required="true"> <span
                                                                id="account_display_name_description"><em>Đây sẽ là tên của
                                                                    bạn được hiển thị trong phần tài khoản và trong
                                                                    phần đánh giá</em></span>
                                                        </p>
                                                        <div class="clear"></div>
                                                        <p
                                                            class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                                            <label for="name">Tên&nbsp;<span class="required"
                                                                    aria-hidden="true">*</span></label>
                                                            <input type="text"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="name" id="name" autocomplete="given-name"
                                                                value="{{ old('name', auth()->user()->name ?? '') }}"
                                                                aria-required="true">
                                                            @error('name')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                        </p>
                                                        <p
                                                            class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                                                            <label for="phone">Số điện thoại&nbsp;<span class="required"
                                                                    aria-hidden="true">*</span></label>
                                                            <input type="tel"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="phone" id="phone" autocomplete="family-name"
                                                                value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                                                aria-required="true">
                                                            @error('phone')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                        </p>
                                                        <div class="clear"></div>

                                                        <p
                                                            class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                            <label for="email">Địa chỉ email&nbsp;<span class="required"
                                                                    aria-hidden="true">*</span></label>
                                                            <input type="email"
                                                                class="woocommerce-Input woocommerce-Input--email input-text"
                                                                name="email" id="email" autocomplete="email"
                                                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                                                aria-required="true">
                                                            @error('email')
                                                            <div class="error">{{ $message }}</div>
                                                        @enderror
                                                        </p>



                                                        <div class="clear"></div>


                                                        <p>
                                                            <input type="hidden" id="save-account-details-nonce"
                                                                name="save-account-details-nonce"
                                                                value="0ea55554c6"><input type="hidden"
                                                                name="_wp_http_referer" value="/my-account/edit-account/">
                                                            <button type="submit" class="woocommerce-Button button"
                                                                name="save_account_details" value="Save changes">Lưu</button>
                                                            <input type="hidden" name="action"
                                                                value="save_account_details">
                                                        </p>

                                                    </form>

                                                </div>
                                            </div>

                                            <script>
                                                // Xem trước avatar
                                                const input = document.getElementById('avatar');
                                                const preview = document.getElementById('avatarPreview');
                                                if (input) {
                                                    input.addEventListener('change', e => {
                                                        const file = e.target.files?.[0];
                                                        if (!file) return;
                                                        if (file.size > 2048 * 2048) {
                                                            alert('Ảnh vượt quá 2MB. Hãy chọn ảnh nhỏ hơn.');
                                                            input.value = '';
                                                            return;
                                                        }
                                                        const reader = new FileReader();
                                                        reader.onload = ev => {
                                                            preview.src = ev.target.result;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    });
                                                }
                                            </script>


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
