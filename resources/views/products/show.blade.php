@extends('master')
@section('content')
<body
    class="wp-singular product-template-default single single-product postid-164 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-383 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
    <div class="site-wrapper">

        <div class="kitify-site-wrapper elementor-459kitify">
            @include('layouts.header')
            <div class="container py-5">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="{{ asset('storage/products/' . $product->image) }}"
            alt="{{ $product->name }}"
            class="img-fluid mb-3 rounded shadow">

            @if(isset($albums) && $albums->count() > 0)
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($albums as $img)
                        <img src="{{ asset('storage/' . $img->image) }}"
                             alt="Ảnh phụ"
                             class="img-thumbnail"
                             width="100">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
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

@endsection

