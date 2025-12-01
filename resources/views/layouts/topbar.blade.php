@extends('master')
@section('content')

    <body
        class="wp-singular product-template-default single single-product postid-164 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-422 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div data-elementor-type="product" data-elementor-id="422"
                        class="elementor elementor-422 elementor-location-single post-164 product type-product status-publish has-post-thumbnail product_cat-men product_cat-sweatshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m12 product_tag-men product_tag-products first instock shipping-taxable purchasable product-type-variable has-default-attributes product">
                        <div class="elementor-element elementor-element-2aa9a7f8 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="2aa9a7f8" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-6cde03d elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="6cde03d" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a href="/"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Home">Trang Chủ</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><a
                                                            href="{{ route('products.index') }}"
                                                            class="kitify-breadcrumbs__item-link" rel="tag"
                                                            title="Shop">Sản Phẩm</a></div>
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
                        <div class="elementor-element elementor-element-6a859d3 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="6a859d3" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-74070b10 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="74070b10" data-element_type="container">
                                    <div class="elementor-element elementor-element-164bd38 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                        data-id="164bd38" data-element_type="container"
                                        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet_extra&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:1,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
                                        <div class="e-con-inner">
                                            <div class="elementor-element elementor-element-4856c0b3 elementor-widget kitify elementor-kitify-wooproduct-images"
                                                data-id="4856c0b3" data-element_type="widget"
                                                data-widget_type="kitify-wooproduct-images.default">
                                                <div class="elementor-widget-container">
                                                    <div class="kitify-product-images layout-type-2">
    <div class="woocommerce-product-gallery
                woocommerce-product-gallery--with-images
                woocommerce-product-gallery--columns-6 images"
        data-columns="{{ min(6, max(1, count($images))) }}"
        style="opacity: 1; transition: opacity .25s ease-in-out;">

        <div class="woocommerce-product-gallery__wrapper">

            @foreach ($images as $index => $img)
                @php
                    // URL đầy đủ tới ảnh (storage)
                    $imgUrl = asset('storage/' . $img);
                    $alt    = $product->name . ' - Image ' . ($index + 1);
                @endphp

                <div class="woocommerce-product-gallery__image"
                     data-thumb="{{ $imgUrl }}"
                     data-thumb-alt="{{ $alt }}"
                     data-thumb-srcset="{{ $imgUrl }} 1000w"
                     data-thumb-sizes="(max-width: 250px) 100vw, 250px">

                    <a href="{{ $imgUrl }}">
                        <img
                            width="1000"
                            height="1000"
                            src="{{ $imgUrl }}"
                            class="{{ $index === 0 ? 'wp-post-image' : '' }}"
                            alt="{{ $alt }}"
                            data-caption=""
                            data-src="{{ $imgUrl }}"
                            data-large_image="{{ $imgUrl }}"
                            data-large_image_width="1000"
                            data-large_image_height="1000"
                            sizes="(max-width: 1000px) 100vw, 1000px"
                            {{-- Gắn id cho ảnh chính để JS đổi theo màu/biến thể --}}
                            @if ($index === 0)
                                id="js-main-image"
                                data-image-base="{{ asset('storage') }}/"
                            @endif
                        />
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</div>

                                                    <div class="kitify-product-images layout-type-2">
                                                        <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-6 images"
                                                            data-columns="4"
                                                            style="opacity: 0; transition: opacity .25s ease-in-out;">
                                                            <div class="woocommerce-product-gallery__wrapper">
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg"><img
                                                                            fetchpriority="high" width="1000"
                                                                            height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg"
                                                                            class="wp-post-image"
                                                                            alt="Carhartt American Script Sweat, tobacco"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco - Image 2"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg"><img
                                                                            width="1000" height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg"
                                                                            class=""
                                                                            alt="Carhartt American Script Sweat, tobacco - Image 2"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000" decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco - Image 3"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg"><img
                                                                            width="1000" height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg"
                                                                            class=""
                                                                            alt="Carhartt American Script Sweat, tobacco - Image 3"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000"
                                                                            decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco - Image 4"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg"><img
                                                                            loading="lazy" width="1000" height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg"
                                                                            class=""
                                                                            alt="Carhartt American Script Sweat, tobacco - Image 4"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000"
                                                                            decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco - Image 5"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg"><img
                                                                            loading="lazy" width="1000" height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg"
                                                                            class=""
                                                                            alt="Carhartt American Script Sweat, tobacco - Image 5"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000"
                                                                            decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                                <div data-thumb="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-250x250.jpg"
                                                                    data-thumb-alt="Carhartt American Script Sweat, tobacco - Image 6"
                                                                    data-thumb-srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg 1000w"
                                                                    data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                    class="woocommerce-product-gallery__image"><a
                                                                        href="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg"><img
                                                                            loading="lazy" width="1000" height="1000"
                                                                            src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg"
                                                                            class=""
                                                                            alt="Carhartt American Script Sweat, tobacco - Image 6"
                                                                            data-caption=""
                                                                            data-src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg"
                                                                            data-large_image="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg"
                                                                            data-large_image_width="1000"
                                                                            data-large_image_height="1000"
                                                                            decoding="async"
                                                                            srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2.jpg 1000w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-100x100.jpg 100w"
                                                                            sizes="(max-width: 1000px) 100vw, 1000px" /></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-54c1645a e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="54c1645a" data-element_type="container">
                                    <div class="elementor-element elementor-element-fd52eb9 elementor-widget kitify elementor-kitify-wooproduct-title"
                                        data-id="fd52eb9" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-title.default">
                                        <div class="elementor-widget-container">
                                            <h1 class="kitify-post-title ">{{ $product->name }}</h1>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4125f0e9 elementor-widget elementor-widget-spacer"
                                        data-id="4125f0e9" data-element_type="widget" data-widget_type="spacer.default">
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
                                                <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                    <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                        out of 5 based on <span class="rating">1</span> customer
                                                        rating</span>
                                                </div> <a href="#reviews" class="woocommerce-review-link"
                                                    rel="nofollow">(<span class="count">1</span> customer review)</a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-5c2da7b2 elementor-widget elementor-widget-spacer"
                                        data-id="5c2da7b2" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-74bff889 elementor-widget kitify elementor-kitify-wooproduct-price"
                                        data-id="74bff889" data-element_type="widget"
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
                                    <div class="elementor-element elementor-element-653f73d9 elementor-widget kitify elementor-kitify-wooproduct-shortdescription"
                                        data-id="653f73d9" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-shortdescription.default">
                                        <div class="elementor-widget-container">
                                            <div class="woocommerce-product-details__short-description">
                                                <p>{{ $product->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-1997adfa elementor-widget elementor-widget-spacer"
                                        data-id="1997adfa" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-41282ed0 elementor-widget kitify elementor-kitify-wooproduct-addtocart"
                                        data-id="41282ed0" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-addtocart.default">
                                        <div class="elementor-widget-container">

                                            <div class="elementor-add-to-cart elementor-product-variable">

                                                <form class="variations_form cart" action="#" method="post"
                                                    enctype="multipart/form-data" data-product_id="{{ $product->id }}">
                                                    <div data-product_id="{{ $product->id }}">
                                                        <table class="variations" cellspacing="0" role="presentation">
                                                            <tbody>
                                                                {{-- COLOR --}}
                                                                <tr>
                                                                    <th class="label">
                                                                        <label for="pa_color">Color</label>
                                                                    </th>
                                                                    <td class="value">
                                                                        {{-- Select ẩn để submit form nếu cần --}}
                                                                        <select style="display:none" id="pa_color"
                                                                            class="woo-variation-raw-select"
                                                                            name="color_id" data-attribute_name="color_id"
                                                                            data-show_option_none="yes">
                                                                            <option value="">Choose an option
                                                                            </option>
                                                                            @foreach ($colors as $color)
                                                                                <option value="{{ $color->id }}">
                                                                                    {{ $color->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                        {{-- Swatch màu --}}
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
                                                                                    data-value="{{ $color->id }}"
                                                                                    role="radio">
                                                                                    <div class="variable-item-contents">
                                                                                        <span
                                                                                            class="variable-item-span variable-item-span-color"
                                                                                            style="background-color: {{ $color->color_code ?? '#cccccc' }};">
                                                                                        </span>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                {{-- SIZE --}}
                                                                <tr>
                                                                    <th class="label">
                                                                        <label for="pa_size">Size</label>
                                                                    </th>
                                                                    <td class="value">
                                                                        {{-- Select ẩn --}}
                                                                        <select style="display:none" id="pa_size"
                                                                            class="woo-variation-raw-select"
                                                                            name="size_id" data-attribute_name="size_id"
                                                                            data-show_option_none="yes">
                                                                            <option value="">Choose an option
                                                                            </option>
                                                                            @foreach ($sizes as $size)
                                                                                <option value="{{ $size->id }}">
                                                                                    {{ $size->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                        {{-- Nút size --}}
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
                                                                                    data-value="{{ $size->id }}"
                                                                                    role="radio">
                                                                                    <div class="variable-item-contents">
                                                                                        <span
                                                                                            class="variable-item-span variable-item-span-button">
                                                                                            {{ $size->siz }}
                                                                                        </span>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>

                                                                        <a class="reset_variations" href="#"
                                                                            id="js-reset-variations"
                                                                            aria-label="Clear options">
                                                                            Clear
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="reset_variations_alert screen-reader-text"
                                                            role="alert" aria-live="polite" aria-relevant="all"></div>
                                                        <div class="single_variation_wrap">
                                                            <div class="woocommerce-variation single_variation"></div>
                                                            <div
                                                                class="woocommerce-variation-add-to-cart variations_button">
                                                                <div class="woocommerce-product-details__add-to-cart">
                                                                    <div class="quantity"> <span
                                                                            class="nova-minicart-qty-button decrease"><svg
                                                                                class="icon">
                                                                                <use xlink:href="#mini-cart-delete"></use>
                                                                            </svg></span> <label class="screen-reader-text"
                                                                            for="quantity_68dbd5718e0e6">Carhartt American
                                                                            Script Sweat, tobacco quantity</label> <input
                                                                            type="number" id="quantity_68dbd5718e0e6"
                                                                            class="input-text qty text" name="quantity"
                                                                            value="1" aria-label="Product quantity"
                                                                            min="1" max="" step="1"
                                                                            placeholder="" inputmode="numeric"
                                                                            autocomplete="off" /> <span
                                                                            class="nova-minicart-qty-button increase"><svg
                                                                                class="icon">
                                                                                <use xlink:href="#mini-cart-add"></use>
                                                                            </svg></span> </div> <button type="submit"
                                                                        class="single_add_to_cart_button button alt">Add to
                                                                        cart</button>
                                                                </div> <input type="hidden" name="add-to-cart"
                                                                    value="164" /> <input type="hidden"
                                                                    name="product_id" value="164" /> <input
                                                                    type="hidden" name="variation_id"
                                                                    class="variation_id" value="0" />
                                                            </div>
                                                        </div>
                                                        {{-- Phần alert / add to cart của bạn có thể giữ nguyên hoặc tùy chỉnh tiếp --}}
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-7c091c0c elementor-widget elementor-widget-spacer"
                                        data-id="7c091c0c" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-36ce4bb9 elementor-widget kitify elementor-kitify-wishlist-button"
                                        data-id="36ce4bb9" data-element_type="widget"
                                        data-widget_type="kitify-wishlist-button.default">
                                        <div class="elementor-widget-container">

                                            <div class="yith-wcwl-add-to-wishlist add-to-wishlist-165 yith-wcwl-add-to-wishlist--link-style yith-wcwl-add-to-wishlist--single wishlist-fragment on-first-load"
                                                data-fragment-ref="165"
                                                data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;product_id&quot;:165,&quot;parent_product_id&quot;:164,&quot;product_type&quot;:&quot;variation&quot;,&quot;is_single&quot;:true,&quot;in_default_wishlist&quot;:false,&quot;show_view&quot;:false,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">

                                                <!-- ADD TO WISHLIST -->

                                                <div class="yith-wcwl-add-button">
                                                    <a href="{{ route('products.show', ['id' => $product->id]) }}"
                                                        class="add_to_wishlist single_add_to_wishlist"
                                                        data-product-id="{{ $product->id }}"
                                                        data-product-type="variation"
                                                        data-original-product-id="{{ $product->id }}"
                                                        data-title="Add to wishlist" rel="nofollow">
                                                        <svg id="yith-wcwl-icon-heart-outline" class="yith-wcwl-icon-svg"
                                                            fill="none" stroke-width="1.5" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z">
                                                            </path>
                                                        </svg> <span>Thêm vào danh sách yêu thích</span>
                                                    </a>
                                                </div>
                                                <div class="yith-wcwl-wishlistaddedbrowse" data-product-id="819"
                                                    data-original-product-id="818">
                                                    <span class="feedback">
                                                        <svg id="yith-wcwl-icon-heart" class="yith-wcwl-icon-svg"
                                                            fill="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z">
                                                            </path>
                                                        </svg> Product added! </span>
                                                    <a href="https://mixtas.novaworks.net/wishlist/" rel="nofollow"
                                                        data-title="Browse wishlist">
                                                        Browse wishlist </a>
                                                </div>
                                                <!-- COUNT TEXT -->

                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4999a9ba elementor-widget elementor-widget-spacer"
                                        data-id="4999a9ba" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-485e0ad9 elementor-woo-meta--view-table elementor-widget kitify elementor-kitify-wooproduct-meta"
                                        data-id="485e0ad9" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-meta.default">
                                        <div class="elementor-widget-container">
                                            <div class="product_meta">


                                                <span class="sku_wrapper detail-container"><span
                                                        class="detail-label">SKU</span> <span
                                                        class="sku">{{ $product->product_code }}</span></span>

                                                <span class="posted_in detail-container"><span class="detail-label">Danh
                                                        mục</span> <span class="detail-content">

                                                        <a href="../../product-category/men/index.html"
                                                            rel="tag">{{ $product->category->name }}</a>
                                                    </span></span>

                                                <span class="color detail-container"><span class="detail-label">Màu
                                                        sắc</span>
                                                    <span class="detail-content">
                                                        @foreach ($colors as $index => $color)
                                                            <a rel="color">{{ $color->name }}</a>
                                                            @if ($index < count($colors) - 1)
                                                                <span class="sept">,</span>
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </span>
                                                <span class="size detail-container"><span class="detail-label">Size</span>
                                                    <span class="detail-content">
                                                        @foreach ($sizes as $index => $size)
                                                            <a rel="size">{{ $size->name }}</a>
                                                            @if ($index < count($sizes) - 1)
                                                                <span class="sept">,</span>
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="elementor-element elementor-element-787c6000 elementor-widget elementor-widget-spacer"
                                        data-id="787c6000" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-7881627b elementor-share-buttons--skin-flat elementor-share-buttons--align-left elementor-share-buttons--color-custom elementor-grid-mobile_extra-0 elementor-share-buttons--view-icon-text elementor-share-buttons--shape-square elementor-grid-0 elementor-widget kitify elementor-kitify-social-share"
                                        data-id="7881627b" data-element_type="widget"
                                        data-widget_type="kitify-social-share.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-grid">
                                                <div class="elementor-grid-item">
                                                    <div class="elementor-share-btn elementor-share-btn_facebook">
                                                        <span class="elementor-share-btn__icon">
                                                            <i class="novaicon-b-facebook" aria-hidden="true"></i>
                                                            <span class="elementor-screen-only">Share on facebook</span>
                                                        </span>
                                                        <div class="elementor-share-btn__text">
                                                            <span class="elementor-share-btn__title">
                                                                Facebook </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-grid-item">
                                                    <div class="elementor-share-btn elementor-share-btn_twitter">
                                                        <span class="elementor-share-btn__icon">
                                                            <i class="novaicon-b-twitter" aria-hidden="true"></i>
                                                            <span class="elementor-screen-only">Share on twitter</span>
                                                        </span>
                                                        <div class="elementor-share-btn__text">
                                                            <span class="elementor-share-btn__title">
                                                                X </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-grid-item">
                                                    <div class="elementor-share-btn elementor-share-btn_pinterest">
                                                        <span class="elementor-share-btn__icon">
                                                            <i class="novaicon-b-pinterest" aria-hidden="true"></i>
                                                            <span class="elementor-screen-only">Share on pinterest</span>
                                                        </span>
                                                        <div class="elementor-share-btn__text">
                                                            <span class="elementor-share-btn__title">
                                                                Pinterest </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="elementor-grid-item">
                                                    <div class="elementor-share-btn elementor-share-btn_whatsapp">
                                                        <span class="elementor-share-btn__icon">
                                                            <i class="novaicon-b-whatsapp" aria-hidden="true"></i>
                                                            <span class="elementor-screen-only">Share on whatsapp</span>
                                                        </span>
                                                        <div class="elementor-share-btn__text">
                                                            <span class="elementor-share-btn__title">
                                                                WhatsApp </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-2573699b e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="2573699b" data-element_type="container">
                            <div class="elementor-element elementor-element-50491af7 elementor-widget elementor-widget-heading"
                                data-id="50491af7" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <h2 class="elementor-heading-title elementor-size-default">Related Products</h2>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-60a7bf67 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-wooproducts"
                                data-id="60a7bf67" data-element_type="widget"
                                data-widget_type="kitify-wooproducts.default">
                                <div class="elementor-widget-container">
                                    <div class="woocommerce  kitify_wc_widget_60a7bf67_0">
                                        <div class="kitify-products kitify-carousel"
                                            data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:false,&quot;infinite&quot;:false,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-60a7bf67_0&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-60a7bf67_0&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_60a7bf67_0&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_60a7bf67_0&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:4,&quot;mobile&quot;:1,&quot;mobile_extra&quot;:2,&quot;tablet&quot;:3,&quot;tablet_extra&quot;:3,&quot;laptop&quot;:4}}"
                                            dir="ltr">
                                            <div class="kitify-carousel-inner">
                                                <div class="kitify-products__list_wrapper swiper-container">
                                                    <ul
                                                        class="products ul_products kitify-products__list products-grid products-grid-1 swiper-wrapper columns-4">


                                                        <li
                                                            class="product_item product-grid-item product type-product post-1566 status-publish first instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../parra-rug-pull-t-shirt-white/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index73fe.html?theme_template_id=422&amp;add_to_wishlist=1566"
                                                                            data-product-id="1566"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="1566" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../parra-rug-pull-t-shirt-white/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="1566" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Parra Rug Pull t-shirt, white&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_1566"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../parra-rug-pull-t-shirt-white/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_07_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/jackets/index.html"
                                                                                    rel="tag">Jackets</a></div> <a
                                                                                href="../parra-rug-pull-t-shirt-white/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Parra Rug Pull t-shirt, white</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>60.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-1564 status-publish instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../butter-yard-pullover-hood-denim/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index8177.html?theme_template_id=422&amp;add_to_wishlist=1564"
                                                                            data-product-id="1564"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="1564" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../butter-yard-pullover-hood-denim/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="1564" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Butter Yard Pullover Hood, denim&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_1564"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../butter-yard-pullover-hood-denim/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/jackets/index.html"
                                                                                    rel="tag">Jackets</a></div> <a
                                                                                href="../butter-yard-pullover-hood-denim/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Butter Yard Pullover Hood, denim</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>120.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-1489 status-publish instock product_cat-sweatshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m71 product_tag-products product_tag-women has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../lapels-houndstooth-suit-blazer/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index5080.html?theme_template_id=422&amp;add_to_wishlist=1489"
                                                                            data-product-id="1489"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="1489" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../lapels-houndstooth-suit-blazer/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="1489" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Lapels Houndstooth suit blazer&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_1489"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../lapels-houndstooth-suit-blazer/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_03_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/sweatshirts/index.html"
                                                                                    rel="tag">Sweatshirts</a></div>
                                                                            <a href="../lapels-houndstooth-suit-blazer/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Lapels Houndstooth suit blazer</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>99.99</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-1487 status-publish last instock product_cat-sweatshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m71 product_tag-products product_tag-women has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../button-knit-cardigan/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="indexdb2f.html?theme_template_id=422&amp;add_to_wishlist=1487"
                                                                            data-product-id="1487"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="1487" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../button-knit-cardigan/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="1487" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Button knit cardigan&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_1487"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a href="../button-knit-cardigan/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/sweatshirts/index.html"
                                                                                    rel="tag">Sweatshirts</a></div>
                                                                            <a href="../button-knit-cardigan/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Button knit cardigan</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>39.99</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-168 status-publish first instock product_cat-bags product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m12 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../parra-trees-in-wind-toiletry-bag-camo-green/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index9c0c.html?theme_template_id=422&amp;add_to_wishlist=168"
                                                                            data-product-id="168"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="168" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../parra-trees-in-wind-toiletry-bag-camo-green/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="168" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Parra Trees in Wind Toiletry Bag, camo green&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_168"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../parra-trees-in-wind-toiletry-bag-camo-green/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_11_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/bags/index.html"
                                                                                    rel="tag">Bags</a></div> <a
                                                                                href="../parra-trees-in-wind-toiletry-bag-camo-green/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Parra Trees in Wind Toiletry Bag, camo
                                                                                    green</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>85.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-159 status-publish instock product_cat-hoodies product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m12 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-simple kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../dime-classic-remastered-hoodie-black/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index5d70.html?theme_template_id=422&amp;add_to_wishlist=159"
                                                                            data-product-id="159"
                                                                            data-product-type="simple"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="159" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="indexe8b4.html?add-to-cart=159"
                                                                            data-quantity="1"
                                                                            class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                                            data-product_id="159" data-product_sku=""
                                                                            aria-label="Add to cart: &ldquo;Dime Classic Remastered Hoodie, black&rdquo;"
                                                                            rel="nofollow"
                                                                            data-success_message="&ldquo;Dime Classic Remastered Hoodie, black&rdquo; has been added to your cart"><svg
                                                                                class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Add to
                                                                                cart</span></a>
                                                                        <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_159"
                                                                            class="screen-reader-text">
                                                                        </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../dime-classic-remastered-hoodie-black/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_06_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/hoodies/index.html"
                                                                                    rel="tag">Hoodies</a></div> <a
                                                                                href="../dime-classic-remastered-hoodie-black/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Dime Classic Remastered Hoodie, black
                                                                                </h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>140.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-156 status-publish instock product_cat-jackets product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m11 product_tag-men product_tag-products has-post-thumbnail sale shipping-taxable product-type-grouped kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">

                                                                    <span class="onsale">Sale!</span>
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../carhartt-hooded-coach-jacket-cypress/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index9bae.html?theme_template_id=422&amp;add_to_wishlist=156"
                                                                            data-product-id="156"
                                                                            data-product-type="grouped"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="156" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../carhartt-hooded-coach-jacket-cypress/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_grouped"
                                                                            data-product_id="156" data-product_sku=""
                                                                            aria-label="View products in the &ldquo;Carhartt Hooded Coach jacket, cypress&rdquo; group"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">View
                                                                                products</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_156"
                                                                            class="screen-reader-text">
                                                                        </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../carhartt-hooded-coach-jacket-cypress/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/jackets/index.html"
                                                                                    rel="tag">Jackets</a></div> <a
                                                                                href="../carhartt-hooded-coach-jacket-cypress/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Carhartt Hooded Coach jacket, cypress
                                                                                </h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>160.00</bdi></span>
                                                                                &ndash; <span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>165.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>


                                                        <li
                                                            class="product_item product-grid-item product type-product post-154 status-publish last instock product_cat-jackets product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m11 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                            <div class="product-item">
                                                                <div class="product-item__badges">
                                                                </div>
                                                                <div class="product-item__thumbnail">
                                                                    <div class="product-item__thumbnail_overlay">
                                                                    </div>
                                                                    <a class="product-item-link"
                                                                        href="../carhartt-og-santa-fe-jacket/index.html"></a>
                                                                    <div class="product-item__description--top-actions">

                                                                        <a href="index113a.html?theme_template_id=422&amp;add_to_wishlist=154"
                                                                            data-product-id="154"
                                                                            data-product-type="variable"
                                                                            data-wishlist-url="../../wishlist/index.html"
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
                                                                            data-product-id="154" rel="nofollow"><i
                                                                                class="inova ic-zoom"></i></a><a
                                                                            href="../carhartt-og-santa-fe-jacket/index.html"
                                                                            data-quantity="1"
                                                                            class="button product_type_variable add_to_cart_button"
                                                                            data-product_id="154" data-product_sku=""
                                                                            aria-label="Select options for &ldquo;Carhartt OG Santa Fe Jacket&rdquo;"
                                                                            rel="nofollow"><svg class="mixtas-addtocart">
                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                </use>
                                                                            </svg><span class="text">Select
                                                                                options</span></a> <span
                                                                            id="woocommerce_loop_add_to_cart_link_describedby_154"
                                                                            class="screen-reader-text">
                                                                            This product has multiple variants. The options
                                                                            may be chosen on the product page </span>
                                                                    </div>


                                                                    <div
                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                        <a
                                                                            href="../carhartt-og-santa-fe-jacket/index.html">
                                                                            <img loading="lazy" width="700"
                                                                                height="700"
                                                                                src="../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-700x700.jpg"
                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                alt="" decoding="async"
                                                                                srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_1.jpg 1000w"
                                                                                sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                class="product_second_image"
                                                                                style="background-image: url('../../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_03_2-700x700.jpg')"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <div class="product-item__description">

                                                                    <div class="product-item__description--info">
                                                                        <div class="info-left">
                                                                            <div class="product-item__category"><a
                                                                                    class="content-product-cat"
                                                                                    href="../../product-category/jackets/index.html"
                                                                                    rel="tag">Jackets</a></div> <a
                                                                                href="../carhartt-og-santa-fe-jacket/index.html"
                                                                                class="title">
                                                                                <h3
                                                                                    class="woocommerce-loop-product__title">
                                                                                    Carhartt OG Santa Fe Jacket</h3>
                                                                            </a>
                                                                        </div>
                                                                        <div class="info-right">

                                                                            <span class="price"><span
                                                                                    class="woocommerce-Price-amount amount"><bdi><span
                                                                                            class="woocommerce-Price-currencySymbol">&#36;</span>160.00</bdi></span></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="kitify-carousel__prev-arrow-60a7bf67_0 kitify-arrow prev-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-left"></i></div>
                                            <div class="kitify-carousel__next-arrow-60a7bf67_0 kitify-arrow next-arrow"><i
                                                    aria-hidden="true" class="novaicon-arrow-right"></i></div>
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
            <script>
                const variantMap = @json($variantMap);

                let selectedColorId = null;
                let selectedSizeId = null;

                const priceEl = document.getElementById('js-product-price');
                const originalEl = document.getElementById('js-product-original-price');
                const discountEl = document.getElementById('js-product-discount');

                const mainImageEl = document.getElementById('js-main-image');
                const imageBase = mainImageEl ? mainImageEl.dataset.imageBase : '';

                const colorSelect = document.getElementById('pa_color');
                const sizeSelect = document.getElementById('pa_size');
                // giá default

                const defaultPrice = {{ (float) $displayPrice }};
                const defaultOriginal = {{ (float) $originalPrice }};
                const defaultHasDiscount = {{ $discountPercent ? 'true' : 'false' }};
                const defaultDiscount = {{ (int) ($discountPercent ?? 0) }};

                function formatCurrency(value) {
                    if (!value) return '0₫';
                    return new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                        maximumFractionDigits: 0
                    }).format(value);
                }


                function setImageVariant(variant) {
                    if (!variant || !variant.image || !mainImageEl) return;
                    mainImageEl.src = imageBase + variant.image;
                }

                function updatePriceByVariant() {
                    if (!selectedColorId || !selectedSizeId) {
                        return;
                    }

                    const key = `${selectedColorId}_${selectedSizeId}`;
                    const variant = variantMap[key];

                    if (!variant) {
                        // không có biến thể tương ứng
                        return;
                    }

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
                    setImageByVariant(variant);
                }

                function clearSelection() {
                    selectedColorId = null;
                    selectedSizeId = null;

                    // Clear select ẩn
                    if (colorSelect) colorSelect.value = '';
                    if (sizeSelect) sizeSelect.value = '';

                    // Clear class selected + aria-checked
                    document.querySelectorAll('.js-color-item').forEach(item => {
                        item.classList.remove('selected');
                        item.setAttribute('aria-checked', 'false');
                    });
                    document.querySelectorAll('.js-size-item').forEach(item => {
                        item.classList.remove('selected');
                        item.setAttribute('aria-checked', 'false');
                    });

                    // Reset giá về mặc định
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
                }

                function updateImageByColor() {
                    if (!selectedColorId || !mainImageEl) return;

                    const variants = Object.values(variantMap);
                    const firstVariantOfColor = variants.find(v =>
                        String(v.color_id) === String(selectedColorId) && v.image
                    );

                    if (firstVariantOfColor) {
                        setImageByVariant(firstVariantOfColor);
                    }
                }

                // Chọn màu
                document.querySelectorAll('.js-color-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const colorId = this.dataset.colorId;
                        selectedColorId = colorId;

                        // Update select ẩn
                        if (colorSelect) {
                            colorSelect.value = colorId;
                        }

                        // Toggle UI selected
                        document.querySelectorAll('.js-color-item').forEach(i => {
                            i.classList.remove('selected');
                            i.setAttribute('aria-checked', 'false');
                        });
                        this.classList.add('selected');
                        this.setAttribute('aria-checked', 'true');

                        updatePriceByVariant();
                    });
                });

                // Chọn size
                document.querySelectorAll('.js-size-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const sizeId = this.dataset.sizeId;
                        selectedSizeId = sizeId;

                        // Update select ẩn
                        if (sizeSelect) {
                            sizeSelect.value = sizeId;
                        }

                        // Toggle UI selected
                        document.querySelectorAll('.js-size-item').forEach(i => {
                            i.classList.remove('selected');
                            i.setAttribute('aria-checked', 'false');
                        });
                        this.classList.add('selected');
                        this.setAttribute('aria-checked', 'true');

                        updatePriceByVariant();
                    });
                });
                // clear
                const resetBtn = document.getElementById('js-reset-variations');
                if (resetBtn) {
                    resetBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        clearSelection();
                    });
                }
            </script>

            @include('layouts.js')








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

                                    {{-- <div class="main-image mb-4">
                                        <img src="{{ asset('storage/' . $product->photoAlbums->first()->image) }}"
                                            data-default="{{ asset('storage/' . $product->photoAlbums->first()->image) }}"
                                            alt="{{ $product->name }}" class="img-fluid rounded shadow"
                                            style="max-height: 500px; object-fit: cover;">
                                    </div> --}}




                                    {{-- Album ảnh nhỏ phía dưới --}}
                                    {{-- @if (isset($albums) && $albums->count())
                                        <div class="album-images d-flex justify-content-center gap-3 flex-wrap mt-3">
                                            @foreach ($albums as $img)
                                                <img src="{{ Storage::disk('public')->url('product_images/' . $img->image) }}"
                                                    alt="" width="100" height="100"
                                                    class="img-thumbnail border border-secondary"
                                                    style="object-fit: cover; border-radius: 6px;">
                                            @endforeach
                                        </div>
                                    @endif --}}
                                </div>

                                <!-- Thông tin sản phẩm -->
                                <div class="col-md-6 ps-md-5"> {{-- thêm ps-md-5 để tạo khoảng cách bên trái --}}
                                    <h2 class="mb-3">{{ $product->name }}</h2>
                                    <p class="text-muted">{{ $product->material }}</p>
                                    <p>{{ $product->description }}</p>

                                    @if (isset($variants) && $variants->count() > 0)
                                        <h4 class="mt-4 mb-2">Chọn thuộc tính</h4>

                                        {{-- Form thêm giỏ --}}
                                        <form method="POST" action="{{ route('cart.add') }}" id="addToCartForm"
                                            class="border p-3 rounded">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            {{-- sẽ set động theo lựa chọn --}}
                                            <input type="hidden" name="product_variant_id" id="variantId"
                                                value="">

                                            {{-- Màu --}}
                                            <div class="mb-3">
                                                <label for="selectColor" class="form-label fw-semibold">Màu sắc</label>

                                                @php
                                                    // Lấy các color_id còn hàng từ $variants của chính product này
                                                    $inStockColorIds = $variants
                                                        ->filter(
                                                            fn($v) => ($v->quantity ?? 0) > 0 && !empty($v->color_id),
                                                        )
                                                        ->pluck('color_id')
                                                        ->unique()
                                                        ->values()
                                                        ->all();
                                                @endphp

                                                <select id="selectColor" class="form-select">
                                                    <option value="" selected>— Chọn màu —</option>
                                                    @foreach ($colors->whereIn('id', $inStockColorIds) as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>

                                                {{-- Trường hợp không còn màu nào còn hàng --}}
                                                @if (empty($inStockColorIds))
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
                                                    <span class="text-muted">Vui lòng chọn màu & size</span>
                                                </div>
                                            </div>

                                            <!-- Tồn kho -->
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tồn Kho</label>
                                                <span id="stockBox" class="text-muted">Vui lòng chọn màu & size</span>
                                            </div>

                                            {{-- Số lượng --}}

                                            <div class="mb-3">
                                                <label for="quantity" class="form-label fw-semibold m-0">Số
                                                    lượng</label>
                                                <div class="qty-pill" id="qtyBox">
                                                    <button type="button" class="qty-btn" id="qtyMinus"
                                                        aria-label="Giảm">−</button>
                                                    <input type="number" id="quantity" name="quantity"
                                                        class="qty-input" value="1" min="1"
                                                        inputmode="numeric" pattern="\d*">
                                                    <button type="button" class="qty-btn" id="qtyPlus"
                                                        aria-label="Tăng">+</button>
                                                </div>
                                            </div>

                                            {{-- Nút thêm giỏ hàng đưa xuống dưới ô số lượng --}}
                                            <button type="submit" class="btn btn-dark d-inline-block"
                                                style="margin-top:8px; display:block" id="btnAddToCart">
                                                Thêm Vào Giỏ Hàng
                                            </button>

                                            <button type="submit" class="btn btn-primary" id="btnBuyNow"
                                                style="margin-top:8px" formaction="{{ route('checkout.buy_now') }}">
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
                                            @foreach ($variants as $v)
                                                @if ($v->color_id && $v->size_id && ($v->quantity ?? 0) > 0)
                                                    COLOR_SIZES[{{ $v->color_id }}] = COLOR_SIZES[{{ $v->color_id }}] || [];
                                                    COLOR_SIZES[{{ $v->color_id }}].push({
                                                        id: {{ $v->size_id }},
                                                        name: "{{ $v->size?->name }}"
                                                    });
                                                @endif
                                            @endforeach

                                            const fmt = (n) => new Intl.NumberFormat('vi-VN').format(n) + '₫';

                                            const selectColor = document.getElementById('selectColor');
                                            const selectSize = document.getElementById('selectSize');
                                            const priceBox = document.getElementById('priceBox');
                                            const variantId = document.getElementById('variantId');
                                            const btnAdd = document.getElementById('btnAddToCart');
                                            const btnBuy = document.getElementById('btnBuyNow');
                                            const stockBox = document.getElementById('stockBox');


                                            // === ẢNH: luôn lấy được ảnh gốc & chuẩn bị base URL ===
                                            const mainImg = document.querySelector('.main-image img');
                                            const DEFAULT_SRC = mainImg ? (mainImg.getAttribute('data-default') || mainImg.src) : null;
                                            const urlProductImages = `{{ Storage::disk('public')->url('product_images') }}`;
                                            const urlProducts = `{{ Storage::disk('public')->url('products') }}`;
                                            const storageBase = `{{ asset('storage') }}`; // => /storage

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
                                                    stockBox.classList.remove('text-success', 'text-danger');
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
                                                const sizeId = selectSize.value || '0';
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
                                                        stockBox.classList.remove('text-success', 'text-danger');
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
                                                        if (await canLoad(url)) {
                                                            loadedUrl = url;
                                                            break;
                                                        }
                                                    }

                                                    if (loadedUrl) {
                                                        // Bổ sung tiền tố /storage/products nếu là tên file tương đối
                                                        if (!loadedUrl.startsWith('http') && !loadedUrl.startsWith('/storage')) {
                                                            loadedUrl = `${BASE_STORAGE_URL}/${loadedUrl.replace(/^\/?/, '')}`;
                                                        }
                                                        mainImg.src = loadedUrl;

                                                    } else if (v.image) {
                                                        // Có tên file nhưng không load được theo candidates -> tự build URL tuyệt đối
                                                        mainImg.src = v.image.startsWith('http') ?
                                                            v.image :
                                                            (v.image.startsWith('/storage') || v.image.startsWith('storage/')) ?
                                                            (v.image.startsWith('/') ? v.image : `/${v.image}`) :
                                                            `${BASE_STORAGE_URL}/${(v.image+'').replace(/^\/?/, '')}`;


                                                    } else if (mainImg.src && mainImg.src.trim() !== '' && !mainImg.src.includes('undefined') && !
                                                        mainImg.src.includes('null')) {
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
                                            const btnPlus = document.getElementById('qtyPlus');

                                            const MIN_QTY = parseInt(qtyInput?.min || '1', 10) || 1;
                                            let MAX_QTY = null; // sẽ set theo tồn kho nếu bạn có (v.stock)

                                            // đồng bộ trạng thái nút
                                            function syncQtyButtons() {
                                                const val = parseInt(qtyInput.value || '1', 10);
                                                btnMinus.disabled = val <= MIN_QTY;
                                                btnPlus.disabled = (MAX_QTY && val >= MAX_QTY) ? true : false;
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
                                    @if (isset($reviews) && $reviews->count() > 0)
                                        @foreach ($reviews as $r)
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
                        @include('layouts.footer')
                        <div class="nova-overlay-global"></div>
                    </div><!-- .kitify-site-wrapper -->
                    @include('layouts.js')
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->

                    <style>
                        .main-image img {
                            max-width: 100%;
                            height: 500px;
                            /* Tăng kích thước ảnh chính */
                            object-fit: cover;
                            /* Giữ tỉ lệ hợp lý, cắt viền nếu cần */
                            border-radius: 10px;
                        }

                        .album-images {
                            margin-top: 20px;
                            /* Cách ảnh chính 1 khoảng */
                            gap: 15px !important;
                            /* Khoảng cách giữa các ảnh nhỏ */
                        }

                        .album-images img {
                            width: 100px;
                            /* Ảnh nhỏ to hơn một chút */
                            height: 100px;
                            object-fit: cover;
                            border-radius: 6px;
                            cursor: pointer;
                            transition: transform 0.2s ease-in-out, border-color 0.2s;
                        }

                        .album-images img:hover {
                            transform: scale(1.05);
                            /* Hiệu ứng phóng nhẹ khi hover */
                            border-color: #000;
                        }
                    </style>

                    <style>
                        /* Giãn khoảng giữa 2 cột (ảnh và thông tin) */
                        .row>.col-md-6:first-child {
                            padding-right: 60px !important;
                            /* ép khoảng cách bên phải ảnh */
                        }

                        .row>.col-md-6:last-child {
                            padding-left: 60px !important;
                            /* ép khoảng cách bên trái nội dung */
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
                        .qty-pill {
                            display: inline-flex;
                            align-items: center;
                            gap: 8px;
                            border: 1px solid #e5e5e5;
                            border-radius: 999px;
                            padding: 4px 8px;
                            background: #fff;
                        }

                        /* Nút – / + luôn hiện rõ */
                        .qty-btn {
                            background: transparent !important;
                            border: none !important;
                            width: 24px;
                            height: 24px;
                            line-height: 24px;
                            font-size: 16px;
                            font-weight: 600;
                            color: #222 !important;
                            cursor: pointer;
                            user-select: none;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .qty-btn:disabled {
                            opacity: .35;
                            cursor: not-allowed;
                        }

                        /* Ô số lượng nhỏ gọn */
                        .qty-input {
                            width: 34px;
                            text-align: center;
                            border: none;
                            outline: none;
                            box-shadow: none;
                            background: transparent;
                            color: #222;
                            font-size: 14px;
                            padding: 0;
                        }

                        /* Ẩn spinner */
                        .qty-input::-webkit-outer-spin-button,
                        .qty-input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }

                        .qty-input[type=number] {
                            -moz-appearance: textfield;
                        }

                        /* Focus đẹp một chút */
                        .qty-pill:focus-within {
                            box-shadow: 0 0 0 3px rgba(0, 0, 0, .05);
                        }

                        #priceBox .price {
                            display: flex;
                            gap: 8px;
                            align-items: baseline;
                            flex-wrap: wrap;
                        }

                        #priceBox .price--sale {
                            font-size: 20px;
                            font-weight: 700;
                            color: #d0021b;
                        }

                        /* sale to & đỏ */
                        #priceBox .price--original {
                            font-size: 14px;
                            color: #777;
                            text-decoration: line-through;
                        }

                        #priceBox .price--normal {
                            font-size: 18px;
                            font-weight: 600;
                        }
                    </style>

                    <script>
                        (function() {
                            // —— Cấu hình tối thiểu ——
                            const BASE_STORAGE_URL = "{{ asset('storage') }}"; // /storage
                            const imgEl = document.getElementById('productMainImg');
                            const sizeSel = document.getElementById('selectSize');
                            const colorSel = document.getElementById('selectColor'); // nếu không có thì vẫn OK
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
                                if (x.startsWith('storage/')) return '/' + x;

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
                                probe.onload = () => {
                                    imgEl.src = finalUrl;
                                };
                                probe.onerror = () => {
                                    imgEl.src = DEFAULT_SRC;
                                };
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
                                const sizeId = sizeSel.value;
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
                        (function() {
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
                            window.updateVariantImage = function() {
                                // No-op: luôn giữ ảnh chính
                                keepMainImage();
                            };

                            // Một số dự án đổi ảnh trong updateBySelection/updatePrice..., ta “bọc” lại:
                            const origUpdateBySelection = window.updateBySelection;
                            if (typeof origUpdateBySelection === 'function') {
                                window.updateBySelection = function() {
                                    const ret = origUpdateBySelection.apply(this, arguments);
                                    keepMainImage();
                                    return ret;
                                };
                            }
                        })();
                    </script>

                    <script>
                        (function() {
                            const form = document.getElementById('addToCartForm');
                            if (!form) return;
                            const btnAdd = document.getElementById('btnAddToCart');
                            const btnBuyNow = document.getElementById('btnBuyNow');
                            const miniCartCount = document.getElementById('miniCartCount');

                            // Lấy CSRF token
                            function getCsrfToken() {
                                const meta = document.querySelector('meta[name="csrf-token"]');
                                if (meta && meta.content) return meta.content;
                                const inp = form.querySelector('input[name="_token"]');
                                return inp ? inp.value : '';
                            }

                            form.addEventListener('submit', async function(e) {
                                // Chỉ “bắt” khi nhấn nút Thêm Vào Giỏ Hàng; nút Mua Ngay giữ nguyên hành vi
                                const submitter = e.submitter || document.activeElement;
                                if (!submitter || submitter.id !== 'btnAddToCart') return;

                                e.preventDefault();

                                // Yêu cầu chọn biến thể nếu có
                                const variantId = document.getElementById('variantId');
                                if (variantId && !variantId.value) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Thiếu lựa chọn',
                                        text: 'Vui lòng chọn màu & size trước khi thêm vào giỏ.'
                                    });
                                    return;
                                }

                                btnAdd.disabled = true;
                                const oldText = btnAdd.innerHTML;
                                btnAdd.innerHTML = 'Đang thêm...';

                                try {
                                    const res = await fetch(form.getAttribute('action'), {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': getCsrfToken(),
                                            'Accept': 'application/json'
                                        },
                                        body: new FormData(form)
                                    });

                                    const data = await res.json().catch(() => ({}));
                                    if (!res.ok || !data.ok) {
                                        const msg = (data && (data.message || data.error)) ||
                                            'Không thể thêm vào giỏ hàng.';
                                        throw new Error(msg);
                                    }

                                    // Cập nhật badge số lượng (nếu có phần tử này ở header)
                                    if (miniCartCount && typeof data.cart_count !== 'undefined') {
                                        miniCartCount.textContent = data.cart_count;
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Đã thêm vào giỏ!',
                                        text: data.message || 'Sản phẩm đã được thêm.',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                } catch (err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi',
                                        text: err.message || 'Đã xảy ra lỗi.'
                                    });
                                } finally {
                                    btnAdd.disabled = false;
                                    btnAdd.innerHTML = oldText;
                                }
                            });
                        })();
                    </script>










<div class="reset_variations_alert screen-reader-text"
     role="alert" aria-live="polite" aria-relevant="all"></div>

<div class="single_variation_wrap">
    <div class="woocommerce-variation single_variation"></div>

    <div class="woocommerce-variation-add-to-cart variations_button">
        <div class="woocommerce-product-details__add-to-cart">

            {{-- FORM ADD TO CART / MUA NGAY --}}
            <form action="{{ route('cart.store') }}"
                  method="POST"
                  id="product-add-to-cart-form">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant_id" id="js-variant-id" value="">
                <input type="hidden" name="action_type" id="js-action-type" value="add_to_cart">

                <div class="d-flex align-items-center gap-3">
                    {{-- Quantity --}}
                    <div class="quantity d-flex align-items-center">
                        <span class="nova-minicart-qty-button decrease" id="js-qty-decrease">
                            <svg class="icon">
                                <use xlink:href="#mini-cart-delete"></use>
                            </svg>
                        </span>

                        <label class="screen-reader-text" for="js-quantity-input">
                            Số lượng
                        </label>

                        <input type="number"
                               id="js-quantity-input"
                               class="input-text qty text"
                               name="quantity"
                               value="1"
                               aria-label="Product quantity"
                               min="1"
                               max=""
                               step="1"
                               inputmode="numeric"
                               autocomplete="off" />

                        <span class="nova-minicart-qty-button increase" id="js-qty-increase">
                            <svg class="icon">
                                <use xlink:href="#mini-cart-add"></use>
                            </svg>
                        </span>
                    </div>

                    {{-- Nút hành động --}}
                    <button type="button"
                            class="single_add_to_cart_button button alt"
                            data-action-type="add_to_cart">
                        Thêm vào giỏ
                    </button>

                    <button type="button"
                            class="single_add_to_cart_button button btn-primary"
                            data-action-type="buy_now">
                        Mua ngay
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

                    <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:13:29 -->
                @endsection
<div class="tabs" id="panel_reviews">
    <div id="reviews" class="woocommerce-Reviews">
        <div id="comments">
            @if ($ratingCount > 0)
                <ol class="commentlist">
                    @foreach ($reviews as $review)
                        @php
                            $user   = optional(optional($review->order)->user);
                            $name   = $user->name ?? 'Khách ẩn danh';
                            $avatar = $user->image
                                ? asset('storage/' . $user->image)
                                : asset('assets/images/users/avatar-1.jpg'); // avatar mặc định
                            $ratingPercent = max(0, min(100, ($review->rating / 5) * 100));
                        @endphp

                        <li class="review even thread-even depth-1" id="li-comment-{{ $review->id }}">
                            <div id="comment-{{ $review->id }}" class="comment_container">
                                <img alt="{{ $name }}"
                                     src="{{ $avatar }}"
                                     class="avatar avatar-60 photo"
                                     height="60" width="60" />

                                <div class="comment-text">

                                    {{-- Sao đánh giá --}}
                                    <div class="star-rating" role="img"
                                         aria-label="Rated {{ $review->rating }} out of 5">
                                        <span style="width:{{ $ratingPercent }}%">
                                            Rated
                                            <strong class="rating">{{ $review->rating }}</strong>
                                            out of 5
                                        </span>
                                    </div>

                                    <p class="meta">
                                        <strong class="woocommerce-review__author">
                                            {{ $name }}
                                        </strong>
                                        <span class="woocommerce-review__dash">&ndash;</span>
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
