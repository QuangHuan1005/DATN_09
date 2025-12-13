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
                                                            
                                                            @if($shouldShowSelection)
                                                            <div class="woocommerce-order-details__field">
                                                                <label>Chọn sản phẩm muốn hoàn <span class="required">*</span></label>
                                                                <div class="product-selection-container">
                                                                    @foreach($order->details as $index => $detail)
                                                                        @php
                                                                            $variant = $detail->productVariant;
                                                                            $product = $variant ? $variant->product : $detail->product;
                                                                            $variantText = [];
                                                                            if ($variant?->color?->name) $variantText[] = "Màu: {$variant->color->name}";
                                                                            if ($variant?->size?->name) $variantText[] = "Size: {$variant->size->name}";
                                                                            $variantDisplay = $variantText ? ' (' . implode(', ', $variantText) . ')' : '';
                                                                        @endphp
                                                                        
                                                                        {{-- ✅ Nếu quantity > 1, tách thành nhiều checkbox riêng biệt --}}
                                                                        @for($i = 1; $i <= $detail->quantity; $i++)
                                                                            @php
                                                                                // ✅ Thêm số thứ tự nếu quantity > 1
                                                                                $itemNumber = $detail->quantity > 1 ? ' #' . $i : '';
                                                                            @endphp
                                                                            <div class="product-select-item">
                                                                                <label>
                                                                                    <input type="checkbox" 
                                                                                           name="product_ids[]" 
                                                                                           value="{{ $detail->id }}_{{ $i }}" 
                                                                                           class="product-checkbox"
                                                                                           data-detail-id="{{ $detail->id }}"
                                                                                           data-price="{{ $detail->price }}">
                                                                                    <span class="product-name">{{ $product->name }}{{ $variantDisplay }}{{ $itemNumber }}</span>
                                                                                    <span class="product-quantity">x1</span>
                                                                                    <span class="product-price">{{ number_format($detail->price) }}₫</span>
                                                                                </label>
                                                                            </div>
                                                                        @endfor
                                                                    @endforeach
                                                                    <div class="select-all-container">
                                                                        <label>
                                                                            <input type="checkbox" id="selectAllProducts">
                                                                            <span>Chọn tất cả sản phẩm</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="error-message" id="product-selection-error"></div>
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
            // Chạy sau khi tất cả scripts khác đã load
            window.addEventListener('load', function() {
                // Đợi thêm 100ms để đảm bảo tất cả scripts khác đã chạy xong
                setTimeout(function() {
                    const form = document.querySelector('form[action*="return"]');

                    if (!form) {
                        return;
                    }

                    // XÓA TẤT CẢ event listeners cũ trên form
                    const newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    // Tìm lại các elements sau khi clone
                    const returnForm = document.querySelector('form[action*="return"]');
                    const reasonSelect = document.getElementById('reason');
                    const accountSelect = document.getElementById('refund_account_id');
                    const imageInput = document.getElementById('images');

                    if (!returnForm || !reasonSelect || !accountSelect || !imageInput) {
                        return;
                    }

                    // Function to show error
                    function showError(elementId, message) {
                        const errorDiv = document.getElementById(elementId + '-error');
                        if (errorDiv) {
                            errorDiv.textContent = message;
                            errorDiv.style.display = 'block';
                            errorDiv.style.color = '#e74c3c';
                            errorDiv.style.fontSize = '14px';
                            errorDiv.style.marginTop = '5px';
                        }
                    }

                    // Function to hide error
                    function hideError(elementId) {
                        const errorDiv = document.getElementById(elementId + '-error');
                        if (errorDiv) {
                            errorDiv.textContent = '';
                            errorDiv.style.display = 'none';
                        }
                    }

                    // Validate reason (required)
                    function validateReason() {
                        const currentReason = document.getElementById('reason');
                        if (!currentReason || !currentReason.value || currentReason.value === '') {
                            showError('reason', 'Vui lòng chọn lý do hoàn hàng');
                            return false;
                        }
                        hideError('reason');
                        return true;
                    }

                    // Validate refund account (required)
                    function validateRefundAccount() {
                        const currentAccount = document.getElementById('refund_account_id');
                        if (!currentAccount || !currentAccount.value || currentAccount.value === '') {
                            showError('refund_account_id', 'Vui lòng chọn tài khoản nhận hoàn tiền');
                            return false;
                        }
                        hideError('refund_account_id');
                        return true;
                    }

                    // Validate images (required at least 1)
                    function validateImages() {
                        // Kiểm tra selectedFiles array thay vì input.files
                        if (!selectedFiles || selectedFiles.length === 0) {
                            showError('images', 'Vui lòng chọn ít nhất 1 hình ảnh');
                            return false;
                        }
                        hideError('images');
                        return true;
                    }

                    // Validate product selection (for orders with 2+ products)
                    function validateProductSelection() {
                        const productCheckboxes = document.querySelectorAll('.product-checkbox');
                        if (productCheckboxes.length > 0) {
                            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                            if (checkedBoxes.length === 0) {
                                showError('product-selection', 'Vui lòng chọn ít nhất 1 sản phẩm muốn hoàn');
                                return false;
                            }
                        }
                        hideError('product-selection');
                        return true;
                    }

                    // Flag to control form submission
                    let isValidated = false;

                    // Form submit handler
                    returnForm.addEventListener('submit', function(e) {
                        // Nếu đã validate thành công rồi, cho phép submit
                        if (isValidated) {
                            return true;
                        }

                        // Chặn submit để validate
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();

                        // Validate tất cả các fields
                        let hasErrors = false;

                        if (!validateReason()) {
                            hasErrors = true;
                        }
                        if (!validateProductSelection()) {
                            hasErrors = true;
                        }
                        if (!validateRefundAccount()) {
                            hasErrors = true;
                        }
                        if (!validateImages()) {
                            hasErrors = true;
                        }

                        // Nếu có lỗi, dừng lại
                        if (hasErrors) {
                            return false;
                        }

                        // Update the file input with selected files before submitting
                        if (selectedFiles.length > 0) {
                            const dataTransfer = new DataTransfer();
                            selectedFiles.forEach(file => dataTransfer.items.add(file));
                            imageInput.files = dataTransfer.files;
                        }

                        // Đánh dấu đã validate thành công
                        isValidated = true;

                        // Submit form
                        returnForm.submit();
                        
                        return false;
                    }, true);

                    // Real-time validation on change - clear errors when user starts interacting
                    reasonSelect.addEventListener('focus', function() {
                        hideError('reason');
                    });
                    reasonSelect.addEventListener('change', function() {
                        if (this.value && this.value !== '') {
                            hideError('reason');
                        } else {
                            validateReason();
                        }
                    });

                    accountSelect.addEventListener('focus', function() {
                        hideError('refund_account_id');
                    });
                    accountSelect.addEventListener('change', function() {
                        if (this.value && this.value !== '') {
                            hideError('refund_account_id');
                        } else {
                            validateRefundAccount();
                        }
                    });

                    // Image preview functionality
                    const selectImagesBtn = document.getElementById('selectImagesBtn');
                    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                    let selectedFiles = [];

                    if (selectImagesBtn) {
                        selectImagesBtn.addEventListener('click', function() {
                            imageInput.click();
                        });
                    }

                    imageInput.addEventListener('focus', function() {
                        hideError('images');
                    });

                    imageInput.addEventListener('change', function(e) {
                        const files = Array.from(e.target.files);
                        
                        // Giới hạn tối đa 5 ảnh
                        if (selectedFiles.length + files.length > 5) {
                            alert('Bạn chỉ có thể chọn tối đa 5 hình ảnh!');
                            return;
                        }

                        files.forEach(function(file) {
                            if (file.type.startsWith('image/')) {
                                selectedFiles.push(file);
                                addImagePreview(file);
                            }
                        });

                        if (selectedFiles.length > 0) {
                            hideError('images');
                        }

                        // Reset input để có thể chọn lại cùng file
                        e.target.value = '';
                    });

                    function addImagePreview(file) {
                        const reader = new FileReader();
                        const previewId = 'preview-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

                        reader.onload = function(e) {
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'image-preview-item';
                            previewDiv.id = previewId;
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" alt="Preview">
                                <div class="image-name">${file.name}</div>
                                <button type="button" class="btn-remove-image" data-preview-id="${previewId}" title="Xóa ảnh">
                                    <span>&times;</span>
                                </button>
                            `;
                            imagePreviewContainer.appendChild(previewDiv);

                            // Add remove event listener
                            const removeBtn = previewDiv.querySelector('.btn-remove-image');
                            removeBtn.addEventListener('click', function() {
                                removeImage(previewId, file);
                            });
                        };

                        reader.readAsDataURL(file);
                    }

                    function removeImage(previewId, file) {
                        // Remove from selectedFiles array
                        const index = selectedFiles.indexOf(file);
                        if (index > -1) {
                            selectedFiles.splice(index, 1);
                        }

                        // Remove preview element
                        const previewElement = document.getElementById(previewId);
                        if (previewElement) {
                            previewElement.remove();
                        }

                        // Update validation
                        if (selectedFiles.length === 0) {
                            validateImages();
                        }
                    }

                    // Select All Products functionality và Real-time Refund Amount Update
                    const selectAllCheckbox = document.getElementById('selectAllProducts');
                    const productCheckboxes = document.querySelectorAll('.product-checkbox');
                    const refundAmountDisplay = document.getElementById('refundAmountDisplay');

                    // Function to calculate and update refund amount
                    function updateRefundAmount() {
                        let totalRefund = 0;
                        
                        if (productCheckboxes.length === 0) {
                            // Đơn 1 sản phẩm hoặc không có checkbox: hoàn toàn bộ
                            totalRefund = {{ $order->total_amount }};
                        } else {
                            // Đơn nhiều sản phẩm: tính tổng các sản phẩm đã chọn
                            productCheckboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    totalRefund += parseFloat(checkbox.dataset.price || 0);
                                }
                            });
                        }

                        // Format và hiển thị
                        if (refundAmountDisplay) {
                            refundAmountDisplay.textContent = new Intl.NumberFormat('vi-VN').format(totalRefund) + '₫';
                        }
                    }

                    if (selectAllCheckbox && productCheckboxes.length > 0) {
                        // Handle Select All checkbox
                        selectAllCheckbox.addEventListener('change', function() {
                            productCheckboxes.forEach(checkbox => {
                                checkbox.checked = this.checked;
                            });
                            // Hide error when products are selected
                            if (this.checked) {
                                hideError('product-selection');
                            }
                            // Update refund amount
                            updateRefundAmount();
                        });

                        // Handle individual product checkboxes
                        productCheckboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                // Update "Select All" state
                                const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
                                const noneChecked = Array.from(productCheckboxes).every(cb => !cb.checked);
                                
                                selectAllCheckbox.checked = allChecked;
                                selectAllCheckbox.indeterminate = !allChecked && !noneChecked;

                                // Hide error when at least one is selected
                                if (this.checked) {
                                    hideError('product-selection');
                                }
                                
                                // Update refund amount
                                updateRefundAmount();
                            });
                        });

                        // Set initial refund amount to 0 (user must select products)
                        updateRefundAmount();
                    } else {
                        // Đơn 1 sản phẩm: hiển thị full amount
                        updateRefundAmount();
                    }

                }, 100);
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
