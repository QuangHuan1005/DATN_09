<script>
    const variantMap = @json($variantMap);

    // Giá mặc định ban đầu (Blade đổ xuống)
    const defaultPrice = {{ (float) $displayPrice }};
    const defaultOriginal = {{ (float) $originalPrice }};
    const defaultHasDiscount = {{ $discountPercent ? 'true' : 'false' }};
    const defaultDiscount = {{ (int) ($discountPercent ?? 0) }};

    let selectedColorId = null;
    let selectedSizeId = null;
    let currentVariantStock = null; // <<=== STOCK CỦA BIẾN THỂ HIỆN TẠI

    const priceEl = document.getElementById('js-product-price');
    const originalEl = document.getElementById('js-product-original-price');
    const discountEl = document.getElementById('js-product-discount');
    const stockEl = document.getElementById('js-variant-stock');

    const colorSelect = document.getElementById('pa_color');
    const sizeSelect = document.getElementById('pa_size');

    const variantIdInput = document.getElementById('js-variant-id');
    const actionTypeInput = document.getElementById('js-action-type');
    const addToCartForm = document.getElementById('addToCartFrom');

    const colorItems = document.querySelectorAll('.js-color-item');
    const sizeItems = document.querySelectorAll('.js-size-item');

    // Ô số lượng + form lỗi
    const quantityInput = document.getElementById('quantity_input_{{ $product->id }}');
    const qtyErrorEl = document.getElementById('js-qty-error');

    function formatCurrency(value) {
        if (!value) return '0₫';
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0
        }).format(value);
    }

    // ====== FORM THÔNG BÁO LỖI SỐ LƯỢNG ======
    function showQtyError(message) {
        if (!qtyErrorEl) return;
        qtyErrorEl.textContent = message;
        qtyErrorEl.style.display = 'block';
    }

    function clearQtyError() {
        if (!qtyErrorEl) return;
        qtyErrorEl.textContent = '';
        qtyErrorEl.style.display = 'none';
    }

    function resetPriceAndStock() {
        // Reset giá
        priceEl.textContent = formatCurrency(defaultPrice);

        if (defaultHasDiscount === true || defaultHasDiscount === 'true') {
            originalEl.textContent = formatCurrency(defaultOriginal);
            originalEl.classList.remove('d-none');

            discountEl.textContent = `-${defaultDiscount}%`;
            discountEl.classList.remove('d-none');
        } else {
            originalEl.classList.add('d-none');
            discountEl.classList.add('d-none');
        }

        // Reset stock + variant id
        if (stockEl) {
            stockEl.textContent = 'Vui lòng chọn màu và size';
            stockEl.classList.remove('text-danger');
            stockEl.classList.add('text-body-secondary');
        }

        if (variantIdInput) {
            variantIdInput.value = '';
        }

        currentVariantStock = null; // <<=== reset stock
        clearQtyError();
        if (quantityInput) {
            quantityInput.value = 1;
        }
    }

    // Cập nhật UI theo 1 biến thể cụ thể
    function updateUIByVariant(variant) {
        const originalPrice = Number(variant.price);
        const salePrice = variant.sale && variant.sale > 0 ? Number(variant.sale) : null;

        if (salePrice && salePrice < originalPrice) {
            priceEl.textContent = formatCurrency(salePrice);
            originalEl.textContent = formatCurrency(originalPrice);

            const percent = Math.round((originalPrice - salePrice) / originalPrice * 100);

            originalEl.classList.remove('d-none');
            discountEl.classList.remove('d-none');
            discountEl.textContent = `-${percent}%`;
        } else {
            priceEl.textContent = formatCurrency(originalPrice);
            originalEl.classList.add('d-none');
            discountEl.classList.add('d-none');
        }

        if (variantIdInput) {
            variantIdInput.value = variant.id;
        }

        currentVariantStock = Number(variant.stock ?? 0); // <<=== LƯU LẠI STOCK HIỆN TẠI

        if (stockEl) {
            if (variant.stock > 0) {
                stockEl.textContent = `Còn ${variant.stock} sản phẩm`;
                stockEl.classList.remove('text-danger');
                stockEl.classList.add('text-body-secondary');
            } else {
                stockEl.textContent = 'Hết hàng';
                stockEl.classList.remove('text-body-secondary');
                stockEl.classList.add('text-danger');
            }
        }

        // Reset lỗi số lượng khi chọn biến thể mới
        clearQtyError();
        if (quantityInput && currentVariantStock > 0 && quantityInput.value > currentVariantStock) {
            quantityInput.value = currentVariantStock;
        }
    }

    function updatePriceByVariant() {
        if (!selectedColorId || !selectedSizeId) {
            resetPriceAndStock();
            return;
        }

        const key = `${selectedColorId}_${selectedSizeId}`;
        const variant = variantMap[key];

        if (!variant) {
            if (stockEl) {
                stockEl.textContent = 'Biến thể này hiện không có sẵn';
                stockEl.classList.add('text-danger');
            }
            if (variantIdInput) {
                variantIdInput.value = '';
            }
            currentVariantStock = null;
            clearQtyError();
            return;
        }

        updateUIByVariant(variant);
    }

    // ... (giữ nguyên phần LỌC CHÉO màu/size, clearSelection, event click color/size, reset button, action_type ...) ...


    // ====== HÀM CHECK SỐ LƯỢNG ======
    function validateQuantity() {
        if (!quantityInput) return;

        let qty = parseInt(quantityInput.value, 10);
        if (isNaN(qty)) qty = 1;

        clearQtyError();

        // 1. Không cho nhỏ hơn 1
        if (qty <= 0) {
            qty = 1;
            quantityInput.value = 1;
            showQtyError('Số lượng không thể nhỏ hơn 1');
            return false;
        }

        // 2. Không vượt quá stock của biến thể (nếu có)
        if (currentVariantStock !== null && currentVariantStock >= 0 && qty > currentVariantStock) {
            qty = currentVariantStock || 1;
            quantityInput.value = qty;
            showQtyError('Số lượng bạn chọn đã đạt mức tối đa của sản phẩm này');
            return false;
        }

        // Hợp lệ
        quantityInput.value = qty;
        return true;
    }

    // Lắng nghe thay đổi số lượng (gõ tay)
    if (quantityInput) {
        quantityInput.addEventListener('change', validateQuantity);
        quantityInput.addEventListener('blur', validateQuantity);
        quantityInput.addEventListener('keyup', function () {
            // Không spam thông báo quá nhiều, chỉ kiểm tra logic số học
            let val = parseInt(this.value, 10);
            if (isNaN(val) || val <= 0) return; // để cho user gõ xong rồi mới báo
        });
    }

    // Bắt sự kiện nút +/- nếu có (giữ nguyên class của bạn)
    document.querySelectorAll('.quantity').forEach(qtyBox => {
        const input = qtyBox.querySelector('input[name="quantity"]');
        const decBtn = qtyBox.querySelector('.nova-minicart-qty-button.decrease');
        const incBtn = qtyBox.querySelector('.nova-minicart-qty-button.increase');

        if (!input) return;

        if (decBtn) {
            decBtn.addEventListener('click', function () {
                let val = parseInt(input.value, 10);
                if (isNaN(val)) val = 1;
                val = val - 1;
                input.value = val;
                validateQuantity();
            });
        }

        if (incBtn) {
            incBtn.addEventListener('click', function () {
                let val = parseInt(input.value, 10);
                if (isNaN(val)) val = 1;
                val = val + 1;
                input.value = val;
                validateQuantity();
            });
        }
    });

    // Bắt action_type cho 2 nút submit (Add to cart / Mua ngay) – GIỮ NGUYÊN
    document.querySelectorAll('.js-submit-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            if (actionTypeInput) {
                actionTypeInput.value = this.dataset.action;
            }
        });
    });

    // Validate trước khi submit form
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function (e) {
            // 1. Bắt buộc chọn biến thể
            if (!variantIdInput || !variantIdInput.value) {
                e.preventDefault();
                alert('Vui lòng chọn đầy đủ màu sắc và size trước khi đặt hàng.');
                return;
            }

            // 2. Check số lượng
            if (!validateQuantity()) {
                e.preventDefault();
                return;
            }
        });
    }
</script>