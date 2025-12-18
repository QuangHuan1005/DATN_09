@extends('master')
@section('content')
    <body class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit" data-elementor-device-mode="laptop">

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
                                            <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                                            <a href="{{ route('orders.index') }}">My account</a><span class="delimiter">/</span>
                                            <a href="{{ route('orders.show', $order->id) }}">Order {{ $order->order_code }}</a><span class="delimiter">/</span>Yêu cầu hoàn hàng
                                        </nav>
                                        <h1 class="page-title">Yêu cầu hoàn hàng</h1>
                                    </div>

                                    <article class="hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                @include('account.partials.navigation')

                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper">
                                                        @if (session('error'))
                                                            <div class="woocommerce-error">{{ session('error') }}</div>
                                                        @endif
                                                        @if (session('success'))
                                                            <div class="woocommerce-message">{{ session('success') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="woocommerce-order-details">
                                                        <div class="order-header">
                                                            <div><strong>Đơn hàng: {{ $order->order_code }}</strong></div>
                                                            <div>Tổng tiền: ₫{{ number_format($order->total_amount) }}</div>
                                                        </div>

                                                        <form method="POST" action="{{ route('orders.return.store', $order->id) }}" enctype="multipart/form-data">
                                                            @csrf

                                                            @php
                                                                // ✅ Kiểm tra tổng số lượng sản phẩm (không chỉ đếm records)
                                                                $totalQuantity = $order->details->sum('quantity');
                                                                $shouldShowSelection = $order->details->count() >= 2 || $totalQuantity >= 2;
                                                            @endphp
                                                            
                                                                 {{-- ✅ Sử dụng biến $groupedDetails đã được gom nhóm từ Controller --}}
@if(count($groupedDetails) > 0)
    <div class="woocommerce-order-details__field">
        <label style="font-weight: bold; margin-bottom: 15px; display: block;">
            Chọn sản phẩm muốn hoàn trả <span class="required">*</span>
        </label>
        
        <div class="product-selection-container" style="background: #f9f9f9; padding: 15px; border-radius: 8px;">
            @foreach($groupedDetails as $variantId => $item)
    <div class="product-select-item" style="display: flex; align-items: center; background: #fff; margin-bottom: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        
        {{-- Checkbox chọn sản phẩm --}}
        <div style="margin-right: 15px;">
            <input type="checkbox" 
                   name="variant_ids[]" 
                   value="{{ $variantId }}" 
                   class="product-checkbox"
                   id="variant_{{ $variantId }}">
        </div>

        {{-- Ảnh sản phẩm --}}
        <div style="margin-right: 15px;">
            <img src="{{ asset('storage/' . $item->image) }}" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
        </div>

        {{-- Thông tin tên & biến thể --}}
        <div style="flex: 1;">
            <label for="variant_{{ $variantId }}" style="margin: 0; cursor: pointer;">
                <span style="font-weight: 600; display: block; line-height: 1.2;">{{ $item->product_name }}</span>
                <small class="text-muted">{{ $item->variant_label }}</small>
            </label>
            <div style="color: #d63384; font-weight: bold;">{{ number_format($item->price) }}₫</div>
        </div>

        {{-- Ô nhập số lượng --}}
        <div style="width: 130px; text-align: right;">
            <small style="display: block; color: #666; font-size: 11px;">Số lượng hoàn</small>
            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 5px;">
                <input type="number" 
                       name="quantities[{{ $variantId }}]" 
                       value="1" 
                       min="1" 
                       max="{{ $item->max_quantity }}" 
                       class="input-qty"
                       id="qty_{{ $variantId }}" {{-- QUAN TRỌNG --}}
                       data-variant-id="{{ $variantId }}"
                       data-price="{{ $item->price }}" {{-- QUAN TRỌNG: Script dùng cái này để tính --}}
                       style="width: 50px; padding: 2px 5px; text-align: center; border: 1px solid #ccc;">
                <span style="font-size: 12px; color: #999;">/ {{ $item->max_quantity }}</span>
            </div>
        </div>
    </div>
@endforeach

            <div class="select-all-container" style="margin-top: 10px; padding-left: 10px;">
                <label style="cursor: pointer; font-size: 14px;">
                    <input type="checkbox" id="selectAllProducts">
                    <span style="margin-left: 5px;">Chọn tất cả sản phẩm</span>
                </label>
            </div>
        </div>
        <div class="error-message" id="product-selection-error" style="color: red; font-size: 12px; margin-top: 5px;"></div>
    </div>
@endif

                                                            <div class="woocommerce-order-details__field">
                                                                <label for="reason">Lý do hoàn hàng <span class="required">*</span></label>
                                                                <select name="reason" id="reason" class="form-select">
                                                                    <option value="" disabled selected>-- Chọn lý do hoàn hàng --</option>
                                                                    <option value="Tôi không còn nhu cầu mua nữa" {{ old('reason') == 'Tôi không còn nhu cầu mua nữa' ? 'selected' : '' }}>Tôi không còn nhu cầu mua nữa</option>
                                                                    <option value="Tôi đặt nhầm sản phẩm / màu sắc / kích thước" {{ old('reason') == 'Tôi đặt nhầm sản phẩm / màu sắc / kích thước' ? 'selected' : '' }}>Tôi đặt nhầm sản phẩm / màu sắc / kích thước</option>
                                                                    <option value="Tôi muốn thay đổi địa chỉ nhận hàng" {{ old('reason') == 'Tôi muốn thay đổi địa chỉ nhận hàng' ? 'selected' : '' }}>Tôi muốn thay đổi địa chỉ nhận hàng</option>
                                                                    <option value="Tôi muốn thay đổi phương thức thanh toán" {{ old('reason') == 'Tôi muốn thay đổi phương thức thanh toán' ? 'selected' : '' }}>Tôi muốn thay đổi phương thức thanh toán</option>
                                                                    <option value="Shop xử lý đơn quá chậm" {{ old('reason') == 'Shop xử lý đơn quá chậm' ? 'selected' : '' }}>Shop xử lý đơn quá chậm</option>
                                                                    <option value="Sản phẩm hết hàng" {{ old('reason') == 'Sản phẩm hết hàng' ? 'selected' : '' }}>Sản phẩm hết hàng</option>
                                                                    <option value="Thời gian giao hàng dự kiến quá lâu" {{ old('reason') == 'Thời gian giao hàng dự kiến quá lâu' ? 'selected' : '' }}>Thời gian giao hàng dự kiến quá lâu</option>
                                                                    <option value="Khác" {{ old('reason') == 'Khác' ? 'selected' : '' }}>Khác</option>
                                                                </select>
                                                                <div class="error-message" id="reason-error"></div>
                                                            </div>

                                                            <div class="woocommerce-order-details__field">
                                                                <label for="notes">Ghi chú bổ sung</label>
                                                                <textarea name="notes" id="notes" rows="3"
                                                                    placeholder="Thông tin bổ sung (tùy chọn)...">{{ old('notes') }}</textarea>
                                                            </div>

                                                            <div class="woocommerce-order-details__field">
                                                                <label for="return_address">Địa chỉ nhận hàng của Friday</label>
                                                                <input type="text" name="return_address" id="return_address" value="Số nhà 123, đường Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội" readonly>
                                                                <small>Quý khách vui lòng gửi hàng về đúng địa chỉ này để chúng tôi xác nhận và tiến hành hoàn tiền</small>
                                                            </div>

                                                            <div class="woocommerce-order-details__field">
                                                                <label for="refund_account_id">Chọn tài khoản nhận hoàn tiền <span class="required">*</span></label>
                                                                <select name="refund_account_id" id="refund_account_id" class="form-select">
                                                                    <option value="" disabled selected>-- Chọn tài khoản nhận tiền --</option>
                                                                    @foreach($userBankAccounts ?? [] as $account)
                                                                        <option value="{{ $account->id }}"
                                                                                {{ old('refund_account_id') == $account->id ? 'selected' : '' }}>
                                                                            {{ $account->bank_name }} - {{ $account->masked_account_number }} ({{ $account->account_holder }})
                                                                            @if($account->is_default)
                                                                                <em>(Mặc định)</em>
                                                                            @endif
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small>Chọn tài khoản ngân hàng để nhận tiền hoàn trả</small>
                                                                <div class="error-message" id="refund_account_id-error"></div>
                                                            </div>

                                                            <div class="woocommerce-order-details__field">
                                                                <label for="images">Hình ảnh minh họa (tối đa 5 ảnh) <span class="required">*</span></label>
                                                                <input type="file" name="images[]" id="images" multiple accept="image/*" style="display: none;">
                                                                <button type="button" id="selectImagesBtn" class="woocommerce-button button button-select-images">
                                                                    Chọn hình ảnh
                                                                </button>
                                                                <small>Chọn ít nhất 1 hình ảnh (JPEG, PNG, JPG, GIF - tối đa 2MB/ảnh)</small>
                                                                <div class="error-message" id="images-error"></div>
                                                                <div id="imagePreviewContainer" class="image-preview-container"></div>
                                                            </div>

                                                            {{-- Tổng số tiền hoàn --}}
                                                            <div class="refund-amount-summary">
                                                                <div class="refund-amount-container">
                                                                    <span class="refund-amount-label">Tổng số tiền hoàn:</span>
                                                                    <span class="refund-amount-value" id="refundAmountDisplay">
                                                                        {{ number_format($order->total_amount) }}₫
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="woocommerce-order-details__actions">
                                                                <button type="submit" class="woocommerce-button button">Gửi yê cầu hoàn hàng</button>
                                                                <a href="{{ route('orders.show', $order->id) }}" class="woocommerce-button button">Quay lại</a>
                                                            </div>
                                                        </form>
                                                    </div>
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
        </div>

   <script>
document.addEventListener('DOMContentLoaded', function() {
    // === CẤU HÌNH BIẾN ===
    let selectedFiles = []; // Mảng chứa file thực tế để gửi lên server
    const imageInput = document.getElementById('images');
    const selectBtn = document.getElementById('selectImagesBtn');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const refundDisplay = document.getElementById('refundAmountDisplay');

    // === PHẦN 1: CHỌN VÀ HIỂN THỊ ẢNH ===
    if (selectBtn && imageInput) {
        // Khi bấm nút "Chọn hình ảnh" -> Kích hoạt ô chọn file ẩn
        selectBtn.addEventListener('click', function(e) {
            e.preventDefault();
            imageInput.click();
        });

        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            // Giới hạn tối đa 5 ảnh
            if (selectedFiles.length + files.length > 5) {
                alert('Bạn chỉ được chọn tối đa 5 ảnh.');
                return;
            }

            files.forEach(file => {
                // Kiểm tra định dạng ảnh
                if (!file.type.startsWith('image/')) return;

                selectedFiles.push(file);

                // Tạo giao diện Preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.style = "display:inline-block; position:relative; margin:10px 10px 0 0;";
                    div.innerHTML = `
                        <img src="${event.target.result}" style="width:80px; height:80px; object-fit:cover; border-radius:5px; border:1px solid #ddd;">
                        <span class="remove-btn" style="position:absolute; top:-10px; right:-10px; background:red; color:white; border-radius:50%; width:20px; height:20px; text-align:center; cursor:pointer; line-height:18px; font-weight:bold;">×</span>
                    `;

                    // Xử lý xóa ảnh khi bấm nút x
                    div.querySelector('.remove-btn').onclick = function() {
                        selectedFiles = selectedFiles.filter(f => f !== file);
                        div.remove();
                    };
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            // Reset giá trị input để có thể chọn lại cùng 1 file vừa xóa
            imageInput.value = '';
        });
    }

    // === PHẦN 2: TÍNH TIỀN & XỬ LÝ SỐ LƯỢNG (Cho phép nhập số 2) ===
    function updateRefundTotal() {
        let total = 0;
        const checkedItems = document.querySelectorAll('.product-checkbox:checked');
        
        checkedItems.forEach(cb => {
            const qtyInput = document.getElementById('qty_' + cb.value);
            if (qtyInput) {
                const price = parseFloat(qtyInput.dataset.price.replace(/[^0-9.-]+/g, "")) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                total += (price * qty);
            }
        });

        if (refundDisplay) {
            refundDisplay.innerText = new Intl.NumberFormat('vi-VN').format(total) + '₫';
        }
    }

    // Lắng nghe sự kiện gõ số lượng (Sửa lỗi không gõ được số 2)
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('input-qty')) {
            const input = e.target;
            const max = parseInt(input.getAttribute('max'));
            
            if (input.value === "") return; // Để trống cho khách gõ số mới

            let val = parseInt(input.value);
            if (val > max) input.value = max;
            if (val < 1) input.value = 1;

            // Tự động check vào sản phẩm
            const vId = input.dataset.variantId;
            const cb = document.getElementById('variant_' + vId);
            if (cb) cb.checked = true;

            updateRefundTotal();
        }
    });

    // Khi rời khỏi ô nhập liệu, nếu trống thì về 1
    document.addEventListener('blur', function(e) {
        if (e.target.classList.contains('input-qty')) {
            if (e.target.value === "") {
                e.target.value = 1;
                updateRefundTotal();
            }
        }
    }, true);

    // Xử lý Checkbox
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox') || e.target.id === 'selectAllProducts') {
            if (e.target.id === 'selectAllProducts') {
                document.querySelectorAll('.product-checkbox').forEach(c => c.checked = e.target.checked);
            }
            updateRefundTotal();
        }
    });

    // === PHẦN 3: GỬI FORM (Đưa ảnh từ mảng JS vào Form thực tế) ===
    const form = document.querySelector('form[action*="return"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (selectedFiles.length === 0) {
                alert('Vui lòng chọn ít nhất 1 hình ảnh minh họa!');
                e.preventDefault();
                return;
            }

            // Dùng DataTransfer để nén mảng selectedFiles vào input file images[]
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            imageInput.files = dataTransfer.files;
        });
    }

    updateRefundTotal();
});
</script>

        <style>
            .woocommerce-order-details__field {
                margin-bottom: 20px;
            }

            .woocommerce-order-details__field label {
                display: block;
                font-weight: 600;
                margin-bottom: 8px;
            }

            .woocommerce-order-details__field textarea,
            .woocommerce-order-details__field select,
            .woocommerce-order-details__field input[type="file"],
            .woocommerce-order-details__field input[type="text"] {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .woocommerce-order-details__field input[type="text"][readonly],
            .woocommerce-order-details__field textarea[readonly] {
                background-color: #f8f9fa;
                color:rgb(0, 0, 0);
                cursor: not-allowed;
            }

            .woocommerce-order-details__field select option {
                padding: 12px 8px;
                line-height: 1.5;
                display: block;
                text-align: left;
                margin-top: 6px;
            }

            .woocommerce-order-details__actions {
                margin-top: 30px;
                display: flex;
                gap: 10px;
            }

            .order-header {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-bottom: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .error {
                color: #e74c3c;
                font-size: 14px;
                margin-top: 5px;
            }

            .error-message {
                display: none;
            }

            .required {
                color: #e74c3c;
            }

            /* Product Selection Styles */
            .product-selection-container {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 15px;
                background: #f8f9fa;
            }

            .product-select-item {
                padding: 12px;
                margin-bottom: 10px;
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                transition: all 0.2s ease;
            }

            .product-select-item:hover {
                border-color: #0073aa;
                box-shadow: 0 2px 4px rgba(0,115,170,0.1);
            }

            .product-select-item label {
                display: flex;
                align-items: center;
                gap: 12px;
                cursor: pointer;
                margin: 0;
                font-weight: normal;
            }

            .product-select-item input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
                flex-shrink: 0;
            }

            .product-select-item .product-name {
                flex: 1;
                font-weight: 500;
                color: #333;
            }

            .product-select-item .product-quantity {
                color: #666;
                font-size: 14px;
            }

            .product-select-item .product-price {
                font-weight: 600;
                color: #0073aa;
                min-width: 100px;
                text-align: right;
            }

            .select-all-container {
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #e5e7eb;
            }

            .select-all-container label {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                font-weight: 600;
                color: #0073aa;
                margin: 0;
            }

            .select-all-container input[type="checkbox"] {
                width: 18px;
                height: 18px;
                cursor: pointer;
            }

            /* Refund Amount Summary */
            .refund-amount-summary {
                margin: 30px 0 20px 0;
                padding: 20px;
                background: #ffffff;
                border: 2px solid #000000;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .refund-amount-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .refund-amount-label {
                font-size: 18px;
                font-weight: 600;
                color: #000000;
                text-shadow: none;
            }

            .refund-amount-value {
                font-size: 28px;
                font-weight: 700;
                color: #ffffff;
                background: #6b6b6b;
                padding: 8px 20px;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            /* Image Preview Styles */
            .button-select-images {
                background: #0073aa;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 14px;
                display: inline-block;
                margin-bottom: 10px;
            }

            .button-select-images:hover {
                background: #005177;
            }

            .image-preview-container {
                display: flex;
                flex-direction: column;
                gap: 10px;
                margin-top: 15px;
            }

            .image-preview-item {
                display: flex;
                align-items: center;
                background: #f8f9fa;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                position: relative;
                transition: all 0.3s ease;
            }

            .image-preview-item:hover {
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .image-preview-item img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
                margin-right: 15px;
                flex-shrink: 0;
            }

            .image-name {
                flex: 1;
                font-size: 14px;
                color: #333;
                word-break: break-word;
                margin-right: 15px;
            }

            .btn-remove-image {
                background: #dc3545;
                color: white;
                border: none;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                line-height: 1;
                transition: background 0.2s ease;
                flex-shrink: 0;
                margin-left: auto;
            }

            .btn-remove-image:hover {
                background: #c82333;
            }

            .btn-remove-image span {
                display: block;
                margin-top: -2px;
            }
        </style>
    @endsection