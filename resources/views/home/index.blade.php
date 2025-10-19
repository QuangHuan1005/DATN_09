@extends('master')
@section('content')

    <body
        class="wp-singular page-template page-template-elementor_header_footer page page-id-917 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-917 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-1043kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div data-elementor-type="wp-page" data-elementor-id="917" class="elementor elementor-917">
                        <div class="elementor-element elementor-element-bbd8021 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="bbd8021" data-element_type="container">
                            <div class="elementor-element elementor-element-9f30ff8 elementor-widget elementor-widget-slider_revolution"
                                data-id="9f30ff8" data-element_type="widget" data-widget_type="slider_revolution.default">
                                <div class="elementor-widget-container">

                                    <div class="wp-block-themepunch-revslider">
                                        <!-- START Home v2 REVOLUTION SLIDER 6.7.31 -->
                                        <div class="e-con-inner">
                                            <div class="elementor-element elementor-element-0091745 elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-banner"
                                                data-id="0091745" data-element_type="widget"
                                                data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;}"
                                                data-widget_type="kitify-banner.default">
                                                <div class="elementor-widget-container">
                                                    <figure class="kitify-banner kitify-effect-none"><a
                                                            href="../shop/index.html" class="kitify-banner__link">
                                                            <div class="kitify-banner__overlay"></div><img decoding="async"
                                                                src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m5_banner_01.jpg"
                                                                alt="m5_banner_01" class="kitify-banner__img">
                                                            {{-- <img decoding="async"
                                                                src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m5_banner_01.jpg"
                                                                alt="m5_banner_01" class="kitify-banner__img"> --}}
                                                            <figcaption class="kitify-banner__content">
                                                                <div class="kitify-banner__content-wrap">
                                                                    <div class="kitify-banner__sub-title">Urban Muse</div>
                                                                    <h2 class="kitify-banner__title">City Chic with a
                                                                        Feminine Twist
                                                                    </h2>
                                                                    <div class="kitify-banner__button"><button
                                                                            type="button" class="elementor-button"><span
                                                                                class="elementor-button-text">Shop
                                                                                now</span></button>
                                                                    </div>
                                                                </div>
                                                            </figcaption>
                                                        </a></figure>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END REVOLUTION SLIDER -->
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-0515f8d e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="0515f8d" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-b96983c e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="b96983c" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-b2bacd0 elementor-widget elementor-widget-heading"
                                        data-id="b2bacd0" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <span class="elementor-heading-title elementor-size-default">Top sản phẩm</span>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-840db58 elementor-widget elementor-widget-heading"
                                        data-id="840db58" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">Nổi bật</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-520bb32 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="520bb32" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:500}"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div class="woocommerce  kitify_wc_widget_520bb32_0">
                                            <div class="kitify-products">
                                                <div class="kitify-products__list_wrapper">
                                                    <ul
                                                        class="products ul_products kitify-products__list products-grid products-grid-1 col-row columns-4">


                                                        @foreach ($newProducts as $item)
                                                            <li
                                                                class="product_item product-grid-item product type-product post-960 status-publish first instock product_cat-hoodies product_cat-tshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m41 product_tag-products product_tag-women has-post-thumbnail sale shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-4 col-tabp-2 col-tab-3 col-lap-4">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                        @php
                                                                            $variant = $item->variants->first();
                                                                        @endphp
                                                                        @if ($variant && $variant->sale && $variant->sale < $variant->price)
                                                                            @php
                                                                                $discount = round(
                                                                                    (($variant->price -
                                                                                        $variant->sale) /
                                                                                        $variant->price) *
                                                                                        100,
                                                                                );
                                                                            @endphp
                                                                            <span class="onsale">{{ $discount }}%</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="{{ route('products.show', ['id' => $item->id]) }}"></a>
                                                                        <div class="product-item__description--top-actions">

                                                                            <a href="{{ route('products.show', ['id' => $item->id]) }}?add_to_wishlist=960"
                                                                                data-product-id="960"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="https://mixtas.novaworks.net/wishlist/"
                                                                                data-browse-wishlist-text="Browse wishlist"
                                                                                class="nova_product_wishlist_btn add_to_wishlist"
                                                                                rel="nofollow">
                                                                                <i class="inova ic-favorite"></i>
                                                                                <span class="hidden add-text">Add to
                                                                                    wishlist</span>
                                                                                <span class="hidden added-text">Browse
                                                                                    wishlist</span>
                                                                            </a>

                                                                            <a href="#"
                                                                                class="nova_product_quick_view_btn"
                                                                                data-product-id="960" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a>
                                                                            <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="960" data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Space dye knit sweater&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a>
                                                                            <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_960"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options
                                                                                may be chosen on the product page
                                                                            </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            {{-- <a
																		href="{{ route('products.show', ['id' => $item->id]) }}">
																		<img loading="lazy" decoding="async" width="700"
																			height="700" src="{{ $item->image }}"
																			class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																			alt=""
																			srcset="{{ $item->image }} 700w, {{ $item->image }} 300w, {{ $item->image }} 150w, {{ $item->image }} 768w, {{ $item->image }} 250w, {{ $item->image }} 50w, {{ $item->image }} 100w, {{ $item->image }} 1000w"
																			sizes="(max-width: 700px) 100vw, 700px" /><span
																			class="product_second_image"
																			style="background-image: url('{{ $item->image }}')"></span>
																	</a> --}}
                                                                            <a
                                                                                href="{{ route('products.show', ['id' => $item->id]) }}">
                                                                                <img loading="lazy" decoding="async"
                                                                                    width="700" height="700"
                                                                                    src="https://picsum.photos/700"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt=""
                                                                                    srcset="https://picsum.photos/700 700w, https://picsum.photos/300 300w, https://picsum.photos/150 150w, https://picsum.photos/768 768w, https://picsum.photos/250 250w, https://picsum.photos/50 50w, https://picsum.photos/100 100w, https://picsum.photos/1000 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('https://picsum.photos/700')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category">
                                                                                    <a class="content-product-cat"
                                                                                        href="{{ route('products.category', ['slug' => $item->category->slug]) }}"
                                                                                        rel="tag">{{ $item->category->name }}
                                                                                    </a>
                                                                                </div>
                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        {{ $item->name }}</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">
                                                                                @if ($variant)
                                                                                    @if ($variant->sale && $variant->sale < $variant->price)
                                                                                        {{-- Có giá khuyến mãi --}}
                                                                                        <span class="price">
                                                                                            <del aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </del>
                                                                                            <ins aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->sale, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </ins>
                                                                                        </span>
                                                                                    @else
                                                                                        {{-- Không có giá khuyến mãi --}}
                                                                                        <span class="price">
                                                                                            <ins aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </ins>
                                                                                        </span>
                                                                                    @endif
                                                                                @else
                                                                                    {{-- Không có biến thể, dùng giá sản phẩm
																			--}}
                                                                                    {{-- <span class="price">
																				<ins aria-hidden="true">
																					<span
																						class="woocommerce-Price-amount amount">
																						<bdi>
																							{{
																							number_format($item->price
																							?? 0, 0, ',', '.') }}₫
																						</bdi>
																					</span>
																				</ins>
																			</span> --}}
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-7e6455b e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="7e6455b" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-07fcf5e e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="07fcf5e" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-352cde9 elementor-widget elementor-widget-heading"
                                        data-id="352cde9" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <span class="elementor-heading-title elementor-size-default">Top Danh
                                                Mục</span>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-83e0ef6 elementor-widget elementor-widget-heading"
                                        data-id="83e0ef6" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">Danh Mục Sản Phẩm
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-f8ace01 bannerlist--preset-default custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-banner-list"
                                    data-id="f8ace01" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:500}"
                                    data-widget_type="kitify-banner-list.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-bannerlist layout-type-flat preset-default kitify-carousel"
                                            data-item_selector=".kitify-bannerlist__item"
                                            data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:true,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-f8ace01&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-f8ace01&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_f8ace01&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_f8ace01&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:&quot;6&quot;,&quot;mobile&quot;:&quot;2&quot;,&quot;tablet&quot;:&quot;4&quot;,&quot;tablet_extra&quot;:&quot;5&quot;,&quot;laptop&quot;:&quot;6&quot;,&quot;mobile_extra&quot;:&quot;4&quot;}}"
                                            dir="ltr">
                                            <div class="kitify-carousel-inner">
                                                <div class="kitify-bannerlist__list_wrapper swiper-container"
                                                    id="kitify_carousel_f8ace01">
                                                    <div class="kitify-bannerlist__list swiper-wrapper">
                                                        @foreach ($categories as $cat)
                                                            <div
                                                                class="elementor-repeater-item-54e10a7 kitify-bannerlist__item swiper-slide col-desk-6 col-mob-2 col-tab-4 col-lap-6 col-tabp-4">
                                                                <div class="kitify-bannerlist__inner">
                                                                    <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                                                                        class="kitify-bannerlist__link">
                                                                        <div class="kitify-bannerlist__image">
                                                                            <img loading="lazy" decoding="async"
                                                                                src="https://mir-s3-cdn-cf.behance.net/project_modules/max_632_webp/36f6ef55685859.59fd8c47e62ca.png"
                                                                                alt="" loading="lazy"
                                                                                class="kitify-bannerlist__image-instance"
                                                                                width="446" height="446"
                                                                                style="--img-height:446px">
                                                                        </div>
                                                                        <div class="kitify-bannerlist__content">
                                                                            <div class="kitify-bannerlist__content-inner">
                                                                                <div class="kitify-bannerlist__title">
                                                                                    {{ $cat->name }}
                                                                                </div>
                                                                                <div class="kitify-bannerlist__desc">
                                                                                    {{ $cat->products_count }}
                                                                                    items</div>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kitify-carousel__prev-arrow-f8ace01 kitify-arrow prev-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-left"></i></div>
                                            <div class="kitify-carousel__next-arrow-f8ace01 kitify-arrow next-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-0515f8d e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="0515f8d" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-b96983c e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="b96983c" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-b2bacd0 elementor-widget elementor-widget-heading"
                                        data-id="b2bacd0" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <span class="elementor-heading-title elementor-size-default">Top sản
                                                phẩm</span>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-840db58 elementor-widget elementor-widget-heading"
                                        data-id="840db58" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">Đang giảm giá</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-520bb32 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="520bb32" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:500}"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div class="woocommerce  kitify_wc_widget_520bb32_0">
                                            <div class="kitify-products">
                                                <div class="kitify-products__list_wrapper">
                                                    <ul
                                                        class="products ul_products kitify-products__list products-grid products-grid-1 col-row columns-4">


                                                        @foreach ($saleProducts as $item)
                                                            <li
                                                                class="product_item product-grid-item product type-product post-960 status-publish first instock product_cat-hoodies product_cat-tshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m41 product_tag-products product_tag-women has-post-thumbnail sale shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-4 col-tabp-2 col-tab-3 col-lap-4">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                        @php
                                                                            $variant = $item->variants->first();
                                                                        @endphp
                                                                        @if ($variant && $variant->sale && $variant->sale < $variant->price)
                                                                            @php
                                                                                $discount = round(
                                                                                    (($variant->price -
                                                                                        $variant->sale) /
                                                                                        $variant->price) *
                                                                                        100,
                                                                                );
                                                                            @endphp
                                                                            <span
                                                                                class="onsale">{{ $discount }}%</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="{{ route('products.show', ['id' => $item->id]) }}"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="{{ route('products.show', ['id' => $item->id]) }}?add_to_wishlist=960"
                                                                                data-product-id="960"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="https://mixtas.novaworks.net/wishlist/"
                                                                                data-browse-wishlist-text="Browse wishlist"
                                                                                class="nova_product_wishlist_btn add_to_wishlist"
                                                                                rel="nofollow">
                                                                                <i class="inova ic-favorite"></i>
                                                                                <span class="hidden add-text">Add to
                                                                                    wishlist</span>
                                                                                <span class="hidden added-text">Browse
                                                                                    wishlist</span>
                                                                            </a>

                                                                            <a href="#"
                                                                                class="nova_product_quick_view_btn"
                                                                                data-product-id="960" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a>
                                                                            <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="960" data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Space dye knit sweater&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a>
                                                                            <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_960"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options
                                                                                may be chosen on the product page
                                                                            </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            {{-- <a
																		href="{{ route('products.show', ['id' => $item->id]) }}">
																		<img loading="lazy" decoding="async" width="700"
																			height="700" src="{{ $item->image }}"
																			class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																			alt=""
																			srcset="{{ $item->image }} 700w, {{ $item->image }} 300w, {{ $item->image }} 150w, {{ $item->image }} 768w, {{ $item->image }} 250w, {{ $item->image }} 50w, {{ $item->image }} 100w, {{ $item->image }} 1000w"
																			sizes="(max-width: 700px) 100vw, 700px" /><span
																			class="product_second_image"
																			style="background-image: url('{{ $item->image }}')"></span>
																	</a> --}}
                                                                            <a
                                                                                href="{{ route('products.show', ['id' => $item->id]) }}">
                                                                                <img loading="lazy" decoding="async"
                                                                                    width="700" height="700"
                                                                                    src="https://picsum.photos/700"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt=""
                                                                                    srcset="https://picsum.photos/700 700w, https://picsum.photos/300 300w, https://picsum.photos/150 150w, https://picsum.photos/768 768w, https://picsum.photos/250 250w, https://picsum.photos/50 50w, https://picsum.photos/100 100w, https://picsum.photos/1000 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('https://picsum.photos/700')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category">
                                                                                    <a class="content-product-cat"
                                                                                        href="{{ route('products.category', ['slug' => $item->category->slug]) }}"
                                                                                        rel="tag">{{ $item->category->name }}
                                                                                    </a>
                                                                                </div>
                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        {{ $item->name }}</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">
                                                                                @if ($variant)
                                                                                    @if ($variant->sale && $variant->sale < $variant->price)
                                                                                        {{-- Có giá khuyến mãi --}}
                                                                                        <span class="price">
                                                                                            <del aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </del>
                                                                                            <ins aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->sale, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </ins>
                                                                                        </span>
                                                                                    @else
                                                                                        {{-- Không có giá khuyến mãi --}}
                                                                                        <span class="price">
                                                                                            <ins aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </ins>
                                                                                        </span>
                                                                                    @endif
                                                                                @else
                                                                                    {{-- Không có biến thể, dùng giá sản phẩm
																			--}}
                                                                                    {{-- <span class="price">
																				<ins aria-hidden="true">
																					<span
																						class="woocommerce-Price-amount amount">
																						<bdi>
																							{{
																							number_format($item->price
																							?? 0, 0, ',', '.') }}₫
																						</bdi>
																					</span>
																				</ins>
																			</span> --}}
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-3363627 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="3363627" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-fdd3f34 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="fdd3f34" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-78fd096 elementor-widget elementor-widget-heading"
                                        data-id="78fd096" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <span class="elementor-heading-title elementor-size-default">Top sản
                                                phẩm</span>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-ae5e3e5 elementor-widget elementor-widget-heading"
                                        data-id="ae5e3e5" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">Thịnh hành</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-f97f325 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="f97f325" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:500}"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div class="woocommerce  kitify_wc_widget_f97f325_0">
                                            <div class="kitify-products kitify-carousel"
                                                data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:true,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-f97f325_0&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-f97f325_0&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_f97f325_0&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_f97f325_0&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:4,&quot;mobile_extra&quot;:2,&quot;tablet&quot;:3,&quot;laptop&quot;:4}}"
                                                dir="ltr">
                                                <div class="kitify-carousel-inner">
                                                    <div class="kitify-products__list_wrapper swiper-container">
                                                        <ul
                                                            class="products ul_products kitify-products__list products-grid products-grid-1 swiper-wrapper columns-4">


                                                            @foreach ($trending as $item)
                                                                <li
                                                                    class="product_item product-grid-item product type-product post-960 status-publish first instock product_cat-hoodies product_cat-tshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m41 product_tag-products product_tag-women has-post-thumbnail sale shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-4 col-tabp-2 col-tab-3 col-lap-4">


                                                                    <div class="product-item">
                                                                        <div class="product-item__badges">
                                                                            @php
                                                                                $variant = $item->variants->first();
                                                                            @endphp
                                                                            @if ($variant && $variant->sale && $variant->sale < $variant->price)
                                                                                @php
                                                                                    $discount = round(
                                                                                        (($variant->price -
                                                                                            $variant->sale) /
                                                                                            $variant->price) *
                                                                                            100,
                                                                                    );
                                                                                @endphp
                                                                                <span
                                                                                    class="onsale">{{ $discount }}%</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="product-item__thumbnail">
                                                                            <div class="product-item__thumbnail_overlay">
                                                                            </div>
                                                                            <a class="product-item-link"
                                                                                href="{{ route('products.show', ['id' => $item->id]) }}"></a>
                                                                            <div
                                                                                class="product-item__description--top-actions">

                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}?add_to_wishlist=960"
                                                                                    data-product-id="960"
                                                                                    data-product-type="variable"
                                                                                    data-wishlist-url="https://mixtas.novaworks.net/wishlist/"
                                                                                    data-browse-wishlist-text="Browse wishlist"
                                                                                    class="nova_product_wishlist_btn add_to_wishlist"
                                                                                    rel="nofollow">
                                                                                    <i class="inova ic-favorite"></i>
                                                                                    <span class="hidden add-text">Add to
                                                                                        wishlist</span>
                                                                                    <span class="hidden added-text">Browse
                                                                                        wishlist</span>
                                                                                </a>

                                                                                <a href="#"
                                                                                    class="nova_product_quick_view_btn"
                                                                                    data-product-id="960"
                                                                                    rel="nofollow"><i
                                                                                        class="inova ic-zoom"></i></a>
                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                    data-quantity="1"
                                                                                    class="button product_type_variable add_to_cart_button"
                                                                                    data-product_id="960"
                                                                                    data-product_sku=""
                                                                                    aria-label="Select options for &ldquo;Space dye knit sweater&rdquo;"
                                                                                    rel="nofollow"><svg
                                                                                        class="mixtas-addtocart">
                                                                                        <use xlink:href="#mixtas-addtocart"
                                                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                        </use>
                                                                                    </svg><span class="text">Select
                                                                                        options</span></a>
                                                                                <span
                                                                                    id="woocommerce_loop_add_to_cart_link_describedby_960"
                                                                                    class="screen-reader-text">
                                                                                    This product has multiple variants. The
                                                                                    options
                                                                                    may be chosen on the product page
                                                                                </span>
                                                                            </div>


                                                                            <div
                                                                                class="product-item__thumbnail-placeholder second_image_enabled">
                                                                                {{-- <a
																			href="{{ route('products.show', ['id' => $item->id]) }}">
																			<img loading="lazy" decoding="async"
																				width="700" height="700"
																				src="{{ $item->image }}"
																				class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
																				alt=""
																				srcset="{{ $item->image }} 700w, {{ $item->image }} 300w, {{ $item->image }} 150w, {{ $item->image }} 768w, {{ $item->image }} 250w, {{ $item->image }} 50w, {{ $item->image }} 100w, {{ $item->image }} 1000w"
																				sizes="(max-width: 700px) 100vw, 700px" /><span
																				class="product_second_image"
																				style="background-image: url('{{ $item->image }}')"></span>
																		</a> --}}
                                                                                <a
                                                                                    href="{{ route('products.show', ['id' => $item->id]) }}">
                                                                                    <img loading="lazy" decoding="async"
                                                                                        width="700" height="700"
                                                                                        src="https://picsum.photos/700"
                                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                        alt=""
                                                                                        srcset="https://picsum.photos/700 700w, https://picsum.photos/300 300w, https://picsum.photos/150 150w, https://picsum.photos/768 768w, https://picsum.photos/250 250w, https://picsum.photos/50 50w, https://picsum.photos/100 100w, https://picsum.photos/1000 1000w"
                                                                                        sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                        class="product_second_image"
                                                                                        style="background-image: url('https://picsum.photos/700')"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product-item__description">

                                                                            <div class="product-item__description--info">
                                                                                <div class="info-left">
                                                                                    <div class="product-item__category">
                                                                                        <a class="content-product-cat"
                                                                                            href="{{ route('products.category', ['slug' => $item->category->slug]) }}"
                                                                                            rel="tag">{{ $item->category->name }}
                                                                                        </a>
                                                                                    </div>
                                                                                    <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                        class="title">
                                                                                        <h3
                                                                                            class="woocommerce-loop-product__title">
                                                                                            {{ $item->name }}</h3>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="info-right">
                                                                                    @if ($variant)
                                                                                        @if ($variant->sale && $variant->sale < $variant->price)
                                                                                            {{-- Có giá khuyến mãi --}}
                                                                                            <span class="price">
                                                                                                <del aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </del>
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{ number_format($variant->sale, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </ins>
                                                                                            </span>
                                                                                        @else
                                                                                            {{-- Không có giá khuyến mãi --}}
                                                                                            <span class="price">
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{ number_format($variant->price, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </ins>
                                                                                            </span>
                                                                                        @endif
                                                                                    @else
                                                                                        {{-- Không có biến thể, dùng giá sản
																				phẩm
																				--}}
                                                                                        {{-- <span class="price">
																					<ins aria-hidden="true">
																						<span
																							class="woocommerce-Price-amount amount">
																							<bdi>
																								{{
																								number_format($item->price
																								?? 0, 0, ',', '.')
																								}}₫
																							</bdi>
																						</span>
																					</ins>
																				</span> --}}
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="kitify-carousel__prev-arrow-f97f325_0 kitify-arrow prev-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-left"></i>
                                                </div>
                                                <div class="kitify-carousel__next-arrow-f97f325_0 kitify-arrow next-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-097c7c2 elementor-align-center elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-button"
                                    data-id="097c7c2" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:600}"
                                    data-widget_type="kitify-button.default">
                                    <div class="elementor-widget-container">
                                        <div class="elementor-button-wrapper">
                                            <a href="{{ route('products.index') }}"
                                                class="elementor-button-link elementor-button elementor-btn-align-icon- elementor-size-sm"
                                                role="button">
                                                <span class="elementor-button-content-wrapper">
                                                    <span class="elementor-button-text">Xem thêm</span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-ff447c0 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent e-lazyloaded"
                            data-id="ff447c0" data-element_type="container"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="e-con-inner" style="--kitify-section-width: 1225px;">
                                <div class="elementor-element elementor-element-8b60947 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no kitify-has-entrance-animation e-con e-child animated kitifyShortFadeInUp"
                                    data-id="8b60947" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-496afd5 elementor-widget elementor-widget-heading"
                                        data-id="496afd5" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <span class="elementor-heading-title elementor-size-default">our gallery</span>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-a7cb16c elementor-widget elementor-widget-heading"
                                        data-id="a7cb16c" data-element_type="widget" data-widget_type="heading.default">
                                        <div class="elementor-widget-container">
                                            <h2 class="elementor-heading-title elementor-size-default">Instagram Shop</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-0473fd8 active-object-fit active-object-fit-true custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-invisible kitify-has-entrance-animation elementor-widget kitify elementor-kitify-posts"
                                    data-id="0473fd8" data-element_type="widget"
                                    data-settings="{&quot;_animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;_animation_delay&quot;:500}"
                                    data-widget_type="kitify-posts.default">
                                    <div class="elementor-widget-container">

                                        <div id="novapost_0473fd8"
                                            class="kitify-posts layout-type-grid preset- grid-1 querycpt--post kitify-posts--grid kitify-carousel"
                                            data-item_selector=".kitify-posts__item"
                                            data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:true,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-0473fd8&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-0473fd8&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_0473fd8&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_0473fd8&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:3,&quot;laptop&quot;:3,&quot;tablet&quot;:3,&quot;mobile_extra&quot;:3}}"
                                            dir="ltr">
                                            <div class="kitify-carousel-inner">
                                                <div class="kitify-posts__list_wrapper swiper-container">
                                                    <div class="kitify-posts__list swiper-wrapper"
                                                        id="kitify_carousel_0473fd8">
                                                        <div
                                                            class="kitify-posts__item has-post-thumbnail swiper-slide term-53 term-62 term-50 term-52 term-48 term-63">
                                                            <div class="kitify-posts__outer-box">
                                                                <div class="kitify-posts__inner-box">
                                                                    <div class="post-thumbnail kitify-posts__thumbnail">
                                                                        <a href="2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html"
                                                                            class="kitify-posts__thumbnail-link"><img
                                                                                loading="lazy" decoding="async"
                                                                                width="1500" height="1000"
                                                                                src="https://picsum.photos/1500"
                                                                                class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                                alt=""
                                                                                srcset="https://picsum.photos/1500 1500w, https://picsum.photos/300 300w, https://picsum.photos/1024 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-04-1000x667.jpg 1000w"
                                                                                sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                    </div>
                                                                    <div class="kitify-posts__inner-content">
                                                                        <div class="kitify-posts__inner-content-inner">
                                                                            <div
                                                                                class="kitify-posts__meta kitify-posts__meta2">
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                    <span
                                                                                        class="meta--label">By</span><span
                                                                                        class="meta--value"><a
                                                                                            href="author/admin/index.html"
                                                                                            class="posted-by__author"
                                                                                            rel="author">admin</a></span>
                                                                                </div>
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                    <span class="meta--value">December 19,
                                                                                        2023</span>
                                                                                </div>
                                                                            </div>
                                                                            <h4 class="kitify-posts__title"><a
                                                                                    href="2023/12/unveiling-elegance-timeless-fashion-trends-for-women/index.html"
                                                                                    title="Unveiling Elegance: Timeless Fashion Trends for Women"
                                                                                    rel="bookmark">Unveiling Elegance:
                                                                                    Timeless Fashion Trends for Women</a>
                                                                            </h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="kitify-posts__item has-post-thumbnail swiper-slide term-53 term-62 term-50 term-52 term-48 term-63">
                                                            <div class="kitify-posts__outer-box">
                                                                <div class="kitify-posts__inner-box">
                                                                    <div class="post-thumbnail kitify-posts__thumbnail">
                                                                        <a href="2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html"
                                                                            class="kitify-posts__thumbnail-link"><img
                                                                                loading="lazy" decoding="async"
                                                                                width="1500" height="1000"
                                                                                src="../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05.jpg"
                                                                                class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                                alt=""
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-05-1000x667.jpg 1000w"
                                                                                sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                    </div>
                                                                    <div class="kitify-posts__inner-content">
                                                                        <div class="kitify-posts__inner-content-inner">
                                                                            <div
                                                                                class="kitify-posts__meta kitify-posts__meta2">
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                    <span
                                                                                        class="meta--label">By</span><span
                                                                                        class="meta--value"><a
                                                                                            href="author/admin/index.html"
                                                                                            class="posted-by__author"
                                                                                            rel="author">admin</a></span>
                                                                                </div>
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                    <span class="meta--value">December 19,
                                                                                        2023</span>
                                                                                </div>
                                                                            </div>
                                                                            <h4 class="kitify-posts__title"><a
                                                                                    href="2023/12/dress-to-impress-a-guide-to-power-dressing-for-success/index.html"
                                                                                    title="Dress to Impress: A Guide to Power Dressing for Success"
                                                                                    rel="bookmark">Dress to Impress: A
                                                                                    Guide
                                                                                    to Power Dressing for Success</a></h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="kitify-posts__item has-post-thumbnail swiper-slide term-53 term-62 term-50 term-52 term-48 term-63">
                                                            <div class="kitify-posts__outer-box">
                                                                <div class="kitify-posts__inner-box">
                                                                    <div class="post-thumbnail kitify-posts__thumbnail">
                                                                        <a href="2023/12/fashion-forward-emerging-trends-you-need-to-know/index.html"
                                                                            class="kitify-posts__thumbnail-link"><img
                                                                                loading="lazy" decoding="async"
                                                                                width="1500" height="1000"
                                                                                src="../mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06.jpg"
                                                                                class="kitify-posts__thumbnail-img wp-post-image nova-lazyload-image wp-post-image"
                                                                                alt=""
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06.jpg 1500w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-300x200.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-1024x683.jpg 1024w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-768x512.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/blog-06-1000x667.jpg 1000w"
                                                                                sizes="(max-width: 1500px) 100vw, 1500px" /></a>

                                                                    </div>
                                                                    <div class="kitify-posts__inner-content">
                                                                        <div class="kitify-posts__inner-content-inner">
                                                                            <div
                                                                                class="kitify-posts__meta kitify-posts__meta2">
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--author post__author posted-by">
                                                                                    <span
                                                                                        class="meta--label">By</span><span
                                                                                        class="meta--value"><a
                                                                                            href="author/admin/index.html"
                                                                                            class="posted-by__author"
                                                                                            rel="author">admin</a></span>
                                                                                </div>
                                                                                <div
                                                                                    class="kitify-posts__meta__item kitify-posts__meta__item--date post__date">
                                                                                    <span class="meta--value">December 19,
                                                                                        2023</span>
                                                                                </div>
                                                                            </div>
                                                                            <h4 class="kitify-posts__title"><a
                                                                                    href="2023/12/fashion-forward-emerging-trends-you-need-to-know/index.html"
                                                                                    title="Fashion Forward: Emerging Trends You Need to Know"
                                                                                    rel="bookmark">Fashion Forward:
                                                                                    Emerging
                                                                                    Trends You Need to Know</a></h4>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="kitify-carousel__prev-arrow-0473fd8 kitify-arrow prev-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-left"></i></div>
                                            <div class="kitify-carousel__next-arrow-0473fd8 kitify-arrow next-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-800a4c8 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="800a4c8" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-0beba00 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="0beba00" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;}">
                                    <div class="elementor-element elementor-element-df8564a elementor-view-framed elementor-position-left elementor-tablet_extra-position-top elementor-mobile-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
                                        data-id="df8564a" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                            height="32" viewBox="0 0 32 32" fill="none">
                                                            <path d="M8 16H4" stroke="black" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M7.99984 22.6667H6.6665" stroke="black"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M23.7719 24H30.6666V16L25.3333 13.3333L23.9999 8H13.3333V24H16.2279"
                                                                stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path d="M1.33325 9.3335H7.99992" stroke="black"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path d="M1.33325 2.66675H13.3333V8.00008" stroke="black"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M20 29.3335C22.2091 29.3335 24 27.5426 24 25.3335C24 23.1244 22.2091 21.3335 20 21.3335C17.7909 21.3335 16 23.1244 16 25.3335C16 27.5426 17.7909 29.3335 20 29.3335Z"
                                                                stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path d="M18.6665 12V14.6667H21.3332" stroke="black"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                        </svg> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Miễn phí vận chuyển </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Miễn phí vận chuyển cho đơn hàng trên 300.000đ </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-2f437bf e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="2f437bf" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;animation_delay&quot;:400}">
                                    <div class="elementor-element elementor-element-5c399d5 elementor-view-framed elementor-position-left elementor-tablet_extra-position-top elementor-mobile-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
                                        data-id="5c399d5" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="36"
                                                            height="36" viewBox="0 0 36 36" fill="none">
                                                            <path
                                                                d="M33.6677 7.11781L27.2392 4.54638C27.0857 4.48487 26.9144 4.48487 26.7609 4.54638L20.3323 7.11781C20.2131 7.16557 20.111 7.24791 20.039 7.35424C19.9671 7.46056 19.9286 7.586 19.9286 7.71438V14.359C19.9319 15.5798 20.2496 16.7793 20.8511 17.8418C21.4526 18.9042 22.3176 19.7939 23.3627 20.425L26.6696 22.4088C26.7694 22.4686 26.8836 22.5002 27 22.5002C27.1164 22.5002 27.2306 22.4686 27.3304 22.4088L30.2143 20.6782V27.8782C30.214 28.1577 30.1028 28.4257 29.9051 28.6234C29.7075 28.821 29.4395 28.9322 29.16 28.9325H4.26859C3.98908 28.9322 3.72112 28.821 3.52347 28.6234C3.32583 28.4257 3.21464 28.1577 3.2143 27.8782V13.5001H18C18.1705 13.5001 18.334 13.4324 18.4546 13.3118C18.5751 13.1912 18.6429 13.0277 18.6429 12.8572C18.6429 12.6867 18.5751 12.5232 18.4546 12.4027C18.334 12.2821 18.1705 12.2144 18 12.2144H10.6072H3.2143V10.6972C3.21464 10.4177 3.32583 10.1498 3.52347 9.95212C3.72112 9.75448 3.98908 9.64329 4.26859 9.64295H18C18.1705 9.64295 18.334 9.57522 18.4546 9.45466C18.5751 9.3341 18.6429 9.17059 18.6429 9.00009C18.6429 8.8296 18.5751 8.66609 18.4546 8.54553C18.334 8.42497 18.1705 8.35724 18 8.35724H4.26859C3.64809 8.35758 3.0531 8.60422 2.61434 9.04298C2.17557 9.48175 1.92893 10.0767 1.92859 10.6972V27.8744C1.92893 28.4949 2.17557 29.0899 2.61434 29.5286C3.0531 29.9674 3.64809 30.214 4.26859 30.2144H29.16C29.7805 30.214 30.3755 29.9674 30.8143 29.5286C31.253 29.0899 31.4997 28.4949 31.5 27.8744V19.8001C32.3008 19.1361 32.9462 18.3045 33.3905 17.3639C33.8348 16.4233 34.0672 15.3966 34.0714 14.3564V7.71438C34.0714 7.586 34.033 7.46056 33.961 7.35424C33.889 7.24791 33.7869 7.16557 33.6677 7.11781ZM32.7857 14.359C32.7831 15.3579 32.5231 16.3394 32.0308 17.2087C31.5385 18.078 30.8305 18.8057 29.9752 19.3218L27 21.1077L24.0249 19.3218C23.1695 18.8057 22.4615 18.078 21.9692 17.2087C21.4769 16.3394 21.2169 15.3579 21.2143 14.359V8.14895L27 5.83467L32.7857 8.14895V14.359Z"
                                                                fill="#000000"></path>
                                                            <path
                                                                d="M24.8838 12.5127C24.8241 12.453 24.7532 12.4055 24.6752 12.3732C24.5972 12.3408 24.5135 12.3241 24.4291 12.324C24.3446 12.324 24.2609 12.3405 24.1829 12.3728C24.1048 12.4051 24.0339 12.4524 23.9741 12.5121C23.9143 12.5718 23.8669 12.6427 23.8345 12.7207C23.8022 12.7987 23.7855 12.8823 23.7854 12.9668C23.7853 13.0513 23.8019 13.1349 23.8342 13.213C23.8665 13.291 23.9138 13.362 23.9735 13.4217L25.6886 15.1356C25.8092 15.2561 25.9727 15.3238 26.1431 15.3238C26.3136 15.3238 26.4771 15.2561 26.5976 15.1356L30.0266 11.7066C30.1472 11.5859 30.2148 11.4222 30.2147 11.2516C30.2146 11.0811 30.1467 10.9175 30.026 10.797C29.9053 10.6764 29.7416 10.6088 29.571 10.6089C29.4004 10.609 29.2369 10.6769 29.1163 10.7976L26.1425 13.7727L24.8838 12.5127Z"
                                                                fill="#000000"></path>
                                                            <path
                                                                d="M6.42862 25.0715C6.25813 25.0715 6.09461 25.1393 5.97406 25.2598C5.8535 25.3804 5.78577 25.5439 5.78577 25.7144C5.78577 25.8849 5.8535 26.0484 5.97406 26.169C6.09461 26.2895 6.25813 26.3572 6.42862 26.3572H11.5715C11.742 26.3572 11.9055 26.2895 12.0261 26.169C12.1466 26.0484 12.2143 25.8849 12.2143 25.7144C12.2143 25.5439 12.1466 25.3804 12.0261 25.2598C11.9055 25.1393 11.742 25.0715 11.5715 25.0715H6.42862Z"
                                                                fill="#000000"></path>
                                                        </svg> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Đảm bảo hoàn tiền </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Đổi trả trong vòng 30 ngày</p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-fdf744d e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="fdf744d" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;animation_delay&quot;:600}">
                                    <div class="elementor-element elementor-element-7581603 elementor-view-framed elementor-position-left elementor-tablet_extra-position-top elementor-mobile-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
                                        data-id="7581603" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="33"
                                                            height="32" viewBox="0 0 33 32" fill="none">
                                                            <path
                                                                d="M8.50004 4H4.50004C3.02671 4 1.83337 5.19333 1.83337 6.66667C1.83337 8.14 3.02671 9.33333 4.50004 9.33333"
                                                                stroke="#000000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M8.5 9.33325V1.33325H27.1667V9.33325" stroke="#000000"
                                                                stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"></path>
                                                            <path
                                                                d="M31.1667 9.33317H4.50004C3.02671 9.33317 1.83337 8.13984 1.83337 6.6665V26.6665C1.83337 28.8758 3.62404 30.6665 5.83337 30.6665H31.1667V9.33317Z"
                                                                stroke="#000000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path
                                                                d="M23.1667 22.6666C24.6394 22.6666 25.8333 21.4727 25.8333 19.9999C25.8333 18.5272 24.6394 17.3333 23.1667 17.3333C21.6939 17.3333 20.5 18.5272 20.5 19.9999C20.5 21.4727 21.6939 22.6666 23.1667 22.6666Z"
                                                                stroke="#000000" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Thanh toán linh hoạt </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Thanh toán bằng nhiều thẻ tín dụng </p>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-074b02e e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no elementor-invisible kitify-has-entrance-animation e-con e-child"
                                    data-id="074b02e" data-element_type="container"
                                    data-settings="{&quot;animation&quot;:&quot;kitifyShortFadeInUp&quot;,&quot;animation_delay&quot;:500}">
                                    <div class="elementor-element elementor-element-929a779 elementor-view-framed elementor-position-left elementor-tablet_extra-position-top elementor-mobile-position-left elementor-shape-circle elementor-vertical-align-top elementor-widget elementor-widget-icon-box"
                                        data-id="929a779" data-element_type="widget" data-widget_type="icon-box.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-icon-box-wrapper">

                                                <div class="elementor-icon-box-icon">
                                                    <span class="elementor-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="37"
                                                            height="36" viewBox="0 0 37 36" fill="none">
                                                            <g clip-path="url(#clip0_174_981)">
                                                                <path d="M30.167 6.33301L23.804 12.696" stroke="black"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M30.167 29.667L23.804 23.304" stroke="black"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M6.83301 29.667L13.196 23.304" stroke="black"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path d="M6.83301 6.33301L13.196 12.696" stroke="black"
                                                                    stroke-width="1.5" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M30.1669 29.6671C36.6104 23.2236 36.6104 12.7764 30.1669 6.33285C23.7233 -0.110738 13.2761 -0.110738 6.83255 6.33285C0.388966 12.7764 0.388966 23.2236 6.83255 29.6671C13.2761 36.1107 23.7233 36.1107 30.1669 29.6671Z"
                                                                    stroke="black" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M23.8029 23.3032C26.7318 20.3743 26.7318 15.6257 23.8029 12.6968C20.874 9.76785 16.1253 9.76785 13.1964 12.6968C10.2675 15.6257 10.2675 20.3743 13.1964 23.3032C16.1253 26.2322 20.874 26.2322 23.8029 23.3032Z"
                                                                    stroke="black" stroke-width="1.5"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_174_981">
                                                                    <rect width="36" height="36" fill="white"
                                                                        transform="translate(0.5)"></rect>
                                                                </clipPath>
                                                            </defs>
                                                        </svg> </span>
                                                </div>

                                                <div class="elementor-icon-box-content">

                                                    <h3 class="elementor-icon-box-title">
                                                        <span>
                                                            Hỗ trợ trực tuyến </span>
                                                    </h3>

                                                    <p class="elementor-icon-box-description">
                                                        Hỗ trợ khách hàng 24/7 </p>

                                                </div>

                                            </div>
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

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        @endsection
