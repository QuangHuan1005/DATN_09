@extends('master')
@section('content')
<body
    class="wp-singular product-template-default single single-product postid-164 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-383 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
    <div class="site-wrapper">

        <div class="kitify-site-wrapper elementor-459kitify">
            @include('layouts.header')
            <div class="container py-5">



    <div class="row align-items-start">
    <!-- Hình ảnh sản phẩm -->
    <div class="col-md-6 text-center pe-md-5"> {{-- thêm pe-md-5 để tạo khoảng cách bên phải --}}
        {{-- Ảnh chính --}}
        <div class="main-image mb-4">
            <img
                src="{{ Storage::disk('public')->url('products/'.$product->image) }}"
                alt="{{ $product->name }}"
                class="img-fluid rounded shadow"
                style="max-height: 500px; object-fit: cover;">
        </div>

        {{-- Album ảnh nhỏ phía dưới --}}
        @if(isset($albums) && $albums->count())
        <div class="album-images d-flex justify-content-center gap-3 flex-wrap mt-3">
            @foreach($albums as $img)
            <img
                src="{{ Storage::disk('public')->url('product_images/'.$img->image) }}"
                alt=""
                width="100" height="100"
                class="img-thumbnail border border-secondary"
                style="object-fit: cover; border-radius: 6px;">
            @endforeach
        </div>
        @endif
    </div>

    <!-- Thông tin sản phẩm -->
    <div class="col-md-6 ps-md-5"> {{-- thêm ps-md-5 để tạo khoảng cách bên trái --}}
        <h2 class="mb-3">{{ $product->name }}</h2>
        <p class="text-muted">{{ $product->material }}</p>
        <p>{{ $product->description }}</p>

        @if(isset($variants) && $variants->count() > 0)
            <h4 class="mt-4">Giá:</h4>
            @foreach($variants as $v)
                <div class="border p-2 mb-2 rounded">
                    <strong>
                        {{ $v->color->name ?? 'Mặc định' }} -
                        {{ $v->size->name ?? '' }}
                    </strong><br>
                    @if($v->sale)
                        <span class="text-danger fw-bold">{{ number_format($v->sale) }}₫</span>
                        <span class="text-muted text-decoration-line-through ms-2">{{ number_format($v->price) }}₫</span>
                    @else
                        <span class="text-dark fw-bold">{{ number_format($v->price) }}₫</span>
                    @endif
                </div>
            @endforeach
        @endif

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </form>
    </div>
</div>


    <!-- Đánh giá sản phẩm -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Đánh giá sản phẩm</h3>
            @if(isset($reviews) && $reviews->count() > 0)
                @foreach($reviews as $r)
                    <div class="border-bottom py-3">
                        <strong>⭐ {{ $r->rating }}/5</strong>
                        <p class="mb-0">{{ $r->content }}</p>
                    </div>
                @endforeach
            @else
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            @endif
        </div>
    </div>
</div>
<!-- .site-content-wrapper -->
            <div data-elementor-type="footer" data-elementor-id="478"
                class="elementor elementor-478 elementor-location-footer">
                <div class="elementor-element elementor-element-22c97ffc e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                    data-id="22c97ffc" data-element_type="container"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <div class="e-con-inner">
                        <div class="elementor-element elementor-element-861c9ce e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="861c9ce" data-element_type="container">
                            <div class="elementor-element elementor-element-afefbe8 kitify-widget-align-none elementor-widget kitify elementor-kitify-logo"
                                data-id="afefbe8" data-element_type="widget" data-widget_type="kitify-logo.default">
                                <div class="elementor-widget-container">
                                    <div class="kitify-logo kitify-logo-type-image kitify-logo-display-block">
                                        <a href="../../index.html" class="kitify-logo__link"><img loading="lazy"
                                                src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/footer-logo.svg"
                                                class="kitify-logo__img kitify-logo-default" alt="Mixtas" width="150"
                                                height="36"><img loading="lazy"
                                                src="https://mixtas.b-cdn.net/wp-content/themes/mixtas/assets/images/logo_light.svg"
                                                class="kitify-logo__img kitify-logo-light" alt="Mixtas" width="150"
                                                height="36"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-7276cec9 elementor-widget elementor-widget-heading"
                                data-id="7276cec9" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <p class="elementor-heading-title elementor-size-default">Whether you're a
                                        trendsetter, a minimalist, or an adventurer at heart, Mixtas has something for
                                        everyone. Our diverse range of styles caters to various personas. </p>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-4b1084e8 elementor-shape-circle e-grid-align-left elementor-grid-0 elementor-widget elementor-widget-social-icons"
                                data-id="4b1084e8" data-element_type="widget" data-widget_type="social-icons.default">
                                <div class="elementor-widget-container">
                                    <div class="elementor-social-icons-wrapper elementor-grid">
                                        <span class="elementor-grid-item">
                                            <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-974b910"
                                                href="#" target="_blank">
                                                <span class="elementor-screen-only"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="19"
                                                    viewBox="0 0 11 19" fill="none">
                                                    <path
                                                        d="M9.70117 10.7671H7.06445V18.6421H3.54883V10.7671H0.666016V7.53271H3.54883V5.03662C3.54883 2.22412 5.23633 0.64209 7.80273 0.64209C9.0332 0.64209 10.334 0.888184 10.334 0.888184V3.66553H8.89258C7.48633 3.66553 7.06445 4.50928 7.06445 5.42334V7.53271H10.1934L9.70117 10.7671Z">
                                                    </path>
                                                </svg> </a>
                                        </span>
                                        <span class="elementor-grid-item">
                                            <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-0171b7d"
                                                href="#" target="_blank">
                                                <span class="elementor-screen-only"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                    viewBox="0 0 19 19" fill="none">
                                                    <path
                                                        d="M14.1828 2.32959H16.6649L11.2438 8.52412L17.6211 16.9546H12.6289L8.71603 11.8429L4.24415 16.9546H1.75861L7.55587 10.3276L1.4422 2.32959H6.56095L10.0942 7.00186L14.1828 2.32959ZM13.3109 15.471H14.6856L5.81212 3.73584H4.33556L13.3109 15.471Z">
                                                    </path>
                                                </svg> </a>
                                        </span>
                                        <span class="elementor-grid-item">
                                            <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-ce3448b"
                                                href="#" target="_blank">
                                                <span class="elementor-screen-only"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="19"
                                                    viewBox="0 0 17 19" fill="none">
                                                    <g clip-path="url(#clip0_89_2537)">
                                                        <path
                                                            d="M8.50353 5.59893C6.26759 5.59893 4.46407 7.40244 4.46407 9.63838C4.46407 11.8743 6.26759 13.6778 8.50353 13.6778C10.7395 13.6778 12.543 11.8743 12.543 9.63838C12.543 7.40244 10.7395 5.59893 8.50353 5.59893ZM8.50353 12.2646C7.05861 12.2646 5.87736 11.0868 5.87736 9.63838C5.87736 8.18994 7.05509 7.01221 8.50353 7.01221C9.95197 7.01221 11.1297 8.18994 11.1297 9.63838C11.1297 11.0868 9.94845 12.2646 8.50353 12.2646ZM13.6504 5.43369C13.6504 5.95752 13.2285 6.37588 12.7082 6.37588C12.1844 6.37588 11.766 5.954 11.766 5.43369C11.766 4.91338 12.1879 4.4915 12.7082 4.4915C13.2285 4.4915 13.6504 4.91338 13.6504 5.43369ZM16.3258 6.38994C16.266 5.12783 15.9777 4.00986 15.0531 3.08877C14.132 2.16768 13.0141 1.87939 11.752 1.81611C10.4512 1.74229 6.55236 1.74229 5.25157 1.81611C3.99298 1.87588 2.87501 2.16416 1.9504 3.08525C1.02579 4.00635 0.741028 5.12432 0.677747 6.38643C0.603918 7.68721 0.603918 11.586 0.677747 12.8868C0.737512 14.1489 1.02579 15.2669 1.9504 16.188C2.87501 17.1091 3.98947 17.3974 5.25157 17.4606C6.55236 17.5345 10.4512 17.5345 11.752 17.4606C13.0141 17.4009 14.132 17.1126 15.0531 16.188C15.9742 15.2669 16.2625 14.1489 16.3258 12.8868C16.3996 11.586 16.3996 7.69072 16.3258 6.38994ZM14.6453 14.2825C14.3711 14.9716 13.8402 15.5024 13.1477 15.7802C12.1106 16.1915 9.64962 16.0966 8.50353 16.0966C7.35743 16.0966 4.89298 16.188 3.85939 15.7802C3.17032 15.506 2.63947 14.9751 2.36173 14.2825C1.9504 13.2454 2.04532 10.7845 2.04532 9.63838C2.04532 8.49229 1.95392 6.02783 2.36173 4.99424C2.63595 4.30518 3.16681 3.77432 3.85939 3.49658C4.8965 3.08525 7.35743 3.18018 8.50353 3.18018C9.64962 3.18018 12.1141 3.08877 13.1477 3.49658C13.8367 3.7708 14.3676 4.30166 14.6453 4.99424C15.0567 6.03135 14.9617 8.49229 14.9617 9.63838C14.9617 10.7845 15.0567 13.2489 14.6453 14.2825Z">
                                                        </path>
                                                    </g>
                                                </svg> </a>
                                        </span>
                                        <span class="elementor-grid-item">
                                            <a class="elementor-icon elementor-social-icon elementor-social-icon- elementor-repeater-item-aa47dc0"
                                                href="#" target="_blank">
                                                <span class="elementor-screen-only"></span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="19"
                                                    viewBox="0 0 15 19" fill="none">
                                                    <g clip-path="url(#clip0_89_2540)">
                                                        <path
                                                            d="M7.92188 0.870605C4.31484 0.870605 0.75 3.27529 0.75 7.16709C0.75 9.64209 2.14219 11.0483 2.98594 11.0483C3.33398 11.0483 3.53437 10.078 3.53437 9.80381C3.53437 9.47686 2.70117 8.78076 2.70117 7.42021C2.70117 4.59365 4.85273 2.58975 7.63711 2.58975C10.0312 2.58975 11.8031 3.95029 11.8031 6.4499C11.8031 8.3167 11.0543 11.8183 8.62852 11.8183C7.75313 11.8183 7.0043 11.1854 7.0043 10.2784C7.0043 8.94951 7.93242 7.66279 7.93242 6.2917C7.93242 3.96436 4.63125 4.38623 4.63125 7.19873C4.63125 7.78936 4.70508 8.44326 4.96875 8.98115C4.48359 11.0694 3.49219 14.1808 3.49219 16.3323C3.49219 16.9968 3.58711 17.6507 3.65039 18.3151C3.76992 18.4487 3.71016 18.4347 3.89297 18.3679C5.66484 15.9421 5.60156 15.4675 6.40313 12.2929C6.83555 13.1155 7.95352 13.5585 8.83945 13.5585C12.573 13.5585 14.25 9.91982 14.25 6.63975C14.25 3.14873 11.2336 0.870605 7.92188 0.870605Z">
                                                        </path>
                                                    </g>
                                                </svg> </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-78bc8008 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="78bc8008" data-element_type="container">
                            <div class="elementor-element elementor-element-675d55a4 elementor-widget elementor-widget-heading"
                                data-id="675d55a4" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default">About Us</h3>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-2675c66c elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                data-id="2675c66c" data-element_type="widget" data-widget_type="icon-list.default">
                                <div class="elementor-widget-container">
                                    <ul class="elementor-icon-list-items">
                                        <li class="elementor-icon-list-item">
                                            <a href="../../order-tracking/index.html">

                                                <span class="elementor-icon-list-text">Our Story</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../cart/index.html">

                                                <span class="elementor-icon-list-text">Mission & Values</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Meet the Team</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Sustainability Efforts</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../faqs">

                                                <span class="elementor-icon-list-text">Brand Partnerships</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../faqs">

                                                <span class="elementor-icon-list-text">Influencer Collaborations</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-16032d9e e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="16032d9e" data-element_type="container">
                            <div class="elementor-element elementor-element-4d7c4cfe elementor-widget elementor-widget-heading"
                                data-id="4d7c4cfe" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default">Accessibility</h3>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-40eb361b elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                data-id="40eb361b" data-element_type="widget" data-widget_type="icon-list.default">
                                <div class="elementor-widget-container">
                                    <ul class="elementor-icon-list-items">
                                        <li class="elementor-icon-list-item">
                                            <a href="../../my-account">

                                                <span class="elementor-icon-list-text">Accessibility Statement</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../cart/index.html">

                                                <span class="elementor-icon-list-text">Site Map</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Web Accessibility Options</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">ADA Compliance</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Privacy Policy</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Terms of Service</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-31de1b1 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="31de1b1" data-element_type="container">
                            <div class="elementor-element elementor-element-7362d692 elementor-widget elementor-widget-heading"
                                data-id="7362d692" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h3 class="elementor-heading-title elementor-size-default">Join Our Community</h3>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-1ee74dbf elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list"
                                data-id="1ee74dbf" data-element_type="widget" data-widget_type="icon-list.default">
                                <div class="elementor-widget-container">
                                    <ul class="elementor-icon-list-items">
                                        <li class="elementor-icon-list-item">
                                            <a href="../../about-us/index.html">

                                                <span class="elementor-icon-list-text">VIP Membership</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../cart/index.html">

                                                <span class="elementor-icon-list-text">Loyalty Program</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Customer Reviews</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Style Forums</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Job Openings</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Culture and Values</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-76773236 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="76773236" data-element_type="container">
                            <div class="elementor-element elementor-element-dd4dd2b elementor-widget elementor-widget-heading"
                                data-id="dd4dd2b" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h2 class="elementor-heading-title elementor-size-default">Let’s get in touch</h2>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-3a84aaf4 elementor-widget elementor-widget-heading"
                                data-id="3a84aaf4" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <span class="elementor-heading-title elementor-size-default">Sign up for our
                                        newsletter and receive 10% off your</span>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-6e184175 elementor-widget kitify elementor-kitify-subscribe-form"
                                data-id="6e184175" data-element_type="widget"
                                data-widget_type="kitify-subscribe-form.default">
                                <div class="elementor-widget-container">
                                    <div class="kitify-subscribe-form kitify-subscribe-form--inline-layout"
                                        data-settings="{&quot;redirect&quot;:false,&quot;redirect_url&quot;:&quot;#&quot;,&quot;use_target_list_id&quot;:false,&quot;target_list_id&quot;:&quot;&quot;}">
                                        <form method="POST" action="#" class="kitify-subscribe-form__form">
                                            <div class="kitify-subscribe-form__input-group">
                                                <div class="kitify-subscribe-form__fields">
                                                    <input
                                                        class="kitify-subscribe-form__input kitify-subscribe-form__mail-field"
                                                        type="email" name="email"
                                                        placeholder="Enter your email address..."
                                                        data-instance-data="[]" />
                                                </div>
                                                <a class="kitify-subscribe-form__submit elementor-button elementor-size-md"
                                                    href="#"><span class="elementor-icon"><i aria-hidden="true"
                                                            class="kitify-subscribe-form__submit-icon novaicon novaicon-arrow-right"></i></span><span
                                                        class="kitify-subscribe-form__submit-text"></span></a>
                                            </div>
                                            <div class="kitify-subscribe-form__message">
                                                <div class="kitify-subscribe-form__message-inner"><span></span></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- .site-content-wrapper -->
            @include('layouts.footer')
        <div class="nova-overlay-global"></div>
    </div><!-- .kitify-site-wrapper -->
    @include('layouts.js')


    <div class="pswp" tabindex="-1" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--zoom" aria-label="Zoom in/out"></button>
                    <button class="pswp__button pswp__button--fs" aria-label="Toggle fullscreen"></button>
                    <button class="pswp__button pswp__button--share" aria-label="Share"></button>
                    <button class="pswp__button pswp__button--close" aria-label="Close (Esc)"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                            <div class="pswp__preloader__cut">
                                <div class="pswp__preloader__donut"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button pswp__button--arrow--left" aria-label="Previous (arrow left)"></button>
                <button class="pswp__button pswp__button--arrow--right" aria-label="Next (arrow right)"></button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript'>
        (function () {
			var c = document.body.className;
			c = c.replace(/woocommerce-no-js/, 'woocommerce-js');
			document.body.className = c;
		})();
    </script>
    <link rel='stylesheet' id='wc-blocks-style-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/client/blocks/wc-blocks2656.css?ver=wc-9.7.1'
        type='text/css' media='all' />
    <link rel='stylesheet' id='widget-heading-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-heading.min87cc.css?ver=3.28.3'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-nav-menu-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/nav-menu4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-search-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/search4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-canvas-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/kitify-canvas4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-breadcrumbs-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/breadcrumbs4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-woocommerce-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/kitify-woocommerce4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='widget-spacer-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-spacer.min87cc.css?ver=3.28.3'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-social-share-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/social-share4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='elementor-post-121-css'
        href='../../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/post-12166a8.css?ver=1743737462'
        type='text/css' media='all' />
    <link rel='stylesheet' id='widget-social-icons-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-social-icons.min87cc.css?ver=3.28.3'
        type='text/css' media='all' />
    <link rel='stylesheet' id='e-apple-webkit-css'
        href='../../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-apple-webkit.minbea4.css?ver=1743737085'
        type='text/css' media='all' />
    <link rel='stylesheet' id='widget-icon-list-css'
        href='../../../mixtas.b-cdn.net/wp-content/uploads/elementor/css/custom-widget-icon-list.minbea4.css?ver=1743737085'
        type='text/css' media='all' />
    <link rel='stylesheet' id='kitify-subscribe-form-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/css/addons/subscribe-form4e4e.css?ver=1759216409'
        type='text/css' media='all' />
    <link rel='stylesheet' id='widget-image-css'
        href='../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/css/widget-image.min87cc.css?ver=3.28.3'
        type='text/css' media='all' />
    <link rel='stylesheet' id='rs-plugin-settings-css'
        href='../../wp-content/plugins/revslider/sr6/assets/css/rs61676.css?ver=6.7.31' type='text/css' media='all' />
    <style id='rs-plugin-settings-inline-css' type='text/css'>
        #rs-demo-id {}
    </style>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.selectBox.min7359.js?ver=1.2.0"
        id="jquery-selectBox-js"></script>
    <script type="text/javascript"
        src="../../wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min005e.js?ver=3.1.6"
        id="prettyPhoto-js" data-wp-strategy="defer"></script>
    <script type="text/javascript" id="jquery-yith-wcwl-js-extra">
        /* <![CDATA[ */
var yith_wcwl_l10n = {"ajax_url":"\/wp-admin\/admin-ajax.php","redirect_to_cart":"no","yith_wcwl_button_position":"after_add_to_cart","multi_wishlist":"","hide_add_button":"1","enable_ajax_loading":"","ajax_loader_url":"https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg","remove_from_wishlist_after_add_to_cart":"1","is_wishlist_responsive":"","time_to_close_prettyphoto":"3000","fragments_index_glue":".","reload_on_found_variation":"1","mobile_media_query":"768","labels":{"cookie_disabled":"We are sorry, but this feature is available only if cookies on your browser are enabled.","added_to_cart_message":"<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>"},"actions":{"add_to_wishlist_action":"add_to_wishlist","remove_from_wishlist_action":"remove_from_wishlist","reload_wishlist_and_adding_elem_action":"reload_wishlist_and_adding_elem","load_mobile_action":"load_mobile","delete_item_action":"delete_item","save_title_action":"save_title","save_privacy_action":"save_privacy","load_fragments":"load_fragments"},"nonce":{"add_to_wishlist_nonce":"54e378c625","remove_from_wishlist_nonce":"47efc3fe29","reload_wishlist_and_adding_elem_nonce":"2a7b7e69b5","load_mobile_nonce":"9943d11ffb","delete_item_nonce":"52dcfee0b6","save_title_nonce":"7d0742e0b7","save_privacy_nonce":"31d311c85b","load_fragments_nonce":"66747c4b21"},"redirect_after_ask_estimate":"","ask_estimate_redirect_url":"https:\/\/mixtas.novaworks.net"};
var yith_wcwl_l10n = {"ajax_url":"\/wp-admin\/admin-ajax.php","redirect_to_cart":"no","yith_wcwl_button_position":"after_add_to_cart","multi_wishlist":"","hide_add_button":"1","enable_ajax_loading":"","ajax_loader_url":"https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg","remove_from_wishlist_after_add_to_cart":"1","is_wishlist_responsive":"","time_to_close_prettyphoto":"3000","fragments_index_glue":".","reload_on_found_variation":"1","mobile_media_query":"768","labels":{"cookie_disabled":"We are sorry, but this feature is available only if cookies on your browser are enabled.","added_to_cart_message":"<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>"},"actions":{"add_to_wishlist_action":"add_to_wishlist","remove_from_wishlist_action":"remove_from_wishlist","reload_wishlist_and_adding_elem_action":"reload_wishlist_and_adding_elem","load_mobile_action":"load_mobile","delete_item_action":"delete_item","save_title_action":"save_title","save_privacy_action":"save_privacy","load_fragments":"load_fragments"},"nonce":{"add_to_wishlist_nonce":"54e378c625","remove_from_wishlist_nonce":"47efc3fe29","reload_wishlist_and_adding_elem_nonce":"2a7b7e69b5","load_mobile_nonce":"9943d11ffb","delete_item_nonce":"52dcfee0b6","save_title_nonce":"7d0742e0b7","save_privacy_nonce":"31d311c85b","load_fragments_nonce":"66747c4b21"},"redirect_after_ask_estimate":"","ask_estimate_redirect_url":"https:\/\/mixtas.novaworks.net"};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.min474a.js?ver=4.4.0"
        id="jquery-yith-wcwl-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-includes/js/dist/hooks.min4fdd.js?ver=4d63a3d491d11ffd8ac6" id="wp-hooks-js">
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-includes/js/dist/i18n.minc33c.js?ver=5e580eb46a90c2b997e6" id="wp-i18n-js">
    </script>
    <script type="text/javascript" id="wp-i18n-js-after">
        /* <![CDATA[ */
wp.i18n.setLocaleData( { 'text direction\u0004ltr': [ 'ltr' ] } );
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/swv/js/index52c7.js?ver=6.0.5"
        id="swv-js"></script>
    <script type="text/javascript" id="contact-form-7-js-before">
        /* <![CDATA[ */
var wpcf7 = {
    "api": {
        "root": "https:\/\/mixtas.novaworks.net\/wp-json\/",
        "namespace": "contact-form-7\/v1"
    },
    "cached": 1
};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/contact-form-7/includes/js/index52c7.js?ver=6.0.5"
        id="contact-form-7-js"></script>
    <script type="text/javascript" src="../../wp-content/plugins/revslider/sr6/assets/js/rbtools.min0c0c.js?ver=6.7.29"
        defer async id="tp-tools-js"></script>
    <script type="text/javascript" src="../../wp-content/plugins/revslider/sr6/assets/js/rs6.min1676.js?ver=6.7.31"
        defer async id="revmin-js"></script>
    <script type="text/javascript" id="crisp-js-before">
        /* <![CDATA[ */
    window.$crisp=[];
    if (!window.CRISP_RUNTIME_CONFIG) {
      window.CRISP_RUNTIME_CONFIG = {}
    }

    if (!window.CRISP_RUNTIME_CONFIG.locale) {
      window.CRISP_RUNTIME_CONFIG.locale = 'en-us'
    }

    CRISP_WEBSITE_ID = '114c3be4-da0f-4663-b5f7-3febfccc9984';
/* ]]> */
    </script>
    <script type="text/javascript" async src="../../../client.crisp.chat/ldad2.js?ver=20250930" id="crisp-js"></script>
    <script type="text/javascript" id="wp-api-request-js-extra">
        /* <![CDATA[ */
var wpApiSettings = {"root":"https:\/\/mixtas.novaworks.net\/wp-json\/","nonce":"b30a18ec1e","versionString":"wp\/v2\/"};
/* ]]> */
    </script>
    <script type="text/javascript" src="../../../mixtas.b-cdn.net/wp-includes/js/api-request.min6c2d.js?ver=6.8.2"
        id="wp-api-request-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-includes/js/dist/vendor/wp-polyfill.min2c7c.js?ver=3.15.0"
        id="wp-polyfill-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-includes/js/dist/url.mind63a.js?ver=c2964167dfe2477c14ea" id="wp-url-js">
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-includes/js/dist/api-fetch.minc31c.js?ver=3623a576c78df404ff20"
        id="wp-api-fetch-js"></script>
    <script type="text/javascript" id="wp-api-fetch-js-after">
        /* <![CDATA[ */
wp.apiFetch.use( wp.apiFetch.createRootURLMiddleware( "../../wp-json/index.html" ) );
wp.apiFetch.nonceMiddleware = wp.apiFetch.createNonceMiddleware( "b30a18ec1e" );
wp.apiFetch.use( wp.apiFetch.nonceMiddleware );
wp.apiFetch.use( wp.apiFetch.mediaUploadMiddleware );
wp.apiFetch.nonceEndpoint = "../../wp-admin/admin-ajaxf809.html?action=rest-nonce";
/* ]]> */
    </script>
    <script type="text/javascript" id="woo-variation-swatches-js-extra">
        /* <![CDATA[ */
var woo_variation_swatches_options = {"show_variation_label":"1","clear_on_reselect":"","variation_label_separator":":","is_mobile":"","show_variation_stock":"","stock_label_threshold":"5","cart_redirect_after_add":"no","enable_ajax_add_to_cart":"yes","cart_url":"https:\/\/mixtas.novaworks.net\/cart\/","is_cart":""};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/woo-variation-swatches/assets/js/frontend.mine98f.js?ver=1743737055"
        id="woo-variation-swatches-js"></script>
    <script type="text/javascript" id="ppcp-smart-button-js-extra">
        /* <![CDATA[ */
var PayPalCommerceGateway = {"url":"https:\/\/www.paypal.com\/sdk\/js?client-id=AcKQGCUWQZ8CU6o2bsCRh4PjRhnE_usVuzmuJTIMS8YHISCUYvqm7d98bLByNiI3gvP15wNp6BBzZCoJ&currency=USD&integration-date=2024-02-16&components=buttons,funding-eligibility&vault=false&commit=false&intent=capture&disable-funding=card&enable-funding=venmo,paylater","url_params":{"client-id":"AcKQGCUWQZ8CU6o2bsCRh4PjRhnE_usVuzmuJTIMS8YHISCUYvqm7d98bLByNiI3gvP15wNp6BBzZCoJ","currency":"USD","integration-date":"2024-02-16","components":"buttons,funding-eligibility","vault":"false","commit":"false","intent":"capture","disable-funding":"card","enable-funding":"venmo,paylater"},"script_attributes":{"data-partner-attribution-id":"Woo_PPCP"},"client_id":"AcKQGCUWQZ8CU6o2bsCRh4PjRhnE_usVuzmuJTIMS8YHISCUYvqm7d98bLByNiI3gvP15wNp6BBzZCoJ","currency":"USD","data_client_id":{"set_attribute":false,"endpoint":"\/?wc-ajax=ppc-data-client-id","nonce":"8f7a084c90","user":0,"has_subscriptions":false,"paypal_subscriptions_enabled":false},"redirect":"https:\/\/mixtas.novaworks.net\/checkout\/","context":"product","ajax":{"simulate_cart":{"endpoint":"\/?wc-ajax=ppc-simulate-cart","nonce":"5142290ff0"},"change_cart":{"endpoint":"\/?wc-ajax=ppc-change-cart","nonce":"e0e59c7f9e"},"create_order":{"endpoint":"\/?wc-ajax=ppc-create-order","nonce":"d779ae2741"},"approve_order":{"endpoint":"\/?wc-ajax=ppc-approve-order","nonce":"6dcdfaa7d5"},"approve_subscription":{"endpoint":"\/?wc-ajax=ppc-approve-subscription","nonce":"3ad93b22a9"},"vault_paypal":{"endpoint":"\/?wc-ajax=ppc-vault-paypal","nonce":"8b6d653186"},"save_checkout_form":{"endpoint":"\/?wc-ajax=ppc-save-checkout-form","nonce":"00dc1a0ab9"},"validate_checkout":{"endpoint":"\/?wc-ajax=ppc-validate-checkout","nonce":"10536a5f5f"},"cart_script_params":{"endpoint":"\/?wc-ajax=ppc-cart-script-params"}},"cart_contains_subscription":"","subscription_plan_id":"","variable_paypal_subscription_variations":[],"subscription_product_allowed":"","locations_with_subscription_product":{"product":false,"payorder":false,"cart":false},"enforce_vault":"","can_save_vault_token":"","is_free_trial_cart":"","vaulted_paypal_email":"","bn_codes":{"checkout":"Woo_PPCP","cart":"Woo_PPCP","mini-cart":"Woo_PPCP","product":"Woo_PPCP"},"payer":null,"button":{"wrapper":"#ppc-button-ppcp-gateway","is_disabled":false,"mini_cart_wrapper":"#ppc-button-minicart","is_mini_cart_disabled":false,"cancel_wrapper":"#ppcp-cancel","mini_cart_style":{"layout":"vertical","color":"gold","shape":"rect","label":"paypal","tagline":false,"height":35},"style":{"layout":"horizontal","color":"gold","shape":"rect","label":"paypal","tagline":"false"}},"separate_buttons":{"card":{"id":"ppcp-card-button-gateway","wrapper":"#ppc-button-ppcp-card-button-gateway","style":{"shape":"rect","color":"black","layout":"horizontal"}}},"hosted_fields":{"wrapper":"#ppcp-hosted-fields","labels":{"credit_card_number":"","cvv":"","mm_yy":"MM\/YY","fields_empty":"Card payment details are missing. Please fill in all required fields.","fields_not_valid":"Unfortunately, your credit card details are not valid.","card_not_supported":"Unfortunately, we do not support your credit card.","cardholder_name_required":"Cardholder's first and last name are required, please fill the checkout form required fields."},"valid_cards":["mastercard","visa","amex","discover","american-express","master-card"],"contingency":"SCA_WHEN_REQUIRED"},"messages":[],"labels":{"error":{"generic":"Something went wrong. Please try again or choose another payment source.","required":{"generic":"Required form fields are not filled.","field":"%s is a required field.","elements":{"terms":"Please read and accept the terms and conditions to proceed with your order."}}},"billing_field":"Billing %s","shipping_field":"Shipping %s"},"simulate_cart":{"enabled":true,"throttling":5000},"order_id":"0","single_product_buttons_enabled":"1","mini_cart_buttons_enabled":"","basic_checkout_validation_enabled":"","early_checkout_validation_enabled":"1","funding_sources_without_redirect":["paypal","paylater","venmo","card"],"user":{"is_logged":false}};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/woocommerce-paypal-payments/modules/ppcp-button/assets/js/button21bb.js?ver=2.5.4"
        id="ppcp-smart-button-js"></script>
    <script type="text/javascript" src="../../../mixtas.b-cdn.net/wp-includes/js/imagesloaded.minbb93.js?ver=5.0.0"
        id="imagesloaded-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/foundation/dist/js/foundation.min4e4e.js?ver=1759216409"
        id="foundation-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/cookies/js.cookie4e4e.js?ver=1759216409"
        id="cookies-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-visible/jquery.visible4e4e.js?ver=1759216409"
        id="jquery-visible-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/scrollTo/jquery.scrollTo.min4e4e.js?ver=1759216409"
        id="scrollTo-js"></script>
    <script type="text/javascript" src="../../../mixtas.b-cdn.net/wp-includes/js/hoverIntent.min3e5a.js?ver=1.10.2"
        id="hoverIntent-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery.perfect-scrollbar.minceb2.js?ver=0.7.1"
        id="perfect-scrollbar-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/mojs/mo.min4e4e.js?ver=1759216409"
        id="mojs-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/anime/anime.min4e4e.js?ver=1759216409"
        id="anime-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/swiper/v8/swiper.min94a4.js?ver=8.4.5"
        id="swiper-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/headroom.js/headroom.min4e4e.js?ver=1759216409"
        id="headroom-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/slick/slick.min4e4e.js?ver=1759216409"
        id="slick-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/sticky-kit/jquery.sticky-kit.min4e4e.js?ver=1759216409"
        id="sticky-kit-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/jquery-loading-overlay/loadingoverlay.min4e4e.js?ver=1759216409"
        id="jquery-loading-overlay-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/readmore/readmorec64e.js?ver=1.1.1"
        id="readmore-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/isotope/isotope.pkgd.minc64e.js?ver=1.1.1"
        id="isotope-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/video.popupc64e.js?ver=1.1.1"
        id="video-popup-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/vendor/animatedModal.js/animatedModalc64e.js?ver=1.1.1"
        id="animatedModal-js"></script>
    <script type="text/javascript" id="nova-app-js-extra">
        /* <![CDATA[ */
var nova_js_var = {"js_path":"https:\/\/mixtas.b-cdn.net\/wp-content\/themes\/mixtas\/assets\/js\/vendor\/","js_min":"1","site_preloader":"","topbar_progress":"","select_placeholder":"Choose an option","blog_pagination_type":"default","load_more_btn":"Load more","read_more_btn":"Read more","read_less_btn":"Read less","enable_header_sticky":"0","shop_pagination_type":"infinite_scroll","accent_color":"#000000","shop_display":"grid","popup_show_after":"2000","product_image_zoom":"1","is_customize_preview":""};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/themes/mixtas/assets/js/app4e4e.js?ver=1759216409" id="nova-app-js">
    </script>
    <script type="text/javascript" src="../../../mixtas.b-cdn.net/wp-includes/js/comment-reply.min6c2d.js?ver=6.8.2"
        id="comment-reply-js" async="async" data-wp-strategy="async"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/sourcebuster/sourcebuster.min04d4.js?ver=9.7.1"
        id="sourcebuster-js-js"></script>
    <script type="text/javascript" id="wc-order-attribution-js-extra">
        /* <![CDATA[ */
var wc_order_attribution = {"params":{"lifetime":1.0e-5,"session":30,"base64":false,"ajaxurl":"https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php","prefix":"wc_order_attribution_","allowTracking":true},"fields":{"source_type":"current.typ","referrer":"current_add.rf","utm_campaign":"current.cmp","utm_source":"current.src","utm_medium":"current.mdm","utm_content":"current.cnt","utm_id":"current.id","utm_term":"current.trm","utm_source_platform":"current.plt","utm_creative_format":"current.fmt","utm_marketing_tactic":"current.tct","session_entry":"current_add.ep","session_start_time":"current_add.fd","session_pages":"session.pgs","session_count":"udata.vst","user_agent":"udata.uag"}};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/order-attribution.min04d4.js?ver=9.7.1"
        id="wc-order-attribution-js"></script>
    <script type="text/javascript" id="wc-cart-fragments-js-extra">
        /* <![CDATA[ */
var wc_cart_fragments_params = {"ajax_url":"\/wp-admin\/admin-ajax.php","wc_ajax_url":"\/?wc-ajax=%%endpoint%%","cart_hash_key":"wc_cart_hash_5d3227775be22d377568ebad71c4a81b","fragment_name":"wc_fragments_5d3227775be22d377568ebad71c4a81b","request_timeout":"5000"};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min04d4.js?ver=9.7.1"
        id="wc-cart-fragments-js" defer="defer" data-wp-strategy="defer"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/webpack.runtime.min87cc.js?ver=3.28.3"
        id="elementor-webpack-runtime-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend-modules.min87cc.js?ver=3.28.3"
        id="elementor-frontend-modules-js"></script>
    <script type="text/javascript" src="../../../mixtas.b-cdn.net/wp-includes/js/jquery/ui/core.minb37e.js?ver=1.13.3"
        id="jquery-ui-core-js"></script>
    <script type="text/javascript" id="elementor-frontend-js-extra">
        /* <![CDATA[ */
var kitifySubscribeConfig = {"action":"kitify_ajax","nonce":"c8247f9c14","type":"POST","data_type":"json","is_public":"true","ajax_url":"https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php","sys_messages":{"invalid_mail":"Please, provide valid mail","mailchimp":"Please, set up MailChimp API key and List ID","internal":"Internal error. Please, try again later","server_error":"Server error. Please, try again later","invalid_nonce":"Invalid nonce. Please, try again later","subscribe_success":"Success"}};
/* ]]> */
    </script>
    <script type="text/javascript" id="elementor-frontend-js-before">
        /* <![CDATA[ */
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close","a11yCarouselPrevSlideMessage":"Previous slide","a11yCarouselNextSlideMessage":"Next slide","a11yCarouselFirstSlideMessage":"This is the first slide","a11yCarouselLastSlideMessage":"This is the last slide","a11yCarouselPaginationBulletMessage":"Go to slide"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Landscape","value":991,"default_value":880,"direction":"max","is_enabled":true},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Landscape","value":1279,"default_value":1200,"direction":"max","is_enabled":true},"laptop":{"label":"Laptop","value":1599,"default_value":1366,"direction":"max","is_enabled":true},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}},
"hasCustomBreakpoints":true},"version":"3.28.3","is_static":false,"experimentalFeatures":{"e_font_icon_svg":true,"additional_custom_breakpoints":true,"container":true,"e_local_google_fonts":true,"theme_builder_v2":true,"nested-elements":true,"editor_v2":true,"home_screen":true},"urls":{"assets":"https:\/\/mixtas.b-cdn.net\/wp-content\/plugins\/elementor\/assets\/","ajaxurl":"https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php","uploadUrl":"https:\/\/mixtas.b-cdn.net\/wp-content\/uploads"},"nonces":{"floatingButtonsClickTracking":"1bf67367a8"},"swiperClass":"swiper","settings":{"page":[],"editorPreferences":[]},"kit":{"active_breakpoints":["viewport_mobile","viewport_mobile_extra","viewport_tablet","viewport_tablet_extra","viewport_laptop"],"viewport_mobile":767,"viewport_mobile_extra":991,"viewport_tablet":1024,"viewport_tablet_extra":1279,"viewport_laptop":1599,"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":164,"title":"Carhartt%20American%20Script%20Sweat%2C%20tobacco%20%E2%80%93%20Mixtas","excerpt":"A product short description is a concise and brief overview of a product, providing key information to potential customers. Typically, it is a brief summary that highlights the most important features, benefits, and characteristics of the product. The goal is to quickly communicate relevant details to the consumer and entice them to learn more or make a purchase.","featuredImage":"https:\/\/mixtas.b-cdn.net\/wp-content\/uploads\/2023\/12\/m1_09_1.jpg"}};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/js/frontend.min87cc.js?ver=3.28.3"
        id="elementor-frontend-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/lib/jquery.sticky.min4e4e.js?ver=1759216409"
        id="kitify-sticky-js-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/motion-fx4e4e.js?ver=1759216409"
        id="kitify-motion-fx-js"></script>
    <script type="text/javascript" id="kitify-base-js-extra">
        /* <![CDATA[ */
var KitifySettings = {"templateApiUrl":"https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-template","widgetApiUrl":"https:\/\/mixtas.novaworks.net\/wp-json\/kitify-api\/v1\/elementor-widget","homeURL":"https:\/\/mixtas.novaworks.net\/","ajaxurl":"https:\/\/mixtas.novaworks.net\/wp-admin\/admin-ajax.php","isMobile":"false","devMode":"false","cache_ttl":"300","local_ttl":"86400","themeName":"mixtas","i18n":[],"ajaxNonce":"c8247f9c14","useFrontAjax":"true","isElementorAdmin":""};
/* ]]> */
    </script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/kitify-base4e4e.js?ver=1759216409"
        id="kitify-base-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nav-menu4e4e.js?ver=1759216409"
        id="kitify-w__nav-menu-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/nova-menu4e4e.js?ver=1759216409"
        id="kitify-w__nova-menu-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/elementor/assets/lib/share-link/share-link.min87cc.js?ver=3.28.3"
        id="share-link-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/social-share4e4e.js?ver=1759216409"
        id="kitify-w__social-share-js"></script>
    <script type="text/javascript"
        src="../../../mixtas.b-cdn.net/wp-content/plugins/kitify/assets/js/addons/subscribe-form4e4e.js?ver=1759216409"
        id="kitify-w__subscribe-form-js"></script>

        <style>
        .main-image img {
            max-width: 100%;
            height: 500px;           /* Tăng kích thước ảnh chính */
            object-fit: cover;       /* Giữ tỉ lệ hợp lý, cắt viền nếu cần */
            border-radius: 10px;
        }

        .album-images {
            margin-top: 20px;        /* Cách ảnh chính 1 khoảng */
            gap: 15px !important;    /* Khoảng cách giữa các ảnh nhỏ */
        }

        .album-images img {
            width: 100px;            /* Ảnh nhỏ to hơn một chút */
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s ease-in-out, border-color 0.2s;
        }

        .album-images img:hover {
            transform: scale(1.05);   /* Hiệu ứng phóng nhẹ khi hover */
            border-color: #000;
        }
        </style>

        <style>
        /* Giãn khoảng giữa 2 cột (ảnh và thông tin) */
        .row > .col-md-6:first-child {
            padding-right: 60px !important; /* ép khoảng cách bên phải ảnh */
        }

        .row > .col-md-6:last-child {
            padding-left: 60px !important;  /* ép khoảng cách bên trái nội dung */
        }

        /* Cho ảnh chính to hơn, rõ hơn */
        .main-image img {
            width: 100%;
            max-width: 500px;
            height: 500px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* Cách ảnh chính và album ra xa */
        .album-images {
            margin-top: 20px;
            gap: 15px !important;
        }

        /* Ảnh nhỏ trong album */
        .album-images img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }
        .album-images img:hover {
            transform: scale(1.05);
        }
        </style>

</body>

<!-- Mirrored from mixtas.novaworks.net/product/carhartt-american-script-sweat-tobacco/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Sep 2025 13:03:27 GMT -->

</html>


<!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:13:29 -->

@endsection

