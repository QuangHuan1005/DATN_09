@extends('master')
@section('content')

<<<<<<< HEAD
    <body
        class="wp-singular product-template-default single single-product postid-1558 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-383 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div data-elementor-type="product" data-elementor-id="383"
                        class="elementor elementor-383 elementor-location-single post-1558 product type-product status-publish has-post-thumbnail product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products first instock shipping-taxable purchasable product-type-variable has-default-attributes product">
                        <div class="elementor-element elementor-element-39b316d e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="39b316d" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-58d624c5 elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="58d624c5" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a href="/"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Trang Chủ">Trang Chủ</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><a
                                                            href="{{ route('products.index') }}"
                                                            class="kitify-breadcrumbs__item-link" rel="tag"
                                                            title="Sản Phẩm">Sản Phẩm</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><span
                                                            class="kitify-breadcrumbs__item-target">{{ $product->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-2e5f5a67 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="2e5f5a67" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-7f1d1720 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="7f1d1720" data-element_type="container">
                                    <div class="elementor-element elementor-element-951389e e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                        data-id="951389e" data-element_type="container"
                                        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet_extra&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:1,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
                                        <div class="e-con-inner">
                                            <div class="elementor-element elementor-element-1f95cbfc elementor-widget kitify elementor-kitify-wooproduct-images"
                                                data-id="1f95cbfc" data-element_type="widget"
                                                data-widget_type="kitify-wooproduct-images.default">
                                                <div class="elementor-widget-container">
                                                    <div class="kitify-product-images layout-type-1">
                                                        <div class="woocommerce-product-gallery
                                                            woocommerce-product-gallery--with-images
                                                            woocommerce-product-gallery--columns-6 images"
                                                            data-columns="{{ min(6, max($images ?? [], 6)) ?? null }}"
                                                            style="opacity: 0; transition: opacity .25s ease-in-out;">
                                                            <div class="woocommerce-product-gallery__wrapper">

                                                                @foreach ($images as $index => $img)
                                                                    @php
                                                                        $imgUrl = asset('storage/' . $img);
                                                                        $alt =
                                                                            $product->name . '- Image' . ($index + 1);
                                                                    @endphp

                                                                    <div data-thumb="{{ $imgUrl }}" data-thumb-alt="{{ $alt }}"
                                                                        data-thumb-srcset="{{ $imgUrl }} 250w,
                                                                                {{ $imgUrl }} 300w,
                                                                                {{ $imgUrl }} 150w,
                                                                                {{ $imgUrl }} 768w,
                                                                                {{ $imgUrl }} 700w,
                                                                                {{ $imgUrl }} 50w,
                                                                                {{ $imgUrl }} 100w,
                                                                                {{ $imgUrl }} 1000w"
                                                                        data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                        class="woocommerce-product-gallery__image">

                                                                        <a href="{{ $imgUrl }}">
                                                                            <img fetchpriority="high" width="1000" height="1000"
                                                                                src="{{ $imgUrl }}"
                                                                                class="{{ $index == 0 ? 'wp-post-image' : '' }}"
                                                                                alt="{{ $alt }}" data-caption=""
                                                                                data-src="{{ $imgUrl }}"
                                                                                data-large_image="{{ $imgUrl }}"
                                                                                data-large_image_width="1000"
                                                                                data-large_image_height="1000" decoding="async"
                                                                                srcset="{{ $imgUrl }} 1000w,
                                                                                        {{ $imgUrl }} 300w,
                                                                                        {{ $imgUrl }} 150w,
                                                                                        {{ $imgUrl }} 768w,
                                                                                        {{ $imgUrl }} 700w,
                                                                                        {{ $imgUrl }} 250w,
                                                                                        {{ $imgUrl }} 50w,
                                                                                        {{ $imgUrl }} 100w"
                                                                                sizes="(max-width: 1000px) 100vw, 1000px" @if ($index === 0) id="js-main-image"
                                                                                    data-image-base="{{ asset('storage') }}"
                                                                                @endif />
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-7c6682b4 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="7c6682b4" data-element_type="container">
                                    <div class="elementor-element elementor-element-757ccde elementor-widget kitify elementor-kitify-wooproduct-title"
                                        data-id="757ccde" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-title.default">
                                        <div class="elementor-widget-container">
                                            <h1 class="kitify-post-title ">{{ $product->name }}</h1>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4176e03d elementor-widget elementor-widget-spacer"
                                        data-id="4176e03d" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-22a6034f elementor-widget kitify elementor-kitify-wooproduct-rating"
                                        data-id="22a6034f" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-rating.default">
                                        <div class="elementor-widget-container">
                                            <div class="woocommerce-product-rating">
                                                @php
                                                    $percent = ($avgRating / 5) * 100;
                                                    $total_stock = $product->variants->sum('quantity');
                                                    $total_sold = $product->orderDetails->sum('quantity');

                                                    $stock = (int) ($total_stock ?? 0) - (int) ($total_sold ?? 0);
                                                    if ($stock < 0) {
                                                        $stock = 0;
                                                    }
                                                    $sold = (int) ($total_sold ?? 0);
                                                @endphp

                                                <div class="star-rating" role="img"
                                                    aria-label="Rated {{ $avgRating }} out of 5">
                                                    <span style="width:{{ $percent }}%">Rated <strong
                                                            class="rating">{{ $avgRating }}</strong>
                                                        out of
                                                        5 based on <span class="rating">1</span> customer rating</span>
                                                </div><a href="#reviews" class="woocommerce-review-link" rel="nofollow">
                                                    ({{ $avgRating }}) |
                                                    <span class="count">{{ $ratingCount }}</span> đánh
                                                    giá | <span class="count">đã bán {{ $sold }}</span></a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-42e852fe elementor-widget elementor-widget-spacer"
                                        data-id="42e852fe" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4fae2f47 elementor-widget kitify elementor-kitify-wooproduct-price"
                                        data-id="4fae2f47" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-price.default">
                                        <div class="elementor-widget-container">
                                            <p class="price position-relative">
                                                <ins aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol"
                                                                id="js-product-price" data-product-price>
                                                                {{ number_format($displayPrice, 0, ',', '.') }}₫
                                                            </span>
                                                        </bdi>

                                                    </span>

                                                </ins>
                                                <span class="screen-reader-text" id="js-product-price" data-product-price>
                                                    Original price was: {{ number_format($displayPrice, 0, ',', '.') }}₫.
                                                </span>

                                                <del aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol"
                                                                id="js-product-original-price"
                                                                data-product-original-price>{{ number_format($originalPrice, 0, ',', '.') }}₫
                                                            </span>
                                                        </bdi>
                                                    </span>
                                                </del>

                                                <span class="screen-reader-text" id="js-product-original-price"
                                                    data-product-original-price>
                                                    Current price is: {{ number_format($originalPrice, 0, ',', '.') }}₫.
                                                </span>

                                                {{-- Badge giảm giá đưa lên góc trên, thu nhỏ --}}
                                                <span
                                                    class="badge bg-danger price-discount-badge {{ $discountPercent ? '' : 'd-none' }}"
                                                    id="js-product-discount" data-product-discount>
                                                    -{{ $discountPercent }}%
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6233891c elementor-widget elementor-widget-spacer"
                                        data-id="6233891c" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-53d89609 elementor-widget kitify elementor-kitify-wooproduct-addtocart"
                                        data-id="53d89609" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-addtocart.default">
                                        <div class="elementor-widget-container">

                                            <div class="elementor-add-to-cart elementor-product-variable">

                                                @if (isset($variantMap) && $variantMap->count() > 0)
                                                    <form class="variations_form cart" action="{{ route('cart.add') }}"
                                                        method="post" id="addToCartFrom" enctype='multipart/form-data'
                                                        data-product_id="{{ $product->id }}">
                                                        @csrf
                                                        <div data-product_id="{{ $product->id }}">
                                                            <table class="variations" cellspacing="0" role="presentation">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="label"><label for="pa_color">Màu
                                                                                sắc</label>
                                                                        </th>
                                                                        <td class="value">
                                                                            <select style="display:none" id="pa_color"
                                                                                class=" woo-variation-raw-select"
                                                                                name="color_id" data-attribute_name="color_id"
                                                                                data-show_option_none="yes">
                                                                                <option value="">Choose an option
                                                                                </option>
                                                                                @foreach ($colors as $color)
                                                                                    <option value="{{ $color->id }}">
                                                                                        {{ $color->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <ul role="radiogroup" aria-label="Color"
                                                                                class="variable-items-wrapper color-variable-items-wrapper wvs-style-squared"
                                                                                data-attribute_name="color_id">
                                                                                @foreach ($colors as $color)
                                                                                    <li aria-checked="false" tabindex="0"
                                                                                        data-attribute_name="color_id"
                                                                                        data-wvstooltip="{{ $color->name }}"
                                                                                        class="variable-item color-variable-item js-color-item"
                                                                                        title="{{ $color->name }}"
                                                                                        data-title="{{ $color->name }}"
                                                                                        data-color-id="{{ $color->id }}"
                                                                                        data-value="{{ $color->id }}" role="radio">
                                                                                        <div class="variable-item-contents">
                                                                                            <span
                                                                                                class="variable-item-span variable-item-span-color"
                                                                                                style="background-color:{{ $color->color_code ?? '#cccccc' }};"></span>
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="label"><label for="pa_size">Size</label>
                                                                        </th>
                                                                        <td class="value">
                                                                            <select style="display:none" id="pa_size"
                                                                                class=" woo-variation-raw-select" name="size_id"
                                                                                data-attribute_name="size_id"
                                                                                data-show_option_none="yes">
                                                                                <option value="">Choose an option
                                                                                </option>
                                                                                @foreach ($sizes as $size)
                                                                                    <option value="{{ $size->id }}">
                                                                                        {{ $size->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <ul role="radiogroup" aria-label="Size"
                                                                                class="variable-items-wrapper button-variable-items-wrapper wvs-style-squared"
                                                                                data-attribute_name="size_id">
                                                                                @foreach ($sizes as $size)
                                                                                    <li aria-checked="false" tabindex="0"
                                                                                        data-attribute_name="size_id"
                                                                                        data-wvstooltip="{{ $size->name }}"
                                                                                        class="variable-item button-variable-item js-size-item"
                                                                                        title="{{ $size->name }}"
                                                                                        data-title="{{ $size->name }}"
                                                                                        data-size-id="{{ $size->id }}"
                                                                                        data-value="{{ $size->id }}" role="radio">
                                                                                        <div class="variable-item-contents">
                                                                                            <span
                                                                                                class="variable-item-span variable-item-span-button">{{ $size->size_code }}</span>
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul><a class="reset_variations" href="#"
                                                                                id="js-reset-variations"
                                                                                aria-label="Clear options">Clear</a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="reset_variations_alert screen-reader-text" role="alert"
                                                                aria-live="polite" aria-relevant="all">
                                                                <div class="single_variation_wrap">
                                                                    <div class="woocommerce-variation single_variation">
                                                                        <div class="woocommerce-variation-description">
                                                                        </div>
                                                                        <div class="woocommerce-variation-price"></div>
                                                                        <div class="woocommerce-variation-availability">
                                                                            <p class="stock out-of-stock">Hết hàng</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="single_variation_wrap">
                                                                <div class="woocommerce-variation single_variation"></div>
                                                                <div
                                                                    class="woocommerce-variation-add-to-cart variations_button ">
                                                                    <div class="woocommerce-product-details__add-to-cart">
                                                                        <div class="quantity">
                                                                            <span class="nova-minicart-qty-button decrease"><svg
                                                                                    class="icon">
                                                                                    <use xlink:href="#mini-cart-delete">
                                                                                    </use>
                                                                                </svg></span> <label class="screen-reader-text"
                                                                                for="quantity_input_{{ $product->id }}">
                                                                                Số lượng {{ $product->name }}</label>
                                                                            <input type="number"
                                                                                id="quantity_input_{{ $product->id }}"
                                                                                class="input-text qty text" name="quantity"
                                                                                value="1" aria-label="Product quantity" min="1"
                                                                                max="" step="1" placeholder=""
                                                                                inputmode="numeric" autocomplete="off" />
                                                                            <span class="nova-minicart-qty-button increase"><svg
                                                                                    class="icon">
                                                                                    <use xlink:href="#mini-cart-add"></use>
                                                                                </svg></span>
                                                                        </div>
                                                                        <p class="mb-2">
                                                                            <span id="js-variant-stock"
                                                                                class="fw-medium text-body-secondary">
                                                                                Vui lòng chọn màu và size
                                                                            </span>
                                                                        </p>
                                                                        {{-- HIDDEN INPUT QUAN TRỌNG --}}
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $product->id }}">
                                                                        <input type="hidden" name="product_variant_id"
                                                                            id="js-variant-id" value="">
                                                                        <input type="hidden" name="action_type"
                                                                            id="js-action-type" value="add_to_cart">

                                                                        {{-- NÚT THÊM GIỎ HÀNG --}}
                                                                        <button type="submit"
                                                                            class="single_add_to_cart_button button alt me-2 js-submit-cart"
                                                                            data-action="add_to_cart">
                                                                            Thêm vào giỏ hàng
                                                                        </button>

                                                                        {{-- NÚT MUA NGAY --}}
                                                                        <button type="submit"
                                                                            class="single_add_to_cart_button button btn-primary js-submit-cart"
                                                                            data-action="buy_now">
                                                                            Mua ngay
                                                                        </button>
                                                                    </div>


                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6685eeb6 elementor-widget elementor-widget-spacer"
                                        data-id="6685eeb6" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-3aedd8b5 elementor-widget kitify elementor-kitify-wishlist-button"
                                        data-id="3aedd8b5" data-element_type="widget"
                                        data-widget_type="kitify-wishlist-button.default">
                                        <div class="elementor-widget-container">

                                            <div class="yith-wcwl-add-to-wishlist add-to-wishlist-1558 yith-wcwl-add-to-wishlist--link-style yith-wcwl-add-to-wishlist--single wishlist-fragment on-first-load"
                                                data-fragment-ref="1558"
                                                data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;product_id&quot;:1558,&quot;parent_product_id&quot;:0,&quot;product_type&quot;:&quot;variable&quot;,&quot;is_single&quot;:true,&quot;in_default_wishlist&quot;:false,&quot;show_view&quot;:true,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">

                                                <!-- ADD TO WISHLIST -->

                                                {{-- <div class="yith-wcwl-add-button">
                                                    <a href="index8633.html?add_to_wishlist=1558&amp;_wpnonce=54e378c625"
                                                        class="add_to_wishlist single_add_to_wishlist"
                                                        data-product-id="1558" data-product-type="variable"
                                                        data-original-product-id="0" data-title="Add to wishlist"
                                                        rel="nofollow">
                                                        <svg id="yith-wcwl-icon-heart-outline" class="yith-wcwl-icon-svg"
                                                            fill="none" stroke-width="1.5" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z">
                                                            </path>
                                                        </svg> <span>Add to wishlist</span>
                                                    </a>
                                                </div> --}}
                                                <!-- COUNT TEXT -->

                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div
                                        class="elementor-element elementor-element-43596861 elementor-widget elementor-widget-spacer"
                                        data-id="43596861" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="elementor-element elementor-element-55b36d48 elementor-woo-meta--view-table elementor-widget kitify elementor-kitify-wooproduct-meta"
                                        data-id="55b36d48" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-meta.default">
                                        <div class="elementor-widget-container">
                                            <div class="product_meta">


                                                <span class="sku_wrapper detail-container"><span
                                                        class="detail-label">SKU</span> <span
                                                        class="sku">{{ $product->product_code }}</span></span>

                                                <span class="posted_in detail-container">
                                                    <span class="detail-label">Danh mục</span>
                                                    <span class="detail-content">
                                                        <a href="../../product-category/jackets/index.html"
                                                            rel="categories">{{ $product->category->name }}
                                                        </a>
                                                    </span>
                                                </span>

                                                <span class="material detail-container">
                                                    <span class="detail-label">Chất liệu</span>
                                                    <span class="detail-content">
                                                        <a href="#" rel="material">{{ $product->material }}</a>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6faf664c elementor-widget elementor-widget-spacer"
                                        data-id="6faf664c" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-6cf878e4 elementor-widget kitify elementor-kitify-wooproduct-datatabs"
                            data-id="6cf878e4" data-element_type="widget"
                            data-widget_type="kitify-wooproduct-datatabs.default">
                            <div class="container">
                                <div class="kitify-product-tabs layout-type-accordion">
                                    <div class="nova-woocommerce-tabs">

                                        <ul class="tabs"
                                            data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-accordion"
                                            data-allow-all-closed="true" id="single_product_tab">
                                            <li class="title"><span>Mô tả sản phẩm</span></a></li>
                                            {{-- <li class="title"><span>Đánh giá (1)</span></a></li> --}}
                                        </ul>
                                        <div class="tabs-content">
                                            <div class="tabs-panel is-active" id="panel_description">
                                                <div data-elementor-type="container" data-elementor-id="121"
                                                    class="elementor elementor-121">
                                                    <div class="elementor-element elementor-element-bae4132 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                                                        data-id="bae4132" data-element_type="container">
                                                        <div class="e-con-inner">
                                                            <div class="elementor-element elementor-element-5faa12c elementor-widget elementor-widget-text-editor"
                                                                data-id="5faa12c" data-element_type="widget"
                                                                data-widget_type="text-editor.default">
                                                                <div class="elementor-widget-container">
                                                                    <p>{{ $product->description }}</p>
                                                                    {{-- <p>In WooCommerce, you can create and manage
                                                                        product descriptions through the
                                                                        WordPress dashboard. Each product has
                                                                        its own page where you can input and
                                                                        format the description, add images, set
                                                                        prices, and manage other product-related
                                                                        details. Effective product descriptions
                                                                        are essential for e-commerce success as
                                                                        they help customers make informed
                                                                        decisions and contribute to a positive
                                                                        shopping experience.</p> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <ul class="tabs"
                                            data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-accordion"
                                            data-allow-all-closed="true" id="single_product_tab">
                                            {{-- <li class="title"><span>Mô tả sản phẩm</span></a></li> --}}
                                            <li class="title"><span>Đánh giá</span></a></li>
                                        </ul>
                                        <div class="tabs-content ">
                                            <div id="reviews" class="woocommerce-Reviews">
                                                <div id="comments">
                                                    @if ($ratingCount > 0)
                                                        <ol class="commentlist">
                                                            @foreach ($reviews as $review)
                                                                @php
                                                                    $user = optional(optional($review->order)->user);
                                                                    $name = $user->name ?? 'Khách ẩn danh';
                                                                    $avatar = $user->image
                                                                        ? asset('storage/' . $user->image)
                                                                        : asset('assets/images/users/avatar-1.jpg'); // avatar mặc định
                                                                    $ratingPercent = max(
                                                                        0,
                                                                        min(100, ($review->rating / 5) * 100),
                                                                    );
                                                                @endphp

                                                                <li class="review even thread-even depth-1"
                                                                    id="li-comment-{{ $review->id }}">
                                                                    <div id="comment-{{ $review->id }}" class="comment_container">
                                                                        <img alt="{{ $name }}" src="{{ $avatar }}"
                                                                            class="avatar avatar-60 photo" height="60" width="60" />

                                                                        <div class="comment-text">

                                                                            {{-- Sao đánh giá --}}
                                                                            <div class="star-rating" role="img"
                                                                                aria-label="Rated {{ $review->rating }} out of 5">
                                                                                <span style="width:{{ $ratingPercent }}%">
                                                                                    Rated
                                                                                    <strong
                                                                                        class="rating">{{ $review->rating }}</strong>
                                                                                    out of 5
                                                                                </span>
                                                                            </div>

                                                                            <p class="meta">
                                                                                <strong class="woocommerce-review__author">
                                                                                    {{ $name }}
                                                                                </strong>
                                                                                <span
                                                                                    class="woocommerce-review__dash">&ndash;</span>
                                                                                <time class="woocommerce-review__published-date"
                                                                                    datetime="{{ $review->created_at->toIso8601String() }}">
                                                                                    {{ $review->created_at->format('d/m/Y H:i') }}
                                                                                </time>
                                                                            </p>

                                                                            <div class="description">
                                                                                <p>{{ $review->content }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                        <div id="review_form_wrapper" class="mt-4">
                                                            <div id="review_form">
                                                                <div id="respond" class="comment-respond">
                                                                    <span id="reply-title" class="comment-reply-title"
                                                                        role="heading" aria-level="3">
                                                                        Thêm đánh giá
                                                                    </span>

                                                                    @auth
                                                                        @if ($canReview)
                                                                            {{-- FORM ĐÁNH GIÁ --}}
                                                                            <form action="{{ route('reviews.store', $product->id) }}"
                                                                                method="post" id="commentform" class="comment-form">
                                                                                @csrf

                                                                                <p class="comment-notes">
                                                                                    <span class="required-field-message">
                                                                                        Các trường có dấu <span
                                                                                            class="required">*</span> là bắt
                                                                                        buộc.
                                                                                    </span>
                                                                                </p>

                                                                                {{-- Rating --}}
                                                                                <div class="comment-form-rating mb-3">
                                                                                    <label for="rating" id="comment-form-rating-label">
                                                                                        Đánh giá của bạn&nbsp;<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <select name="rating" id="rating" required
                                                                                        class="form-select">
                                                                                        <option value="">Chọn đánh giá…
                                                                                        </option>
                                                                                        <option value="5">Rất tốt (5★)
                                                                                        </option>
                                                                                        <option value="4">Tốt (4★)
                                                                                        </option>
                                                                                        <option value="3">Bình thường (3★)
                                                                                        </option>
                                                                                        <option value="2">Tạm được (2★)
                                                                                        </option>
                                                                                        <option value="1">Tệ (1★)</option>
                                                                                    </select>
                                                                                </div>

                                                                                {{-- Nội dung --}}
                                                                                <p class="comment-form-comment mb-3">
                                                                                    <label for="comment">
                                                                                        Nội dung đánh giá&nbsp;<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <textarea id="comment" name="content" cols="45"
                                                                                        rows="5" class="form-control"
                                                                                        required>{{ old('content') }}</textarea>
                                                                                </p>

                                                                                {{-- Tên + email (readonly) --}}
                                                                                <p class="comment-form-author mb-3">
                                                                                    <label for="author">Tên</label>
                                                                                    <input id="author" type="text" class="form-control"
                                                                                        value="{{ auth()->user()->name }}" readonly />
                                                                                </p>
                                                                                <p class="comment-form-email mb-3">
                                                                                    <label for="email">Email</label>
                                                                                    <input id="email" type="email" class="form-control"
                                                                                        value="{{ auth()->user()->email }}" readonly />
                                                                                </p>

                                                                                <p class="form-submit mb-0">
                                                                                    <button type="submit" id="submit"
                                                                                        class="btn btn-primary">
                                                                                        Gửi đánh giá
                                                                                    </button>
                                                                                </p>
                                                                            </form>
                                                                        @elseif ($hasReviewed)
                                                                            <p class="mt-2 text-muted">
                                                                                Bạn đã gửi đánh giá cho sản phẩm này trước đó.
                                                                            </p>
                                                                        @else
                                                                            <p class="mt-2 text-muted">
                                                                                Chỉ khách đã mua sản phẩm này mới có thể gửi
                                                                                đánh giá.
                                                                            </p>
                                                                        @endif
                                                                    @else
                                                                        <p class="mt-2">
                                                                            Vui lòng <a href="{{ route('login') }}">đăng
                                                                                nhập</a> để viết đánh giá.
                                                                        </p>
                                                                    @endauth
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Phân trang --}}
                                                        <div class="mt-3">
                                                            {{ $reviews->links() }}
                                                        </div>
                                                    @else
                                                        <p class="woocommerce-noreviews mb-0">
                                                            Chưa có đánh giá nào cho sản phẩm này.
                                                        </p>
                                                    @endif
                                                </div>

                                                {{-- <div class="tabs" id="panel_reviews">
                                                    <div id="reviews" class="woocommerce-Reviews">
                                                        <div id="comments">

                                                            @if ($ratingCount > 0)
                                                            <ol class="commentlist">
                                                                @foreach ($reviews as $review)
                                                                @php
                                                                $user = optional(optional($review->order)->user);
                                                                $name = $user->name ?? 'Khách hàng';


                                                                @endphp

                                                                @endforeach
                                                                @endif
                                                                <li class="review even thread-even depth-1"
                                                                    id="li-comment-8">

                                                                    <div id="comment-8" class="comment_container">

                                                                        <img alt=''
                                                                            src='https://secure.gravatar.com/avatar/87924606b4131a8aceeeae8868531fbb9712aaa07a5d3a756b26ce0f5d6ca674?s=60&amp;d=mm&amp;r=g'
                                                                            srcset='https://secure.gravatar.com/avatar/87924606b4131a8aceeeae8868531fbb9712aaa07a5d3a756b26ce0f5d6ca674?s=120&#038;d=mm&#038;r=g 2x'
                                                                            class='avatar avatar-60 photo' height='60'
                                                                            width='60' decoding='async' />
                                                                        <div class="comment-text">

                                                                            <div class="star-rating" role="img"
                                                                                aria-label="Rated 5 out of 5">
                                                                                <span style="width:100%">Rated
                                                                                    <strong class="rating">5</strong>
                                                                                    out of 5</span>
                                                                            </div>
                                                                            <p class="meta">
                                                                                <strong
                                                                                    class="woocommerce-review__author">test
                                                                                </strong>
                                                                                <span
                                                                                    class="woocommerce-review__dash">&ndash;</span>
                                                                                <time
                                                                                    class="woocommerce-review__published-date"
                                                                                    datetime="2024-01-13T22:01:36+00:00">January
                                                                                    13, 2024</time>
                                                                            </p>

                                                                            <div class="description">
                                                                                <p>test</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li><!-- #comment-## -->
                                                            </ol>

                                                        </div>

                                                        <div id="review_form_wrapper">
                                                            <div id="review_form">
                                                                <div id="respond" class="comment-respond">
                                                                    <span id="reply-title" class="comment-reply-title"
                                                                        role="heading" aria-level="3">Add a
                                                                        review <small><a rel="nofollow"
                                                                                id="cancel-comment-reply-link"
                                                                                href="index.html#respond"
                                                                                style="display:none;">Cancel
                                                                                reply</a></small></span>
                                                                    <form
                                                                        action="https://mixtas.novaworks.net/wp-comments-post.php"
                                                                        method="post" id="commentform" class="comment-form">
                                                                        <p class="comment-notes"><span id="email-notes">Your
                                                                                email
                                                                                address
                                                                                will not be published.</span> <span
                                                                                class="required-field-message">Required
                                                                                fields are marked <span
                                                                                    class="required">*</span></span>
                                                                        </p>
                                                                        <div class="comment-form-rating"><label for="rating"
                                                                                id="comment-form-rating-label">Your
                                                                                rating&nbsp;<span
                                                                                    class="required">*</span></label><select
                                                                                name="rating" id="rating" required>
                                                                                <option value="">
                                                                                    Rate&hellip;
                                                                                </option>
                                                                                <option value="5">Perfect
                                                                                </option>
                                                                                <option value="4">Good
                                                                                </option>
                                                                                <option value="3">Average
                                                                                </option>
                                                                                <option value="2">Not that
                                                                                    bad
                                                                                </option>
                                                                                <option value="1">Very poor
                                                                                </option>
                                                                            </select></div>
                                                                        <p class="comment-form-comment"><label
                                                                                for="comment">Your
                                                                                review&nbsp;<span
                                                                                    class="required">*</span></label>
                                                                            <textarea id="comment" name="comment" cols="45"
                                                                                rows="8" required></textarea>
                                                                        </p>
                                                                        <p class="comment-form-author"><label
                                                                                for="author">Name&nbsp;<span
                                                                                    class="required">*</span></label><input
                                                                                id="author" name="author" type="text"
                                                                                autocomplete="name" value="" size="30"
                                                                                required />
                                                                        </p>
                                                                        <p class="comment-form-email"><label
                                                                                for="email">Email&nbsp;<span
                                                                                    class="required">*</span></label><input
                                                                                id="email" name="email" type="email"
                                                                                autocomplete="email" value="" size="30"
                                                                                required />
                                                                        </p>
                                                                        <p class="comment-form-cookies-consent">
                                                                            <input id="wp-comment-cookies-consent"
                                                                                name="wp-comment-cookies-consent"
                                                                                type="checkbox" value="yes" />
                                                                            <label for="wp-comment-cookies-consent">Save
                                                                                my name, email, and website in this
                                                                                browser for the next time I
                                                                                comment.</label>
                                                                        </p>
                                                                        <p class="form-submit"><input name="submit"
                                                                                type="submit" id="submit" class="submit"
                                                                                value="Submit" />
                                                                            <input type='hidden' name='comment_post_ID'
                                                                                value='1558' id='comment_post_ID' />
                                                                            <input type='hidden' name='comment_parent'
                                                                                id='comment_parent' value='0' />
                                                                        </p>
                                                                    </form>
                                                                </div><!-- #respond -->
                                                            </div>
                                                        </div>

                                                        <div class="clear"></div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="elementor-element elementor-element-3b561aea e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                                data-id="3b561aea" data-element_type="container">
                                <div class="elementor-element elementor-element-56e87309 elementor-widget elementor-widget-heading"
                                    data-id="56e87309" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">Sản Phẩm Liên
                                            Quan</h2>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-eef8dba custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="eef8dba" data-element_type="widget"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div class="woocommerce  kitify_wc_widget_eef8dba_0">
                                            <div class="kitify-products kitify-carousel"
                                                data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:false,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-eef8dba_0&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-eef8dba_0&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_eef8dba_0&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_eef8dba_0&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:4,&quot;mobile&quot;:1,&quot;mobile_extra&quot;:2,&quot;tablet&quot;:3,&quot;tablet_extra&quot;:3,&quot;laptop&quot;:4}}"
                                                dir="ltr">
                                                <div class="kitify-carousel-inner">
                                                    <div class="kitify-products__list_wrapper swiper-container">
                                                        <ul
                                                            class="products ul_products kitify-products__list products-grid products-grid-1 swiper-wrapper columns-4">
                                                            @foreach ($relatedProducts as $item)
                                                                @php
                                                                    // Lấy biến thể rẻ nhất để tính giá hiển thị
                                                                    $sortedVariants = $item->variants->sortBy(function ($v, ) {
                                                                        // Ưu tiên giá sale nếu có sale < price, nếu không dùng price
                                                                        $effectivePrice =
                                                                            $v->sale !== null && $v->sale < $v->price
                                                                            ? $v->sale
                                                                            : $v->price;
                                                                        return $effectivePrice;
                                                                    });

                                                                    $bestVariant = $sortedVariants->first(); // có thể null nếu chưa có biến thể

                                                                    // Chuẩn bị giá
                                                                    $hasSale =
                                                                        $bestVariant &&
                                                                        $bestVariant->sale !== null &&
                                                                        $bestVariant->sale < $bestVariant->price;

                                                                    $originalPrice = $bestVariant->price ?? null;
                                                                    $salePrice = $hasSale ? $bestVariant->sale : null;
                                                                    $finalPrice = $hasSale
                                                                        ? $bestVariant->sale
                                                                        : $bestVariant->price ?? null;

                                                                    // Tính % giảm
                                                                    $discountPercent = null;
                                                                    if ($hasSale && $originalPrice > 0) {
                                                                        $discountPercent = round(
                                                                            (($originalPrice - $salePrice) /
                                                                                $originalPrice) *
                                                                            100,
                                                                        );
                                                                    }

                                                                    // Ảnh chính
                                                                    $mainImage = $item->firstPhoto?->image
                                                                        ? asset('storage/' . $item->firstPhoto->image)
                                                                        : 'https://via.placeholder.com/700x700?text=No+Image';

                                                                    // Ảnh hover (second image). Nếu có album khác thì lấy ảnh kế tiếp
                                                                    $secondPhoto = $item->photoAlbums
                                                                        ->skip(1) // bỏ ảnh đầu tiên
                                                                        ->first();

                                                                    $hoverImage = $secondPhoto?->image
                                                                        ? asset('storage/' . $secondPhoto->image)
                                                                        : $mainImage; // fallback chính nó
                                                                @endphp
                                                                <li
                                                                    class="product_item product-grid-item product type-product post-960 status-publish instock product_cat-hoodies product_cat-tshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m41 product_tag-products product_tag-women has-post-thumbnail sale shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                                    <div class="product-item">
                                                                        <div class="product-item__badges">

                                                                            @if ($discountPercent)
                                                                                <span class="onsale">{{ $discountPercent }}%</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="product-item__thumbnail">
                                                                            <div class="product-item__thumbnail_overlay">
                                                                            </div>
                                                                            <a class="product-item-link"
                                                                                href="{{ route('products.show', ['id' => $item->id]) }}"></a>
                                                                            <div class="product-item__description--top-actions">

                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}?add_to_wishlist={{ $item->id }}"
                                                                                    data-product-id="{{ $item->id }}"
                                                                                    data-product-type="variable"
                                                                                    data-browse-wishlist-text="Browse wishlist"
                                                                                    class="nova_product_wishlist_btn add_to_wishlist"
                                                                                    rel="nofollow">
                                                                                    <i class="inova ic-favorite"></i>
                                                                                    <span class="hidden add-text">Add to
                                                                                        wishlist</span>
                                                                                    <span class="hidden added-text">Browse
                                                                                        wishlist</span>
                                                                                </a>

                                                                                <a href="#" class="nova_product_quick_view_btn"
                                                                                    data-product-id="{{ $item->id }}"
                                                                                    rel="nofollow"><i
                                                                                        class="inova ic-zoom"></i></a>
                                                                                <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                    data-quantity="1"
                                                                                    class="button product_type_variable add_to_cart_button"
                                                                                    data-product_id="{{ $item->id }}"
                                                                                    data-product_sku=""
                                                                                    aria-label="Select options for {{ $item->name }}"
                                                                                    rel="nofollow"><svg
                                                                                        class="mixtas-addtocart">
                                                                                        <use xlink:href="#mixtas-addtocart"
                                                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                        </use>
                                                                                    </svg><span class="text">Select
                                                                                        options</span></a> <span
                                                                                    id="woocommerce_loop_add_to_cart_link_describedby_{{ $item->id }}"
                                                                                    class="screen-reader-text">
                                                                                    This product has multiple variants. The
                                                                                    options
                                                                                    may be chosen on the product page
                                                                                </span>
                                                                            </div>


                                                                            <div
                                                                                class="product-item__thumbnail-placeholder second_image_enabled">
                                                                                <a
                                                                                    href="{{ route('products.show', ['id' => $item->id]) }}">
                                                                                    <img loading="lazy" width="700" height="700"
                                                                                        src="{{ $mainImage }}"
                                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                        alt="{{ $item->name }}" decoding="async"
                                                                                        srcset="{{ $mainImage }} 700w,
                                                                                                 {{ $mainImage }} 300w, {{ $mainImage }} 150w, {{ $mainImage }} 768w, {{ $mainImage }} 250w, {{ $mainImage }} 50w, {{ $mainImage }} 100w, {{ $mainImage }} 1000w"
                                                                                        sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                        class="product_second_image"
                                                                                        style="background-image: url('{{ $hoverImage }}')"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product-item__description">

                                                                            <div class="product-item__description--info">
                                                                                <div class="info-left">
                                                                                    @if ($item->category)
                                                                                        <div class="product-item__category">
                                                                                            <a class="content-product-cat"
                                                                                                href="{{ route('products.category', ['slug' => $item->category->slug]) }}"
                                                                                                rel="tag">{{ $item->category->name }}</a>
                                                                                        </div>
                                                                                    @endif
                                                                                    <a href="{{ route('products.show', ['id' => $item->id]) }}"
                                                                                        class="title">
                                                                                        <h3
                                                                                            class="woocommerce-loop-product__title">
                                                                                            {{ $item->name }}
                                                                                        </h3>
                                                                                    </a>
                                                                                </div>
                                                                                {{-- Giá --}}
                                                                                <div class="info-right">
                                                                                    @if ($bestVariant)
                                                                                        @if ($hasSale)
                                                                                            {{-- Có khuyến mãi --}}
                                                                                            <span class="price">
                                                                                                <del aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{ number_format($originalPrice, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </del>
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount m-2">
                                                                                                        <bdi>
                                                                                                            {{ number_format($salePrice, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </ins>
                                                                                            </span>
                                                                                        @else
                                                                                            {{-- Không khuyến mãi --}}
                                                                                            <span class="price">
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{ number_format($finalPrice ?? 0, 0, ',', '.') }}₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </ins>
                                                                                            </span>
                                                                                        @endif
                                                                                    @else
                                                                                        {{-- Không có biến thể nào (trường hợp hiếm
                                                                                        / dữ liệu chưa nhập variant) --}}
                                                                                        <span class="price">
                                                                                            <ins aria-hidden="true">
                                                                                                <span
                                                                                                    class="woocommerce-Price-amount amount">
                                                                                                    <bdi>
                                                                                                        {{-- fallback 0₫ vì bảng
                                                                                                        products hiện không có cột
                                                                                                        price --}}
                                                                                                        0₫
                                                                                                    </bdi>
                                                                                                </span>
                                                                                            </ins>
                                                                                        </span>
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
                                                <div class="kitify-carousel__prev-arrow-eef8dba_0 kitify-arrow prev-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-left"></i>
                                                </div>
                                                <div class="kitify-carousel__next-arrow-eef8dba_0 kitify-arrow next-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .site-content-wrapper -->
                        @include('layouts.footer')
                        <div class="nova-overlay-global"></div>
                    </div>
=======
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
        src="{{ asset('storage/' . $product->photoAlbums->first()->image) }}"
        data-default="{{ asset('storage/' . $product->photoAlbums->first()->image) }}"
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
            <h4 class="mt-4 mb-2">Chọn thuộc tính</h4>

{{-- Form thêm giỏ --}}
<form method="POST" action="{{ route('cart.add') }}" id="addToCartForm" class="border p-3 rounded">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    {{-- sẽ set động theo lựa chọn --}}
    <input type="hidden" name="product_variant_id" id="variantId" value="">

    {{-- Màu --}}
    <div class="mb-3">
        <label for="selectColor" class="form-label fw-semibold">Màu sắc</label>

        @php
            // Lấy các color_id còn hàng từ $variants của chính product này
            $inStockColorIds = $variants
                ->filter(fn($v) => ($v->quantity ?? 0) > 0 && !empty($v->color_id))
                ->pluck('color_id')
                ->unique()
                ->values()
                ->all();
        @endphp

        <select id="selectColor" class="form-select">
            <option value="" selected>— Chọn màu —</option>
            @foreach($colors->whereIn('id', $inStockColorIds) as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        {{-- Trường hợp không còn màu nào còn hàng --}}
        @if(empty($inStockColorIds))
            <small class="text-danger d-block mt-1">Sản phẩm tạm hết hàng.</small>
        @endif
    </div>

    {{-- Size (tuỳ theo màu đã chọn sẽ lọc) --}}
    <div class="mb-3">
        <label for="selectSize" class="form-label fw-semibold">Kích cỡ</label>
        <select id="selectSize" class="form-select" disabled>
            <option value="" selected>— Chọn size —</option>
        </select>
    </div>

    {{-- Giá hiển thị theo biến thể đã chọn --}}
    <div class="mb-3">
    <label class="form-label fw-semibold">Giá Tiền</label>
    <div id="priceBox">
    @php
        // Lấy "giá hiệu lực" cho mỗi biến thể: ưu tiên sale nếu có, ngược lại price
        // Nếu muốn chỉ tính biến thể còn hàng, bỏ comment dòng filter(...) bên dưới.
        $effPrices = collect($variants ?? [])
            // ->filter(fn($v) => ($v->quantity ?? 0) > 0) // chỉ tính biến thể còn tồn
            ->map(fn($v) => (float)($v->sale ?? $v->price));

        $minPrice = $effPrices->min();
        $maxPrice = $effPrices->max();
    @endphp

    @if(!is_null($minPrice))
        <div class="price">
        <span class="price--normal">
            {{ number_format($minPrice, 0, ',', '.') }}₫
            @if(!is_null($maxPrice) && $maxPrice > $minPrice)
            – {{ number_format($maxPrice, 0, ',', '.') }}₫
            @endif
        </span>
        </div>
    @else
        <div class="price"><span class="price--normal">Đang cập nhật</span></div>
    @endif
    </div>
    </div>

    <!-- Tồn kho -->
    <div class="mb-3">
    <label class="form-label fw-semibold">Tồn Kho</label>
    <span id="stockBox" class="text-muted">Vui lòng chọn màu & size</span>
    </div>

    {{-- Số lượng --}}

        <div class="mb-3">
        <label for="quantity" class="form-label fw-semibold m-0">Số lượng</label>
        <div class="qty-pill" id="qtyBox">
            <button type="button" class="qty-btn" id="qtyMinus" aria-label="Giảm">−</button>
            <input type="number" id="quantity" name="quantity" class="qty-input" value="1" min="1" inputmode="numeric" pattern="\d*">
            <button type="button" class="qty-btn" id="qtyPlus" aria-label="Tăng">+</button>
        </div>
        </div>

        {{-- Nút thêm giỏ hàng đưa xuống dưới ô số lượng --}}
        <button type="submit"
                class="btn btn-dark d-inline-block"
                style="margin-top:8px; display:block"
                id="btnAddToCart" >
        Thêm Vào Giỏ Hàng
        </button>

        <button type="submit"
                class="btn btn-primary"
                id="btnBuyNow"
                style="margin-top:8px"
                formaction="{{ route('checkout.buy_now') }}">
        Mua Ngay
        </button>
</form>

{{-- Dữ liệu variants cho JS --}}
<script>
    // Popup dạng modal trung tâm
function showWarnModal(message, title = 'Thông báo') {
  Swal.fire({
    icon: 'warning',
    title: title,
    text: message,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Đã hiểu',
  });
}

// Popup dạng toast góc phải, tự ẩn
function showWarnToast(message) {
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'warning',
    title: message,
    showConfirmButton: false,
    timer: 2200,
    timerProgressBar: true,
  });
}
    // map "colorId-sizeId" -> data
    const VARIANTS = @json($variantMap);

    // xây index: colorId -> [{size_id, size_name}]
    const COLOR_SIZES = {};
    @foreach($variants as $v)
        @if($v->color_id && $v->size_id && ($v->quantity ?? 0) > 0)
            COLOR_SIZES[{{ $v->color_id }}] = COLOR_SIZES[{{ $v->color_id }}] || [];
            COLOR_SIZES[{{ $v->color_id }}].push({
                id: {{ $v->size_id }},
                name: "{{ $v->size?->name }}"
            });
        @endif
    @endforeach

    const fmt = (n) => new Intl.NumberFormat('vi-VN').format(n) + '₫';

    const selectColor = document.getElementById('selectColor');
    const selectSize  = document.getElementById('selectSize');
    const priceBox    = document.getElementById('priceBox');
    const variantId   = document.getElementById('variantId');
    const btnAdd      = document.getElementById('btnAddToCart');
    const btnBuy      = document.getElementById('btnBuyNow');
    const stockBox    = document.getElementById('stockBox');


    // === ẢNH: luôn lấy được ảnh gốc & chuẩn bị base URL ===
    const mainImg          = document.querySelector('.main-image img');
    const DEFAULT_SRC      = mainImg ? (mainImg.getAttribute('data-default') || mainImg.src) : null;
    const urlProductImages = `{{ Storage::disk('public')->url('product_images') }}`;
    const urlProducts      = `{{ Storage::disk('public')->url('products') }}`;
    const storageBase      = `{{ asset('storage') }}`; // => /storage

    // helper: thử tải 1 url, resolve(true/false)
    function canLoad(url) {
        return new Promise(resolve => {
            const img = new Image();
            img.onload = () => resolve(true);
            img.onerror = () => resolve(false);
            img.src = url;
        });
    }

    // helper: từ v.image -> danh sách URL thử lần lượt
    function buildCandidateUrls(vImage) {
        const list = [];
        if (!vImage) return list;

        const trimmed = (vImage + '').trim();

        // URL tuyệt đối
        if (/^https?:\/\//i.test(trimmed)) {
            list.push(trimmed);
            return list;
        }

        if (trimmed.startsWith('/storage') || trimmed.startsWith('storage/')) {
        list.push(trimmed.startsWith('/') ? trimmed : `/${trimmed}`);
        return list;
}

        // đã có thư mục (ví dụ "products/xxx.jpg" hoặc "product_images/xxx.jpg")
        if (trimmed.includes('/')) {
            // ghép với /storage (Laravel public disk)
            list.push(`${storageBase}/${trimmed}`);
        } else {
            // chỉ là tên file -> thử 2 thư mục quen dùng
           // chỉ là tên file -> thử 2 thư mục (ưu tiên 'products')
list.push(`${urlProducts}/${trimmed}`);
list.push(`${urlProductImages}/${trimmed}`);

        }

        return list;
    }

    // khi chọn màu -> nạp danh sách size hợp lệ và trả ảnh về mặc định
    selectColor.addEventListener('change', () => {
        const colorId = selectColor.value;
        selectSize.innerHTML = '<option value="" selected>— Chọn size —</option>';
        variantId.value = '';
        btnAdd.disabled = true;
        if (btnBuy) btnBuy.disabled = true;
        priceBox.innerHTML = '<span class="text-muted">Chọn size để xem giá</span>';

        if (stockBox) {
        stockBox.textContent = 'Vui lòng chọn màu & size';
        stockBox.classList.remove('text-success','text-danger');
        }
        // Bỏ giới hạn số lượng khi chưa chọn đủ biến thể (MAX_QTY sẽ set lại khi chọn size)
        if (typeof MAX_QTY !== 'undefined') {
        MAX_QTY = null;
        qtyInput.value = clampQty(qtyInput.value);
        syncQtyButtons();
        }
        // if (mainImg && DEFAULT_SRC) mainImg.src = DEFAULT_SRC;

        if (!colorId) {
            selectSize.disabled = true;
            return;
        }

        const sizes = (COLOR_SIZES[colorId] || []).reduce((acc, s) => {
            if (!acc.some(x => x.id === s.id)) acc.push(s); // tránh trùng size
            return acc;
        }, []);

        sizes.forEach(s => {
            const op = document.createElement('option');
            op.value = s.id;
            op.textContent = s.name;
            selectSize.appendChild(op);
        });

        selectSize.disabled = sizes.length === 0;
        if (sizes.length === 0) {
            priceBox.innerHTML = '<span class="text-danger">Màu này tạm hết size</span>';
        }
    });

    const BASE_STORAGE_URL = "{{ asset('storage') }}";
    // khi chọn size -> tìm biến thể, hiện giá, ĐỔI ẢNH CÓ KIỂM TRA TẢI
    selectSize.addEventListener('change', async () => {
        const colorId = selectColor.value || '0';
        const sizeId  = selectSize.value  || '0';
        const key = `${colorId}-${sizeId}`;
        const v = VARIANTS[key];

        if (!v) {
            variantId.value = '';
            btnAdd.disabled = true;
            if (btnBuy) btnBuy.disabled = true;
            priceBox.innerHTML = '<span class="text-danger">Biến thể không tồn tại</span>';
            if (mainImg && DEFAULT_SRC) mainImg.src = DEFAULT_SRC;
            return;
        }

        variantId.value = v.id;
        btnAdd.disabled = false;
        if (btnBuy) btnBuy.disabled = false;

        // hiện giá (ưu tiên sale)
        if (v.sale && Number(v.sale) > 0) {
        priceBox.innerHTML =
            `<div class="price">
                <span class="price--sale">${fmt(v.sale)}</span>
                <span class="price--original">${fmt(v.price)}</span>
            </div>`;
        } else {
        priceBox.innerHTML =
            `<div class="price">
                <span class="price--normal">${fmt(v.price)}</span>
            </div>`;
        }

        // --- TỒN KHO & GIỚI HẠN SỐ LƯỢNG ---
        if (typeof v.stock !== 'undefined' && v.stock !== null) {
        const s = parseInt(v.stock, 10) || 0;

        if (stockBox) {
            if (s > 0) {
            stockBox.textContent = `${s} sản phẩm`;
            stockBox.classList.remove('text-danger');
            stockBox.classList.add('text-success');
            } else {
            stockBox.textContent = 'Hết hàng';
            stockBox.classList.remove('text-success');
            stockBox.classList.add('text-danger');
            }
        }

        // Khoá/mở nút Thêm vào giỏ
        btnAdd.disabled = s <= 0;
        if (btnBuy) btnBuy.disabled = s <= 0;

        // Giới hạn số lượng theo tồn kho
        MAX_QTY = s > 0 ? s : null;
        qtyInput.value = clampQty(qtyInput.value);
        syncQtyButtons();
        } else {
        if (stockBox) {
            stockBox.textContent = 'Vui lòng chọn màu & size';
            stockBox.classList.remove('text-success','text-danger');
        }
        MAX_QTY = null;
        btnAdd.disabled = false;
        if (btnBuy) btnBuy.disabled = false; // hoặc true nếu muốn bắt buộc stock > 0 mới cho thêm
        qtyInput.value = clampQty(qtyInput.value);
        syncQtyButtons();
        }


        // === ĐỔI ẢNH: chỉ set src khi chắc chắn có URL load được ===
        if (mainImg) {
            const candidates = buildCandidateUrls(v.image);

            let loadedUrl = null;
            for (const url of candidates) {
                // eslint-disable-next-line no-await-in-loop
                if (await canLoad(url)) { loadedUrl = url; break; }
            }

            if (loadedUrl) {
                // Bổ sung tiền tố /storage/products nếu là tên file tương đối
                if (!loadedUrl.startsWith('http') && !loadedUrl.startsWith('/storage')) {
                    loadedUrl = `${BASE_STORAGE_URL}/${loadedUrl.replace(/^\/?/, '')}`;
                }
                mainImg.src = loadedUrl;

            } else if (v.image) {
                // Có tên file nhưng không load được theo candidates -> tự build URL tuyệt đối
                mainImg.src = v.image.startsWith('http')
                ? v.image
                : (v.image.startsWith('/storage') || v.image.startsWith('storage/'))
                ? (v.image.startsWith('/') ? v.image : `/${v.image}`)
                : `${BASE_STORAGE_URL}/${(v.image+'').replace(/^\/?/, '')}`;


            } else if (mainImg.src && mainImg.src.trim() !== '' && !mainImg.src.includes('undefined') && !mainImg.src.includes('null')) {
                // ✅ GIỮ NGUYÊN ẢNH HIỆN TẠI nếu variant không có ảnh riêng
                mainImg.src = mainImg.src;

            } else if (DEFAULT_SRC) {
                // fallback cuối cùng
                mainImg.src = DEFAULT_SRC;
            }
        }



    });

    // chặn submit nếu chưa có variant
    document.getElementById('addToCartForm').addEventListener('submit', (e) => {
        if (!variantId.value) {
            e.preventDefault();
            showWarnModal('Vui lòng chọn màu và size trước khi thêm vào giỏ hàng.');
        }
    });

    // --- SỐ LƯỢNG: – / + ---
    const qtyInput = document.getElementById('quantity');
    const btnMinus = document.getElementById('qtyMinus');
    const btnPlus  = document.getElementById('qtyPlus');

    const MIN_QTY = parseInt(qtyInput?.min || '1', 10) || 1;
    let MAX_QTY = null; // sẽ set theo tồn kho nếu bạn có (v.stock)

    // đồng bộ trạng thái nút
    function syncQtyButtons() {
    const val = parseInt(qtyInput.value || '1', 10);
    btnMinus.disabled = val <= MIN_QTY;
    btnPlus.disabled  = (MAX_QTY && val >= MAX_QTY) ? true : false;
    }
    function clampQty(v) {
    let n = parseInt(v || '1', 10);
    if (isNaN(n) || n < MIN_QTY) n = MIN_QTY;
    if (MAX_QTY && n > MAX_QTY) n = MAX_QTY;
    return n;
    }

    btnMinus.addEventListener('click', () => {
    let val = parseInt(qtyInput.value || '1', 10);
    val = Math.max(MIN_QTY, val - 1);
    qtyInput.value = val;
    syncQtyButtons();
    });

    btnPlus.addEventListener('click', () => {
        let val = parseInt(qtyInput.value || '1', 10);
        val += 1;

        if (MAX_QTY && val > MAX_QTY) {
            val = MAX_QTY;
            // ⚠️ Hiển thị cảnh báo
            Swal.fire({
            icon: 'warning',
            title: 'Vượt quá số lượng tồn kho!',
            text: `Sản phẩm chỉ còn ${MAX_QTY} sản phẩm trong kho.`,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Đã hiểu',
    });
        }

        qtyInput.value = val;
        syncQtyButtons();
    });

    // Khi người dùng gõ tay
    qtyInput.addEventListener('input', () => {
        let val = parseInt(qtyInput.value || '1', 10);

        if (isNaN(val) || val < MIN_QTY) val = MIN_QTY;
        if (MAX_QTY && val > MAX_QTY) {
            val = MAX_QTY;
            showWarnToast(`Chỉ còn ${MAX_QTY} sản phẩm trong kho`);
        }

        qtyInput.value = val;
        syncQtyButtons();
    });

    syncQtyButtons();

</script>


        @endif

        {{-- <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary ms-2">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </form> --}}
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
        <span class="text-muted ms-2">— {{ $r->user->name ?? 'Khách hàng ẩn danh' }}</span>
        <p class="mb-0">{{ $r->content }}</p>
    </div>
@endforeach

            @else
                <p>Chưa có đánh giá nào cho sản phẩm này.</p>
            @endif
        </div>
    </div>

    {{-- Sản phẩm cùng danh mục --}}
    @if(isset($relatedProducts) && $relatedProducts->count())
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Sản phẩm cùng danh mục</h3>
            </div>

            @foreach($relatedProducts as $item)
                <div class="col-6 col-md-3 mb-4">
                    <a href="{{ route('products.show', $item->id) }}"
                       class="text-decoration-none text-dark">
                        <div class="card h-100 border-0 shadow-sm">
                            {{-- Ảnh sản phẩm --}}
                            @php
                                $thumb = optional($item->photoAlbums->first())->image;
                            @endphp
                            <div class="ratio ratio-4x3">
                                <img
                                    src="{{ $thumb
                                            ? asset('storage/' . $thumb)
                                            : 'https://via.placeholder.com/400x400?text=No+Image' }}"
                                    alt="{{ $item->name }}"
                                    class="card-img-top"
                                    style="object-fit: cover; border-radius: 8px 8px 0 0;">
                            </div>

                            <div class="card-body p-2">
                                {{-- Tên sản phẩm --}}
                                <div class="fw-semibold text-truncate" title="{{ $item->name }}">
                                    {{ $item->name }}
                                </div>

                                {{-- Hiển thị khoảng giá từ variants --}}
                                @php
                                    $prices = $item->variants->map(function ($v) {
                                        return (float)($v->sale ?? $v->price);
                                    })->filter(fn($p) => $p > 0);

                                    $min = $prices->min();
                                    $max = $prices->max();
                                @endphp

                                @if($min)
                                    <div class="text-danger fw-bold small mt-1">
                                        {{ number_format($min, 0, ',', '.') }}₫
                                        @if($max && $max > $min)
                                            - {{ number_format($max, 0, ',', '.') }}₫
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div> {{-- đóng .container --}}
@include('layouts.footer')

                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->

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

       <style>
            /* Thu nhỏ pill */
            .qty-pill{
            display:inline-flex; align-items:center; gap:8px;
            border:1px solid #e5e5e5; border-radius:999px; padding:4px 8px;
            background:#fff;
            }

            /* Nút – / + luôn hiện rõ */
            .qty-btn{
            background:transparent !important; border:none !important;
            width:24px; height:24px; line-height:24px;
            font-size:16px; font-weight:600;
            color:#222 !important; cursor:pointer; user-select:none;
            display:flex; align-items:center; justify-content:center;
            }
            .qty-btn:disabled{opacity:.35; cursor:not-allowed;}

            /* Ô số lượng nhỏ gọn */
            .qty-input{
            width:34px; text-align:center;
            border:none; outline:none; box-shadow:none;
            background:transparent; color:#222;
            font-size:14px; padding:0;
            }

            /* Ẩn spinner */
            .qty-input::-webkit-outer-spin-button,
            .qty-input::-webkit-inner-spin-button{ -webkit-appearance:none; margin:0; }
            .qty-input[type=number]{ -moz-appearance:textfield; }

            /* Focus đẹp một chút */
            .qty-pill:focus-within{ box-shadow:0 0 0 3px rgba(0,0,0,.05); }

            #priceBox .price{ display:flex; gap:8px; align-items:baseline; flex-wrap:wrap; }
            #priceBox .price--sale{ font-size:20px; font-weight:700; color:#d0021b; }   /* sale to & đỏ */
            #priceBox .price--original{
            font-size:14px; color:#777; text-decoration: line-through;
            }
            #priceBox .price--normal{ font-size:18px; font-weight:600; }
            </style>

            <script>
                (function () {
                // —— Cấu hình tối thiểu ——
                const BASE_STORAGE_URL = "{{ asset('storage') }}"; // /storage
                const imgEl      = document.getElementById('productMainImg');
                const sizeSel    = document.getElementById('selectSize');
                const colorSel   = document.getElementById('selectColor'); // nếu không có thì vẫn OK
                if (!imgEl || !sizeSel) return; // không có element -> thoát, không phá gì khác

                const DEFAULT_SRC = imgEl.dataset.default || imgEl.src || '';

                // Chuẩn hoá URL ảnh để KHÔNG lặp /storage/ và hỗ trợ http(s)
                function normalizeUrl(u) {
                    if (!u) return '';
                    let x = String(u).trim();

                    // Nếu là URL tuyệt đối
                    if (/^https?:\/\//i.test(x)) return x;

                    // Nếu đã là /storage/... hoặc storage/...
                    if (x.startsWith('/storage/')) return x;
                    if (x.startsWith('storage/'))  return '/' + x;

                    // Còn lại: ghép với /storage
                    x = x.replace(/^\/+/, ''); // bỏ / đầu nếu có
                    return BASE_STORAGE_URL.replace(/\/+$/, '') + '/' + x;
                }

                // Tải thử trước khi set src; lỗi thì rơi về default
                function loadWithFallback(url) {
                    const finalUrl = normalizeUrl(url);
                    if (!finalUrl) {
                    imgEl.src = DEFAULT_SRC;
                    return;
                    }
                    const probe = new Image();
                    probe.onload  = () => { imgEl.src = finalUrl; };
                    probe.onerror = () => { imgEl.src = DEFAULT_SRC; };
                    probe.src = finalUrl;
                }

                // Lấy ảnh cho biến thể hiện tại từ nhiều nguồn khả dĩ
                function getVariantImage() {
                    // 1) Ưu tiên data-image trên option size
                    const opt = sizeSel.options[sizeSel.selectedIndex];
                    if (opt && opt.dataset && opt.dataset.image) {
                    return opt.dataset.image;
                    }

                    // 2) Nếu có map toàn cục VARIANTS hoặc variantMap
                    //    Kỳ vọng key dạng "colorId-sizeId" hoặc chỉ "sizeId" tuỳ bạn đang lưu
                    const sizeId  = sizeSel.value;
                    const colorId = colorSel ? colorSel.value : null;

                    const maps = [window.VARIANTS, window.variantMap, window.variant_map];
                    for (const M of maps) {
                    if (!M) continue;

                    if (colorId && M[`${colorId}-${sizeId}`]?.image) {
                        return M[`${colorId}-${sizeId}`].image;
                    }
                    if (M[sizeId]?.image) {
                        return M[sizeId].image;
                    }
                    }

                    // 3) Không tìm thấy -> để trống (sẽ fallback)
                    return '';
                }

                function onSizeOrColorChange() {
                    const img = getVariantImage();
                    if (img) {
                    loadWithFallback(img);
                    } else {
                    // Không có ảnh riêng cho biến thể -> dùng ảnh mặc định
                    imgEl.src = DEFAULT_SRC;
                    }
                }

                sizeSel.addEventListener('change', onSizeOrColorChange);
                if (colorSel) colorSel.addEventListener('change', onSizeOrColorChange);

                // Khởi tạo (khi trang load xong)
                document.addEventListener('DOMContentLoaded', onSizeOrColorChange);
                })();
                </script>

                <script>
                    (function () {
                    const mainImg = document.getElementById('productMainImg');
                    if (!mainImg) return;

                    const defaultSrc = mainImg.getAttribute('data-default');

                    // Hàm luôn ép ảnh về ảnh chính
                    function keepMainImage() {
                        if (mainImg.src !== defaultSrc) {
                        mainImg.src = defaultSrc;
                        }
                    }

                    // Nếu có nơi khác set ảnh sai → tự hồi về ảnh chính
                    mainImg.addEventListener('error', keepMainImage);

                    // Gắn vào các select màu/size (đặt nhiều selector để “bắt” được dù bạn đặt id/name khác)
                    const selectors = [
                        '#colorSelect', '#sizeSelect',
                        'select[name="color_id"]', 'select[name="size_id"]',
                        'select[name="color"]', 'select[name="size"]'
                    ];

                    document.querySelectorAll(selectors.join(',')).forEach(el => {
                        el.addEventListener('change', keepMainImage);
                    });

                    // Nếu code cũ có hàm đổi ảnh theo biến thể, ta vô hiệu hoá nhẹ nhàng:
                    window.updateVariantImage = function () {
                        // No-op: luôn giữ ảnh chính
                        keepMainImage();
                    };

                    // Một số dự án đổi ảnh trong updateBySelection/updatePrice..., ta “bọc” lại:
                    const origUpdateBySelection = window.updateBySelection;
                    if (typeof origUpdateBySelection === 'function') {
                        window.updateBySelection = function () {
                        const ret = origUpdateBySelection.apply(this, arguments);
                        keepMainImage();
                        return ret;
                        };
                    }
                    })();
                    </script>

>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8
                    <script>
                        const variantMap = @json($variantMap);

                        // Giá mặc định ban đầu (Blade đổ xuống)
                        const defaultPrice = {{ (float) $displayPrice }};
                        const defaultOriginal = {{ (float) $originalPrice }};
                        const defaultHasDiscount = {{ $discountPercent ? 'true' : 'false' }};
                        const defaultDiscount = {{ (int) ($discountPercent ?? 0) }};

                        let selectedColorId = null;
                        let selectedSizeId = null;

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

                        function formatCurrency(value) {
                            if (!value) return '0₫';
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND',
                                maximumFractionDigits: 0
                            }).format(value);
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
                                return;
                            }

                            updateUIByVariant(variant);
                        }

                        // ===== LỌC CHÉO: SIZE THEO MÀU =====
                        function updateAvailableSizes() {
                            sizeItems.forEach(item => {
                                const sizeId = item.dataset.sizeId;

                                if (!selectedColorId) {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                    return;
                                }

                                const key = `${selectedColorId}_${sizeId}`;
                                const variant = variantMap[key];

                                if (!variant || variant.stock <= 0) {
                                    item.classList.add('is-disabled');
                                    item.setAttribute('aria-disabled', 'true');

                                    if (item.classList.contains('selected')) {
                                        item.classList.remove('selected');
                                        item.setAttribute('aria-checked', 'false');
                                        selectedSizeId = null;
                                        if (sizeSelect) sizeSelect.value = '';
                                    }
                                } else {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                }
                            });
                        }

                        // ===== LỌC CHÉO: MÀU THEO SIZE =====
                        function updateAvailableColors() {
                            colorItems.forEach(item => {
                                const colorId = item.dataset.colorId;

                                if (!selectedSizeId) {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                    return;
                                }

                                const key = `${colorId}_${selectedSizeId}`;
                                const variant = variantMap[key];

                                if (!variant || variant.stock <= 0) {
                                    item.classList.add('is-disabled');
                                    item.setAttribute('aria-disabled', 'true');

                                    if (item.classList.contains('selected')) {
                                        item.classList.remove('selected');
                                        item.setAttribute('aria-checked', 'false');
                                        selectedColorId = null;
                                        if (colorSelect) colorSelect.value = '';
                                    }
                                } else {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                }
                            });
                        }

                        function clearSelection() {
                            selectedColorId = null;
                            selectedSizeId = null;

                            if (colorSelect) colorSelect.value = '';
                            if (sizeSelect) sizeSelect.value = '';

                            colorItems.forEach(item => {
                                item.classList.remove('selected', 'is-disabled');
                                item.setAttribute('aria-checked', 'false');
                                item.setAttribute('aria-disabled', 'false');
                            });

                            sizeItems.forEach(item => {
                                item.classList.remove('selected', 'is-disabled');
                                item.setAttribute('aria-checked', 'false');
                                item.setAttribute('aria-disabled', 'false');
                            });

                            resetPriceAndStock();
                        }

                        // ===== EVENT: CHỌN / BỎ CHỌN MÀU =====
                        colorItems.forEach(item => {
                            item.addEventListener('click', function () {
                                if (this.classList.contains('is-disabled')) return;

                                const colorId = this.dataset.colorId;

                                // Nếu đang được chọn -> click lần 2 để HUỶ CHỌN màu
                                if (this.classList.contains('selected')) {
                                    this.classList.remove('selected');
                                    this.setAttribute('aria-checked', 'false');
                                    selectedColorId = null;
                                    if (colorSelect) colorSelect.value = '';

                                    // Khi không còn màu được chọn, enable lại size theo logic hiện tại
                                    updateAvailableSizes();

                                    // Không đủ cặp color+size -> reset giá/stock
                                    updatePriceByVariant();
                                    return;
                                }

                                // Chọn màu mới
                                selectedColorId = colorId;

                                if (colorSelect) {
                                    colorSelect.value = colorId;
                                }

                                colorItems.forEach(i => {
                                    i.classList.remove('selected');
                                    i.setAttribute('aria-checked', 'false');
                                });
                                this.classList.add('selected');
                                this.setAttribute('aria-checked', 'true');

                                updateAvailableSizes();
                                updatePriceByVariant();
                            });
                        });

                        // ===== EVENT: CHỌN / BỎ CHỌN SIZE =====
                        sizeItems.forEach(item => {
                            item.addEventListener('click', function () {
                                if (this.classList.contains('is-disabled')) return;

                                const sizeId = this.dataset.sizeId;

                                // Nếu đang được chọn -> click lần 2 để HUỶ CHỌN size
                                if (this.classList.contains('selected')) {
                                    this.classList.remove('selected');
                                    this.setAttribute('aria-checked', 'false');
                                    selectedSizeId = null;
                                    if (sizeSelect) sizeSelect.value = '';

                                    updateAvailableColors();
                                    updatePriceByVariant();
                                    return;
                                }

                                // Chọn size mới
                                selectedSizeId = sizeId;

                                if (sizeSelect) {
                                    sizeSelect.value = sizeId;
                                }

                                sizeItems.forEach(i => {
                                    i.classList.remove('selected');
                                    i.setAttribute('aria-checked', 'false');
                                });
                                this.classList.add('selected');
                                this.setAttribute('aria-checked', 'true');

                                updateAvailableColors();
                                updatePriceByVariant();
                            });
                        });

                        // Nút Clear
                        const resetBtn = document.getElementById('js-reset-variations');
                        if (resetBtn) {
                            resetBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                clearSelection();
                            });
                        }

                        // Bắt action_type cho 2 nút submit (Add to cart / Mua ngay)
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
                                if (!variantIdInput || !variantIdInput.value) {
                                    e.preventDefault();
                                    alert('Vui lòng chọn đầy đủ màu sắc và size trước khi đặt hàng.');
                                    return;
                                }
                            });
                        }
                    </script>




                    @include('layouts.js')

                    <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:21:45 -->
@endsection