@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng')

@push('styles')
<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
@endpush

@section('content')
<main id="main" class="site-main">
    <div class="container">
        <div class="cart pt-40 checkout">
            <form action="{{ route('checkout.store') }}" method="post" enctype="application/x-www-form-urlencoded">
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
                                    <div class="block-border address-default">
                                        <input type="radio" class="hidden" name="address_id" value="1" checked />
                                        <h4>{{ $user->name ?? 'Khách hàng' }}
                                            <span>(Mặc định)</span>
                                        </h4>
                                        <p>Điện thoại: <span>{{ $user->phone ?? 'Chưa cập nhật' }}</span></p>
                                        <p>Địa chỉ: <span>{{ $user->address ?? 'Chưa cập nhật địa chỉ' }}</span></p>
                                        <div class="checkout-address-delivery__action">
                                            <a href="javascript:void(0)" class="choose-address" data-toggle="modal" data-target="#addressModal">
                                                <span>Chọn địa chỉ khác</span>
                                            </a>
                                            <span class="btn btn--large">Mặc định</span>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="addressModal" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="addressModalLabel">Chọn địa chỉ</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="block-border change-address mt-3 border-success">
                                                        <input type="radio" class="hidden" name="address_id" value="1" checked="checked" />
                                                        <h4>{{ $user->name ?? 'Khách hàng' }}
                                                            <span>(Mặc định)</span>
                                                        </h4>
                                                        <p>Điện thoại: <span>{{ $user->phone ?? 'Chưa cập nhật' }}</span></p>
                                                        <p>Địa chỉ: <span>{{ $user->address ?? 'Chưa cập nhật địa chỉ' }}</span></p>
                                                        <div class="checkout-address-delivery__action">
                                                            <a href="javascript:void(0)" class="choose-address" data-toggle="modal" data-target="#addressModal">
                                                                <span>Chọn địa chỉ khác</span>
                                                            </a>
                                                            <span class="btn btn--large">Mặc định</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn--large mt-4 btn-add-address-modal" data-toggle="modal" data-target="#addAddressModal">
                                        <span class="icon-ic_plus"></span><span>Thêm Địa Chỉ</span>
                                    </button>
                                    <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModal" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header-close">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Form thêm địa chỉ mới -->
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
                                <p>Mọi giao dịch đều được bảo mật và mã hóa. Thông tin thẻ tín dụng sẽ không bao giờ được lưu lại.</p>
                                <div class="checkout-payment__options">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_1" value="1" />
                                        <span class="ds__item__label">
                                            Thanh toán bằng thẻ tín dụng
                                        </span>
                                        <span style="margin-left: 3px">
                                            <img src="https://pubcdn.ivymoda.com/ivy2/images/1.png" class="">
                                        </span>
                                    </label>

                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_2" value="2" />
                                        <span class="ds__item__label">
                                            <div class="payment-method-title">Thanh toán bằng thẻ ATM</div>
                                            <div class="payment-method-description">Hỗ trợ thanh toán online hơn 38 ngân hàng phổ biến Việt Nam.</div>
                                        </span>
                                    </label>

                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_5" value="5" />
                                        <span class="ds__item__label">
                                            Thanh toán bằng Momo
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
                                    <div class="cart-summary__overview__item">
                                        <p>Phí vận chuyển</p>
                                        <p>30.000đ</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tiền thanh toán</p>
                                        <p><b>{{ number_format($totalAmount) }}đ</b></p>
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
                                    <input class="form-control" type="text" placeholder="Mã giảm giá" name="coupon_code_text" id="coupon_code_text" value="" />
                                    <button type="button" class="btn btn--large btn--outline" id="but_coupon_code">Áp dụng</button>
                                    <button type="button" class="btn btn--large" id="but_coupon_delete" style="display: none;">Bỏ Mã</button>
                                </div>
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
</script>
@endsection
