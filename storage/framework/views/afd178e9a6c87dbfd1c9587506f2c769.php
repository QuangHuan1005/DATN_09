<?php $__env->startSection('title', 'Xác nhận đơn hàng'); ?>

<?php $__env->startPush('styles'); ?>
<link href="<?php echo e(asset('css/checkout.css')); ?>" rel="stylesheet">
<style>
    /* UI Layout & Block */
    .block-border { border: 1px solid #edf2f7; border-radius: 12px; padding: 20px; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); margin-bottom: 20px; position: relative; }
    .checkout-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 15px; color: #2d3748; display: flex; align-items: center; }
    
    /* Product Item UI */
    .product-item { display: flex; align-items: center; padding: 15px 0; border-bottom: 1px solid #f1f1f1; }
    .product-item:last-child { border-bottom: none; }
    .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; margin-right: 15px; border: 1px solid #eee; }
    .product-info { flex-grow: 1; }
    .product-name { font-size: 0.95rem; font-weight: 600; color: #333; margin-bottom: 2px; }
    .product-meta { font-size: 0.8rem; color: #777; }

    /* Validation UI */
    .text-danger-star { color: #ff4747; margin-left: 4px; }
    .invalid-feedback-custom { color: #ff4747; font-size: 0.8rem; margin-top: 5px; display: none; }
    .is-invalid-custom { border-color: #ff4747 !important; box-shadow: 0 0 0 0.2rem rgba(255, 71, 71, 0.1) !important; }

    /* Address Selection */
    .address-item { border: 2px solid #edf2f7 !important; transition: 0.2s; cursor: pointer; border-radius: 10px; position: relative; padding: 15px; margin-bottom: 10px; }
    .address-item.active { border-color: #ff4747 !important; background: #fffcfc; }
    
    /* Voucher UI */
    .voucher-card-wrapper { background: #f8fafc; border: 1px dashed #ff4747; border-radius: 12px; padding: 15px; }
    .applied-tag { background: #f0fff4; border: 1px solid #38a169; border-radius: 8px; padding: 10px; display: flex; align-items: center; margin-top: 10px; }
    .voucher-item-modal { display: flex; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; margin-bottom: 15px; background: #fff; }
    .voucher-left { background: linear-gradient(135deg, #ff4747, #ff6b6b); color: #fff; width: 85px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* Toast Notification */
    .custom-toast { position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease; }
    @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main id="main" class="site-main">
    <div class="container pt-4">
        <form action="<?php echo e(route('checkout.store')); ?>" method="post" id="checkoutForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="is_checkout_page" value="1" />
            <input type="hidden" name="address_id" id="selected_address_id" value="<?php echo e($defaultAddress->id ?? ''); ?>">

            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-address-delivery">
                        <h3 class="checkout-title"><i class="fa fa-map-marker-alt me-2 text-danger"></i>1. Địa chỉ giao hàng</h3>
                        <div class="block-border shadow-sm">
                            <h4 class="fw-bold mb-2">
                                <span id="selectedAddressName"><?php echo e($defaultAddress->name ?? ($user->name ?? 'Khách hàng')); ?></span>
                                <span id="selectedAddressDefaultLabel" class="badge bg-success ms-2 <?php echo e((isset($defaultAddress) && !$defaultAddress->is_default) ? 'd-none' : ''); ?>">Mặc định</span>
                            </h4>
                            <p class="mb-1"><i class="fa fa-phone me-2 text-muted"></i><span id="selectedAddressPhone"><?php echo e($defaultAddress->phone ?? ($user->phone ?? 'Chưa cập nhật')); ?></span></p>
                            <p class="mb-3 text-muted"><i class="fa fa-home me-2 text-muted"></i><span id="selectedAddressText">
                                <?php echo e($defaultAddress ? ($defaultAddress->address . ', ' . $defaultAddress->ward . ', ' . $defaultAddress->district . ', ' . $defaultAddress->province) : ($user->address ?? 'Chưa cập nhật địa chỉ')); ?>

                            </span></p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-dark btn-sm px-4" data-bs-toggle="modal" data-bs-target="#addressModal">Thay đổi địa chỉ</button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="openAddAddressModal()">+ Thêm địa chỉ mới</button>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-products mt-4">
                        <h3 class="checkout-title"><i class="fa fa-shopping-basket me-2 text-success"></i>2. Thông tin sản phẩm</h3>
                        <div class="block-border shadow-sm">
                            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="product-item">
                                    <img src="<?php echo e(asset('storage/' . ($item['variant']->product->image))); ?>" class="product-img" alt="Product">
                                    <div class="product-info">
                                        <div class="product-name"><?php echo e($item['variant']->product->name); ?></div>
                                        <div class="product-meta">
                                            Phân loại: <?php echo e($item['variant']->color->name ?? ''); ?> / <?php echo e($item['variant']->size->name ?? ''); ?>

                                            <span class="ms-3">Số lượng: <b>x<?php echo e($item['quantity']); ?></b></span>
                                        </div>
                                    </div>
                                    <div class="product-price fw-bold text-dark">
                                        <?php echo e(number_format($item['itemTotal'])); ?>đ
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="checkout-payment mt-4">
                        <h3 class="checkout-title"><i class="fa fa-credit-card me-2 text-primary"></i>3. Phương thức thanh toán</h3>
                        <div class="block-border shadow-sm">
                            <label class="d-flex align-items-center mb-3 p-3 border rounded-3 cursor-pointer">
                                <input type="radio" name="payment_method" value="1" checked class="me-3">
                                <div><strong class="d-block">Thanh toán khi nhận hàng (COD)</strong></div>
                            </label>
                            <label class="d-flex align-items-center p-3 border rounded-3 cursor-pointer">
                                <input type="radio" name="payment_method" value="2" class="me-3">
                                <div><strong class="d-block">Thanh toán qua VNPay</strong></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary sticky-top" style="top: 20px;">
                        <div class="block-border shadow-sm bg-white border-0">
                            <h3 class="fw-bold mb-4" style="font-size: 1.2rem; border-bottom: 2px solid #f1f1f1; padding-bottom: 10px;">Tóm tắt đơn hàng</h3>
                            <div class="d-flex justify-content-between mb-2"> <span class="text-muted">Tạm tính</span> <span><?php echo e(number_format($totalAmount)); ?>đ</span> </div>
                            <div class="d-flex justify-content-between mb-2"> <span class="text-muted">Phí vận chuyển</span> <span><?php echo e($shippingFee > 0 ? number_format($shippingFee).'đ' : 'Miễn phí'); ?></span> </div>
                            
                            <?php if(isset($discountAmount) && $discountAmount > 0): ?>
                                <div class="d-flex justify-content-between mb-2 text-danger fw-bold"> <span>Voucher giảm giá</span> <span>-<?php echo e(number_format($discountAmount)); ?>đ</span> </div>
                            <?php endif; ?>
                            
                            <hr>
                            <div class="d-flex justify-content-between mb-4"> <span class="fw-bold fs-5">TỔNG CỘNG</span> <span class="text-danger fw-bold fs-4"><?php echo e(number_format($grandTotal)); ?>đ</span> </div>

                            <div class="voucher-card-wrapper">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small">Mã giảm giá</span>
                                    <a href="javascript:void(0)" class="text-danger small fw-bold" data-bs-toggle="modal" data-bs-target="#myVoucherWallet">Kho voucher <i class="fa fa-chevron-right"></i></a>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="coupon_code_input" name="coupon_code" placeholder="Nhập mã..." value="<?php echo e($appliedVoucher->voucher_code ?? ''); ?>">
                                    <button class="btn btn-dark" type="button" id="btn_apply_coupon">Áp dụng</button>
                                </div>
                                
                                <?php if(isset($appliedVoucher)): ?>
                                <div class="applied-tag">
                                    <i class="fa fa-check-circle me-2 text-success"></i>
                                    <div class="flex-grow-1 small">
                                        <b class="text-uppercase"><?php echo e($appliedVoucher->voucher_code); ?></b>
                                        <span class="d-block text-muted" style="font-size: 0.7rem;">Đã giảm <?php echo e(number_format($discountAmount)); ?>đ</span>
                                    </div>
                                    <button type="button" class="btn-close" id="btn_remove_coupon" style="font-size: 0.6rem;"></button>
                                </div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold mt-4 fs-5 rounded-pill shadow">ĐẶT HÀNG NGAY</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<div class="modal fade" id="addressModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0"> <h5 class="modal-title fw-bold">Chọn địa chỉ nhận hàng</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div>
            <div class="modal-body bg-light mt-3" style="max-height: 450px; overflow-y: auto;">
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="address-item p-3 mb-2 <?php echo e((isset($defaultAddress) && $defaultAddress->id == $addr->id) ? 'active' : ''); ?>" onclick="uiSelectAddress(this, <?php echo e($addr->id); ?>)">
                    <input type="radio" name="modal_addr" value="<?php echo e($addr->id); ?>" <?php echo e((isset($defaultAddress) && $defaultAddress->id == $addr->id) ? 'checked' : ''); ?> class="d-none">
                    <span class="fw-bold fs-6"><?php echo e($addr->name); ?></span>
                    <?php if($addr->is_default): ?> <span class="badge bg-success ms-2">Mặc định</span> <?php endif; ?>
                    <p class="mb-0 mt-1 small text-muted"><?php echo e($addr->phone); ?> | <?php echo e($addr->address); ?>, <?php echo e($addr->ward); ?>, <?php echo e($addr->district); ?>, <?php echo e($addr->province); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modal-footer border-0"> <button type="button" class="btn btn-danger w-100 py-2 fw-bold rounded-pill" id="btn_confirm_addr">GIAO ĐẾN ĐỊA CHỈ NÀY</button> </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0"> <h5 class="modal-title fw-bold">Thêm địa chỉ mới</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div>
            <form id="formAddressAction">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Họ tên<span class="text-danger-star">*</span></label>
                            <input type="text" class="form-control" id="addr_name" required>
                            <div class="invalid-feedback-custom"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold">Số điện thoại<span class="text-danger-star">*</span></label>
                            <input type="text" class="form-control" id="addr_phone" required>
                            <div class="invalid-feedback-custom"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="small fw-bold">Tỉnh/Thành<span class="text-danger-star">*</span></label>
                            <select class="form-select" id="addr_province" required><option value="">Chọn Tỉnh/Thành</option></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small fw-bold">Quận/Huyện<span class="text-danger-star">*</span></label>
                            <select class="form-select" id="addr_district" disabled required><option value="">Chọn Quận/Huyện</option></select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="small fw-bold">Phường/Xã<span class="text-danger-star">*</span></label>
                            <select class="form-select" id="addr_ward" disabled required><option value="">Chọn Phường/Xã</option></select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Địa chỉ chi tiết<span class="text-danger-star">*</span></label>
                        <textarea class="form-control" id="addr_detail" rows="2" required></textarea>
                    </div>
                    <div class="form-check"> 
                        <input class="form-check-input" type="checkbox" id="addr_default"> 
                        <label class="form-check-label small">Đặt làm mặc định</label> 
                    </div>
                </div>
                <div class="modal-footer border-0"> <button type="submit" class="btn btn-danger w-100 fw-bold py-2 rounded-pill" id="btnSaveAddress">LƯU ĐỊA CHỈ</button> </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myVoucherWallet" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0"> <h5 class="modal-title fw-bold">Kho Voucher ưu đãi</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div>
            <div class="modal-body bg-light mt-3" style="max-height: 400px; overflow-y: auto;">
                <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="voucher-item-modal">
                        <div class="voucher-left"> <i class="fa fa-ticket-alt fa-2x"></i> </div>
                        <div class="p-3 flex-grow-1">
                            <h6 class="fw-bold mb-1"><?php echo e($v->voucher_code); ?></h6>
                            <p class="text-danger small fw-bold mb-0">Giảm <?php echo e($v->discount_type == 'percent' ? $v->discount_value.'%' : number_format($v->discount_value).'đ'); ?></p>
                        </div>
                        <div class="p-3 d-flex align-items-center">
                            <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" onclick="pickVoucher('<?php echo e($v->voucher_code); ?>')">Dùng</button>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center py-5 text-muted">Trống</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div id="toast-container"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // --- TỈNH THÀNH API ---
    const provinceSelect = document.getElementById('addr_province');
    const districtSelect = document.getElementById('addr_district');
    const wardSelect = document.getElementById('addr_ward');

    async function loadProvinces() {
        const res = await fetch('https://provinces.open-api.vn/api/p/');
        const data = await res.json();
        data.forEach(p => provinceSelect.innerHTML += `<option value="${p.name}" data-code="${p.code}">${p.name}</option>`);
    }
    loadProvinces();

    provinceSelect.onchange = async function() {
        const code = this.options[this.selectedIndex].dataset.code;
        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        districtSelect.disabled = true; wardSelect.disabled = true;
        if(code) {
            const res = await fetch(`https://provinces.open-api.vn/api/p/${code}?depth=2`);
            const data = await res.json();
            data.districts.forEach(d => districtSelect.innerHTML += `<option value="${d.name}" data-code="${d.code}">${d.name}</option>`);
            districtSelect.disabled = false;
        }
    };

    districtSelect.onchange = async function() {
        const code = this.options[this.selectedIndex].dataset.code;
        wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>';
        wardSelect.disabled = true;
        if(code) {
            const res = await fetch(`https://provinces.open-api.vn/api/d/${code}?depth=2`);
            const data = await res.json();
            data.wards.forEach(w => wardSelect.innerHTML += `<option value="${w.name}">${w.name}</option>`);
            wardSelect.disabled = false;
        }
    };

    // --- LƯU ĐỊA CHỈ (FIXED) ---
    document.getElementById('formAddressAction').onsubmit = function(e) {
        e.preventDefault();
        const saveBtn = document.getElementById('btnSaveAddress');
        saveBtn.disabled = true;
        saveBtn.innerText = 'Đang xử lý...';

        const data = {
            name: document.getElementById('addr_name').value,
            phone: document.getElementById('addr_phone').value,
            province: provinceSelect.value,
            district: districtSelect.value,
            ward: wardSelect.value,
            address: document.getElementById('addr_detail').value,
            is_default: document.getElementById('addr_default').checked ? 1 : 0,
            _token: '<?php echo e(csrf_token()); ?>'
        };

        fetch('/checkout/address/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if(res.success || res.id) {
                showToast("Lưu địa chỉ thành công!", "success");
                location.reload();
            } else {
                saveBtn.disabled = false;
                saveBtn.innerText = 'LƯU ĐỊA CHỈ';
                showToast(res.message || "Lỗi lưu địa chỉ", "error");
            }
        });
    };

    // --- THAY ĐỔI ĐỊA CHỈ (FIXED) ---
    document.getElementById('btn_confirm_addr').onclick = function() {
        const selected = document.querySelector('input[name="modal_addr"]:checked');
        if (selected) {
            const btn = this;
            btn.disabled = true;
            btn.innerText = 'Đang xử lý...';

            fetch("<?php echo e(route('account.update')); ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ address_id: selected.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast("Đã thay đổi địa chỉ", "success");
                    location.reload();
                } else {
                    btn.disabled = false;
                    btn.innerText = 'GIAO ĐẾN ĐỊA CHỈ NÀY';
                }
            });
        }
    };

    // --- VOUCHER ---
    function pickVoucher(code) {
        document.getElementById('coupon_code_input').value = code;
        executeApplyVoucher(code);
    }

    document.getElementById('btn_apply_coupon').addEventListener('click', function() {
        executeApplyVoucher(document.getElementById('coupon_code_input').value.trim());
    });

    function executeApplyVoucher(code) {
        if(!code) return showToast("Vui lòng nhập mã!", "error");
        fetch("<?php echo e(route('checkout.voucher.apply')); ?>", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>", "Accept": "application/json" },
            body: JSON.stringify({ voucher_code: code })
        }).then(res => res.json()).then(data => {
            if(data.success) { showToast("Áp dụng thành công!", "success"); setTimeout(() => location.reload(), 800); }
            else { showToast(data.message, "error"); }
        });
    }

    const btnDel = document.getElementById('btn_remove_coupon');
    if(btnDel) {
        btnDel.onclick = function() {
            fetch("<?php echo e(route('checkout.voucher.remove')); ?>", { method: "POST", headers: { "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>" } }).then(() => location.reload());
        };
    }

    // --- UI HELPERS ---
    function openAddAddressModal() {
        document.getElementById('formAddressAction').reset();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addressModal')).hide();
        new bootstrap.Modal(document.getElementById('editAddressModal')).show();
    }

    function uiSelectAddress(el, id) {
        document.querySelectorAll('.address-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active'); el.querySelector('input').checked = true;
    }

    function showToast(msg, type) {
        const box = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = `custom-toast p-3 mb-2 rounded shadow-lg text-white ${type === 'success' ? 'bg-success' : 'bg-danger'}`;
        t.innerText = msg;
        box.appendChild(t);
        setTimeout(() => t.remove(), 3000);
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/checkout/index.blade.php ENDPATH**/ ?>