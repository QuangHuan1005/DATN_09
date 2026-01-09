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
                                    <nav class="woocommerce-breadcrumb">
                                        <a href="{{ url('/') }}">Home</a>
                                        <span class="delimiter">/</span>
                                        <a href="{{ route('account.dashboard') }}">Tài khoản của tôi</a>
                                        <span class="delimiter">/</span>Chi tiết tài khoản
                                    </nav>
                                    <h1 class="page-title">Tài khoản của tôi</h1>
                                </div>
                                <article id="post-11" class="post-11 page type-page status-publish hentry">
                                    <div class="entry-content">
                                        <div class="woocommerce">
                                            @include('account.partials.navigation')
                                            
                                            <div class="woocommerce-MyAccount-content" style="position: relative;">
                                                
                                                {{-- NÚT BẬT CHẾ ĐỘ SỬA TOÀN BỘ FORM --}}
                                                <div style="text-align: right; margin-bottom: 20px;">
                                                    <button type="button" id="master-edit-btn" 
                                                        style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 5px; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                                                        <i class="fa fa-user-edit"></i> Chỉnh sửa thông tin
                                                    </button>
                                                </div>

                                                <div class="woocommerce-notices-wrapper">
                                                    @if ($errors->any())
                                                        <ul class="alert woocommerce-error" role="alert" tabindex="-1">
                                                            @foreach ($errors->all() as $error)
                                                                <li><strong>Lỗi:</strong> {{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    @if (session('success'))
                                                        <ul class="woocommerce-message" role="status" tabindex="-1">
                                                            <li><strong>Thành công:</strong> {{ session('success') }}</li>
                                                        </ul>
                                                    @endif
                                                </div>

                                                <form id="profile-form" class="woocommerce-EditAccountForm edit-account"
                                                    action="{{ route('account.update') }}" method="POST"
                                                    enctype="multipart/form-data" style="opacity: 0.7; pointer-events: none; transition: all 0.4s ease;">
                                                    @csrf

                                                    {{-- Ảnh đại diện --}}
                                                    <p class="woocommerce-form-row form-row-wide">
                                                        <label>Ảnh đại diện</label>
                                                        <div style="text-align:center;">
                                                            <img id="avatar-preview"
                                                                src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/default-avatar.png') }}" 
                                                                alt="Avatar"
                                                                style="width:120px;height:120px;border-radius:50%;object-fit:cover;display:block;margin:0 auto 12px; border: 3px solid #eee; transition: border-color 0.3s;">
                                                            
                                                            <label for="image" id="label-image" class="button"
                                                                style="display:none; padding:8px 16px;border:1px solid #ccc;border-radius:6px;cursor:pointer; background:#f7f7f7;">
                                                                Thay đổi ảnh
                                                            </label>
                                                            <input type="file" name="image" id="image" accept="image/*" style="display:none;" onchange="previewImage(this)">
                                                        </div>
                                                    </p>

                                                    <div class="clear"></div>

                                                    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                                        <label for="name">Họ tên <span class="required">*</span></label>
                                                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text readonly-style"
                                                            name="name" id="name" value="{{ old('name', $user->name) }}" readonly>
                                                    </p>

                                                    <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                                                        <label for="phone">Số điện thoại</label>
                                                        <input type="tel" class="woocommerce-Input woocommerce-Input--text input-text readonly-style"
                                                            name="phone" id="phone" value="{{ old('phone', $user->phone) }}" readonly>
                                                    </p>

                                                    <div class="clear"></div>

                                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                        <label for="email">Địa chỉ email <span class="required">*</span></label>
                                                        <input type="email" class="woocommerce-Input woocommerce-Input--email input-text readonly-style"
                                                            name="email" id="email" value="{{ old('email', $user->email) }}" readonly>
                                                    </p>

                                                    {{-- THÔNG TIN NGÂN HÀNG --}}
                                                    <fieldset style="margin-top: 30px; border: 1px solid #ddd; padding: 25px 20px 20px; border-radius: 8px; background-color: #fcfcfc;">
                                                        <legend style="padding: 0 10px; font-weight: bold; color: #333; font-size: 1.1em; background: #fff;">
                                                            Thông tin ngân hàng nhận tiền hoàn
                                                        </legend>
                                                        
                                                        @php $bank = $user->bankAccount; @endphp

                                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                                            <label for="bank_name">Tên ngân hàng <span class="required">*</span></label>
                                                            <input type="text" class="woocommerce-Input input-text readonly-style" 
                                                                name="bank_name" id="bank_name" placeholder="VD: Vietcombank, MB Bank..."
                                                                value="{{ old('bank_name', $bank->bank_name ?? '') }}" readonly>
                                                        </p>

                                                        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                                                            <label for="account_number">Số tài khoản <span class="required">*</span></label>
                                                            <input type="text" class="woocommerce-Input input-text readonly-style" 
                                                                name="account_number" id="account_number" 
                                                                value="{{ old('account_number', $bank->account_number ?? '') }}" readonly>
                                                        </p>

                                                        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
                                                            <label for="account_holder">Tên chủ tài khoản <span class="required">*</span></label>
                                                            <input type="text" class="woocommerce-Input input-text readonly-style" 
                                                                name="account_holder" id="account_holder" placeholder="VIET HOA KHONG DAU"
                                                                value="{{ old('account_holder', $bank->account_holder ?? '') }}" readonly 
                                                                style="text-transform: uppercase;">
                                                        </p>
                                                        
                                                        <input type="hidden" name="is_default" value="1">
                                                    </fieldset>

                                                    <p class="mt-4" id="submit-container" style="display: none; text-align: center;">
                                                        <button type="submit" class="woocommerce-Button button" style="padding: 15px 50px; font-weight: bold; border-radius: 5px; background-color: #10b981; color: white;">
                                                            LƯU TẤT CẢ THAY ĐỔI
                                                        </button>
                                                        <button type="button" id="cancel-edit-btn" style="margin-left: 10px; padding: 15px 20px; background: #9ca3af; border: none; color: white; border-radius: 5px; font-weight: bold;">
                                                            HỦY
                                                        </button>
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
            <div class="nova-overlay-global"></div>
        </div>
        @include('layouts.js')

        <style>
            .readonly-style {
                background-color: #f9fafb !important;
                border: 1px solid #e5e7eb !important;
                cursor: default;
            }
            .editing-style {
                background-color: #ffffff !important;
                border: 1px solid #3b82f6 !important;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            }
        </style>

        <script>
            // Xem trước ảnh đại diện
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatar-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const masterEditBtn = document.getElementById('master-edit-btn');
                const cancelBtn = document.getElementById('cancel-edit-btn');
                const form = document.getElementById('profile-form');
                const inputs = form.querySelectorAll('input:not([type="hidden"])');
                const submitContainer = document.getElementById('submit-container');
                const labelImage = document.getElementById('label-image');
                const avatarImg = document.getElementById('avatar-preview');

                // HÀM BẬT CHẾ ĐỘ SỬA
                masterEditBtn.addEventListener('click', function() {
                    // 1. Mở khóa form (opacity & pointer-events)
                    form.style.opacity = "1";
                    form.style.pointerEvents = "auto";

                    // 2. Mở khóa toàn bộ inputs
                    inputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.classList.remove('readonly-style');
                        input.classList.add('editing-style');
                    });

                    // 3. Hiện nút chọn ảnh & Nút Lưu
                    labelImage.style.display = "inline-block";
                    submitContainer.style.display = "block";
                    avatarImg.style.borderColor = "#3b82f6";

                    // 4. Ẩn nút sửa chính
                    this.style.display = "none";
                });

                // HÀM HỦY (Tải lại trang)
                cancelBtn.addEventListener('click', function() {
                    if(confirm("Các thay đổi chưa lưu sẽ bị mất. Bạn có chắc chắn?")) {
                        window.location.reload();
                    }
                });
            });
        </script>
</body>
@endsection