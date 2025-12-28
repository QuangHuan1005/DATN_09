@extends('layouts.app')

@section('title', 'Xác nhận đơn hàng')

@push('styles')
<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
@endpush


@section('content')
<div id="site-content" class="site-content-wrapper">
				<div class="nova-container">
					<div class="grid-x">
						<div class="cell small-12">
							<div class="site-content">
								<div class="page-header-content">
									<nav class="woocommerce-breadcrumb"><a href="../index.html">Home</a><span
											class="delimiter">/</span>Checkout</nav>
									<h1 class="page-title">Checkout</h1>
								</div>
								<article id="post-10" class="post-10 page type-page status-publish hentry">
									<div class="entry-content">
										<div data-block-name="woocommerce/checkout"
											class="wp-block-woocommerce-checkout alignwide wc-block-checkout is-loading">
											<div data-block-name="woocommerce/checkout-fields-block"
												class="wp-block-woocommerce-checkout-fields-block">
												<div data-block-name="woocommerce/checkout-express-payment-block"
													class="wp-block-woocommerce-checkout-express-payment-block"></div>

												<div data-block-name="woocommerce/checkout-contact-information-block"
													class="wp-block-woocommerce-checkout-contact-information-block">
												</div>

												<div data-block-name="woocommerce/checkout-shipping-method-block"
													class="wp-block-woocommerce-checkout-shipping-method-block"></div>

												<div data-block-name="woocommerce/checkout-pickup-options-block"
													class="wp-block-woocommerce-checkout-pickup-options-block"></div>

												<div data-block-name="woocommerce/checkout-shipping-address-block"
													class="wp-block-woocommerce-checkout-shipping-address-block"></div>

												<div data-block-name="woocommerce/checkout-billing-address-block"
													class="wp-block-woocommerce-checkout-billing-address-block"></div>

												<div data-block-name="woocommerce/checkout-shipping-methods-block"
													class="wp-block-woocommerce-checkout-shipping-methods-block"></div>

												<div data-block-name="woocommerce/checkout-payment-block"
													class="wp-block-woocommerce-checkout-payment-block"></div>

												<div data-block-name="woocommerce/checkout-additional-information-block"
													class="wp-block-woocommerce-checkout-additional-information-block">
												</div>



												<div data-block-name="woocommerce/checkout-order-note-block"
													class="wp-block-woocommerce-checkout-order-note-block"></div>

												<div data-block-name="woocommerce/checkout-terms-block"
													class="wp-block-woocommerce-checkout-terms-block"></div>

												<div data-block-name="woocommerce/checkout-actions-block"
													class="wp-block-woocommerce-checkout-actions-block"></div>
											</div>

											<div data-block-name="woocommerce/checkout-totals-block"
												class="wp-block-woocommerce-checkout-totals-block">
												<div data-block-name="woocommerce/checkout-order-summary-block"
													class="wp-block-woocommerce-checkout-order-summary-block">
													<div data-block-name="woocommerce/checkout-order-summary-cart-items-block"
														class="wp-block-woocommerce-checkout-order-summary-cart-items-block">
													</div>
													<div data-block-name="woocommerce/checkout-order-summary-coupon-form-block"
														class="wp-block-woocommerce-checkout-order-summary-coupon-form-block">
													</div>
													<div data-block-name="woocommerce/checkout-order-summary-totals-block"
														class="wp-block-woocommerce-checkout-order-summary-totals-block">
														<div data-block-name="woocommerce/checkout-order-summary-subtotal-block"
															class="wp-block-woocommerce-checkout-order-summary-subtotal-block">
														</div>
														<div data-block-name="woocommerce/checkout-order-summary-discount-block"
															class="wp-block-woocommerce-checkout-order-summary-discount-block">
														</div>
														<div data-block-name="woocommerce/checkout-order-summary-fee-block"
															class="wp-block-woocommerce-checkout-order-summary-fee-block">
														</div>
														<div data-block-name="woocommerce/checkout-order-summary-shipping-block"
															class="wp-block-woocommerce-checkout-order-summary-shipping-block">
														</div>
														<div data-block-name="woocommerce/checkout-order-summary-taxes-block"
															class="wp-block-woocommerce-checkout-order-summary-taxes-block">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div><!-- .entry-content -->

								</article><!-- #post-## -->
							</div>

						</div>
					</div>
				</div>


			</div>
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
            
            <!-- Hidden backup form for CSRF issues -->
            <form id="backupCheckoutForm" action="{{ route('checkout.store') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="is_checkout_page" value="1">
                <input type="hidden" id="backup_address_id" name="address_id" value="">
                <input type="hidden" id="backup_payment_method" name="payment_method" value="">
                <input type="hidden" name="coupon_code_text" value="">
            </form>

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
                                        <p>Địa chỉ: <span id="selectedAddressText">
                                            @if($defaultAddress)
                                                {{ $defaultAddress->address }}
                                                @php
                                                    $locationParts = [];
                                                    if($defaultAddress->ward) $locationParts[] = $defaultAddress->ward;
                                                    if($defaultAddress->district) $locationParts[] = $defaultAddress->district;
                                                    if($defaultAddress->province) $locationParts[] = $defaultAddress->province;
                                                @endphp
                                                @if(count($locationParts) > 0)
                                                    , {{ implode(', ', $locationParts) }}
                                                @endif
                                            @elseif($user && $user->address)
                                                {{ $user->address }}
                                            @else
                                                Chưa cập nhật địa chỉ
                                            @endif
                                        </span></p>
                                        <div class="checkout-address-delivery__action">
                                            <button type="button" class="btn btn--large" data-bs-toggle="modal" data-bs-target="#addressModal">
                                                <span>Thay đổi địa chỉ</span>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-12 col-2xl-5">
                                </div>
                            </div>
                        </div>
                        
                        <div class="checkout-payment">
                            <h3 class="checkout-title">Phương thức thanh toán</h3>
                            <div class="block-border">
                                <p>Mọi giao dịch đều được bảo mật và mã hóa.</p>
                                <div class="checkout-payment__options">
                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_cod" value="1" checked />
                                        <span class="ds__item__label">
                                            <div class="payment-method-title">Thanh toán khi nhận hàng (COD)</div>
                                            <div class="payment-method-description">Thanh toán bằng tiền mặt khi nhận hàng tại nhà.</div>
                                        </span>
                                    </label>

                                    <label class="ds__item">
                                        <input class="ds__item__input" type="radio" name="payment_method" id="payment_method_vnpay" value="2" />
                                        <span class="ds__item__label">
                                            <div class="payment-method-title">Thanh toán bằng VNPay</div>
                                            <div class="payment-method-description">Hỗ trợ thanh toán online hơn 38 ngân hàng phổ biến Việt Nam.</div>
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
                                            <th style="width: 60%;">Tên Sản phẩm</th>
                                            <th style="width: 15%;">Số lượng</th>
                                            <th style="width: 25%;">Tổng tiền</th>
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
                                        <p>{{ $totalAmount > 300000 ? 'Miễn phí' : number_format($shippingFee ?? 30000) . 'đ' }}</p>
                                    </div>
                                    <div class="cart-summary__overview__item">
                                        <p>Tiền thanh toán</p>
                                        <p><b>{{ number_format($grandTotal ?? ($totalAmount + 30000)) }}đ</b></p>
                                    </div>
                                </div>
                            </div>
                            
                           <div class="cart-summary__voucher-form p-3 border rounded bg-light">
    <div class="cart-summary__voucher-form__title d-flex justify-content-between align-items-center mb-2">
        <h4 class="active mb-0" style="font-size: 1.1rem; font-weight: 600;">Mã phiếu giảm giá</h4>
        <h4 style="cursor: pointer; color: #ff4747; font-size: 0.9rem; margin-bottom: 0;" 
            data-bs-toggle="modal" 
            data-bs-target="#myVoucherWallet">
            <i class="fa fa-ticket"></i> Mã của tôi
        </h4>
    </div>

    <p class="small" id="p_coupon" style="display: none; text-align: center; margin-bottom: 10px;"></p>

   <div class="cart-summary__voucher-form">
    <div class="form-group mb-0">
        <div class="d-flex align-items-center justify-content-between" style="gap: 10px;">
            
            <div id="selected_voucher_display" 
                 data-bs-toggle="modal" 
                 data-bs-target="#myVoucherWallet"
                 style="background-color: #fff; 
                        border: 1px dashed #ff4747; 
                        height: 45px; 
                        cursor: pointer; 
                        display: flex; 
                        align-items: center; 
                        padding: 0 12px; 
                        border-radius: 6px;
                        color: #ff4747;
                        font-weight: 500;
                        flex: 1; /* Tự co giãn */
                        min-width: 0; /* Quan trọng để xử lý tràn chữ */
                        position: relative;">
                
                <i class="fa fa-ticket" style="margin-right: 8px; flex-shrink: 0;"></i>
                
                <span id="voucher_status_text" style="
                      white-space: nowrap; 
                      overflow: hidden; 
                      text-overflow: ellipsis; 
                      display: block;
                      font-size: 0.9rem;">
                    {{ $appliedVoucher ? $appliedVoucher->voucher_code : 'Chọn mã giảm giá' }}
                </span>
            </div>

            <div style="flex-shrink: 0;">
               <button
    type="button"
    class="btn btn-dark"
    id="but_coupon_code"
>
    Áp dụng
</button>

                <button type="button" class="btn btn-outline-danger" id="but_coupon_delete" 
                        style="height: 45px; width: 85px; font-size: 0.9rem; font-weight: 600; display: {{ $appliedVoucher ? 'inline-block' : 'none' }}; border-radius: 6px;">
                    Bỏ Mã
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" name="coupon_code_text" id="coupon_code_text" value="{{ $appliedVoucher->voucher_code ?? '' }}">

    <div id="appliedVoucherInfoWrapper">
        @if($appliedVoucher)
        <div id="appliedVoucherInfo" class="mt-3 p-2 d-flex align-items-center" 
             style="background: #f0fff4; border: 1px solid #28a745; border-radius: 6px; border-left-width: 4px;">
            <div class="me-2 text-success" style="margin-right: 10px;">
                <i class="fa fa-check-circle fa-lg"></i>
            </div>
            <div style="line-height: 1.3;">
                <p class="mb-0 fw-bold text-success" style="font-size: 0.85rem;">Mã: {{ $appliedVoucher->voucher_code }}</p>
                <small class="text-muted" style="font-size: 0.75rem;">
                    @if(stripos($appliedVoucher->voucher_code, 'FREESHIP') !== false)
                        Miễn phí vận chuyển cho đơn hàng này
                    @else
                        Ưu đãi: Giảm {{ $appliedVoucher->discount_type === 'percent' ? $appliedVoucher->discount_value.'%' : number_format($appliedVoucher->discount_value).'đ' }}
                    @endif
                </small>
            </div>
        </div>
        @endif
    </div>
    
    <div class="cart-summary__button mt-3">
        <button type="submit" id="but-checkout-continue-step2" name="btn_continue_step2" 
                class="btn btn-danger w-100 fw-bold" 
                style="height: 50px; font-size: 1rem; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
            HOÀN THÀNH THANH TOÁN
        </button>
    </div>
</div>
                <div class="check-otp-order"></div>
            </form>

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

            <!-- Toast Notification Container -->
            <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

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
                                <div class="error-message text-danger" id="address_name-error" style="font-size: 13px; margin-top: 5px;"></div>
                            </div>
                            <div class="form-group">
                                <label for="address_phone">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address_phone" name="address_phone" data-required="true">
                                <div class="error-message text-danger" id="address_phone-error" style="font-size: 13px; margin-top: 5px;"></div>
                            </div>
                            <div class="form-group">
                                <label for="address_address">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address_address" name="address_address" rows="2" data-required="true"></textarea>
                                <div class="error-message text-danger" id="address_address-error" style="font-size: 13px; margin-top: 5px;"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address_province">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address_province" name="province" data-required="true">
                                        <div class="error-message text-danger" id="address_province-error" style="font-size: 13px; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address_district">Quận/Huyện <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address_district" name="district" data-required="true">
                                        <div class="error-message text-danger" id="address_district-error" style="font-size: 13px; margin-top: 5px;"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address_ward">Phường/Xã <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address_ward" name="ward" data-required="true">
                                        <div class="error-message text-danger" id="address_ward-error" style="font-size: 13px; margin-top: 5px;"></div>
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
</main>

<script>
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

        if (addressId == '0') {
            // Sử dụng địa chỉ mặc định của user (từ bảng users, không phải user_addresses)
            const addressData = {
                id: 0,
                name: '{{ $user->name ?? "Khách hàng" }}',
                phone: '{{ $user->phone ?? "Chưa cập nhật" }}',
                address: '{{ $user->address ?? "Chưa cập nhật địa chỉ" }}',
                ward: '{{ $user->ward ?? "" }}',
                district: '{{ $user->district ?? "" }}',
                province: '{{ $user->province ?? "" }}',
                is_default: true
            };

            // Cập nhật hiển thị địa chỉ đã chọn
            updateSelectedAddressDisplay(addressData);
        } else {
            // Gọi API để lấy thông tin địa chỉ đầy đủ từ database
            fetch(`{{ route('checkout.address.get', ':id') }}`.replace(':id', addressId), {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.address) {
                    // Cập nhật hiển thị địa chỉ đã chọn với thông tin đầy đủ
                    updateSelectedAddressDisplay(data.address);
                }
            })
            .catch(error => {
                console.error('Error fetching address details:', error);
            });
        }

        // Đóng modal (Bootstrap 5)
        const modalElement = document.getElementById('addressModal');
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.hide();
    });

    // Function để cập nhật hiển thị địa chỉ đã chọn
    function updateSelectedAddressDisplay(addressData) {
        document.getElementById('selected_address_id').value = addressData.id;

        const selectedAddressName = document.getElementById('selectedAddressName');
        const selectedAddressNameContainer = document.getElementById('selectedAddressNameContainer');
        const selectedAddressDefaultLabel = document.getElementById('selectedAddressDefaultLabel');
        const selectedAddressPhone = document.getElementById('selectedAddressPhone');
        const selectedAddressText = document.getElementById('selectedAddressText');

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

        if (selectedAddressPhone) {
            selectedAddressPhone.textContent = addressData.phone;
        }

        if (selectedAddressText) {
            // Tạo địa chỉ đầy đủ từ tất cả components
            let fullAddress = addressData.address || '';
            if (addressData.ward || addressData.district || addressData.province) {
                const locationParts = [];
                if (addressData.ward) locationParts.push(addressData.ward);
                if (addressData.district) locationParts.push(addressData.district);
                if (addressData.province) locationParts.push(addressData.province);
                if (locationParts.length > 0) {
                    fullAddress += ', ' + locationParts.join(', ');
                }
            }
            selectedAddressText.textContent = fullAddress || 'Chưa cập nhật địa chỉ';
        }
    }
    
    // Hàm hiển thị toast notification
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.style.cssText = `
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#ffc107'};
            color: white;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            min-width: 300px;
            max-width: 400px;
            animation: slideIn 0.3s ease-out;
            position: relative;
        `;
        
        const icon = type === 'success' ? '✓' : type === 'error' ? '✕' : 'ⓘ';
        toast.innerHTML = `
            <span style="font-size: 20px; margin-right: 12px; font-weight: bold;">${icon}</span>
            <span style="flex: 1;">${message}</span>
        `;
        
        container.appendChild(toast);
        
        // Tự động xóa sau 5 giây
        setTimeout(() => {
            toast.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
    }
    
    // Hàm hiển thị confirm dialog đẹp
    function showConfirm(message) {
        return new Promise((resolve) => {
            // Tạo overlay
            const overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                animation: fadeIn 0.2s ease-out;
            `;
            
            // Tạo dialog
            const dialog = document.createElement('div');
            dialog.style.cssText = `
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.3);
                max-width: 400px;
                width: 90%;
                animation: scaleIn 0.3s ease-out;
            `;
            
            dialog.innerHTML = `
                <div style="margin-bottom: 20px;">
                    <div style="font-size: 48px; text-align: center; margin-bottom: 15px;">⚠️</div>
                    <div style="font-size: 16px; color: #333; text-align: center; line-height: 1.5;">${message}</div>
                </div>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button id="confirm-cancel-btn" style="
                        padding: 10px 24px;
                        border: 1px solid #ddd;
                        background: white;
                        color: #333;
                        border-radius: 6px;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: all 0.2s;
                    ">Hủy</button>
                    <button id="confirm-ok-btn" style="
                        padding: 10px 24px;
                        border: none;
                        background: #dc3545;
                        color: white;
                        border-radius: 6px;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: 500;
                        transition: all 0.2s;
                    ">Xác nhận</button>
                </div>
            `;
            
            overlay.appendChild(dialog);
            document.body.appendChild(overlay);
            
            // Hover effects
            const cancelBtn = dialog.querySelector('#confirm-cancel-btn');
            const okBtn = dialog.querySelector('#confirm-ok-btn');
            
            cancelBtn.addEventListener('mouseenter', () => {
                cancelBtn.style.background = '#f8f9fa';
            });
            cancelBtn.addEventListener('mouseleave', () => {
                cancelBtn.style.background = 'white';
            });
            
            okBtn.addEventListener('mouseenter', () => {
                okBtn.style.background = '#c82333';
            });
            okBtn.addEventListener('mouseleave', () => {
                okBtn.style.background = '#dc3545';
            });
            
            // Xử lý sự kiện
            function close(result) {
                overlay.style.animation = 'fadeOut 0.2s ease-out';
                setTimeout(() => {
                    document.body.removeChild(overlay);
                    resolve(result);
                }, 200);
            }
            
            cancelBtn.addEventListener('click', () => close(false));
            okBtn.addEventListener('click', () => close(true));
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) close(false);
            });
        });
    }
    
    // Hàm hiển thị lỗi cho từng field
    function showAddressFieldError(fieldId, message) {
        const errorDiv = document.getElementById(fieldId + '-error');
        const inputField = document.getElementById(fieldId);
        
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
        
        if (inputField) {
            inputField.classList.add('is-invalid');
        }
    }
    
    // Hàm xóa lỗi cho từng field
    function clearAddressFieldError(fieldId) {
        const errorDiv = document.getElementById(fieldId + '-error');
        const inputField = document.getElementById(fieldId);
        
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.style.display = 'none';
        }
        
        if (inputField) {
            inputField.classList.remove('is-invalid');
        }
    }
    
    // Hàm xóa tất cả lỗi trong form
    function clearAddressFormErrors() {
        clearAddressFieldError('address_name');
        clearAddressFieldError('address_phone');
        clearAddressFieldError('address_address');
        clearAddressFieldError('address_province');
        clearAddressFieldError('address_district');
        clearAddressFieldError('address_ward');
    }
    
    // Hàm xử lý lưu địa chỉ - đơn giản hơn
    function handleSaveAddress() {
        console.log('🚀 handleSaveAddress called');

        const modal = document.getElementById('addAddressModal');
        if (!modal) {
            console.error('❌ Modal addAddressModal not found');
            alert('Không tìm thấy modal');
            return;
        }

        console.log('✅ Modal found');
        
        const fieldsDiv = modal.querySelector('#addressFormFields');
        if (!fieldsDiv) {
            alert('Không tìm thấy form fields');
            return;
        }
        
        // Clear tất cả lỗi cũ
        clearAddressFormErrors();
        
        // Validate các trường bắt buộc
        const nameInput = fieldsDiv.querySelector('#address_name');
        const phoneInput = fieldsDiv.querySelector('#address_phone');
        const addressInput = fieldsDiv.querySelector('#address_address');
        const provinceInput = fieldsDiv.querySelector('#address_province');
        const districtInput = fieldsDiv.querySelector('#address_district');
        const wardInput = fieldsDiv.querySelector('#address_ward');
        
        let hasError = false;
        let firstErrorField = null;
        
        // Validate tên người nhận
        if (!nameInput || !nameInput.value.trim()) {
            showAddressFieldError('address_name', 'Vui lòng nhập tên người nhận');
            if (!firstErrorField) firstErrorField = nameInput;
            hasError = true;
        } else if (nameInput.value.trim().length < 2) {
            showAddressFieldError('address_name', 'Tên người nhận phải có ít nhất 2 ký tự');
            if (!firstErrorField) firstErrorField = nameInput;
            hasError = true;
        }
        
        // Validate số điện thoại
        if (!phoneInput || !phoneInput.value.trim()) {
            showAddressFieldError('address_phone', 'Vui lòng nhập số điện thoại');
            if (!firstErrorField) firstErrorField = phoneInput;
            hasError = true;
        } else {
            // Kiểm tra định dạng số điện thoại Việt Nam (10 số, bắt đầu 0)
            const phonePattern = /^0\d{9}$/;
            if (!phonePattern.test(phoneInput.value.trim())) {
                showAddressFieldError('address_phone', 'Số điện thoại không hợp lệ (10 số, bắt đầu bằng 0)');
                if (!firstErrorField) firstErrorField = phoneInput;
                hasError = true;
            }
        }
        
        // Validate địa chỉ chi tiết
        if (!addressInput || !addressInput.value.trim()) {
            showAddressFieldError('address_address', 'Vui lòng nhập địa chỉ chi tiết');
            if (!firstErrorField) firstErrorField = addressInput;
            hasError = true;
        } else if (addressInput.value.trim().length < 10) {
            showAddressFieldError('address_address', 'Địa chỉ chi tiết phải có ít nhất 10 ký tự');
            if (!firstErrorField) firstErrorField = addressInput;
            hasError = true;
        }
        
        // Validate Tỉnh/Thành phố
        if (!provinceInput || !provinceInput.value.trim()) {
            showAddressFieldError('address_province', 'Vui lòng nhập Tỉnh/Thành phố');
            if (!firstErrorField) firstErrorField = provinceInput;
            hasError = true;
        }
        
        // Validate Quận/Huyện
        if (!districtInput || !districtInput.value.trim()) {
            showAddressFieldError('address_district', 'Vui lòng nhập Quận/Huyện');
            if (!firstErrorField) firstErrorField = districtInput;
            hasError = true;
        }
        
        // Validate Phường/Xã
        if (!wardInput || !wardInput.value.trim()) {
            showAddressFieldError('address_ward', 'Vui lòng nhập Phường/Xã');
            if (!firstErrorField) firstErrorField = wardInput;
            hasError = true;
        }
        
        // Nếu có lỗi thì focus vào field đầu tiên có lỗi và dừng lại
        if (hasError) {
            if (firstErrorField) firstErrorField.focus();
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
                console.log('✅ Address saved successfully:', data);
                // Hiển thị thông báo phù hợp - ưu tiên message từ server, nếu không có thì dùng message mặc định
                const message = data.message || (window.currentAddressMode === 'update' ? 'Sửa địa chỉ thành công!' : 'Thêm địa chỉ thành công!');
                showToast(message, 'success');
                
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
                
                // Cập nhật địa chỉ trong danh sách mà không reload
                setTimeout(() => {
                    console.log('🔄 Updating address in list without reload');
                    
                    // Đóng modal thêm/sửa
                    const addModalElement = document.getElementById('addAddressModal');
                    const addModal = bootstrap.Modal.getInstance(addModalElement);
                    if (addModal) {
                        addModal.hide();
                    }
                    
                    // Mở modal chọn địa chỉ
                    setTimeout(() => {
                        const addressModal = document.getElementById('addressModal');
                        if (addressModal) {
                            const bsModal = new bootstrap.Modal(addressModal, {
                                backdrop: 'static',
                                keyboard: false
                            });
                            bsModal.show();
                            
                            // Nếu là update, cập nhật thông tin địa chỉ trong danh sách
                            if (data.address && addressId && addressId !== '' && addressId !== '0') {
                                const addressItem = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
                                if (addressItem) {
                                    // Cập nhật thông tin địa chỉ
                                    const h4 = addressItem.querySelector('h4');
                                    const phoneP = addressItem.querySelector('p:nth-child(2) span');
                                    const addressP = addressItem.querySelector('p:nth-child(3) span');
                                    const locationP = addressItem.querySelector('p:nth-child(4)');
                                    
                                    if (h4) {
                                        const isDefault = data.address.is_default || addressItem.querySelector('.badge-success');
                                        h4.innerHTML = data.address.name + (isDefault ? ' <span>(Mặc định)</span>' : '');
                                    }
                                    if (phoneP) {
                                        phoneP.textContent = data.address.phone;
                                    }
                                    if (addressP) {
                                        addressP.textContent = data.address.address;
                                    }
                                    
                                    // Cập nhật location
                                    const locationParts = [];
                                    if (data.address.ward) locationParts.push(data.address.ward);
                                    if (data.address.district) locationParts.push(data.address.district);
                                    if (data.address.province) locationParts.push(data.address.province);
                                    
                                    if (locationP && locationParts.length > 0) {
                                        locationP.textContent = locationParts.join(', ');
                                    } else if (!locationP && locationParts.length > 0) {
                                        // Tạo p mới nếu chưa có
                                        const newLocationP = document.createElement('p');
                                        newLocationP.textContent = locationParts.join(', ');
                                        addressItem.querySelector('div > div').appendChild(newLocationP);
                                    }
                                    
                                    // Highlight animation
                                    addressItem.style.transition = 'all 0.3s ease-out';
                                    addressItem.style.background = '#d4edda';
                                    setTimeout(() => {
                                        addressItem.style.background = '';
                                    }, 1000);
                                    
                                    console.log('✅ Address updated in DOM without reload');
                                }
                            } else if (data.address) {
                                // Nếu là thêm mới, thêm địa chỉ vào danh sách mà không reload
                                console.log('➕ New address added, adding to list without reload');
                                
                                const addressList = document.getElementById('addressList');
                                if (addressList) {
                                    // Tạo location string
                                    const locationParts = [];
                                    if (data.address.ward) locationParts.push(data.address.ward);
                                    if (data.address.district) locationParts.push(data.address.district);
                                    if (data.address.province) locationParts.push(data.address.province);
                                    const locationStr = locationParts.length > 0 ? `<p>${locationParts.join(', ')}</p>` : '';
                                    
                                    // Tạo HTML cho địa chỉ mới
                                    const newAddressHTML = `
                                        <div class="block-border change-address address-item ${data.address.is_default ? 'border-success' : ''}" 
                                             data-address-id="${data.address.id}" 
                                             style="cursor: pointer; margin-bottom: 15px; opacity: 0; transform: translateY(-20px);">
                                            <input type="radio" class="address-radio" name="modal_address_id" 
                                                   value="${data.address.id}" ${data.address.is_default ? 'checked' : ''} />
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h4>${data.address.name}${data.address.is_default ? ' <span>(Mặc định)</span>' : ''}</h4>
                                                    <p>Điện thoại: <span>${data.address.phone}</span></p>
                                                    <p>Địa chỉ: <span>${data.address.address}</span></p>
                                                    ${locationStr}
                                                </div>
                                                <div class="address-actions">
                                                    ${data.address.is_default ? 
                                                        '<span class="badge badge-success mb-2 d-block">Mặc định</span>' : 
                                                        `<button type="button" class="btn btn-sm btn-outline-primary set-default-address mb-2" data-id="${data.address.id}">Đặt mặc định</button>`
                                                    }
                                                    <button type="button" class="btn btn-sm btn-outline-secondary edit-address" data-id="${data.address.id}">Sửa</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-address" data-id="${data.address.id}">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                    
                                    // Tìm nút "Thêm địa chỉ mới"
                                    const addNewButton = document.getElementById('btnAddNewAddressFromModal');
                                    
                                    // Nếu là địa chỉ mặc định, thêm vào đầu
                                    if (data.address.is_default) {
                                        addressList.insertAdjacentHTML('afterbegin', newAddressHTML);
                                    } else {
                                        // Thêm TRƯỚC nút "Thêm địa chỉ mới" (nếu có), nếu không thì thêm vào cuối
                                        if (addNewButton) {
                                            addNewButton.insertAdjacentHTML('beforebegin', newAddressHTML);
                                        } else {
                                            addressList.insertAdjacentHTML('beforeend', newAddressHTML);
                                        }
                                    }
                                    
                                    // Lấy phần tử vừa thêm
                                    const newAddressItem = document.querySelector(`.address-item[data-address-id="${data.address.id}"]`);
                                    if (newAddressItem) {
                                        // QUAN TRỌNG: Reset style của TẤT CẢ địa chỉ khi thêm mới
                                        document.querySelectorAll('.address-item').forEach(item => {
                                            item.style.background = '';
                                            item.style.border = '';
                                        });
                                        
                                        // Thêm event listener để click vào toàn bộ địa chỉ sẽ chọn radio
                                        newAddressItem.addEventListener('click', function(e) {
                                            // Nếu click vào nút Sửa/Xóa/Đặt mặc định thì không xử lý
                                            if (e.target.closest('.btn')) {
                                                return;
                                            }
                                            
                                            // ✅ Xóa transition và reset style của TẤT CẢ địa chỉ
                                            document.querySelectorAll('.address-item').forEach(item => {
                                                item.style.transition = 'none'; // Tắt animation
                                                item.style.background = '';
                                                item.style.border = '';
                                                item.style.opacity = '1';
                                                item.style.transform = 'none';
                                            });
                                            
                                            // Highlight địa chỉ được chọn với màu xanh lá nhạt
                                            this.style.background = '#e8f5e9';
                                            // Thêm border xanh
                                            this.style.border = '2px solid #28a745';
                                            
                                            // Check radio
                                            const radio = this.querySelector('input[type="radio"]');
                                            if (radio) {
                                                radio.checked = true;
                                            }
                                        });
                                        
                                        // Animation fade in
                                        setTimeout(() => {
                                            newAddressItem.style.transition = 'all 0.5s ease-out';
                                            newAddressItem.style.opacity = '1';
                                            newAddressItem.style.transform = 'translateY(0)';
                                            
                                            // Highlight tạm thời
                                            newAddressItem.style.background = '#d4edda';
                                            
                                            // Lưu timeout ID để có thể clear nó sau
                                            const highlightTimeout = setTimeout(() => {
                                                // Chỉ xóa highlight nếu địa chỉ chưa được chọn (không có border xanh)
                                                if (newAddressItem.style.border !== '2px solid rgb(40, 167, 69)' && 
                                                    newAddressItem.style.border !== '2px solid #28a745') {
                                                    newAddressItem.style.transition = 'none';
                                                    newAddressItem.style.background = '';
                                                    newAddressItem.style.border = '';
                                                }
                                            }, 1500);
                                            
                                            // Lưu timeout ID vào element để có thể clear sau
                                            newAddressItem.dataset.highlightTimeout = highlightTimeout;
                                        }, 50);
                                    }
                                    
                                    console.log('✅ New address added to DOM without reload');
                                    
                                    // ✅ Kiểm tra số lượng địa chỉ và ẩn/hiện nút "Thêm địa chỉ mới"
                                    const allAddresses = document.querySelectorAll('.address-item');
                                    const addressCount = allAddresses.length;
                                    console.log(`📊 Address count after adding: ${addressCount}`);
                                    
                                    const btnAddNew = document.getElementById('btnAddNewAddressFromModal');
                                    const maxAddressWarning = document.querySelector('.alert-warning');
                                    
                                    if (addressCount >= 5) {
                                        // Đã đạt giới hạn 5 địa chỉ, xóa nút và hiện warning
                                        console.log('🚫 Max addresses (5) reached, removing add button');
                                        if (btnAddNew) {
                                            btnAddNew.remove();
                                        }
                                        
                                        // Thêm warning nếu chưa có
                                        if (!maxAddressWarning && addressList) {
                                            const warningHTML = `
                                                <div class="alert alert-warning mt-3">
                                                    Bạn đã đạt giới hạn tối đa 5 địa chỉ.
                                                </div>
                                            `;
                                            addressList.insertAdjacentHTML('beforeend', warningHTML);
                                        }
                                    }
                                }
                            }
                        }
                    }, 300);
                }, 300);
            } else {
                // Hiển thị lỗi validation từ server
                if (data.errors) {
                    // Hiển thị lỗi cho từng field
                    Object.keys(data.errors).forEach(field => {
                        const messages = data.errors[field];
                        if (messages && messages.length > 0) {
                            // Map field name từ server sang field ID trong form
                            let fieldId = field;
                            if (field === 'name') fieldId = 'address_name';
                            if (field === 'phone') fieldId = 'address_phone';
                            if (field === 'address') fieldId = 'address_address';
                            if (field === 'province') fieldId = 'address_province';
                            if (field === 'district') fieldId = 'address_district';
                            if (field === 'ward') fieldId = 'address_ward';
                            
                            showAddressFieldError(fieldId, messages[0]);
                        }
                    });
                } else {
                    // Nếu không có errors object, hiển thị message chung
                    alert(data.message || 'Có lỗi xảy ra');
                }
                
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
    
    // Xử lý click button lưu địa chỉ và xóa địa chỉ - sử dụng delegation
    console.log('🔧 Setting up address buttons with event delegation...');

    // Sử dụng event delegation cho toàn bộ document
    document.addEventListener('click', function(e) {
        const target = e.target;

        // Xử lý nút lưu địa chỉ
        if (target && target.id === 'saveAddressBtn') {
            console.log('🎯 Save address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Ngăn chặn tất cả form submit events
            const allForms = document.querySelectorAll('form');
            allForms.forEach(form => {
                const submitHandler = function(formEvent) {
                    console.log('🚫 Blocked form submit for:', form);
                    formEvent.preventDefault();
                    formEvent.stopPropagation();
                    formEvent.stopImmediatePropagation();
                    return false;
                };
                form.addEventListener('submit', submitHandler, { once: true });
            });

            handleSaveAddress();
            return false;
        }

        // Xử lý nút xóa địa chỉ
        if (target && target.classList.contains('delete-address')) {
            console.log('🗑️ Delete address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();

            const addressId = target.dataset.id;
            
            showConfirm('Bạn có chắc chắn muốn xóa địa chỉ này?').then(confirmed => {
                if (!confirmed) return;
                
                fetch(`{{ route('checkout.address.delete', ':id') }}`.replace(':id', addressId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('🗑️ Delete response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('🗑️ Delete response data:', data);
                if (data.success) {
                    showToast(data.message || 'Xóa địa chỉ thành công!', 'success');
                    
                    // Xóa phần tử HTML của địa chỉ mà không reload
                    const addressItem = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
                    if (addressItem) {
                        // Animation fade out trước khi xóa
                        addressItem.style.transition = 'all 0.3s ease-out';
                        addressItem.style.opacity = '0';
                        addressItem.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            addressItem.remove();
                            console.log('✅ Address item removed from DOM');
                            
                            // Kiểm tra xem còn địa chỉ nào không
                            const remainingAddresses = document.querySelectorAll('.address-item');
                            if (remainingAddresses.length === 0) {
                                // Nếu không còn địa chỉ nào, hiển thị thông báo
                                const addressListDiv = document.getElementById('addressList');
                                if (addressListDiv) {
                                    addressListDiv.innerHTML = '<p class="text-center text-muted" style="padding: 20px;">Chưa có địa chỉ nào. Vui lòng thêm địa chỉ mới.</p>';
                                }
                            }
                            
                            // ✅ Cập nhật nút "Thêm địa chỉ mới" khi xóa địa chỉ
                            const addressCount = remainingAddresses.length;
                            const btnAddNew = document.getElementById('btnAddNewAddressFromModal');
                            const maxAddressWarning = document.querySelector('.alert-warning');
                            
                            console.log(`📊 Current address count: ${addressCount}`);
                            
                            if (addressCount < 5) {
                                // Nếu < 5 địa chỉ, hiện nút "Thêm địa chỉ mới"
                                if (!btnAddNew) {
                                    console.log('✅ Adding "Thêm địa chỉ mới" button');
                                    // Xóa warning nếu có
                                    if (maxAddressWarning) {
                                        maxAddressWarning.remove();
                                    }
                                    
                                    // Thêm nút mới
                                    const addressListDiv = document.getElementById('addressList');
                                    if (addressListDiv) {
                                        const newBtn = document.createElement('button');
                                        newBtn.type = 'button';
                                        newBtn.className = 'btn btn--large mt-3';
                                        newBtn.id = 'btnAddNewAddressFromModal';
                                        newBtn.innerHTML = '<span class="icon-ic_plus"></span><span>Thêm Địa Chỉ Mới</span>';
                                        addressListDiv.appendChild(newBtn);
                                        
                                        // Attach event listener cho nút mới
                                        newBtn.addEventListener('click', function() {
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
                            }
                        }, 300);
                    }
                } else {
                    showToast(data.message || 'Có lỗi xảy ra khi xóa địa chỉ', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Error deleting address:', error);
                showToast('Có lỗi xảy ra khi xóa địa chỉ: ' + error.message, 'error');
            });
            }); // Đóng showConfirm().then()

            return false;
        }

        // Xử lý nút đặt làm mặc định
        if (target && target.classList.contains('set-default-address')) {
            console.log('⭐ Set default address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();

            const addressId = target.dataset.id;
            fetch(`{{ route('checkout.address.set-default', ':id') }}`.replace(':id', addressId), {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('⭐ Set default response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('⭐ Set default response data:', data);
                if (data.success) {
                    showToast(data.message || 'Đặt địa chỉ mặc định thành công!', 'success');
                    
                    // Cập nhật UI mà không reload
                    // 1. Xóa badge "Mặc định" và nút "Đặt mặc định" từ địa chỉ cũ
                    const oldDefaultBadge = document.querySelector('.address-item .badge-success');
                    const oldDefaultItem = oldDefaultBadge ? oldDefaultBadge.closest('.address-item') : null;
                    
                    if (oldDefaultItem) {
                        // Xóa badge "Mặc định"
                        const oldBadge = oldDefaultItem.querySelector('.badge-success');
                        if (oldBadge) {
                            oldBadge.remove();
                        }
                        
                        // Thêm nút "Đặt mặc định" cho địa chỉ cũ
                        const oldActions = oldDefaultItem.querySelector('.address-actions');
                        const oldAddressId = oldDefaultItem.dataset.addressId;
                        if (oldActions && oldAddressId && oldAddressId !== '0') {
                            const setDefaultBtn = document.createElement('button');
                            setDefaultBtn.type = 'button';
                            setDefaultBtn.className = 'btn btn-sm btn-outline-primary set-default-address mb-2';
                            setDefaultBtn.dataset.id = oldAddressId;
                            setDefaultBtn.textContent = 'Đặt mặc định';
                            oldActions.insertBefore(setDefaultBtn, oldActions.firstChild);
                        }
                        
                        // Xóa border màu xanh
                        oldDefaultItem.classList.remove('border-success');
                        
                        // Uncheck radio
                        const oldRadio = oldDefaultItem.querySelector('input[type="radio"]');
                        if (oldRadio) {
                            oldRadio.checked = false;
                        }
                        
                        // XÓA chữ "(Mặc định)" khỏi tên
                        const oldH4 = oldDefaultItem.querySelector('h4');
                        if (oldH4) {
                            // Lấy text và xóa phần "(Mặc định)" và span
                            const oldNameText = oldH4.textContent.replace(/\s*\(Mặc định\)\s*$/i, '').trim();
                            oldH4.textContent = oldNameText;
                        }
                    }
                    
                    // 2. Thêm badge "Mặc định" cho địa chỉ mới
                    const newDefaultItem = document.querySelector(`.address-item[data-address-id="${addressId}"]`);
                    if (newDefaultItem) {
                        // Thêm border màu xanh
                        newDefaultItem.classList.add('border-success');
                        
                        // Check radio
                        const newRadio = newDefaultItem.querySelector('input[type="radio"]');
                        if (newRadio) {
                            newRadio.checked = true;
                        }
                        
                        // Xóa nút "Đặt mặc định"
                        const setDefaultBtn = newDefaultItem.querySelector('.set-default-address');
                        if (setDefaultBtn) {
                            setDefaultBtn.remove();
                        }
                        
                        // Thêm badge "Mặc định"
                        const actions = newDefaultItem.querySelector('.address-actions');
                        if (actions) {
                            const badge = document.createElement('span');
                            badge.className = 'badge badge-success mb-2 d-block';
                            badge.textContent = 'Mặc định';
                            actions.insertBefore(badge, actions.firstChild);
                        }
                        
                        // Cập nhật text trong h4
                        const h4 = newDefaultItem.querySelector('h4');
                        if (h4 && !h4.innerHTML.includes('(Mặc định)')) {
                            const nameText = h4.textContent.trim();
                            h4.innerHTML = `${nameText} <span>(Mặc định)</span>`;
                        }
                        
                        // DI CHUYỂN địa chỉ mới lên đầu danh sách
                        const addressList = newDefaultItem.parentElement;
                        if (addressList) {
                            // Animation: fade out trước
                            newDefaultItem.style.transition = 'all 0.3s ease-out';
                            newDefaultItem.style.opacity = '0';
                            newDefaultItem.style.transform = 'translateY(-10px)';
                            
                            setTimeout(() => {
                                // Di chuyển lên đầu
                                addressList.insertBefore(newDefaultItem, addressList.firstChild);
                                
                                // Animation: fade in với highlight
                                newDefaultItem.style.opacity = '1';
                                newDefaultItem.style.transform = 'translateY(0)';
                                newDefaultItem.style.background = '#d4edda';
                                
                                setTimeout(() => {
                                    newDefaultItem.style.background = '';
                                }, 1000);
                            }, 300);
                        }
                    }
                    
                    console.log('✅ UI updated without reload');
                } else {
                    showToast(data.message || 'Có lỗi xảy ra khi đặt địa chỉ mặc định', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Error setting default address:', error);
                showToast('Có lỗi xảy ra khi đặt địa chỉ mặc định: ' + error.message, 'error');
            });

            return false;
        }

        // Xử lý nút sửa địa chỉ
        if (target && target.classList.contains('edit-address')) {
            console.log('✏️ Edit address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();

            const addressId = target.dataset.id;
            console.log('Editing address ID:', addressId);

            // Đóng modal chọn địa chỉ
            const addressModal = document.getElementById('addressModal');
            const bsModal = bootstrap.Modal.getInstance(addressModal);
            if (bsModal) {
                bsModal.hide();
            }

            // Mở modal thêm địa chỉ để sửa
            setTimeout(() => {
                fetch(`{{ route('checkout.address.get', ':id') }}`.replace(':id', addressId), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.address) {
                        const addr = data.address;
                        console.log('📝 Loading address data for edit:', addr);

                        // Điền dữ liệu vào form
                        const formFields = document.getElementById('addressFormFields');
                        if (formFields) {
                            const addressIdInput = formFields.querySelector('#address_form_id');
                            const nameInput = formFields.querySelector('#address_name');
                            const phoneInput = formFields.querySelector('#address_phone');
                            const addressInput = formFields.querySelector('#address_address');
                            const provinceInput = formFields.querySelector('#address_province');
                            const districtInput = formFields.querySelector('#address_district');
                            const wardInput = formFields.querySelector('#address_ward');
                            const defaultCheckbox = formFields.querySelector('#address_is_default');

                            if (addressIdInput) addressIdInput.value = addr.id;
                            if (nameInput) nameInput.value = addr.name || '';
                            if (phoneInput) phoneInput.value = addr.phone || '';
                            if (addressInput) addressInput.value = addr.address || '';
                            if (provinceInput) provinceInput.value = addr.province || '';
                            if (districtInput) districtInput.value = addr.district || '';
                            if (wardInput) wardInput.value = addr.ward || '';
                            if (defaultCheckbox) defaultCheckbox.checked = addr.is_default || false;

                            // Thay đổi title modal
                            const modalLabel = document.getElementById('addAddressModalLabel');
                            if (modalLabel) {
                                modalLabel.textContent = 'Sửa địa chỉ';
                            }

                            // Mở modal thêm địa chỉ
                            const addModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
                            addModal.show();
                        }
                    } else {
                        alert('Không thể tải thông tin địa chỉ');
                    }
                })
                .catch(error => {
                    console.error('❌ Error loading address for edit:', error);
                    alert('Có lỗi xảy ra khi tải thông tin địa chỉ');
                });
            }, 300);

            return false;
        }

        // Xử lý nút sửa địa chỉ mặc định
        if (target && target.classList.contains('edit-default-address')) {
            console.log('🏠 Edit default address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();

            // Lấy thông tin user từ server
            fetch('{{ route("checkout.user-info.get") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
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
                console.error('❌ Error loading default address for edit:', error);
                alert('Có lỗi xảy ra khi tải thông tin địa chỉ');
            });

            return false;
        }

        // Xử lý nút xóa địa chỉ mặc định
        if (target && target.classList.contains('clear-default-address')) {
            console.log('🗑️ Clear default address button clicked via delegation!');
            e.preventDefault();
            e.stopPropagation();

            showConfirm('Bạn có chắc chắn muốn xóa địa chỉ mặc định này?').then(confirmed => {
                if (!confirmed) return;
                
                fetch('{{ route("checkout.user-info.clear-address") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('🗑️ Clear default response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('🗑️ Clear default response data:', data);
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

                    // Xóa địa chỉ mặc định khỏi danh sách mà không reload
                    const defaultAddressItem = document.querySelector('.address-item[data-address-id="0"]');
                    if (defaultAddressItem) {
                        // Animation fade out
                        defaultAddressItem.style.transition = 'all 0.3s ease-out';
                        defaultAddressItem.style.opacity = '0';
                        defaultAddressItem.style.transform = 'translateX(-20px)';
                        
                        setTimeout(() => {
                            defaultAddressItem.remove();
                            console.log('✅ Default address item removed from DOM');
                            
                            // ✅ Cập nhật nút "Thêm địa chỉ mới" khi xóa địa chỉ mặc định
                            const remainingAddresses = document.querySelectorAll('.address-item');
                            const addressCount = remainingAddresses.length;
                            const btnAddNew = document.getElementById('btnAddNewAddressFromModal');
                            const maxAddressWarning = document.querySelector('.alert-warning');
                            
                            console.log(`📊 Current address count after delete default: ${addressCount}`);
                            
                            if (addressCount < 5) {
                                // Nếu < 5 địa chỉ, hiện nút "Thêm địa chỉ mới"
                                if (!btnAddNew) {
                                    console.log('✅ Adding "Thêm địa chỉ mới" button after delete default');
                                    // Xóa warning nếu có
                                    if (maxAddressWarning) {
                                        maxAddressWarning.remove();
                                    }
                                    
                                    // Thêm nút mới
                                    const addressListDiv = document.getElementById('addressList');
                                    if (addressListDiv) {
                                        const newBtn = document.createElement('button');
                                        newBtn.type = 'button';
                                        newBtn.className = 'btn btn--large mt-3';
                                        newBtn.id = 'btnAddNewAddressFromModal';
                                        newBtn.innerHTML = '<span class="icon-ic_plus"></span><span>Thêm Địa Chỉ Mới</span>';
                                        addressListDiv.appendChild(newBtn);
                                        
                                        // Attach event listener cho nút mới
                                        newBtn.addEventListener('click', function() {
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
                            }
                        }, 300);
                    }
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('❌ Error clearing default address:', error);
                showToast('Có lỗi xảy ra khi xóa địa chỉ mặc định: ' + error.message, 'error');
            });
            }); // Đóng showConfirm().then()

            return false;
        }
    });

    console.log('✅ Event delegation for address buttons set up');

    // All address button events handled by event delegation above
    
    // Edit address handled by event delegation above
    
    // Xóa địa chỉ - handled by event delegation above
    
    // Set default address handled by event delegation above
    
    // Hàm reload danh sách địa chỉ
    function reloadAddressList() {
        console.log('🔄 reloadAddressList() called');
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
                console.log('📝 Updating addressList HTML with', html.length, 'characters');
                addressList.innerHTML = html;
                console.log('✅ Address list HTML updated');

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
        
        // Delete listeners handled by event delegation
        
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
                            // Tạo địa chỉ đầy đủ
                            let fullAddress = data.address.address || '';
                            if (data.address.ward || data.address.district || data.address.province) {
                                const locationParts = [];
                                if (data.address.ward) locationParts.push(data.address.ward);
                                if (data.address.district) locationParts.push(data.address.district);
                                if (data.address.province) locationParts.push(data.address.province);
                                if (locationParts.length > 0) {
                                    fullAddress += ', ' + locationParts.join(', ');
                                }
                            }
                            selectedAddressText.textContent = fullAddress || 'Chưa cập nhật địa chỉ';
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
        
        // ✅ QUAN TRỌNG: Gắn event listener cho việc click vào toàn bộ address item
        console.log('🔧 Attaching click listeners to all address items');
        document.querySelectorAll('.address-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Nếu click vào nút Sửa/Xóa/Đặt mặc định thì không xử lý
                if (e.target.closest('.btn')) {
                    return;
                }
                
                console.log('📍 Address item clicked:', this.dataset.addressId);
                
                // ✅ Xóa transition và reset style của TẤT CẢ địa chỉ
                document.querySelectorAll('.address-item').forEach(addressItem => {
                    addressItem.style.transition = 'none'; // Tắt animation
                    addressItem.style.background = '';
                    addressItem.style.border = '';
                    addressItem.style.opacity = '1';
                    addressItem.style.transform = 'none';
                });
                
                // Highlight địa chỉ được chọn với màu xanh lá nhạt
                this.style.background = '#e8f5e9';
                // Thêm border xanh
                this.style.border = '2px solid #28a745';
                
                // Check radio
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    console.log('✅ Radio checked for address:', this.dataset.addressId);
                }
            });
        });
        
        console.log('✅ Click listeners attached to', document.querySelectorAll('.address-item').length, 'address items');
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
            
            // Clear tất cả lỗi khi mở modal
            clearAddressFormErrors();
            
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
    
    // Thêm event listeners để xóa lỗi khi user bắt đầu nhập
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('address_name');
        const phoneInput = document.getElementById('address_phone');
        const addressInput = document.getElementById('address_address');
        const provinceInput = document.getElementById('address_province');
        const districtInput = document.getElementById('address_district');
        const wardInput = document.getElementById('address_ward');
        
        if (nameInput) {
            nameInput.addEventListener('input', function() {
                clearAddressFieldError('address_name');
            });
        }
        
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                clearAddressFieldError('address_phone');
            });
        }
        
        if (addressInput) {
            addressInput.addEventListener('input', function() {
                clearAddressFieldError('address_address');
            });
        }
        
        if (provinceInput) {
            provinceInput.addEventListener('input', function() {
                clearAddressFieldError('address_province');
            });
        }
        
        if (districtInput) {
            districtInput.addEventListener('input', function() {
                clearAddressFieldError('address_district');
            });
        }
        
        if (wardInput) {
            wardInput.addEventListener('input', function() {
                clearAddressFieldError('address_ward');
            });
        }
    });
    
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
                    const remainingText = voucher.remaining ? `(Còn ${voucher.remaining} mã)` : '';
                    html += `
                        <div class="voucher-dropdown-item" data-code="${voucher.code}" 
                             data-discount-type="${voucher.discount_type}"
                             data-discount-value="${voucher.discount_value}"
                             data-min-order-value="${voucher.min_order_value}"
                             style="padding: 12px 15px; cursor: pointer; border-bottom: 1px solid #eee; transition: all 0.2s; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <div style="font-weight: 600; color: #ff6b6b; font-size: 14px; margin-bottom: 4px;">${voucher.code}</div>
                                    <div style="font-size: 13px; color: #333; font-weight: 500; margin-bottom: 2px;">${voucher.discount_text || 'Mã giảm giá'}</div>
                                    ${voucher.description ? `<div style="font-size: 11px; color: #666; margin-top: 3px;">${voucher.description}</div>` : ''}
                                    <div style="font-size: 10px; color: #999; margin-top: 4px;">
                                        HSD: ${new Date(voucher.end_date).toLocaleDateString('vi-VN')} ${remainingText}
                                    </div>
                                </div>
                                <div style="padding: 4px 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 4px; font-size: 11px; font-weight: 600; white-space: nowrap; margin-left: 10px;">
                                    SỬ DỤNG
                                </div>
                            </div>
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
                        this.style.backgroundColor = '#f8f9fa';
                        this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                    });
                    
                    item.addEventListener('mouseleave', function() {
                        this.style.backgroundColor = 'white';
                        this.style.boxShadow = 'none';
                    });
                });
            } else {
                dropdown.innerHTML = `
                    <div style="padding: 30px 20px; text-align: center;">
                        <div style="font-size: 48px; margin-bottom: 10px;">🎟️</div>
                        <div style="color: #666; font-size: 14px; margin-bottom: 5px;">Không có mã giảm giá khả dụng</div>
                        <div style="color: #999; font-size: 12px;">Vui lòng quay lại sau</div>
                    </div>
                `;
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

        // Tính tổng giá trị đơn hàng
        const cartTotal = calculateCartTotal();

        fetch('{{ route("checkout.voucher.apply") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                voucher_code: code,
                cart_total: cartTotal
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
                
                // Cập nhật tổng tiền thanh toán với phí vận chuyển tự động
                const totalAmount = data.grand_total + data.discount_amount; // Tính tổng tiền gốc
                const autoShippingFee = calculateShippingFee(totalAmount);
                updateGrandTotal(data.grand_total, autoShippingFee, data.discount_amount);
                
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
                        
                        // Cập nhật lại tổng tiền với phí vận chuyển tự động
                        const autoShippingFee = calculateShippingFee(data.grand_total);
                        updateGrandTotal(data.grand_total, autoShippingFee, 0);
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

    // Tính tổng giá trị đơn hàng (chưa bao gồm giảm giá và phí ship)
    function calculateCartTotal() {
        const cartItems = document.querySelectorAll('tbody tr');
        let total = 0;
        
        cartItems.forEach(row => {
            const priceElement = row.querySelector('td:last-child');
            if (priceElement) {
                const priceText = priceElement.textContent.replace(/[^\d]/g, '');
                const price = parseInt(priceText) || 0;
                total += price;
            }
        });
        
        console.log('Cart total calculated:', total);
        return total;
    }

    // Tính phí vận chuyển dựa trên tổng tiền
    function calculateShippingFee(totalAmount) {
        return totalAmount > 300000 ? 0 : 30000;
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
                    secondP.textContent = shippingFee === 0 ? 'Miễn phí' : new Intl.NumberFormat('vi-VN').format(shippingFee) + 'đ';
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
        
        let isSubmitting = false;

        // Auto refresh CSRF token mỗi 5 phút để tránh expired
        setInterval(function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const csrfInput = checkoutForm.querySelector('input[name="_token"]');

            if (csrfToken && csrfInput) {
                console.log('Auto refreshing CSRF token...');
                csrfInput.value = csrfToken.getAttribute('content');
            }
        }, 5 * 60 * 1000); // 5 minutes

        checkoutForm.addEventListener('submit', function(e) {
            console.log('=== FORM SUBMIT START ===');

            // Ngăn submit trùng lặp
            if (isSubmitting) {
                console.log('Form already submitting, preventing duplicate');
                e.preventDefault();
                return false;
            }

            isSubmitting = true;

            // Set timeout: nếu không submit được trong 10 giây, dùng backup form
            const submitTimeout = setTimeout(() => {
                console.log('Submit timeout reached, using backup form...');
                submitBackupForm();
            }, 10000); // 10 seconds

            // Refresh CSRF token từ server trước khi submit
            fetch('{{ route("refresh.csrf.token") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                clearTimeout(submitTimeout); // Clear timeout nếu thành công
                return response.json();
            })
            .then(data => {
                if (data.csrf_token) {
                    // Update CSRF token in form
                    const csrfInput = checkoutForm.querySelector('input[name="_token"]');
                    if (csrfInput) {
                        csrfInput.value = data.csrf_token;
                        console.log('CSRF token refreshed from server');
                    }
                }

                // Tiếp tục submit form bình thường
                submitFormNormally();
            })
            .catch(error => {
                clearTimeout(submitTimeout); // Clear timeout
                console.error('Failed to refresh CSRF token:', error);
                // Nếu không thể refresh token, dùng backup form
                console.log('Using backup form due to CSRF refresh failure...');
                submitBackupForm();
            });

            e.preventDefault();
            return false;
        });

        // Function để submit form bình thường sau khi refresh token
        function submitFormNormally() {
            console.log('=== NORMAL FORM SUBMIT ===');

            // Kiểm tra các trường bắt buộc
            const addressId = document.getElementById('selected_address_id');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            // Đảm bảo address_id có giá trị
            if (!addressId) {
                alert('Lỗi: Không tìm thấy field địa chỉ. Vui lòng làm mới trang.');
                isSubmitting = false;
                return;
            }

            // Nếu address_id rỗng, đặt mặc định là 0 (địa chỉ từ user)
            if (addressId.value === '' || addressId.value === null || addressId.value === undefined) {
                console.log('Address ID is empty, setting to 0 (user default address)');
                addressId.value = '0';
            }

            if (!paymentMethod) {
                alert('Vui lòng chọn phương thức thanh toán');
                isSubmitting = false;
                return;
            }

            // Submit form bình thường với CSRF token đã được refresh
            console.log('Submitting form with refreshed CSRF token...');
            checkoutForm.submit();
        }

        // Function để submit backup form nếu gặp CSRF error
        function submitBackupForm() {
            console.log('=== BACKUP FORM SUBMIT ===');

            // Copy data từ form chính sang backup form
            const addressId = document.getElementById('selected_address_id');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            if (addressId) {
                document.getElementById('backup_address_id').value = addressId.value || '0';
            }
            if (paymentMethod) {
                document.getElementById('backup_payment_method').value = paymentMethod.value;
            }

            console.log('Submitting backup form...');
            document.getElementById('backupCheckoutForm').submit();
        }
    }
})();

$(document).ready(function() {
    // Xử lý click cho nút "Mã của tôi"
    $('[data-target="#myVoucherWallet"], [data-bs-target="#myVoucherWallet"]').on('click', function(e) {
        e.preventDefault();
        
        // Cách 1: Thử với Bootstrap 5 (nếu dùng BS5)
        var myModalEl = document.getElementById('myVoucherWallet');
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);
            modal.show();
        } 
        // Cách 2: Thử với jQuery (nếu dùng BS4)
        else if (typeof $.fn.modal !== 'undefined') {
            $('#myVoucherWallet').modal('show');
        } else {
            console.error('Không tìm thấy thư viện Bootstrap JS');
        }
    });
});

// Hàm để khi chọn voucher trong modal thì điền vào input
function selectVoucher(code) {
    // Điền mã vào input
    $('#coupon_code_text').val(code);

    // Hiện nút áp dụng / bỏ mã
    $('#but_coupon_code').show();
    $('#but_coupon_delete').show();

    // Đóng modal
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalEl = document.getElementById('myVoucherWallet');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
    } else {
        $('#myVoucherWallet').modal('hide');
    }
}
function fillVoucherCode(code) {
    // 1. Điền mã vào input
    $('#coupon_code_text').val(code);

    // 2. Hiện nút Áp dụng
    $('#but_coupon_code').show();

    // 3. Đóng modal
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modal = bootstrap.Modal.getInstance(
            document.getElementById('myVoucherWallet')
        );
        modal?.hide();
    } else {
        $('#myVoucherWallet').modal('hide');
    }
}
</script>

<style>
/* Style cho validation errors */
.form-control.is-invalid,
textarea.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.error-message {
    display: none;
    margin-top: 5px;
    font-size: 13px;
}

.error-message:not(:empty) {
    display: block;
}

/* Căn giữa text trong nút Hoàn thành */
#but-checkout-continue-step2 {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Toast notification animations */
@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOut {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(400px);
        opacity: 0;
    }
}

.toast {
    transition: all 0.3s ease-out;
}

/* Badge Mặc định - màu chữ đen */
.badge-success {
    color: #000 !important;
}

/* Confirm dialog animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

@keyframes scaleIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
<div class="modal fade voucher-wallet" id="myVoucherWallet" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            
            <div class="modal-header" style="border-bottom: 1px solid #f1f1f1; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title fw-bold" id="voucherModalLabel" style="font-size: 1.1rem; margin: 0; color: #333;">Kho Voucher của tôi</h5>
                
                <button type="button" 
                        style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; line-height: 1; outline: none; transition: 0.2s;" 
                        data-dismiss="modal" 
                        data-bs-dismiss="modal" 
                        aria-label="Close"
                        onmouseover="this.style.opacity='1'" 
                        onmouseout="this.style.opacity='0.5'">
                    <span aria-hidden="true" style="font-size: 2rem; color: #000; font-weight: 300; opacity: 0.5;">&times;</span>
                </button>
            </div>

            <div class="modal-body box-voucher-wallet" style="background-color: #f8f9fa; max-height: 420px; overflow-y: auto; padding: 15px;">
                @if(isset($vouchers) && $vouchers->count() > 0)
                    <div class="voucher-list">
                        @foreach($vouchers as $voucher)
                            <div class="voucher-item d-flex mb-3 shadow-sm" style="background: #fff; border-radius: 10px; min-height: 100px; border: 1px solid #eee; overflow: hidden;">
                                <div class="d-flex flex-column align-items-center justify-content-center" style="width: 85px; background: #ff4747; color: #fff; flex-shrink: 0; position: relative;">
                                    <i class="fa fa-ticket fa-2x"></i>
                                    <small class="fw-bold mt-1" style="font-size: 0.6rem; text-transform: uppercase;">Giảm giá</small>
                                    
                                    <div style="position: absolute; right: -5px; top: 0; bottom: 0; width: 10px; background-image: radial-gradient(circle at 10px 10px, transparent 0, transparent 5px, #fff 5px, #fff 10px); background-size: 10px 20px;"></div>
                                </div>
                                
                                <div class="p-3 flex-grow-1" style="min-width: 0;">
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 0.95rem;">{{ $voucher->voucher_code }}</h6>
                                    <p class="mb-1 text-danger fw-bold" style="font-size: 0.9rem;">
                                        Giảm {{ $voucher->discount_type == 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . 'đ' }}
                                    </p>
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        Đơn tối thiểu: {{ number_format($voucher->min_order_value) }}đ
                                    </div>
                                </div>

                                <button
    type="button"
    class="btn btn-danger btn-sm rounded-pill px-3 fw-bold"
    onclick="fillVoucherCode('{{ $voucher->voucher_code }}')"
    style="font-size: 0.75rem; white-space: nowrap;">
    Dùng
</button>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" width="60" style="opacity: 0.2;" alt="Empty">
                        <p class="text-muted mt-2 small">Bạn chưa có mã giảm giá nào</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection