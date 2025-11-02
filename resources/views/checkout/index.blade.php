@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng')

@push('styles')
<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
@endpush

@section('content')
<main id="main" class="site-main">
    <div class="container">
        <div class="cart pt-40 checkout">
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('checkout.store') }}" method="post" enctype="application/x-www-form-urlencoded" id="checkoutForm">
                @csrf
                <input type="hidden" name="is_checkout_page" value="1" />
                <div class="row">
                    <div class="col-lg-8 col-2xl-9">
                        <div class="checkout-process-bar block-border">
                            <p class="checkout-process-bar__title">Xác nhận đơn hàng</p>
                            <div class="progress-steps">
                                <div class="step active">
                                    <div class="step-circle">1</div>
                                    <span class="step-label">Giỏ hàng</span>
                                </div>
                                <div class="step-line active"></div>
                                <div class="step active">
                                    <div class="step-circle">2</div>
                                    <span class="step-label">Đặt hàng</span>
                                </div>
                                <div class="step-line"></div>
                                <div class="step">
                                    <div class="step-circle">3</div>
                                    <span class="step-label">Thanh toán</span>
                                </div>
                                <div class="step-line"></div>
                                <div class="step">
                                    <div class="step-circle">4</div>
                                    <span class="step-label">Hoàn thành đơn</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-address-delivery">
                            <div class="row">
                                <div class="col-12 col-2xl-7 pb-3">
                                    <h3 class="checkout-title">Địa chỉ giao hàng</h3>
                                    <div class="block-border address-default" id="selectedAddressDisplay">
                                        <input type="hidden" name="address_id" id="selected_address_id" value="{{ $defaultAddress->id ?? 0 }}" />
                                        <h4 id="selectedAddressNameContainer">
                                            <span id="selectedAddressName">{{ $defaultAddress->name ?? ($user->name ?? 'Khách hàng') }}</span>
                                            @if(isset($defaultAddress->is_default) && $defaultAddress->is_default)
                                            <span id="selectedAddressDefaultLabel">(Mặc định)</span>
                                            @endif
                                        </h4>
                                        <p>Điện thoại: <span id="selectedAddressPhone">{{ $defaultAddress->phone ?? ($user->phone ?? 'Chưa cập nhật') }}</span></p>
                                        <p>Địa chỉ: <span id="selectedAddressText">{{ $defaultAddress->address ?? ($user->address ?? 'Chưa cập nhật địa chỉ') }}</span></p>
                                        <div class="checkout-address-delivery__action">
                                            <button type="button" class="btn btn--large" data-bs-toggle="modal" data-bs-target="#addressModal">
                                                <span>Thay đổi địa chỉ</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal chọn địa chỉ -->
                                    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="addressModalLabel">Chọn địa chỉ giao hàng</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="addressList">
                                                    <!-- Địa chỉ mặc định từ user - chỉ hiển thị khi không có địa chỉ nào được set làm mặc định VÀ user có address -->
                                                    @php
                                                        $hasDefaultAddress = $addresses->where('is_default', true)->count() > 0;
                                                        $userHasAddress = !empty($user->address) && trim($user->address) !== '' && $user->address !== 'Chưa cập nhật địa chỉ';
                                                    @endphp
                                                    @if(!$hasDefaultAddress && $userHasAddress)
                                                    <div class="block-border change-address address-item" data-address-id="0" style="cursor: pointer; margin-bottom: 15px;">
                                                        <input type="radio" class="address-radio" name="modal_address_id" value="0" {{ !isset($defaultAddress->id) || $defaultAddress->id == 0 ? 'checked' : '' }} />
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h4>
                                                                    {{ $user->name ?? 'Khách hàng' }}
                                                                    <span>(Mặc định)</span>
                                                                </h4>
                                                                <p>Điện thoại: <span>{{ $user->phone ?? 'Chưa cập nhật' }}</span></p>
                                                                <p>Địa chỉ: <span>{{ $user->address ?? 'Chưa cập nhật địa chỉ' }}</span></p>
                                                            </div>
                                                            <div class="address-actions">
                                                                <span class="badge badge-success mb-2 d-block">Mặc định</span>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary edit-default-address" data-id="0">Sửa</button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger clear-default-address" data-id="0">Xóa</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    
                                                    <!-- Danh sách địa chỉ đã lưu -->
                                                    @foreach($addresses as $address)
                                                    <div class="block-border change-address address-item {{ $address->is_default ? 'border-success' : '' }}" data-address-id="{{ $address->id }}" style="cursor: pointer; margin-bottom: 15px;">
                                                        <input type="radio" class="address-radio" name="modal_address_id" value="{{ $address->id }}" {{ ($defaultAddress->id ?? 0) == $address->id ? 'checked' : '' }} />
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h4>
                                                                    {{ $address->name }}
                                                                    @if($address->is_default)
                                                                    <span>(Mặc định)</span>
                                                                    @endif
                                                                </h4>
                                                                <p>Điện thoại: <span>{{ $address->phone }}</span></p>
                                                                <p>Địa chỉ: <span>{{ $address->address }}</span></p>
                                                                @if($address->province || $address->district || $address->ward)
                                                                <p>
                                                                    @if($address->ward){{ $address->ward }}, @endif
                                                                    @if($address->district){{ $address->district }}, @endif
                                                                    @if($address->province){{ $address->province }}@endif
                                                                </p>
                                                                @endif
                                                            </div>
                                                            <div class="address-actions">
                                                                @if($address->is_default)
                                                                <span class="badge badge-success mb-2 d-block">Mặc định</span>
                                                                @else
                                                                <button type="button" class="btn btn-sm btn-outline-primary set-default-address mb-2" data-id="{{ $address->id }}">Đặt mặc định</button>
                                                                @endif
                                                                <button type="button" class="btn btn-sm btn-outline-secondary edit-address" data-id="{{ $address->id }}">Sửa</button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger delete-address" data-id="{{ $address->id }}">Xóa</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                    @if($addressCount >= 5)
                                                    <div class="alert alert-warning">
                                                        Bạn đã đạt giới hạn tối đa 5 địa chỉ.
                                                    </div>
                                                    @else
                                                    <button type="button" class="btn btn--large mt-3" id="btnAddNewAddressFromModal">
                                                        <span class="icon-ic_plus"></span><span>Thêm Địa Chỉ Mới</span>
                                                    </button>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" class="btn btn-primary" id="confirmAddressBtn">Xác nhận</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal thêm/sửa địa chỉ -->
                                    <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModal" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="addressModalBody">
                                                    <!-- Form sẽ được tạo động bằng JavaScript -->
                                                    <div id="addressFormFields">
                                                        <input type="hidden" name="_token" id="csrf_token_field" value="{{ csrf_token() }}">
                                                        <input type="hidden" id="address_form_id" name="address_id" value="">
                                                        <div class="form-group">
                                                            <label for="address_name">Tên người nhận <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="address_name" name="address_name" data-required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address_phone">Số điện thoại <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="address_phone" name="address_phone" data-required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address_address">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="address_address" name="address_address" rows="2" data-required="true"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="address_province">Tỉnh/Thành phố</label>
                                                                    <input type="text" class="form-control" id="address_province" name="province">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="address_district">Quận/Huyện</label>
                                                                    <input type="text" class="form-control" id="address_district" name="district">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="address_ward">Phường/Xã</label>
                                                                    <input type="text" class="form-control" id="address_ward" name="ward">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="address_is_default" name="is_default" value="1">
                                                                <label class="form-check-label" for="address_is_default">
                                                                    Đặt làm địa chỉ mặc định
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="button" class="btn btn-primary" id="saveAddressBtn">Lưu địa chỉ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-2xl-5">
                                    <h3 class="checkout-title">Phương thức giao hàng</h3>
                                    <div class="block-border">
                                        <label class="ds__item">
                                            <input id="shipping_method_1" class="ds__item__input" type="radio" name="shipping_method" value="1" checked />
                                            <span class="ds__item__label">Chuyển phát nhanh
                                                <span class="delivery-time">
                                                    Thời gian giao hàng dự kiến: {{ date('l, d/m/Y', strtotime('+3 days')) }}
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    
                                    <div class="pt-4">
                                        <div class="d-flex align-items-start">
                                            <h3 class="checkout-title mb-0 me-2">
                                                Bạn có muốn nhận hoá đơn VAT không ?
                                            </h3>
                                            <div class="form-check form-switch mt-2">
                                                <input type="checkbox" class="form-check-input" name="receive_vat" />
                                            </div>
                                        </div>
                                        <div class="ds__item__contact-info pt-0 order_vat_form" style="display: none;">
                                            <div class="form-group">
                                                <input type="email" name="order_vat_email" class="form-control" placeholder="Nhập email" value="" />
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="order_vat_tax_code" class="form-control" placeholder="Nhập mã số thuế" value="" />
                                            </div>
                                            <div class="form-group">
                                                <textarea name="order_vat_company_name" class="form-control" placeholder="Nhập tên doanh nghiệp"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="order_vat_address" class="form-control" placeholder="Nhập địa chỉ"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="order_vat_note" class="form-control" placeholder="Nhập ghi chú"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-payment">
                            <h3 class="checkout-title">Phương thức thanh toán</h3>
                            <div class="block-border">
                                <p>Mọi giao dịch đều được bảo mật và mã hóa.</p>
                                <div class="checkout-payment__options">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_vnpay" value="2" />
                                        <span class="ds__item__label">
                                            <div class="payment-method-title">Thanh toán bằng VNPay</div>
                                            <div class="payment-method-description">Hỗ trợ thanh toán online hơn 38 ngân hàng phổ biến Việt Nam.</div>
                                        </span>
                                    </label>
                                    
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_3" value="3" checked />
                                        <span class="ds__item__label">
                                            Thanh toán khi giao hàng
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="view-more-product">
                            <button type="button" class="btn btn--large" id="toggleCartBtn">Hiển thị sản phẩm</button>
                        </div>
                        
                        <div class="checkout-my-cart" id="cartSection" style="display: none;">
                            <div class="cart__list">
                                <h2 class="cart-title">Giỏ hàng của bạn</h2>
                                <table class="cart__table">
                                    <thead>
                                        <tr>
                                            <th>Tên Sản phẩm</th>
                                            <th>Chiết khấu</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="cart__product-item">
                                                    <div class="cart__product-item__img">
                                                        <a href="{{ route('products.show', $item['variant']->product->id) }}">
                                                            @if($item['variant']->product->photoAlbums->first())
                                                                <img src="{{ asset('storage/' . $item['variant']->product->photoAlbums->first()->image_path) }}" alt="{{ $item['variant']->product->name }}" />
                                                            @else
                                                                <img src="{{ asset('storage/products/default.jpg') }}" alt="{{ $item['variant']->product->name }}" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="cart__product-item__content">
                                                        <a href="{{ route('products.show', $item['variant']->product->id) }}">
                                                            <h3 class="cart__product-item__title">
                                                                {{ $item['variant']->product->name }}
                                                            </h3>
                                                        </a>
                                                        <div class="cart__product-item__properties">
                                                            @if($item['variant']->color)
                                                                <p>Màu sắc: <span>{{ $item['variant']->color->name }}</span></p>
                                                            @endif
                                                            @if($item['variant']->size)
                                                                <p>Size: <span>{{ $item['variant']->size->name }}</span></p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="cart-sale-price">
                                                @if($item['variant']->sale > 0)
                                                    -{{ number_format($item['variant']->sale) }}đ
                                                @endif
                                            </td>
                                            <td>
                                                <div class="product-detail__quantity-input">
                                                    <input type="number" value="{{ $item['quantity'] }}" disabled="" readonly="">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="cart__product-item__price">{{ number_format($item['itemTotal']) }}đ</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-2xl-3 cart-page__col-summary">
                        <div class="cart-summary">
                            <div id="box_product_total">
                                <div class="cart-summary__overview">
                                    <h3>Tóm tắt đơn hàng</h3>
                                    <div class="cart-summary__overview__item">
                                        <p>Tổng tiền hàng</p>
                                        <p>{{ number_format($totalAmount) }}đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tạm tính</p>
                                        <p>{{ number_format($totalAmount) }}đ</p>
                                    </div>
                                    @if(isset($discountAmount) && $discountAmount > 0)
                                    <div class="cart-summary__overview__item discount-row">
                                        <p>Giảm giá</p>
                                        <p style="color: #d32f2f;">-{{ number_format($discountAmount) }}đ</p>
                                    </div>
                                    @endif
                                    <div class="cart-summary__overview__item">
                                        <p>Phí vận chuyển</p>
                                        <p>{{ number_format($shippingFee ?? 30000) }}đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tiền thanh toán</p>
                                        <p><b>{{ number_format($grandTotal ?? ($totalAmount + 30000)) }}đ</b></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="cart-summary__voucher-form">
                                <div class="cart-summary__voucher-form__title">
                                    <h4 class="active">Mã phiếu giảm giá</h4>
                                    <span> </span>
                                    <h4 data-toggle="modal" data-target="#myVoucherWallet">Mã của tôi</h4>
                                    <div class="modal fade voucher-wallet" id="myVoucherWallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel">Danh sách mã Voucher</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body box-voucher-wallet">
                                                    <p>Rất tiếc, bạn không còn mã giảm giá nào !</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="" id="p_coupon" style="padding-top: 5px; display: none; text-align: center"></p>
                                <div class="form-group">
                                    <div class="d-flex gap-2 align-items-center" style="position: relative;">
                                        <div style="position: relative; flex: 1;">
                                            <input class="form-control" type="text" placeholder="Mã giảm giá" name="coupon_code_text" id="coupon_code_text" value="{{ $appliedVoucher->voucher_code ?? '' }}" readonly style="background-color: #f5f5f5; cursor: pointer;" autocomplete="off" />
                                            <div id="voucherDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; max-height: 300px; overflow-y: auto; z-index: 1000; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                <!-- Danh sách voucher sẽ được load ở đây -->
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn--large" id="but_coupon_code" style="display: {{ $appliedVoucher ? 'inline-block' : 'none' }};">Áp dụng</button>
                                        <button type="button" class="btn btn--large btn-outline-danger" id="but_coupon_delete" style="display: {{ $appliedVoucher ? 'inline-block' : 'none' }};">Bỏ Mã</button>
                                    </div>
                                </div>
                                @if($appliedVoucher)
                                <div id="appliedVoucherInfo" style="padding: 10px; background: #e8f5e9; border-radius: 4px; margin-top: 10px;">
                                    <strong>Đã áp dụng: {{ $appliedVoucher->voucher_code }}</strong>
                                    @if(stripos($appliedVoucher->voucher_code, 'FREESHIP') !== false || stripos($appliedVoucher->description ?? '', 'Miễn phí vận chuyển') !== false)
                                        <span> - Miễn phí vận chuyển</span>
                                    @elseif($appliedVoucher->discount_type === 'percent')
                                        <span> - Giảm {{ $appliedVoucher->discount_value }}%</span>
                                    @elseif($appliedVoucher->discount_type === 'fixed')
                                        <span> - Giảm {{ number_format($appliedVoucher->discount_value) }}đ</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                            
                            <div class="cart-summary__button">
                                <button type="submit" id="but-checkout-continue-step2" name="btn_continue_step2" class="btn btn--large">
                                    Hoàn thành
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="check-otp-order"></div>
            </form>
        </div>
    </div>
</main>

<script>
// Hiển thị/ẩn form VAT
document.querySelector('input[name="receive_vat"]').addEventListener('change', function() {
    const vatForm = document.querySelector('.order_vat_form');
    if (this.checked) {
        vatForm.style.display = 'block';
    } else {
        vatForm.style.display = 'none';
    }
});

// Toggle hiển thị giỏ hàng
document.getElementById('toggleCartBtn').addEventListener('click', function() {
    const cartSection = document.getElementById('cartSection');
    const btn = this;
    
    if (cartSection.style.display === 'none') {
        cartSection.style.display = 'block';
        btn.textContent = 'Ẩn sản phẩm';
    } else {
        cartSection.style.display = 'none';
        btn.textContent = 'Hiển thị sản phẩm';
    }
});

// Xử lý địa chỉ
(function() {
    // Đảm bảo modal hoạt động với Bootstrap 5
    document.addEventListener('DOMContentLoaded', function() {
        // Kiểm tra nếu Bootstrap modal không hoạt động, thêm class show thủ công
        const addressModalElement = document.getElementById('addressModal');
        const addAddressModalElement = document.getElementById('addAddressModal');
        
        // Xử lý khi modal được mở
        if (addressModalElement) {
            addressModalElement.addEventListener('shown.bs.modal', function() {
                this.style.display = 'block';
                this.classList.add('show');
                document.body.classList.add('modal-open');
            });
            
            addressModalElement.addEventListener('hidden.bs.modal', function() {
                this.style.display = 'none';
                this.classList.remove('show');
                document.body.classList.remove('modal-open');
            });
        }
        
        if (addAddressModalElement) {
            addAddressModalElement.addEventListener('shown.bs.modal', function() {
                this.style.display = 'block';
                this.classList.add('show');
                document.body.classList.add('modal-open');
            });
            
            addAddressModalElement.addEventListener('hidden.bs.modal', function() {
                this.style.display = 'none';
                this.classList.remove('show');
                document.body.classList.remove('modal-open');
            });
        }
        
    });
    
    // Lưu thông tin địa chỉ mặc định từ user
    const defaultUserAddress = {
        id: 0,
        name: '{{ $user->name ?? "Khách hàng" }}',
        phone: '{{ $user->phone ?? "Chưa cập nhật" }}',
        address: '{{ $user->address ?? "Chưa cập nhật địa chỉ" }}',
        is_default: true
    };
    
    // Chọn địa chỉ trong modal
    document.querySelectorAll('.address-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (e.target.closest('.address-actions')) return;
            
            const radio = this.querySelector('.address-radio');
            radio.checked = true;
            
            // Bỏ highlight của tất cả địa chỉ
            document.querySelectorAll('.address-item').forEach(addr => {
                addr.classList.remove('border-success');
            });
            
            // Highlight địa chỉ được chọn
            this.classList.add('border-success');
        });
    });
    
    // Xác nhận chọn địa chỉ
    document.getElementById('confirmAddressBtn').addEventListener('click', function() {
        const selectedRadio = document.querySelector('input[name="modal_address_id"]:checked');
        if (!selectedRadio) return;
        
        const addressId = selectedRadio.value;
        let addressData;
        
        if (addressId == '0') {
            addressData = defaultUserAddress;
        } else {
            const addressItem = document.querySelector(`[data-address-id="${addressId}"]`);
            const h4 = addressItem.querySelector('h4');
            const ps = addressItem.querySelectorAll('p');
            
            // Lấy tên (bỏ phần "(Mặc định)" nếu có)
            let name = h4.textContent.trim();
            name = name.replace(/\(Mặc định\)/g, '').trim();
            
            addressData = {
                id: addressId,
                name: name,
                phone: ps[0] ? ps[0].textContent.replace(/Điện thoại:\s*/, '').trim() : '',
                address: ps[1] ? ps[1].textContent.replace(/Địa chỉ:\s*/, '').trim() : '',
                is_default: addressItem.querySelector('.badge-success') !== null
            };
        }
        
        // Cập nhật hiển thị địa chỉ đã chọn
        document.getElementById('selected_address_id').value = addressData.id;
        const selectedAddressName = document.getElementById('selectedAddressName');
        const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
        const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
        
        if (selectedAddressName) {
            selectedAddressName.textContent = addressData.name;
        }
        
        // Hiển thị "(Mặc định)" chỉ khi is_default = true
        if (addressData.is_default) {
            if (!selectedAddressDefaultLabel) {
                // Tạo label nếu chưa có
                const label = document.createElement('span');
                label.id = 'selectedAddressDefaultLabel';
                label.textContent = '(Mặc định)';
                if (selectedAddressNameContainer) {
                    selectedAddressNameContainer.appendChild(label);
                } else if (selectedAddressName && selectedAddressName.parentElement) {
                    selectedAddressName.parentElement.appendChild(label);
                }
            }
        } else {
            // Xóa label nếu không phải mặc định
            if (selectedAddressDefaultLabel) {
                selectedAddressDefaultLabel.remove();
            }
        }
        
        document.getElementById('selectedAddressPhone').textContent = addressData.phone;
        document.getElementById('selectedAddressText').textContent = addressData.address;
        
        // Đóng modal (Bootstrap 5)
        const modalElement = document.getElementById('addressModal');
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.hide();
    });
    
    // Hàm xử lý lưu địa chỉ - đơn giản hơn
    function handleSaveAddress() {
        const modal = document.getElementById('addAddressModal');
        if (!modal) {
            alert('Không tìm thấy modal');
            return;
        }
        
        const fieldsDiv = modal.querySelector('#addressFormFields');
        if (!fieldsDiv) {
            alert('Không tìm thấy form fields');
            return;
        }
        
        // Validate các trường bắt buộc
        const nameInput = fieldsDiv.querySelector('#address_name');
        const phoneInput = fieldsDiv.querySelector('#address_phone');
        const addressInput = fieldsDiv.querySelector('#address_address');
        
        if (!nameInput || !nameInput.value.trim()) {
            alert('Vui lòng nhập tên người nhận');
            if (nameInput) nameInput.focus();
            return;
        }
        
        if (!phoneInput || !phoneInput.value.trim()) {
            alert('Vui lòng nhập số điện thoại');
            if (phoneInput) phoneInput.focus();
            return;
        }
        
        if (!addressInput || !addressInput.value.trim()) {
            alert('Vui lòng nhập địa chỉ chi tiết');
            if (addressInput) addressInput.focus();
            return;
        }
        
        // Tạo FormData
        const formData = new FormData();
        
        // CSRF token
        const csrfField = fieldsDiv.querySelector('#csrf_token_field') || document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfField ? (csrfField.value || csrfField.content) : '';
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }
        
        // Lấy address_id để xác định là update hay add mới
        // Tìm trong nhiều nơi để đảm bảo tìm thấy
        let addressIdInput = fieldsDiv.querySelector('#address_form_id');
        if (!addressIdInput) {
            addressIdInput = modal.querySelector('#address_form_id');
        }
        if (!addressIdInput) {
            addressIdInput = document.getElementById('address_form_id');
        }
        
        let addressId = addressIdInput ? addressIdInput.value.trim() : '';
        
        // Debug: Kiểm tra giá trị trước khi validate
        console.log('🔍 DEBUG Address ID:');
        console.log('  - Input element:', addressIdInput);
        console.log('  - Raw value:', addressIdInput ? addressIdInput.value : 'N/A');
        console.log('  - Trimmed value:', addressId);
        console.log('  - Type:', typeof addressId);
        console.log('  - Is number?:', !isNaN(parseInt(addressId)));
        
        // Kiểm tra lại ngay trước khi gửi
        if (!addressId || addressId === '0' || addressId === '') {
            // Thử tìm lại
            const retryInput = document.getElementById('address_form_id');
            if (retryInput && retryInput.value) {
                addressId = retryInput.value.trim();
                console.log('⚠️ Retry found address ID:', addressId);
            }
        }
        
        formData.append('name', nameInput.value.trim());
        formData.append('phone', phoneInput.value.trim());
        formData.append('address', addressInput.value.trim());
        
        const province = fieldsDiv.querySelector('#address_province')?.value || '';
        const district = fieldsDiv.querySelector('#address_district')?.value || '';
        const ward = fieldsDiv.querySelector('#address_ward')?.value || '';
        
        if (province) formData.append('province', province);
        if (district) formData.append('district', district);
        if (ward) formData.append('ward', ward);
        
        const isDefault = fieldsDiv.querySelector('#address_is_default')?.checked || false;
        if (isDefault) {
            formData.append('is_default', '1');
        }
        
        // Xác định URL và method
        let url = '{{ route("checkout.address.add") }}';
        let method = 'POST';
        
        // Xác định mode: add mới, update địa chỉ đã lưu, hoặc update địa chỉ mặc định (user)
        const isDefaultAddress = addressId === '0';
        const isUpdate = addressId && 
                        addressId !== '0' && 
                        addressId !== '' && 
                        addressId !== null && 
                        addressId !== undefined &&
                        !isNaN(parseInt(addressId));
        
        // Lưu lại mode để dùng sau
        if (isDefaultAddress) {
            window.currentAddressMode = 'update-default';
        } else if (isUpdate) {
            window.currentAddressMode = 'update';
        } else {
            window.currentAddressMode = 'add';
        }
        
        if (isDefaultAddress) {
            // Update địa chỉ mặc định (thông tin user)
            console.log('✅ Mode: UPDATE DEFAULT ADDRESS (user info)');
            url = '{{ route("checkout.user-info.update") }}';
            method = 'POST';
        } else if (isUpdate) {
            // Update địa chỉ đã lưu
            console.log('✅ Mode: UPDATE ADDRESS, Address ID:', addressId);
            url = `{{ route('checkout.address.update', ':id') }}`.replace(':id', addressId);
            method = 'POST'; // Laravel cần POST với _method=PUT
            formData.append('_method', 'PUT');
            
            // Debug: Log formData
            console.log('📤 Sending update request:', {
                url: url,
                method: method,
                addressId: addressId,
                formDataEntries: Array.from(formData.entries())
            });
        } else {
            // Add địa chỉ mới
            console.log('✅ Mode: ADD NEW ADDRESS');
            console.log('Address ID was:', addressId, '(type:', typeof addressId, ')');
        }
        
        // Disable button
        const saveBtn = document.getElementById('saveAddressBtn');
        const originalText = saveBtn ? saveBtn.textContent : '';
        
        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.textContent = 'Đang lưu...';
        }
        
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            console.log('📥 Response status:', response.status);
            console.log('📥 Response headers:', Object.fromEntries(response.headers.entries()));
            
            // Kiểm tra nếu response không phải JSON
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                return response.text().then(text => {
                    console.error('❌ Response is not JSON:', text.substring(0, 500));
                    throw new Error('Server response is not JSON: ' + text.substring(0, 200));
                });
            }
            
            return response.json().then(data => {
                console.log('📥 Response data:', data);
                return data;
            });
        })
        .then(data => {
            if (data.success) {
                // Hiển thị thông báo phù hợp - ưu tiên message từ server, nếu không có thì dùng message mặc định
                const message = data.message || (window.currentAddressMode === 'update' ? 'Sửa địa chỉ thành công!' : 'Thêm địa chỉ thành công!');
                alert(message);
                
                // Kiểm tra nếu là update địa chỉ mặc định thì cập nhật thông tin user trên trang checkout
                if (window.currentAddressMode === 'update-default' && data.user) {
                    // Cập nhật thông tin user trên trang checkout
                    const selectedAddressName = document.getElementById('selectedAddressName');
                    const selectedAddressPhone = document.getElementById('selectedAddressPhone');
                    const selectedAddressText = document.getElementById('selectedAddressText');
                    
                    if (selectedAddressName) {
                        selectedAddressName.textContent = data.user.name || 'Khách hàng';
                    }
                    if (selectedAddressPhone) {
                        selectedAddressPhone.textContent = data.user.phone || 'Chưa cập nhật';
                    }
                    if (selectedAddressText) {
                        selectedAddressText.textContent = data.user.address || 'Chưa cập nhật địa chỉ';
                    }
                    
                    // Đóng modal thêm/sửa
                    const addModalElement = document.getElementById('addAddressModal');
                    const addModal = bootstrap.Modal.getInstance(addModalElement);
                    if (addModal) {
                        addModal.hide();
                    }
                    
                    // Reload danh sách địa chỉ trong modal để cập nhật thông tin user
                    setTimeout(() => {
                        reloadAddressList();
                        // Mở lại modal chọn địa chỉ
                        const addressModal = document.getElementById('addressModal');
                        if (addressModal) {
                            const bsModal = new bootstrap.Modal(addressModal);
                            bsModal.show();
                        }
                    }, 300);
                    
                    // Xóa biến tạm
                    window.currentAddressMode = null;
                    return;
                }
                
                // Xóa biến tạm
                window.currentAddressMode = null;
                
                // Đóng modal thêm/sửa
                const addModalElement = document.getElementById('addAddressModal');
                const addModal = bootstrap.Modal.getInstance(addModalElement);
                if (addModal) {
                    addModal.hide();
                }
                
                // Reset form
                const formFields = document.getElementById('addressFormFields');
                if (formFields) {
                    const formIdInput = formFields.querySelector('#address_form_id');
                    if (formIdInput) formIdInput.value = '';
                    
                    const nameInput = formFields.querySelector('#address_name');
                    const phoneInput = formFields.querySelector('#address_phone');
                    const addressInput = formFields.querySelector('#address_address');
                    const provinceInput = formFields.querySelector('#address_province');
                    const districtInput = formFields.querySelector('#address_district');
                    const wardInput = formFields.querySelector('#address_ward');
                    const defaultCheckbox = formFields.querySelector('#address_is_default');
                    
                    if (nameInput) nameInput.value = '';
                    if (phoneInput) phoneInput.value = '';
                    if (addressInput) addressInput.value = '';
                    if (provinceInput) provinceInput.value = '';
                    if (districtInput) districtInput.value = '';
                    if (wardInput) wardInput.value = '';
                    if (defaultCheckbox) defaultCheckbox.checked = false;
                    
                    document.getElementById('addAddressModalLabel').textContent = 'Thêm địa chỉ mới';
                }
                
                // Reload danh sách địa chỉ và mở lại modal chọn địa chỉ
                setTimeout(() => {
                    reloadAddressList();
                    // Mở lại modal chọn địa chỉ
                    const addressModal = document.getElementById('addressModal');
                    if (addressModal) {
                        const bsModal = new bootstrap.Modal(addressModal);
                        bsModal.show();
                    }
                }, 300);
            } else {
                // Hiển thị lỗi validation nếu có
                let errorMsg = data.message || 'Có lỗi xảy ra';
                if (data.errors) {
                    const errors = Object.values(data.errors).flat();
                    errorMsg = errors.join('\n');
                }
                alert(errorMsg);
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.textContent = originalText || 'Lưu địa chỉ';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi lưu địa chỉ: ' + error.message);
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.textContent = originalText || 'Lưu địa chỉ';
            }
        });
    }
    
    // Xử lý click button lưu địa chỉ - đơn giản
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'saveAddressBtn') {
            e.preventDefault();
            e.stopPropagation();
            handleSaveAddress();
        }
    });
    
    // Sửa địa chỉ mặc định (user info)
    document.querySelectorAll('.edit-default-address').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const addressId = this.dataset.id;
            
            // Lấy thông tin user từ server
            fetch('{{ route("checkout.user-info.get") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.user) {
                    const user = data.user;
                    
                    // Điền form với thông tin user
                    const formFieldsDiv = document.getElementById('addressFormFields');
                    let formIdInput = null;
                    
                    if (formFieldsDiv) {
                        formIdInput = formFieldsDiv.querySelector('#address_form_id');
                    }
                    if (!formIdInput) {
                        formIdInput = document.getElementById('address_form_id');
                    }
                    
                    // Set ID = 0 để đánh dấu đây là địa chỉ mặc định
                    if (formIdInput) {
                        formIdInput.value = '0';
                    }
                    
                    // Reset button
                    const saveBtn = document.getElementById('saveAddressBtn');
                    if (saveBtn) {
                        saveBtn.disabled = false;
                        saveBtn.textContent = 'Lưu địa chỉ';
                    }
                    
                    document.getElementById('addAddressModalLabel').textContent = 'Sửa địa chỉ mặc định';
                    
                    const nameField = document.getElementById('address_name');
                    const phoneField = document.getElementById('address_phone');
                    const addressField = document.getElementById('address_address');
                    
                    if (nameField) nameField.value = user.name || '';
                    if (phoneField) phoneField.value = user.phone || '';
                    if (addressField) addressField.value = user.address || '';
                    
                    // Reset các trường không dùng cho user
                    const provinceField = document.getElementById('address_province');
                    const districtField = document.getElementById('address_district');
                    const wardField = document.getElementById('address_ward');
                    const defaultCheckbox = document.getElementById('address_is_default');
                    
                    if (provinceField) provinceField.value = '';
                    if (districtField) districtField.value = '';
                    if (wardField) wardField.value = '';
                    if (defaultCheckbox) defaultCheckbox.checked = false;
                    
                    // Đóng modal chọn và mở modal sửa
                    const addressModalElement = document.getElementById('addressModal');
                    const addressModal = bootstrap.Modal.getInstance(addressModalElement);
                    if (addressModal) {
                        addressModal.hide();
                    }
                    
                    const addModalElement = document.getElementById('addAddressModal');
                    const addModal = new bootstrap.Modal(addModalElement);
                    
                    addModalElement.addEventListener('shown.bs.modal', function() {
                        const saveBtn = document.getElementById('saveAddressBtn');
                        if (saveBtn) {
                            saveBtn.disabled = false;
                            saveBtn.textContent = 'Lưu địa chỉ';
                        }
                    }, { once: true });
                    
                    addModal.show();
                } else {
                    alert('Không thể tải thông tin địa chỉ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải thông tin địa chỉ');
            });
        });
    });
    
    // Xóa địa chỉ mặc định
    document.querySelectorAll('.clear-default-address').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            if (!confirm('Bạn có chắc chắn muốn xóa địa chỉ mặc định này?')) return;
            
            fetch('{{ route("checkout.user-info.clear-address") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    
                    // Cập nhật phần hiển thị trên trang checkout
                    const selectedAddressName = document.getElementById('selectedAddressName');
                    const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
                    const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
                    const selectedAddressText = document.getElementById('selectedAddressText');
                    
                    if (selectedAddressName && data.user) {
                        selectedAddressName.textContent = data.user.name || 'Khách hàng';
                    }
                    
                    // Xóa label "(Mặc định)" vì đã xóa địa chỉ
                    if (selectedAddressDefaultLabel) {
                        selectedAddressDefaultLabel.remove();
                    }
                    
                    if (selectedAddressText) {
                        selectedAddressText.textContent = 'Chưa cập nhật địa chỉ';
                    }
                    
                    // Reload danh sách địa chỉ để ẩn địa chỉ user
                    reloadAddressList();
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa địa chỉ');
            });
        });
    });
    
    // Sửa địa chỉ đã lưu
    document.querySelectorAll('.edit-address').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const addressId = this.dataset.id;
            
            // Lấy thông tin địa chỉ từ server
            fetch(`{{ route('checkout.address.get', ':id') }}`.replace(':id', addressId), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.address) {
                    const addr = data.address;
                    
                    // Điền form - đảm bảo address_form_id được set
                    const formFieldsDiv = document.getElementById('addressFormFields');
                    let formIdInput = null;
                    
                    if (formFieldsDiv) {
                        formIdInput = formFieldsDiv.querySelector('#address_form_id');
                    }
                    
                    if (!formIdInput) {
                        formIdInput = document.getElementById('address_form_id');
                    }
                    
                    if (formIdInput) {
                        formIdInput.value = addr.id;
                        console.log('✅ Set address_form_id to:', addr.id);
                        console.log('✅ Input element:', formIdInput);
                        console.log('✅ Input value after set:', formIdInput.value);
                    } else {
                        console.error('❌ Không tìm thấy address_form_id input!');
                    }
                    
                    // Reset button về trạng thái ban đầu
                    const saveBtn = document.getElementById('saveAddressBtn');
                    if (saveBtn) {
                        saveBtn.disabled = false;
                        saveBtn.textContent = 'Lưu địa chỉ';
                    }
                    
                    document.getElementById('addAddressModalLabel').textContent = 'Sửa địa chỉ';
                    
                    const nameField = document.getElementById('address_name');
                    const phoneField = document.getElementById('address_phone');
                    const addressField = document.getElementById('address_address');
                    
                    if (nameField) nameField.value = addr.name || '';
                    if (phoneField) phoneField.value = addr.phone || '';
                    if (addressField) addressField.value = addr.address || '';
                    
                    const provinceField = document.getElementById('address_province');
                    const districtField = document.getElementById('address_district');
                    const wardField = document.getElementById('address_ward');
                    
                    if (provinceField) provinceField.value = addr.province || '';
                    if (districtField) districtField.value = addr.district || '';
                    if (wardField) wardField.value = addr.ward || '';
                    
                    const defaultCheckbox = document.getElementById('address_is_default');
                    if (defaultCheckbox) defaultCheckbox.checked = addr.is_default || false;
                    
            // Đóng modal chọn và mở modal sửa (Bootstrap 5)
            const addressModalElement = document.getElementById('addressModal');
            const addressModal = bootstrap.Modal.getInstance(addressModalElement) || new bootstrap.Modal(addressModalElement);
            addressModal.hide();
            
            // Reset button trước khi mở modal
            const saveBtnBefore = document.getElementById('saveAddressBtn');
            if (saveBtnBefore) {
                saveBtnBefore.disabled = false;
                saveBtnBefore.textContent = 'Lưu địa chỉ';
            }
            
            const addModalElement = document.getElementById('addAddressModal');
            const addModal = new bootstrap.Modal(addModalElement);
            
            // Đảm bảo button được reset sau khi modal hiển thị
            addModalElement.addEventListener('shown.bs.modal', function() {
                const saveBtn = document.getElementById('saveAddressBtn');
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Lưu địa chỉ';
                }
            }, { once: true });
            
            addModal.show();
                } else {
                    alert('Không thể tải thông tin địa chỉ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi tải thông tin địa chỉ');
            });
        });
    });
    
    // Xóa địa chỉ
    document.querySelectorAll('.delete-address').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const addressId = this.dataset.id;
            
            if (!confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')) return;
            
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            
            fetch(`{{ route('checkout.address.delete', ':id') }}`.replace(':id', addressId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    console.log('✅ Xóa địa chỉ thành công, còn lại:', data.remaining_count, 'địa chỉ');
                    // Reload danh sách địa chỉ
                    reloadAddressList();
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa địa chỉ');
            });
        });
    });
    
    // Đặt địa chỉ làm mặc định
    document.querySelectorAll('.set-default-address').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const addressId = this.dataset.id;
            
            fetch(`{{ route('checkout.address.set-default', ':id') }}`.replace(':id', addressId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    
                    // Cập nhật phần hiển thị địa chỉ mặc định trên trang checkout
                    if (data.address) {
                        const selectedAddressName = document.getElementById('selectedAddressName');
                        const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
                        const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
                        const selectedAddressPhone = document.getElementById('selectedAddressPhone');
                        const selectedAddressText = document.getElementById('selectedAddressText');
                        const selectedAddressId = document.getElementById('selected_address_id');
                        
                        if (selectedAddressName) {
                            selectedAddressName.textContent = data.address.name;
                        }
                        
                        // Hiển thị "(Mặc định)" chỉ khi is_default = true
                        if (data.address.is_default) {
                            if (!selectedAddressDefaultLabel) {
                                // Tạo label nếu chưa có
                                const label = document.createElement('span');
                                label.id = 'selectedAddressDefaultLabel';
                                label.textContent = '(Mặc định)';
                                if (selectedAddressNameContainer) {
                                    selectedAddressNameContainer.appendChild(label);
                                } else if (selectedAddressName && selectedAddressName.parentElement) {
                                    selectedAddressName.parentElement.appendChild(label);
                                }
                            }
                        } else {
                            // Xóa label nếu không phải mặc định
                            if (selectedAddressDefaultLabel) {
                                selectedAddressDefaultLabel.remove();
                            }
                        }
                        
                        if (selectedAddressPhone) {
                            selectedAddressPhone.textContent = data.address.phone || 'Chưa cập nhật';
                        }
                        if (selectedAddressText) {
                            selectedAddressText.textContent = data.address.address || 'Chưa cập nhật địa chỉ';
                        }
                        if (selectedAddressId) {
                            selectedAddressId.value = data.address.id;
                        }
                    }
                    
                    // Reload danh sách địa chỉ trong modal
                    reloadAddressList();
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi đặt địa chỉ mặc định');
            });
        });
    });
    
    // Hàm reload danh sách địa chỉ
    function reloadAddressList() {
        // Fetch lại thông tin user và danh sách địa chỉ từ server
        Promise.all([
            fetch('{{ route("checkout.user-info.get") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => response.json()),
            fetch('{{ route("checkout.addresses.get") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => response.json())
        ])
        .then(([userData, addressesData]) => {
            if (addressesData.success && addressesData.addresses) {
                const addressList = document.getElementById('addressList');
                if (!addressList) return;
                
                // Lấy địa chỉ mặc định từ user (nếu không có địa chỉ nào được set default)
                const defaultUserAddress = {
                    id: 0,
                    name: (userData.success && userData.user) ? userData.user.name : '{{ $user->name ?? "Khách hàng" }}',
                    phone: (userData.success && userData.user) ? userData.user.phone : '{{ $user->phone ?? "Chưa cập nhật" }}',
                    address: (userData.success && userData.user) ? userData.user.address : '{{ $user->address ?? "Chưa cập nhật địa chỉ" }}',
                    is_default: true
                };
                
                // Cập nhật thông tin user trên trang checkout nếu có
                if (userData.success && userData.user) {
                    const selectedAddressName = document.getElementById('selectedAddressName');
                    const selectedAddressPhone = document.getElementById('selectedAddressPhone');
                    const selectedAddressText = document.getElementById('selectedAddressText');
                    
                    if (selectedAddressName) {
                        selectedAddressName.textContent = userData.user.name || 'Khách hàng';
                    }
                    if (selectedAddressPhone) {
                        selectedAddressPhone.textContent = userData.user.phone || 'Chưa cập nhật';
                    }
                    if (selectedAddressText) {
                        selectedAddressText.textContent = userData.user.address || 'Chưa cập nhật địa chỉ';
                    }
                }
                
                // Tạo HTML cho danh sách địa chỉ
                let html = '';
                
                // Kiểm tra xem có địa chỉ nào được set làm mặc định không
                const hasDefaultAddress = addressesData.addresses.some(addr => addr.is_default);
                
                // Kiểm tra xem user có địa chỉ hay không (address không null và không rỗng)
                const userHasAddress = userData.success && 
                                     userData.user && 
                                     userData.user.address && 
                                     userData.user.address.trim() !== '' &&
                                     userData.user.address !== 'Chưa cập nhật địa chỉ';
                
                // Chỉ hiển thị địa chỉ user khi:
                // 1. Không có địa chỉ nào được set làm mặc định
                // 2. VÀ user có địa chỉ (không null/empty)
                if (!hasDefaultAddress && userHasAddress) {
                    // Địa chỉ mặc định từ user (chỉ hiển thị khi không có địa chỉ nào được set làm mặc định và user có address)
                    html += `
                        <div class="block-border change-address address-item border-success" data-address-id="0" style="cursor: pointer; margin-bottom: 15px;">
                            <input type="radio" class="address-radio" name="modal_address_id" value="0" checked />
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4>${defaultUserAddress.name} <span>(Mặc định)</span></h4>
                                    <p>Điện thoại: <span>${defaultUserAddress.phone}</span></p>
                                    <p>Địa chỉ: <span>${defaultUserAddress.address}</span></p>
                                </div>
                                <div class="address-actions">
                                    <span class="badge badge-success mb-2 d-block">Mặc định</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary edit-default-address" data-id="0">Sửa</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger clear-default-address" data-id="0">Xóa</button>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Sắp xếp: địa chỉ mặc định (is_default=true) hiển thị trước
                const sortedAddresses = [...addressesData.addresses].sort((a, b) => {
                    if (a.is_default && !b.is_default) return -1;
                    if (!a.is_default && b.is_default) return 1;
                    return 0;
                });
                
                // Các địa chỉ đã lưu
                sortedAddresses.forEach(address => {
                    const locationParts = [];
                    if (address.ward) locationParts.push(address.ward);
                    if (address.district) locationParts.push(address.district);
                    if (address.province) locationParts.push(address.province);
                    const locationStr = locationParts.length > 0 ? `<p>${locationParts.join(', ')}</p>` : '';
                    
                    html += `
                        <div class="block-border change-address address-item ${address.is_default ? 'border-success' : ''}" data-address-id="${address.id}" style="cursor: pointer; margin-bottom: 15px;">
                            <input type="radio" class="address-radio" name="modal_address_id" value="${address.id}" ${address.is_default ? 'checked' : ''} />
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h4>${address.name}${address.is_default ? ' <span>(Mặc định)</span>' : ''}</h4>
                                    <p>Điện thoại: <span>${address.phone}</span></p>
                                    <p>Địa chỉ: <span>${address.address}</span></p>
                                    ${locationStr}
                                </div>
                                <div class="address-actions">
                                    ${address.is_default ? 
                                        '<span class="badge badge-success mb-2 d-block">Mặc định</span>' : 
                                        `<button type="button" class="btn btn-sm btn-outline-primary set-default-address mb-2" data-id="${address.id}">Đặt mặc định</button>`
                                    }
                                    <button type="button" class="btn btn-sm btn-outline-secondary edit-address" data-id="${address.id}">Sửa</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-address" data-id="${address.id}">Xóa</button>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                // Thêm nút "Thêm địa chỉ mới" nếu chưa đạt giới hạn
                if (data.count < 5) {
                    html += `
                        <button type="button" class="btn btn--large mt-3" id="btnAddNewAddressFromModal">
                            <span class="icon-ic_plus"></span><span>Thêm Địa Chỉ Mới</span>
                        </button>
                    `;
                } else {
                    html += `
                        <div class="alert alert-warning mt-3">
                            Bạn đã đạt giới hạn tối đa 5 địa chỉ.
                        </div>
                    `;
                }
                
                // Cập nhật HTML
                addressList.innerHTML = html;
                
                // Re-attach event listeners
                attachAddressEventListeners();
                
                // Re-attach edit-default-address listeners
                document.querySelectorAll('.edit-default-address').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        
                        fetch('{{ route("checkout.user-info.get") }}', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.user) {
                                const user = data.user;
                                const formIdInput = document.getElementById('address_form_id');
                                if (formIdInput) formIdInput.value = '0';
                                
                                const saveBtn = document.getElementById('saveAddressBtn');
                                if (saveBtn) {
                                    saveBtn.disabled = false;
                                    saveBtn.textContent = 'Lưu địa chỉ';
                                }
                                
                                document.getElementById('addAddressModalLabel').textContent = 'Sửa địa chỉ mặc định';
                                document.getElementById('address_name').value = user.name || '';
                                document.getElementById('address_phone').value = user.phone || '';
                                document.getElementById('address_address').value = user.address || '';
                                
                                const addressModalElement = document.getElementById('addressModal');
                                const addressModal = bootstrap.Modal.getInstance(addressModalElement);
                                if (addressModal) addressModal.hide();
                                
                                const addModalElement = document.getElementById('addAddressModal');
                                const addModal = new bootstrap.Modal(addModalElement);
                                addModal.show();
                            }
                        });
                    });
                });
                
                // Re-attach clear-default-address listeners
                document.querySelectorAll('.clear-default-address').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (!confirm('Bạn có chắc chắn muốn xóa địa chỉ mặc định này?')) return;
                        
                        fetch('{{ route("checkout.user-info.clear-address") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                
                                // Cập nhật phần hiển thị trên trang checkout
                                const selectedAddressName = document.getElementById('selectedAddressName');
                                const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
                                const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
                                const selectedAddressText = document.getElementById('selectedAddressText');
                                
                                if (selectedAddressName && data.user) {
                                    selectedAddressName.textContent = data.user.name || 'Khách hàng';
                                }
                                
                                // Xóa label "(Mặc định)"
                                if (selectedAddressDefaultLabel) {
                                    selectedAddressDefaultLabel.remove();
                                }
                                
                                if (selectedAddressText) {
                                    selectedAddressText.textContent = 'Chưa cập nhật địa chỉ';
                                }
                                
                                // Reload danh sách địa chỉ để ẩn địa chỉ user
                                reloadAddressList();
                            }
                        });
                    });
                });
                
                // Re-attach click handlers cho address items
                document.querySelectorAll('.address-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        if (e.target.closest('.address-actions')) return;
                        
                        const radio = this.querySelector('.address-radio');
                        radio.checked = true;
                        
                        document.querySelectorAll('.address-item').forEach(addr => {
                            addr.classList.remove('border-success');
                        });
                        
                        this.classList.add('border-success');
                    });
                });
                
                // Re-attach button "Thêm địa chỉ mới"
                const btnAddNew = document.getElementById('btnAddNewAddressFromModal');
                if (btnAddNew) {
                    btnAddNew.addEventListener('click', function() {
                        const addressModalElement = document.getElementById('addressModal');
                        const addressModal = bootstrap.Modal.getInstance(addressModalElement);
                        if (addressModal) {
                            addressModal.hide();
                        }
                        
                        setTimeout(function() {
                            const addModalElement = document.getElementById('addAddressModal');
                            const addModal = new bootstrap.Modal(addModalElement);
                            addModal.show();
                        }, 300);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error reloading address list:', error);
            // Fallback: reload trang nếu có lỗi
            location.reload();
        });
    }
    
    // Hàm attach event listeners cho các nút trong danh sách địa chỉ
    function attachAddressEventListeners() {
        // Re-attach edit listeners
        document.querySelectorAll('.edit-address').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const addressId = this.dataset.id;
                
                fetch(`{{ route('checkout.address.get', ':id') }}`.replace(':id', addressId), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.address) {
                        const addr = data.address;
                        
                        const formFieldsDiv = document.getElementById('addressFormFields');
                        let formIdInput = null;
                        
                        if (formFieldsDiv) {
                            formIdInput = formFieldsDiv.querySelector('#address_form_id');
                        }
                        if (!formIdInput) {
                            formIdInput = document.getElementById('address_form_id');
                        }
                        
                        if (formIdInput) {
                            formIdInput.value = addr.id;
                            console.log('✅ Set address_form_id (from attachAddressEventListeners):', addr.id);
                        }
                        
                        // Reset button về trạng thái ban đầu
                        const saveBtn = document.getElementById('saveAddressBtn');
                        if (saveBtn) {
                            saveBtn.disabled = false;
                            saveBtn.textContent = 'Lưu địa chỉ';
                        }
                        
                        document.getElementById('addAddressModalLabel').textContent = 'Sửa địa chỉ';
                        
                        const nameField = document.getElementById('address_name');
                        const phoneField = document.getElementById('address_phone');
                        const addressField = document.getElementById('address_address');
                        
                        if (nameField) nameField.value = addr.name || '';
                        if (phoneField) phoneField.value = addr.phone || '';
                        if (addressField) addressField.value = addr.address || '';
                        
                        const provinceField = document.getElementById('address_province');
                        const districtField = document.getElementById('address_district');
                        const wardField = document.getElementById('address_ward');
                        
                        if (provinceField) provinceField.value = addr.province || '';
                        if (districtField) districtField.value = addr.district || '';
                        if (wardField) wardField.value = addr.ward || '';
                        
                        const defaultCheckbox = document.getElementById('address_is_default');
                        if (defaultCheckbox) defaultCheckbox.checked = addr.is_default || false;
                        
                        // Reset button trước khi mở modal
                        const saveBtnBefore = document.getElementById('saveAddressBtn');
                        if (saveBtnBefore) {
                            saveBtnBefore.disabled = false;
                            saveBtnBefore.textContent = 'Lưu địa chỉ';
                        }
                        
                        const addressModalElement = document.getElementById('addressModal');
                        const addressModal = bootstrap.Modal.getInstance(addressModalElement);
                        if (addressModal) {
                            addressModal.hide();
                        }
                        
                        const addModalElement = document.getElementById('addAddressModal');
                        const addModal = new bootstrap.Modal(addModalElement);
                        
                        // Đảm bảo button được reset sau khi modal hiển thị
                        addModalElement.addEventListener('shown.bs.modal', function() {
                            const saveBtn = document.getElementById('saveAddressBtn');
                            if (saveBtn) {
                                saveBtn.disabled = false;
                                saveBtn.textContent = 'Lưu địa chỉ';
                            }
                        }, { once: true });
                        
                        addModal.show();
                    }
                });
            });
        });
        
        // Re-attach delete listeners
        document.querySelectorAll('.delete-address').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const addressId = this.dataset.id;
                
                if (!confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')) return;
                
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                
                fetch(`{{ route('checkout.address.delete', ':id') }}`.replace(':id', addressId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        reloadAddressList();
                    }
                });
            });
        });
        
                        // Re-attach set-default listeners
                        document.querySelectorAll('.set-default-address').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                const addressId = this.dataset.id;
                                
                                fetch(`{{ route('checkout.address.set-default', ':id') }}`.replace(':id', addressId), {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert(data.message);
                                        
                                        // Cập nhật phần hiển thị địa chỉ mặc định trên trang checkout
                                        if (data.address) {
                                            const selectedAddressName = document.getElementById('selectedAddressName');
                                            const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
                                            const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
                                            const selectedAddressPhone = document.getElementById('selectedAddressPhone');
                                            const selectedAddressText = document.getElementById('selectedAddressText');
                                            const selectedAddressId = document.getElementById('selected_address_id');
                                            
                                            if (selectedAddressName) {
                                                selectedAddressName.textContent = data.address.name;
                                            }
                                            
                                            // Hiển thị "(Mặc định)" chỉ khi is_default = true
                                            if (data.address.is_default) {
                                                if (!selectedAddressDefaultLabel) {
                                                    // Tạo label nếu chưa có
                                                    const label = document.createElement('span');
                                                    label.id = 'selectedAddressDefaultLabel';
                                                    label.textContent = '(Mặc định)';
                                                    if (selectedAddressNameContainer) {
                                                        selectedAddressNameContainer.appendChild(label);
                                                    } else if (selectedAddressName && selectedAddressName.parentElement) {
                                                        selectedAddressName.parentElement.appendChild(label);
                                                    }
                                                }
                                            } else {
                                                // Xóa label nếu không phải mặc định
                                                if (selectedAddressDefaultLabel) {
                                                    selectedAddressDefaultLabel.remove();
                                                }
                                            }
                                            
                                            if (selectedAddressPhone) {
                                                selectedAddressPhone.textContent = data.address.phone || 'Chưa cập nhật';
                                            }
                                            if (selectedAddressText) {
                                                selectedAddressText.textContent = data.address.address || 'Chưa cập nhật địa chỉ';
                                            }
                                            if (selectedAddressId) {
                                                selectedAddressId.value = data.address.id;
                                            }
                                        }
                                        
                                        reloadAddressList();
                                    }
                                });
                            });
                        });
    }
    
    // Reset form và button khi mở modal (Bootstrap 5)
    const addAddressModalElement = document.getElementById('addAddressModal');
    if (addAddressModalElement) {
        addAddressModalElement.addEventListener('show.bs.modal', function() {
            // Luôn reset button về trạng thái ban đầu
            const saveBtn = document.getElementById('saveAddressBtn');
            if (saveBtn) {
                saveBtn.disabled = false;
                saveBtn.textContent = 'Lưu địa chỉ';
                console.log('✅ Reset button state');
            }
            
            const formFieldsDiv = document.getElementById('addressFormFields');
            let formIdInput = null;
            
            if (formFieldsDiv) {
                formIdInput = formFieldsDiv.querySelector('#address_form_id');
            }
            if (!formIdInput) {
                formIdInput = document.getElementById('address_form_id');
            }
            
            // Chỉ reset nếu đang mở để thêm mới (không phải để sửa)
            // Kiểm tra modal label để biết là thêm mới hay sửa
            const modalLabel = document.getElementById('addAddressModalLabel');
            const isEditMode = modalLabel && modalLabel.textContent.includes('Sửa');
            
            if (!isEditMode) {
                // Chỉ reset khi thêm mới
                if (formIdInput) {
                    formIdInput.value = '';
                    console.log('✅ Reset address_form_id (thêm mới)');
                }
                if (modalLabel) modalLabel.textContent = 'Thêm địa chỉ mới';
                
                // Reset các fields
                const nameInput = document.getElementById('address_name');
                const phoneInput = document.getElementById('address_phone');
                const addressInput = document.getElementById('address_address');
                const provinceInput = document.getElementById('address_province');
                const districtInput = document.getElementById('address_district');
                const wardInput = document.getElementById('address_ward');
                const defaultCheckbox = document.getElementById('address_is_default');
                
                if (nameInput) nameInput.value = '';
                if (phoneInput) phoneInput.value = '';
                if (addressInput) addressInput.value = '';
                if (provinceInput) provinceInput.value = '';
                if (districtInput) districtInput.value = '';
                if (wardInput) wardInput.value = '';
                if (defaultCheckbox) defaultCheckbox.checked = false;
            } else {
                console.log('✅ Modal mở ở chế độ sửa, không reset form');
            }
        });
    }
    
    // Xử lý nút "Thêm Địa Chỉ Mới" trong modal chọn địa chỉ
    const btnAddNewAddressFromModal = document.getElementById('btnAddNewAddressFromModal');
    if (btnAddNewAddressFromModal) {
        btnAddNewAddressFromModal.addEventListener('click', function() {
            // Đóng modal chọn địa chỉ
            const addressModalElement = document.getElementById('addressModal');
            const addressModal = bootstrap.Modal.getInstance(addressModalElement);
            if (addressModal) {
                addressModal.hide();
            }
            
            // Mở modal thêm địa chỉ sau khi modal chọn địa chỉ đóng
            setTimeout(function() {
                const addModalElement = document.getElementById('addAddressModal');
                const addModal = new bootstrap.Modal(addModalElement);
                addModal.show();
            }, 300);
        });
    }

    // ==================== VOUCHER DROPDOWN ====================
    // Load danh sách voucher vào dropdown
    function loadVouchersToDropdown() {
        const dropdown = document.getElementById('voucherDropdown');
        if (!dropdown) return;
        
        dropdown.innerHTML = '<div style="padding: 10px; text-align: center; color: #999;">Đang tải...</div>';
        
        fetch('{{ route("checkout.vouchers.get") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Vouchers data:', data);
            if (data.success && data.vouchers && data.vouchers.length > 0) {
                let html = '';
                data.vouchers.forEach(voucher => {
                    html += `
                        <div class="voucher-dropdown-item" data-code="${voucher.code}" style="padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #eee; transition: background-color 0.2s;">
                            <div style="font-weight: 500; color: #333;">${voucher.code}</div>
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">${voucher.discount_text || 'Mã giảm giá'}</div>
                            ${voucher.description ? `<div style="font-size: 11px; color: #999; margin-top: 2px;">${voucher.description}</div>` : ''}
                        </div>
                    `;
                });
                dropdown.innerHTML = html;
                
                // Attach click event cho mỗi item
                document.querySelectorAll('.voucher-dropdown-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const code = this.getAttribute('data-code');
                        const couponCodeInput = document.getElementById('coupon_code_text');
                        if (couponCodeInput) {
                            couponCodeInput.value = code;
                            // Đóng dropdown
                            dropdown.style.display = 'none';
                            // Tự động áp dụng voucher
                            applyVoucher(code);
                        }
                    });
                    
                    item.addEventListener('mouseenter', function() {
                        this.style.backgroundColor = '#f5f5f5';
                    });
                    
                    item.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = 'white';
                    });
                });
            } else {
                dropdown.innerHTML = '<div style="padding: 10px; text-align: center; color: #999;">Không có mã giảm giá</div>';
            }
        })
        .catch(error => {
            console.error('Error loading vouchers:', error);
            dropdown.innerHTML = '<div style="padding: 10px; text-align: center; color: #d32f2f;">Lỗi khi tải danh sách</div>';
        });
    }

    // Toggle dropdown khi click vào input
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('voucherDropdown');
        const couponCodeInput = document.getElementById('coupon_code_text');
        
        if (dropdown && couponCodeInput) {
            let vouchersLoaded = false;
            
            // Click vào input để mở/đóng dropdown
            couponCodeInput.addEventListener('click', function(e) {
                e.stopPropagation();
                
                if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                    // Mở dropdown
                    dropdown.style.display = 'block';
                    
                    // Load vouchers lần đầu tiên
                    if (!vouchersLoaded) {
                        loadVouchersToDropdown();
                        vouchersLoaded = true;
                    }
                } else {
                    // Đóng dropdown
                    dropdown.style.display = 'none';
                }
            });
            
            // Đóng dropdown khi click bên ngoài
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && e.target !== couponCodeInput) {
                    dropdown.style.display = 'none';
                }
            });
        }
    });

    // Áp dụng voucher
    function applyVoucher(code) {
        if (!code) {
            const couponCodeInput = document.getElementById('coupon_code_text');
            if (couponCodeInput) {
                code = couponCodeInput.value.trim();
            }
        }

        if (!code) {
            alert('Vui lòng nhập mã giảm giá');
            return;
        }

        const btnApply = document.getElementById('but_coupon_code');
        const originalText = btnApply.textContent;
        btnApply.disabled = true;
        btnApply.textContent = 'Đang xử lý...';

        fetch('{{ route("checkout.voucher.apply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                voucher_code: code
            })
        })
        .then(response => response.json())
        .then(data => {
            btnApply.disabled = false;
            btnApply.textContent = originalText;

            console.log('Voucher apply response:', data);

            if (data.success) {
                alert(data.message);
                
                // Hiển thị thông tin voucher đã áp dụng
                updateVoucherInfo(data.voucher, data.discount_amount, data.shipping_fee);
                
                // Cập nhật tổng tiền thanh toán
                updateGrandTotal(data.grand_total, data.shipping_fee, data.discount_amount);
                
                // Hiển thị nút "Áp dụng" và "Bỏ Mã"
                const btnCouponCode = document.getElementById('but_coupon_code');
                const btnCouponDelete = document.getElementById('but_coupon_delete');
                if (btnCouponCode) btnCouponCode.style.display = 'inline-block';
                if (btnCouponDelete) btnCouponDelete.style.display = 'inline-block';
            } else {
                alert(data.message || 'Có lỗi xảy ra khi áp dụng mã giảm giá');
            }
        })
        .catch(error => {
            btnApply.disabled = false;
            btnApply.textContent = originalText;
            console.error('Error applying voucher:', error);
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
        });
    }

    // Xóa voucher
    document.addEventListener('DOMContentLoaded', function() {
        const butCouponDelete = document.getElementById('but_coupon_delete');
        if (butCouponDelete) {
            butCouponDelete.addEventListener('click', function() {
                fetch('{{ route("checkout.voucher.remove") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        const couponCodeInput = document.getElementById('coupon_code_text');
                        if (couponCodeInput) couponCodeInput.value = '';
                        document.getElementById('but_coupon_delete').style.display = 'none';
                        
                        // Xóa thông tin voucher đã áp dụng
                        const voucherInfo = document.getElementById('appliedVoucherInfo');
                        if (voucherInfo) voucherInfo.remove();
                        
                        // Cập nhật lại tổng tiền
                        updateGrandTotal(data.grand_total, data.shipping_fee, 0);
                    }
                })
                .catch(error => {
                    console.error('Error removing voucher:', error);
                });
            });
        }
    });

    // Nút áp dụng voucher
    document.addEventListener('DOMContentLoaded', function() {
        const butCouponCode = document.getElementById('but_coupon_code');
        if (butCouponCode) {
            butCouponCode.addEventListener('click', function() {
                applyVoucher();
            });
        }
    });

    // Cập nhật thông tin voucher đã áp dụng
    function updateVoucherInfo(voucher, discountAmount, shippingFee) {
        let voucherInfoDiv = document.getElementById('appliedVoucherInfo');
        
        if (!voucherInfoDiv) {
            voucherInfoDiv = document.createElement('div');
            voucherInfoDiv.id = 'appliedVoucherInfo';
            voucherInfoDiv.style.cssText = 'padding: 10px; background: #e8f5e9; border-radius: 4px; margin-top: 10px;';
            document.querySelector('.cart-summary__voucher-form').appendChild(voucherInfoDiv);
        }

        let discountText = '';
        if (voucher.is_freeship) {
            discountText = ' - Miễn phí vận chuyển';
        } else if (voucher.discount_type === 'percent') {
            discountText = ' - Giảm ' + voucher.discount_value + '%';
        } else if (voucher.discount_type === 'fixed') {
            discountText = ' - Giảm ' + new Intl.NumberFormat('vi-VN').format(voucher.discount_value) + 'đ';
        }

        voucherInfoDiv.innerHTML = '<strong>Đã áp dụng: ' + voucher.code + '</strong>' + discountText;
    }

    // Cập nhật tổng tiền thanh toán
    function updateGrandTotal(grandTotal, shippingFee, discountAmount) {
        console.log('Updating grand total:', { grandTotal, shippingFee, discountAmount });
        
        // Tìm tất cả các item trong overview
        const overviewItems = document.querySelectorAll('.cart-summary__overview__item');
        
        overviewItems.forEach(item => {
            const firstP = item.querySelector('p:first-child');
            if (!firstP) return;
            
            // Cập nhật phí vận chuyển
            if (firstP.textContent.trim().includes('Phí vận chuyển')) {
                const secondP = item.querySelector('p:last-child');
                if (secondP) {
                    secondP.textContent = new Intl.NumberFormat('vi-VN').format(shippingFee) + 'đ';
                }
            }
            
            // Cập nhật tiền thanh toán
            if (firstP.textContent.trim().includes('Tiền thanh toán')) {
                const boldElement = item.querySelector('p b');
                if (boldElement) {
                    boldElement.textContent = new Intl.NumberFormat('vi-VN').format(grandTotal) + 'đ';
                } else {
                    const secondP = item.querySelector('p:last-child');
                    if (secondP) {
                        secondP.innerHTML = '<b>' + new Intl.NumberFormat('vi-VN').format(grandTotal) + 'đ</b>';
                    }
                }
            }
        });

        // Thêm/cập nhật dòng giảm giá
        const overview = document.querySelector('.cart-summary__overview');
        if (!overview) return;
        
        let discountRow = document.querySelector('.cart-summary__overview__item.discount-row');
        
        if (discountAmount > 0) {
            if (!discountRow) {
                // Tìm vị trí để chèn (sau "Tạm tính" và trước "Phí vận chuyển")
                const shippingRow = Array.from(overviewItems).find(item => {
                    const p = item.querySelector('p:first-child');
                    return p && p.textContent.trim().includes('Phí vận chuyển');
                });
                
                discountRow = document.createElement('div');
                discountRow.className = 'cart-summary__overview__item discount-row';
                discountRow.innerHTML = '<p>Giảm giá</p><p style="color: #d32f2f;">-' + new Intl.NumberFormat('vi-VN').format(discountAmount) + 'đ</p>';
                
                if (shippingRow) {
                    overview.insertBefore(discountRow, shippingRow);
                } else {
                    // Nếu không tìm thấy shipping row, thêm vào cuối (trước "Tiền thanh toán")
                    const paymentRow = Array.from(overviewItems).find(item => {
                        const p = item.querySelector('p:first-child');
                        return p && p.textContent.trim().includes('Tiền thanh toán');
                    });
                    if (paymentRow) {
                        overview.insertBefore(discountRow, paymentRow);
                    } else {
                        overview.appendChild(discountRow);
                    }
                }
            } else {
                // Cập nhật giá trị giảm giá
                const discountP = discountRow.querySelector('p:last-child');
                if (discountP) {
                    discountP.textContent = '-' + new Intl.NumberFormat('vi-VN').format(discountAmount) + 'đ';
                }
            }
        } else {
            // Xóa dòng giảm giá nếu không có
            if (discountRow) {
                discountRow.remove();
            }
        }
    }

    // Load vouchers khi trang load - Không cần load ngay vì sẽ load khi click vào input
    
    // Xử lý form submit
    const checkoutForm = document.getElementById('checkoutForm');
    const submitBtn = document.getElementById('but-checkout-continue-step2');
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            console.log('Submit button clicked');
            // Không preventDefault - để form submit tự nhiên
        });
    }
    
    if (checkoutForm) {
        // Loại bỏ required từ các input trong modal ngay khi trang load để tránh HTML5 validation
        document.addEventListener('DOMContentLoaded', function() {
            const modalInputs = document.querySelectorAll('#addAddressModal input[required], #addAddressModal textarea[required]');
            modalInputs.forEach(input => {
                input.removeAttribute('required');
            });
        });
        
        checkoutForm.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT START ===');
            console.log('Form action:', checkoutForm.action);
            console.log('Form method:', checkoutForm.method);
            
            // Kiểm tra các trường bắt buộc
            const addressId = document.getElementById('selected_address_id');
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            
            console.log('Validation check:', {
                addressId: addressId ? addressId.value : 'missing',
                addressIdElement: addressId,
                shippingMethod: shippingMethod ? shippingMethod.value : 'missing',
                paymentMethod: paymentMethod ? paymentMethod.value : 'missing'
            });
            
            // Đảm bảo address_id có giá trị
            if (!addressId) {
                alert('Lỗi: Không tìm thấy field địa chỉ. Vui lòng làm mới trang.');
                e.preventDefault();
                return false;
            }
            
            // Nếu address_id rỗng, đặt mặc định là 0 (địa chỉ từ user)
            if (addressId.value === '' || addressId.value === null || addressId.value === undefined) {
                console.log('Address ID is empty, setting to 0 (user default address)');
                addressId.value = '0';
            }
            
            console.log('Final address_id value:', addressId.value);
            
            // Chỉ validate client-side, không chặn submit
            let hasError = false;
            
            if (!shippingMethod) {
                alert('Vui lòng chọn phương thức giao hàng');
                e.preventDefault();
                return false;
            }
            
            if (!paymentMethod) {
                alert('Vui lòng chọn phương thức thanh toán');
                e.preventDefault();
                return false;
            }
            
            // Nếu có form VAT được bật, kiểm tra các trường VAT
            const receiveVat = document.querySelector('input[name="receive_vat"]');
            if (receiveVat && receiveVat.checked) {
                const vatEmail = document.querySelector('input[name="order_vat_email"]');
                if (!vatEmail || !vatEmail.value || !vatEmail.value.trim()) {
                    alert('Vui lòng nhập email để nhận hóa đơn VAT');
                    e.preventDefault();
                    return false;
                }
            }
            
            // Disable submit button để tránh double submit
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Đang xử lý...';
            }
            
            console.log('Form validation passed, allowing submit...');
            console.log('=== FORM SUBMIT END ===');
            
            // KHÔNG preventDefault - để form submit tự nhiên đến server
            // Server sẽ xử lý và redirect đến checkout.success
            return true;
        });
    }
})();
</script>
@endsection
