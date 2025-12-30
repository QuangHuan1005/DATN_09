@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng')

@push('styles')
<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
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
@endpush

@section('content')
<main id="main" class="site-main">
    <div class="container pt-4">
        <form action="{{ route('checkout.store') }}" method="post" id="checkoutForm">
            @csrf
            <input type="hidden" name="is_checkout_page" value="1" />
            <input type="hidden" name="address_id" id="selected_address_id" value="{{ $defaultAddress->id ?? '' }}">

            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-address-delivery">
                        <h3 class="checkout-title"><i class="fa fa-map-marker-alt me-2 text-danger"></i>1. Địa chỉ giao hàng</h3>
                        <div class="block-border shadow-sm">
                            <h4 class="fw-bold mb-2">
                                <span id="selectedAddressName">{{ $defaultAddress->name ?? ($user->name ?? 'Khách hàng') }}</span>
                                <span id="selectedAddressDefaultLabel" class="badge bg-success ms-2 {{ (isset($defaultAddress) && !$defaultAddress->is_default) ? 'd-none' : '' }}">Mặc định</span>
                            </h4>
                            <p class="mb-1"><i class="fa fa-phone me-2 text-muted"></i><span id="selectedAddressPhone">{{ $defaultAddress->phone ?? ($user->phone ?? 'Chưa cập nhật') }}</span></p>
                            <p class="mb-3 text-muted"><i class="fa fa-home me-2 text-muted"></i><span id="selectedAddressText">
                                {{ $defaultAddress ? ($defaultAddress->address . ', ' . $defaultAddress->ward . ', ' . $defaultAddress->district . ', ' . $defaultAddress->province) : ($user->address ?? 'Chưa cập nhật địa chỉ') }}
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
                            @foreach($cartItems as $item)
                                <div class="product-item">
                                  <img src="{{ $item['image_url'] }}" 
     alt="{{ $item['variant']->product->name }}" 
     style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                                    <div class="product-info">
                                        <div class="product-name">{{ $item['variant']->product->name }}</div>
                                        <div class="product-meta">
                                            Phân loại: {{ $item['variant']->color->name ?? '' }} / {{ $item['variant']->size->name ?? '' }}
                                            <span class="ms-3">Số lượng: <b>x{{ $item['quantity'] }}</b></span>
                                        </div>
                                    </div>
                                    <div class="product-price fw-bold text-dark">
                                        {{ number_format($item['itemTotal']) }}đ
                                    </div>
                                </div>
                            @endforeach
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
                            <div class="d-flex justify-content-between mb-2"> <span class="text-muted">Tạm tính</span> <span>{{ number_format($totalAmount) }}đ</span> </div>
                            <div class="d-flex justify-content-between mb-2"> <span class="text-muted">Phí vận chuyển</span> <span>{{ $shippingFee > 0 ? number_format($shippingFee).'đ' : 'Miễn phí' }}</span> </div>
                            
                            @if(isset($discountAmount) && $discountAmount > 0)
                                <div class="d-flex justify-content-between mb-2 text-danger fw-bold"> <span>Voucher giảm giá</span> <span>-{{ number_format($discountAmount) }}đ</span> </div>
                            @endif
                            
                            <hr>
                            <div class="d-flex justify-content-between mb-4"> <span class="fw-bold fs-5">TỔNG CỘNG</span> <span class="text-danger fw-bold fs-4">{{ number_format($grandTotal) }}đ</span> </div>

                            <div class="voucher-card-wrapper">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold small">Mã giảm giá</span>
                                    <a href="javascript:void(0)" class="text-danger small fw-bold" data-bs-toggle="modal" data-bs-target="#myVoucherWallet">Kho voucher <i class="fa fa-chevron-right"></i></a>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="coupon_code_input" name="coupon_code" placeholder="Nhập mã..." value="{{ $appliedVoucher->voucher_code ?? '' }}">
                                    <button class="btn btn-dark" type="button" id="btn_apply_coupon">Áp dụng</button>
                                </div>
                                
                                @if(isset($appliedVoucher))
                                <div class="applied-tag">
                                    <i class="fa fa-check-circle me-2 text-success"></i>
                                    <div class="flex-grow-1 small">
                                        <b class="text-uppercase">{{ $appliedVoucher->voucher_code }}</b>
                                        <span class="d-block text-muted" style="font-size: 0.7rem;">Đã giảm {{ number_format($discountAmount) }}đ</span>
                                    </div>
                                    <button type="button" class="btn-close" id="btn_remove_coupon" style="font-size: 0.6rem;"></button>
                                </div>
                                @endif
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
                @foreach($addresses as $addr)
                <div class="address-item p-3 mb-2 {{ (isset($defaultAddress) && $defaultAddress->id == $addr->id) ? 'active' : '' }}" onclick="uiSelectAddress(this, {{ $addr->id }})">
                    <input type="radio" name="modal_addr" value="{{ $addr->id }}" {{ (isset($defaultAddress) && $defaultAddress->id == $addr->id) ? 'checked' : '' }} class="d-none">
                    <span class="fw-bold fs-6">{{ $addr->name }}</span>
                    @if($addr->is_default) <span class="badge bg-success ms-2">Mặc định</span> @endif
                    <p class="mb-0 mt-1 small text-muted">{{ $addr->phone }} | {{ $addr->address }}, {{ $addr->ward }}, {{ $addr->district }}, {{ $addr->province }}</p>
                </div>
                @endforeach
            </div>
            <div class="modal-footer border-0"> <button type="button" class="btn btn-danger w-100 py-2 fw-bold rounded-pill" id="btn_confirm_addr">GIAO ĐẾN ĐỊA CHỈ NÀY</button> </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0"> <h5 class="modal-title fw-bold">Thêm địa chỉ mới</h5> <button type="button" class="btn-close" data-bs-dismiss="modal"></button> </div>
           <form id="formAddressAction" novalidate> {{-- Thêm novalidate để tắt validation mặc định --}}
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Họ tên<span class="text-danger-star">*</span></label>
                <input type="text" class="form-control" id="addr_name">
                <div id="error_addr_name" class="invalid-feedback-custom">Vui lòng nhập họ tên</div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Số điện thoại<span class="text-danger-star">*</span></label>
                <input type="text" class="form-control" id="addr_phone">
                <div id="error_addr_phone" class="invalid-feedback-custom">Số điện thoại không hợp lệ</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="small fw-bold">Tỉnh/Thành<span class="text-danger-star">*</span></label>
                <select class="form-select" id="addr_province">
                    <option value="">Chọn Tỉnh/Thành</option>
                </select>
                <div id="error_addr_province" class="invalid-feedback-custom">Vui lòng chọn Tỉnh/Thành</div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="small fw-bold">Quận/Huyện<span class="text-danger-star">*</span></label>
                <select class="form-select" id="addr_district" disabled>
                    <option value="">Chọn Quận/Huyện</option>
                </select>
                <div id="error_addr_district" class="invalid-feedback-custom">Vui lòng chọn Quận/Huyện</div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="small fw-bold">Phường/Xã<span class="text-danger-star">*</span></label>
                <select class="form-select" id="addr_ward" disabled>
                    <option value="">Chọn Phường/Xã</option>
                </select>
                <div id="error_addr_ward" class="invalid-feedback-custom">Vui lòng chọn Phường/Xã</div>
            </div>
        </div>
        <div class="mb-3">
            <label class="small fw-bold">Địa chỉ chi tiết<span class="text-danger-star">*</span></label>
            <textarea class="form-control" id="addr_detail" rows="2"></textarea>
            <div id="error_addr_detail" class="invalid-feedback-custom">Vui lòng nhập địa chỉ chi tiết</div>
        </div>
        <div class="form-check"> 
            <input class="form-check-input" type="checkbox" id="addr_default"> 
            <label class="form-check-label small">Đặt làm mặc định</label> 
        </div>
    </div>
    <div class="modal-footer border-0"> 
        <button type="submit" class="btn btn-danger w-100 fw-bold py-2 rounded-pill" id="btnSaveAddress">LƯU ĐỊA CHỈ</button> 
    </div>
</form>
        </div>
    </div>
</div>
<div class="modal fade" id="myVoucherWallet" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header border-0 pb-0"> 
                <h5 class="modal-title fw-bold">Kho Voucher ưu đãi</h5> 
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button> 
            </div>
            <div class="modal-body bg-light mt-3" style="max-height: 500px; overflow-y: auto; padding: 15px;">
                @forelse($vouchers as $v)
                    <div class="voucher-item-modal mb-3 shadow-sm d-flex bg-white" style="border-radius: 12px; border: 1px solid #eee; min-height: 110px;">
                        <div class="voucher-left d-flex flex-column align-items-center justify-content-center text-white" 
                             style="width: 100px; background: linear-gradient(135deg, #ff4747, #ff6b6b); border-right: 2px dashed #f8fafc;">
                            <i class="fa fa-ticket-alt fa-2x mb-1"></i>
                            <small class="fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $v->discount_type == 'percent' ? 'Giảm %' : 'Giảm tiền' }}</small>
                        </div>

                        <div class="p-3 flex-grow-1 position-relative">
                            <h6 class="fw-bold mb-1 text-dark">{{ $v->voucher_code }}</h6>
                            
                            <p class="text-danger small fw-bold mb-1">
                                Giảm {{ $v->discount_type == 'percent' ? $v->discount_value.'%' : number_format($v->discount_value).'đ' }}
                            </p>

                            <div class="text-muted mb-1" style="font-size: 0.75rem;">
                                <i class="fa fa-info-circle me-1"></i>Đơn tối thiểu: <b>{{ number_format($v->min_order_value ?? 0) }}đ</b>
                            </div>

                            <div class="text-muted" style="font-size: 0.75rem;">
                                <i class="fa fa-clock me-1"></i>HSD: {{ $v->end_date ? \Carbon\Carbon::parse($v->end_date)->format('d/m/Y') : 'Không giới hạn' }}
                            </div>
                            
                            @if($v->description)
                            <div class="mt-2 pt-2 border-top text-secondary small" style="font-size: 0.7rem; font-style: italic;">
                                {{ $v->description }}
                            </div>
                            @endif
                        </div>

                        <div class="p-3 d-flex align-items-center bg-white" style="border-radius: 0 12px 12px 0;">
                            @if(isset($totalAmount) && $totalAmount < ($v->min_order_value ?? 0))
                                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3 fw-bold opacity-50" style="font-size: 0.75rem;" disabled>Chưa đủ ĐK</button>
                            @else
                                <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" style="font-size: 0.75rem;" onclick="pickVoucher('{{ $v->voucher_code }}')">Dùng ngay</button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="opacity-25 mb-3">
                        <p class="text-muted">Bạn chưa có voucher nào trong kho</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="toast-container"></div>
@endsection

@push('scripts')
<script>
    // --- KHỞI TẠO CÁC PHẦN TỬ ---
    const provinceSelect = document.getElementById('addr_province');
    const districtSelect = document.getElementById('addr_district');
    const wardSelect = document.getElementById('addr_ward');
    const addressForm = document.getElementById('formAddressAction');

    // --- HÀM VALIDATION HELPER ---
    function setFieldError(fieldId, message) {
        const input = document.getElementById(fieldId);
        const errorDiv = document.getElementById('error_' + fieldId);
        if (input) input.classList.add('is-invalid-custom');
        if (errorDiv) {
            errorDiv.innerText = message;
            errorDiv.style.display = 'block';
        }
    }

    function clearErrors() {
        document.querySelectorAll('.is-invalid-custom').forEach(el => el.classList.remove('is-invalid-custom'));
        document.querySelectorAll('.invalid-feedback-custom').forEach(el => {
            el.innerText = '';
            el.style.display = 'none';
        });
    }

    // Tự động xóa lỗi khi người dùng bắt đầu nhập lại
    document.querySelectorAll('#formAddressAction .form-control, #formAddressAction .form-select').forEach(el => {
        el.addEventListener('input', function() {
            this.classList.remove('is-invalid-custom');
            const errorDiv = document.getElementById('error_' + this.id);
            if (errorDiv) errorDiv.style.display = 'none';
        });
    });

    // --- TỈNH THÀNH API ---
    async function loadProvinces() {
        try {
            const res = await fetch('https://provinces.open-api.vn/api/p/');
            const data = await res.json();
            data.forEach(p => provinceSelect.innerHTML += `<option value="${p.name}" data-code="${p.code}">${p.name}</option>`);
        } catch (err) { console.error("Lỗi tải tỉnh thành:", err); }
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

    // --- LƯU ĐỊA CHỈ VỚI VALIDATION CHI TIẾT ---
    addressForm.onsubmit = function(e) {
        e.preventDefault();
        clearErrors();

        const name = document.getElementById('addr_name').value.trim();
        const phone = document.getElementById('addr_phone').value.trim();
        const province = provinceSelect.value;
        const district = districtSelect.value;
        const ward = wardSelect.value;
        const detail = document.getElementById('addr_detail').value.trim();
        
        let isValid = true;

        // Validation Logic
        if (!name) { setFieldError('addr_name', 'Vui lòng nhập họ tên'); isValid = false; }
        
        const phoneRegex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        if (!phone) { setFieldError('addr_phone', 'Vui lòng nhập số điện thoại'); isValid = false; }
        else if (!phoneRegex.test(phone)) { setFieldError('addr_phone', 'Số điện thoại không đúng định dạng'); isValid = false; }

        if (!province) { setFieldError('addr_province', 'Vui lòng chọn Tỉnh/Thành'); isValid = false; }
        if (!district) { setFieldError('addr_district', 'Vui lòng chọn Quận/Huyện'); isValid = false; }
        if (!ward) { setFieldError('addr_ward', 'Vui lòng chọn Phường/Xã'); isValid = false; }
        if (!detail) { setFieldError('addr_detail', 'Vui lòng nhập địa chỉ cụ thể'); isValid = false; }

        if (!isValid) return;

        const saveBtn = document.getElementById('btnSaveAddress');
        saveBtn.disabled = true;
        saveBtn.innerText = 'Đang xử lý...';

        const data = {
            name: name,
            phone: phone,
            province: province,
            district: district,
            ward: ward,
            address: detail,
            is_default: document.getElementById('addr_default').checked ? 1 : 0,
            _token: '{{ csrf_token() }}'
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
                if (res.errors) {
                    // Hiển thị lỗi từ Laravel Backend nếu có
                    Object.keys(res.errors).forEach(key => setFieldError('addr_' + key, res.errors[key][0]));
                } else {
                    showToast(res.message || "Lỗi lưu địa chỉ", "error");
                }
            }
        }).catch(() => {
            saveBtn.disabled = false;
            showToast("Lỗi kết nối hệ thống", "error");
        });
    };

    // --- THAY ĐỔI ĐỊA CHỈ ---
    document.getElementById('btn_confirm_addr').onclick = function() {
        const selected = document.querySelector('input[name="modal_addr"]:checked');
        if (selected) {
            const btn = this;
            btn.disabled = true;
            btn.innerText = 'Đang xử lý...';

            fetch("{{ route('account.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
        fetch("{{ route('checkout.voucher.apply') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
            body: JSON.stringify({ voucher_code: code })
        }).then(res => res.json()).then(data => {
            if(data.success) { 
                showToast("Áp dụng thành công!", "success"); 
                setTimeout(() => location.reload(), 800); 
            } else { 
                showToast(data.message, "error"); 
            }
        });
    }

    const btnDel = document.getElementById('btn_remove_coupon');
    if(btnDel) {
        btnDel.onclick = function() {
            fetch("{{ route('checkout.voucher.remove') }}", { 
                method: "POST", 
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" } 
            }).then(() => location.reload());
        };
    }

    // --- UI HELPERS ---
    function openAddAddressModal() {
        addressForm.reset();
        clearErrors();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addressModal')).hide();
        new bootstrap.Modal(document.getElementById('editAddressModal')).show();
    }

    function uiSelectAddress(el, id) {
        document.querySelectorAll('.address-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active'); 
        el.querySelector('input').checked = true;
    }

    function showToast(msg, type) {
        const box = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = `custom-toast p-3 mb-2 rounded shadow-lg text-white ${type === 'success' ? 'bg-success' : 'bg-danger'}`;
        t.innerText = msg;
        box.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            setTimeout(() => t.remove(), 500);
        }, 3000);
    }
</script>
@endpush