@extends('master')

@section('title', 'Danh sách sản phẩm')

@section('content')

<body
    class="archive post-type-archive post-type-archive-product wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-shop woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-mobile wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-342 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  shop-pagination-infinite_scroll shop-sidebar-active shop-sidebar-left blog-pagination-default kitify--enabled">
    <div class="site-wrapper">

        <div class="kitify-site-wrapper elementor-459kitify">
            @include('layouts.header')
            <div id="site-content" class="site-content-wrapper">
                <div data-elementor-type="product-archive" data-elementor-id="342"
                    class="elementor elementor-342 elementor-location-archive product">
                    <div class="elementor-element elementor-element-154c7994 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                        data-id="154c7994" data-element_type="container">
                        <div class="e-con-inner">
                            <div class="elementor-element elementor-element-48a016be kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                data-id="48a016be" data-element_type="widget"
                                data-widget_type="kitify-breadcrumbs.default">
                                <div class="elementor-widget-container">

                                    <div class="kitify-breadcrumbs">
                                        <h3 class="kitify-breadcrumbs__title">Shop</h3>
                                        <div class="kitify-breadcrumbs__content">
                                            <div class="kitify-breadcrumbs__wrap">
                                                <div class="kitify-breadcrumbs__item"><a href="../index.html"
                                                        class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                        title="Home">Home</a></div>
                                                <div class="kitify-breadcrumbs__item">
                                                    <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                </div>
                                                <div class="kitify-breadcrumbs__item"><span
                                                        class="kitify-breadcrumbs__item-target">Shop</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="elementor-element elementor-element-62eaf656 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                        data-id="62eaf656" data-element_type="container">
                        <div class="e-con-inner">
                            <div class="elementor-element elementor-element-36fb1d54 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="36fb1d54" data-element_type="container">
                                <div class="elementor-element elementor-element-21e8bcb4 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="21e8bcb4" data-element_type="container"
                                    data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:50,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
                                    <div class="e-con-inner">
                                        <div class="elementor-element elementor-element-71c3e12b elementor-widget kitify elementor-kitify-sidebar"
                                            data-id="71c3e12b" data-element_type="widget"
                                            data-widget_type="kitify-sidebar.default">
                                            <div class="elementor-widget-container">
                                                <div class="kitify-sidebar kitify-sidebar-layout_01 kitify-toggle-sidebar"
                                                    data-breakpoint="1024">
                                                    <div class="kitify-toggle-sidebar__overlay js-column-toggle"></div>
                                                    <div class="kitify-toggle-sidebar__container"><a
                                                            class="kitify-toggle-sidebar__toggle js-column-toggle"
                                                            href="javascript:void(0)"></a>
                                                        <div class="toggle-column-btn__wrap"><a
                                                                class="toggle-column-btn js-column-toggle"
                                                                href="javascript:void(0)"></a></div>
                                                        <div class="kitify-toggle-sidebar__inner nova_box_ps">
                                                            <aside id="novaapf-active-filters-2"
                                                                class="novaapf-widget-hidden woocommerce novaapf-ajax-term-filter widget widget_novaapf-active-filters">
                                                                <h4 class="widget-title">Active filters</h4>
                                                            </aside>
                                                            <aside id="novaapf-category-filter-2"
                                                                class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-category-filter">
                                                                <h4 class="widget-title">Product Categories</h4>
                                                                <div class="novaapf-layered-nav">
                                                                    <ul>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="44"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Bags</span></a><span
                                                                                class="count">(4)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="23"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Hoodies</span></a><span
                                                                                class="count">(5)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="40"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Jackets</span></a><span
                                                                                class="count">(25)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="33"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Men</span></a><span
                                                                                class="count">(23)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="43"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Sweatshirts</span></a><span
                                                                                class="count">(10)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="22"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Tshirts</span></a><span
                                                                                class="count">(15)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="product-cata" data-value="58"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Women</span></a><span
                                                                                class="count">(24)</span></li>
                                                                    </ul>
                                                                </div>
                                                            </aside>
                                                            <aside id="novaapf-price-filter-2"
                                                                class="woocommerce novaapf-price-filter-widget novaapf-ajax-term-filter widget widget_novaapf-price-filter">
                                                                <h4 class="widget-title">Price</h4>
                                                                <div class="novaapf-layered-nav">
                                                                    <ul>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="50"
                                                                                data-key-max="max-price"
                                                                                data-value-max="100"><span
                                                                                    class="min">&#36;50</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;100</span></a></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="100"
                                                                                data-key-max="max-price"
                                                                                data-value-max="150"><span
                                                                                    class="min">&#36;100</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;150</span></a></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="150"
                                                                                data-key-max="max-price"
                                                                                data-value-max="200"><span
                                                                                    class="min">&#36;150</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;200</span></a></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="200"
                                                                                data-key-max="max-price"
                                                                                data-value-max="250"><span
                                                                                    class="min">&#36;200</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;250</span></a></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="250"
                                                                                data-key-max="max-price"
                                                                                data-value-max="300"><span
                                                                                    class="min">&#36;250</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;300</span></a></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key-min="min-price"
                                                                                data-value-min="1"
                                                                                data-key-max="max-price"
                                                                                data-value-max="50"><span
                                                                                    class="min">&#36;1</span> <span
                                                                                    class="to"> - </span> <span
                                                                                    class="max">&#36;50</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </aside>
                                                            <aside id="novaapf-attribute-filter-2"
                                                                class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                                                <h4 class="widget-title">Color</h4>
                                                                <div class="novaapf-layered-nav et-list-novaapf">
                                                                    <ul>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-color" data-value="16"
                                                                                data-multiple-filter=""
                                                                                class="et-color-swatch"><span
                                                                                    class="et-swatch-circle"><span
                                                                                        style="background-color:#1e73be"></span></span><span
                                                                                    class="name">Blue</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-color" data-value="24"
                                                                                data-multiple-filter=""
                                                                                class="et-color-swatch"><span
                                                                                    class="et-swatch-circle"><span
                                                                                        style="background-color:#9e9e9e"></span></span><span
                                                                                    class="name">Gray</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-color" data-value="17"
                                                                                data-multiple-filter=""
                                                                                class="et-color-swatch"><span
                                                                                    class="et-swatch-circle"><span
                                                                                        style="background-color:#6ba031"></span></span><span
                                                                                    class="name">Green</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-color" data-value="20"
                                                                                data-multiple-filter=""
                                                                                class="et-color-swatch"><span
                                                                                    class="et-swatch-circle"><span
                                                                                        style="background-color:#dd3333"></span></span><span
                                                                                    class="name">Red</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-color" data-value="26"
                                                                                data-multiple-filter=""
                                                                                class="et-color-swatch"><span
                                                                                    class="et-swatch-circle"><span
                                                                                        style="background-color:#efd421"></span></span><span
                                                                                    class="name">Yellow</span></a><span
                                                                                class="count">(46)</span></li>
                                                                    </ul>
                                                                </div>
                                                            </aside>
                                                            <aside id="novaapf-attribute-filter-3"
                                                                class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                                                <h4 class="widget-title">Size</h4>
                                                                <div class="novaapf-layered-nav et-list-novaapf">
                                                                    <ul>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-size" data-value="18"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Large</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-size" data-value="19"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Medium</span></a><span
                                                                                class="count">(46)</span></li>
                                                                        <li><a href="javascript:void(0)"
                                                                                data-key="attra-size" data-value="21"
                                                                                data-multiple-filter="" class=""><span
                                                                                    class="name">Small</span></a><span
                                                                                class="count">(46)</span></li>
                                                                    </ul>
                                                                </div>
                                                            </aside>
                                                            <aside id="woocommerce_product_tag_cloud-2"
                                                                class="widget woocommerce widget_product_tag_cloud">
                                                                <h4 class="widget-title">Tags</h4>
                                                                <div class="tagcloud"><a
                                                                        href="../product-tag/clothing/index.html"
                                                                        class="tag-cloud-link tag-link-38 tag-link-position-1"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="clothing (47 products)">clothing</a>
                                                                    <a href="../product-tag/etc/index.html"
                                                                        class="tag-cloud-link tag-link-39 tag-link-position-2"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="etc (47 products)">etc</a>
                                                                    <a href="../product-tag/fashion/index.html"
                                                                        class="tag-cloud-link tag-link-37 tag-link-position-3"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="fashion (47 products)">fashion</a>
                                                                    <a href="../product-tag/m11/index.html"
                                                                        class="tag-cloud-link tag-link-34 tag-link-position-4"
                                                                        style="font-size: 11.5pt;"
                                                                        aria-label="m11 (5 products)">m11</a>
                                                                    <a href="../product-tag/m12/index.html"
                                                                        class="tag-cloud-link tag-link-42 tag-link-position-5"
                                                                        style="font-size: 13.483333333333pt;"
                                                                        aria-label="m12 (8 products)">m12</a>
                                                                    <a href="../product-tag/m31/index.html"
                                                                        class="tag-cloud-link tag-link-60 tag-link-position-6"
                                                                        style="font-size: 10.566666666667pt;"
                                                                        aria-label="m31 (4 products)">m31</a>
                                                                    <a href="../product-tag/m32/index.html"
                                                                        class="tag-cloud-link tag-link-61 tag-link-position-7"
                                                                        style="font-size: 13.483333333333pt;"
                                                                        aria-label="m32 (8 products)">m32</a>
                                                                    <a href="../product-tag/m41/index.html"
                                                                        class="tag-cloud-link tag-link-64 tag-link-position-8"
                                                                        style="font-size: 13.483333333333pt;"
                                                                        aria-label="m41 (8 products)">m41</a>
                                                                    <a href="../product-tag/m71/index.html"
                                                                        class="tag-cloud-link tag-link-67 tag-link-position-9"
                                                                        style="font-size: 13.483333333333pt;"
                                                                        aria-label="m71 (8 products)">m71</a>
                                                                    <a href="../product-tag/m72/index.html"
                                                                        class="tag-cloud-link tag-link-68 tag-link-position-10"
                                                                        style="font-size: 8pt;"
                                                                        aria-label="m72 (2 products)">m72</a>
                                                                    <a href="../product-tag/m81/index.html"
                                                                        class="tag-cloud-link tag-link-69 tag-link-position-11"
                                                                        style="font-size: 13.483333333333pt;"
                                                                        aria-label="m81 (8 products)">m81</a>
                                                                    <a href="../product-tag/men/index.html"
                                                                        class="tag-cloud-link tag-link-35 tag-link-position-12"
                                                                        style="font-size: 18.5pt;"
                                                                        aria-label="men (23 products)">men</a>
                                                                    <a href="../product-tag/products/index.html"
                                                                        class="tag-cloud-link tag-link-36 tag-link-position-13"
                                                                        style="font-size: 22pt;"
                                                                        aria-label="products (47 products)">products</a>
                                                                    <a href="../product-tag/women/index.html"
                                                                        class="tag-cloud-link tag-link-59 tag-link-position-14"
                                                                        style="font-size: 18.733333333333pt;"
                                                                        aria-label="women (24 products)">women</a>
                                                                </div>
                                                            </aside>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="elementor-element elementor-element-55be2b48 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                data-id="55be2b48" data-element_type="container">
                                <div class="elementor-element elementor-element-3d2f7267 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="3d2f7267" data-element_type="widget"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div
                                            class="woocommerce  kitify_wc_widget_3d2f7267_0 kitify_wc_widget_current_query">
                                            <div class="novaapf-before-products">
                                                <div class="woocommerce-notices-wrapper"></div>
                                                <div class="shop_header_placeholder kitify-active">
                                                    <header class="woocommerce-archive-header">
                                                        <div class="woocommerce-archive-header-inside">
                                                            <p class="woocommerce-result-count">
                                                                Showing 1&ndash;12 of 47 results</p>
                                                            <div class="woocommerce-archive-toolbar sh--color">
                                                                <div class="nova-product-filter" data-breakpoint="1024">
                                                                    <button class="js-column-toggle"><span
                                                                            class="icon-filter"><i
                                                                                class="inova ic-options"></i></span><span
                                                                            class="title-filter">Filters</span></button>
                                                                </div>
                                                                <div class="nova-custom-view"><label>Show</label>
                                                                    <ul>
                                                                        <li class="active"><a
                                                                                href="index1c07.html?per_page=12">12</a>
                                                                        </li>
                                                                        <li><a href="indexadcc.html?per_page=15">15</a>
                                                                        </li>
                                                                        <li><a href="index779c.html?per_page=30">30</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <form class="woocommerce-ordering" method="get">
                                                                    <select name="orderby" class="orderby"
                                                                        aria-label="Shop order">
                                                                        <option value="menu_order" selected='selected'>
                                                                            Default sorting</option>
                                                                        <option value="popularity">Sort by popularity
                                                                        </option>
                                                                        <option value="rating">Sort by average rating
                                                                        </option>
                                                                        <option value="date">Sort by latest</option>
                                                                        <option value="price">Sort by price: low to high
                                                                        </option>
                                                                        <option value="price-desc">Sort by price: high
                                                                            to low</option>
                                                                    </select>
                                                                    <input type="hidden" name="paged" value="1" />
                                                                </form>
                                                                <div class="shop-display-type">
                                                                    <span class="shop-display-grid active">
                                                                        <svg class="mixtas-grid-icon">
                                                                            <use xlink:href="#mixtas-grid"></use>
                                                                        </svg>
                                                                    </span>
                                                                    <span class="shop-display-list">
                                                                        <svg class="mixtas-list-icon">
                                                                            <use xlink:href="#mixtas-list"></use>
                                                                        </svg>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </header>
                                                </div>
                                                <div class="kitify-products" data-widget_current_query="yes">
                                                    <div class="kitify-products__list_wrapper">
                                                        <ul
                                                            class="products ul_products kitify-products__list products-grid products-grid-1 col-row columns-3">


                                                            <li
                                                                class="product_item product-grid-item product type-product post-1558 status-publish first instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/adidas-x-pop-beckenbauer-track-jacket/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index942b.html?add_to_wishlist=1558"
                                                                                data-product-id="1558"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="1558" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/adidas-x-pop-beckenbauer-track-jacket/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1558"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;adidas X Pop Beckenbauer Track Jacket&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1558"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/adidas-x-pop-beckenbauer-track-jacket/index.html">
                                                                                <img fetchpriority="high" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_03_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/adidas-x-pop-beckenbauer-track-jacket/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        adidas X Pop Beckenbauer Track
                                                                                        Jacket</h3>
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
                                                                class="product_item product-grid-item product type-product post-1560 status-publish instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/adidas-x-pop-classic-t-shirt-grey-navy/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index6c07.html?add_to_wishlist=1560"
                                                                                data-product-id="1560"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="1560" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/adidas-x-pop-classic-t-shirt-grey-navy/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1560"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;adidas X Pop Classic t-shirt, grey / navy&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1560"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/adidas-x-pop-classic-t-shirt-grey-navy/index.html">
                                                                                <img width="700" height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_04_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/adidas-x-pop-classic-t-shirt-grey-navy/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        adidas X Pop Classic t-shirt,
                                                                                        grey / navy</h3>
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
                                                                class="product_item product-grid-item product type-product post-1554 status-publish last instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/adidas-x-pop-polo-shirt-navy-blue/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index05dd.html?add_to_wishlist=1554"
                                                                                data-product-id="1554"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="1554" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/adidas-x-pop-polo-shirt-navy-blue/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1554"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;adidas X Pop Polo shirt, navy / blue&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1554"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/adidas-x-pop-polo-shirt-navy-blue/index.html">
                                                                                <img width="700" height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_01_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/adidas-x-pop-polo-shirt-navy-blue/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        adidas X Pop Polo shirt, navy /
                                                                                        blue</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>69.99</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-1562 status-publish first instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/adidas-x-pop-sl-cap-navy-white/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index71bb.html?add_to_wishlist=1562"
                                                                                data-product-id="1562"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="1562" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/adidas-x-pop-sl-cap-navy-white/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1562"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;adidas X Pop SL Cap, navy / white&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1562"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/adidas-x-pop-sl-cap-navy-white/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_05_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/adidas-x-pop-sl-cap-navy-white/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        adidas X Pop SL Cap, navy /
                                                                                        white</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>55.00</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-1556 status-publish instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/adidas-x-pop-trx-vintage-navy-white/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index9a70.html?add_to_wishlist=1556"
                                                                                data-product-id="1556"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="1556" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/adidas-x-pop-trx-vintage-navy-white/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1556"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;adidas x Pop TRX Vintage, navy / white&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1556"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/adidas-x-pop-trx-vintage-navy-white/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_02_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/adidas-x-pop-trx-vintage-navy-white/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        adidas x Pop TRX Vintage, navy /
                                                                                        white</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>69.99</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-830 status-publish last instock product_cat-jackets product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m32 product_tag-products product_tag-women has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/bear-graphic-t-shirt/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index4a13.html?add_to_wishlist=830"
                                                                                data-product-id="830"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="830" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/bear-graphic-t-shirt/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="830"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Bear graphic T-shirt&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_830"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/bear-graphic-t-shirt/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m3_09_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/bear-graphic-t-shirt/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Bear graphic T-shirt</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>29.90</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-1564 status-publish first instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/butter-yard-pullover-hood-denim/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="indexab04.html?add_to_wishlist=1564"
                                                                                data-product-id="1564"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                href="../product/butter-yard-pullover-hood-denim/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1564"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Butter Yard Pullover Hood, denim&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1564"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/butter-yard-pullover-hood-denim/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m10_06_1-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/butter-yard-pullover-hood-denim/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Butter Yard Pullover Hood, denim
                                                                                    </h3>
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
                                                                class="product_item product-grid-item product type-product post-1487 status-publish instock product_cat-sweatshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m71 product_tag-products product_tag-women has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/button-knit-cardigan/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="indexf7dc.html?add_to_wishlist=1487"
                                                                                data-product-id="1487"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                href="../product/button-knit-cardigan/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="1487"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Button knit cardigan&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_1487"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/button-knit-cardigan/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2024/01/m09_02_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/sweatshirts/index.html"
                                                                                        rel="tag">Sweatshirts</a></div>
                                                                                <a href="../product/button-knit-cardigan/index.html"
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
                                                                class="product_item product-grid-item product type-product post-164 status-publish last instock product_cat-men product_cat-sweatshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m12 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/carhartt-american-script-sweat-tobacco/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index3d49.html?add_to_wishlist=164"
                                                                                data-product-id="164"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="164" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/carhartt-american-script-sweat-tobacco/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="164"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Carhartt American Script Sweat, tobacco&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_164"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/carhartt-american-script-sweat-tobacco/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_09_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/men/index.html"
                                                                                        rel="tag">Men</a></div> <a
                                                                                    href="../product/carhartt-american-script-sweat-tobacco/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Carhartt American Script Sweat,
                                                                                        tobacco</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>100.00</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-124 status-publish first instock product_cat-jackets product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m11 product_tag-men product_tag-products has-post-thumbnail sale shipping-taxable purchasable product-type-simple kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">

                                                                        <span class="onsale">Sale!</span>
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/carhartt-detroit-jacket-summer-zeus-rigid/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="indexec0f.html?add_to_wishlist=124"
                                                                                data-product-id="124"
                                                                                data-product-type="simple"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="124" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="indexf8f4.html?add-to-cart=124"
                                                                                data-quantity="1"
                                                                                class="button product_type_simple add_to_cart_button ajax_add_to_cart"
                                                                                data-product_id="124"
                                                                                data-product_sku=""
                                                                                aria-label="Add to cart: &ldquo;Carhartt Detroit Jacket (summer), zeus rigid&rdquo;"
                                                                                rel="nofollow"
                                                                                data-success_message="&ldquo;Carhartt Detroit Jacket (summer), zeus rigid&rdquo; has been added to your cart"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Add to
                                                                                    cart</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_124"
                                                                                class="screen-reader-text">
                                                                            </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/carhartt-detroit-jacket-summer-zeus-rigid/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_01_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/carhartt-detroit-jacket-summer-zeus-rigid/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Carhartt Detroit Jacket
                                                                                        (summer), zeus rigid</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><del
                                                                                        aria-hidden="true"><span
                                                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>195.00</bdi></span></del>
                                                                                    <span
                                                                                        class="screen-reader-text">Original
                                                                                        price was:
                                                                                        &#036;195.00.</span><ins
                                                                                        aria-hidden="true"><span
                                                                                            class="woocommerce-Price-amount amount"><bdi><span
                                                                                                    class="woocommerce-Price-currencySymbol">&#36;</span>165.00</bdi></span></ins><span
                                                                                        class="screen-reader-text">Current
                                                                                        price is:
                                                                                        &#036;165.00.</span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-166 status-publish instock product_cat-bags product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m12 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/carhartt-essentials-bag-small-highland/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="indexb128.html?add_to_wishlist=166"
                                                                                data-product-id="166"
                                                                                data-product-type="variable"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                data-product-id="166" rel="nofollow"><i
                                                                                    class="inova ic-zoom"></i></a><a
                                                                                href="../product/carhartt-essentials-bag-small-highland/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_variable add_to_cart_button"
                                                                                data-product_id="166"
                                                                                data-product_sku=""
                                                                                aria-label="Select options for &ldquo;Carhartt Essentials Bag (small), highland&rdquo;"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
                                                                                    <use xlink:href="#mixtas-addtocart"
                                                                                        xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                    </use>
                                                                                </svg><span class="text">Select
                                                                                    options</span></a> <span
                                                                                id="woocommerce_loop_add_to_cart_link_describedby_166"
                                                                                class="screen-reader-text">
                                                                                This product has multiple variants. The
                                                                                options may be chosen on the product
                                                                                page </span>
                                                                        </div>


                                                                        <div
                                                                            class="product-item__thumbnail-placeholder second_image_enabled">
                                                                            <a
                                                                                href="../product/carhartt-essentials-bag-small-highland/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_10_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/bags/index.html"
                                                                                        rel="tag">Bags</a></div> <a
                                                                                    href="../product/carhartt-essentials-bag-small-highland/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Carhartt Essentials Bag (small),
                                                                                        highland</h3>
                                                                                </a>
                                                                            </div>
                                                                            <div class="info-right">

                                                                                <span class="price"><span
                                                                                        class="woocommerce-Price-amount amount"><bdi><span
                                                                                                class="woocommerce-Price-currencySymbol">&#36;</span>55.00</bdi></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                            </li>


                                                            <li
                                                                class="product_item product-grid-item product type-product post-156 status-publish last instock product_cat-jackets product_cat-men product_tag-clothing product_tag-etc product_tag-fashion product_tag-m11 product_tag-men product_tag-products has-post-thumbnail sale shipping-taxable product-type-grouped kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">


                                                                <div class="product-item">
                                                                    <div class="product-item__badges">

                                                                        <span class="onsale">Sale!</span>
                                                                    </div>
                                                                    <div class="product-item__thumbnail">
                                                                        <div class="product-item__thumbnail_overlay">
                                                                        </div>
                                                                        <a class="product-item-link"
                                                                            href="../product/carhartt-hooded-coach-jacket-cypress/index.html"></a>
                                                                        <div
                                                                            class="product-item__description--top-actions">

                                                                            <a href="index17e9.html?add_to_wishlist=156"
                                                                                data-product-id="156"
                                                                                data-product-type="grouped"
                                                                                data-wishlist-url="../wishlist/index.html"
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
                                                                                href="../product/carhartt-hooded-coach-jacket-cypress/index.html"
                                                                                data-quantity="1"
                                                                                class="button product_type_grouped"
                                                                                data-product_id="156"
                                                                                data-product_sku=""
                                                                                aria-label="View products in the &ldquo;Carhartt Hooded Coach jacket, cypress&rdquo; group"
                                                                                rel="nofollow"><svg
                                                                                    class="mixtas-addtocart">
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
                                                                                href="../product/carhartt-hooded-coach-jacket-cypress/index.html">
                                                                                <img loading="lazy" width="700"
                                                                                    height="700"
                                                                                    src="../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-700x700.jpg"
                                                                                    class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                    alt="" decoding="async"
                                                                                    srcset="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-700x700.jpg 700w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-300x300.jpg 300w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-150x150.jpg 150w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-768x768.jpg 768w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-250x250.jpg 250w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-50x50.jpg 50w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1-100x100.jpg 100w, https://mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_1.jpg 1000w"
                                                                                    sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                    class="product_second_image"
                                                                                    style="background-image: url('../../mixtas.b-cdn.net/wp-content/uploads/2023/12/m1_04_2-700x700.jpg')"></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="product-item__description">

                                                                        <div class="product-item__description--info">
                                                                            <div class="info-left">
                                                                                <div class="product-item__category"><a
                                                                                        class="content-product-cat"
                                                                                        href="../product-category/jackets/index.html"
                                                                                        rel="tag">Jackets</a></div> <a
                                                                                    href="../product/carhartt-hooded-coach-jacket-cypress/index.html"
                                                                                    class="title">
                                                                                    <h3
                                                                                        class="woocommerce-loop-product__title">
                                                                                        Carhartt Hooded Coach jacket,
                                                                                        cypress</h3>
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
                                                        </ul>
                                                    </div>
                                                </div>
                                                <nav class="woocommerce-pagination kitify-pagination clearfix kitify-ajax-pagination"
                                                    aria-label="Product Pagination">
                                                    <ul class='page-numbers'>
                                                        <li><span aria-label="Page 1" aria-current="page"
                                                                class="page-numbers current">1</span></li>
                                                        <li><a aria-label="Page 2" class="page-numbers"
                                                                href="page/2/index.html">2</a></li>
                                                        <li><a aria-label="Page 3" class="page-numbers"
                                                                href="page/3/index.html">3</a></li>
                                                        <li><a aria-label="Page 4" class="page-numbers"
                                                                href="page/4/index.html">4</a></li>
                                                        <li><a class="next page-numbers"
                                                                href="page/2/index.html">Next</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- .site-content-wrapper -->
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
                                        <a href="../index.html" class="kitify-logo__link"><img loading="lazy"
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
                                            <a href="../order-tracking/index.html">

                                                <span class="elementor-icon-list-text">Our Story</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../cart/index.html">

                                                <span class="elementor-icon-list-text">Mission & Values</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Meet the Team</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Sustainability Efforts</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../faqs/index.html">

                                                <span class="elementor-icon-list-text">Brand Partnerships</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../faqs/index.html">

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
                                            <a href="../my-account/index.html">

                                                <span class="elementor-icon-list-text">Accessibility Statement</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../cart/index.html">

                                                <span class="elementor-icon-list-text">Site Map</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Web Accessibility Options</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">ADA Compliance</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Privacy Policy</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

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
                                            <a href="../about-us/index.html">

                                                <span class="elementor-icon-list-text">VIP Membership</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../cart/index.html">

                                                <span class="elementor-icon-list-text">Loyalty Program</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Customer Reviews</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Style Forums</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

                                                <span class="elementor-icon-list-text">Job Openings</span>
                                            </a>
                                        </li>
                                        <li class="elementor-icon-list-item">
                                            <a href="../wishlist/index.html">

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
                <div class="elementor-element elementor-element-54567fd e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                    data-id="54567fd" data-element_type="container"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <div class="e-con-inner">
                        <div class="elementor-element elementor-element-32ef9720 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="32ef9720" data-element_type="container">
                            <div class="elementor-element elementor-element-55712cf9 elementor-widget elementor-widget-heading"
                                data-id="55712cf9" data-element_type="widget" data-widget_type="heading.default">
                                <div class="elementor-widget-container">
                                    <span class="elementor-heading-title elementor-size-default">© 2024 Mixtas All
                                        rights reserved. Designed by Novaworks</span>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-ba77c84 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                            data-id="ba77c84" data-element_type="container">
                            <div class="elementor-element elementor-element-3f8296cb elementor-widget elementor-widget-image"
                                data-id="3f8296cb" data-element_type="widget" data-widget_type="image.default">
                                <div class="elementor-widget-container">
                                    <img loading="lazy" width="192" height="14"
                                        src="https://mixtas.b-cdn.net/wp-content/uploads/2023/12/payment_icon.svg"
                                        class="attachment-large size-large wp-image-477" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-content styling__quickview" id="nova_wc_quickview">
                <div class="nova_wc_quickview__content site-content"></div>
            </div>
        </div><!-- .site-wrapper -->
        <!-- .site-search -->
        <div class="off-canvas-wrapper">
            <div class="site-canvas-menu off-canvas position-left" id="MenuOffCanvas_3726810d" data-off-canvas
                data-transition="overlap">
                <div class="row has-scrollbar">
                    <div class="header-mobiles-primary-menu">
                        <ul id="menu-main-menu-1" class="vertical menu drilldown mobile-menu" data-drilldown
                            data-back-button="<li class='js-drilldown-back'><a class='js_mobile_menu_back'></a></li>"
                            data-auto-height="true" data-animate-height="true">
                            <li
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-has-children menu-item-766">
                                <a href="../index.html"><span>Home</span></a>
                                <ul class="menu vertical nested">
                                    <li
                                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-1645">
                                        <a href="../index.html"><span>Home v1 — ChicCanvas</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-941">
                                        <a href="../home-v2/index.html"><span>Home v2 — VogueVibes</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1112">
                                        <a href="../home-v3/index.html"><span>Home v3 — ModaMatrix</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1176">
                                        <a href="../home-v4/index.html"><span>Home v4 — StyleSymphony</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1316">
                                        <a href="../home-v5/index.html"><span>Home v5 — TrendTapestry</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1368">
                                        <a href="../home-v6/index.html"><span>Home v6 — HauteHarmony</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1551">
                                        <a href="../home-v7/index.html"><span>Home v7 — EleganceEnclave</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1604">
                                        <a href="../home-v8/index.html"><span>Home v8 — CoutureCanvas</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1641">
                                        <a href="../home-v9/index.html"><span>Home v9 — UrbanUtopia</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1644">
                                        <a href="../home-v10/index.html"><span>Home v10 — SilkSculpt</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children current-menu-item current_page_item menu-item-79">
                                <a href="index.html" aria-current="page"><span>Shop</span></a>
                                <ul class="menu vertical nested">
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-358">
                                        <a href="#"><span>Shop Pages</span></a>
                                        <ul class="menu vertical nested">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item current_page_item menu-item-360">
                                                <a href="index.html" aria-current="page"><span>Shop — Left
                                                        Sidebar</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-359">
                                                <a href="indexac59.html?theme_template_id=353"><span>Shop — Right
                                                        Sidebar</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-368">
                                                <a href="indexc1c5.html?theme_template_id=363"><span>Shop —
                                                        Fullwidth</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-375">
                                                <a href="index9a6d.html?theme_template_id=371"><span>Shop — No
                                                        Sidebar</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-382">
                                                <a href="index2568.html?theme_template_id=376"><span>Shop — 2
                                                        Columns</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-408">
                                        <a href="#"><span>Product Layouts</span></a>
                                        <ul class="menu vertical nested">
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-409">
                                                <a href="../product/carhartt-american-script-sweat-tobacco/index.html"><span>Product
                                                        — Layout v1</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-414">
                                                <a
                                                    href="../product/carhartt-american-script-sweat-tobacco/indexfab5.html?theme_template_id=410"><span>Product
                                                        — Layout v2</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-421">
                                                <a
                                                    href="../product/carhartt-american-script-sweat-tobacco/index01cf.html?theme_template_id=417"><span>Product
                                                        — Layout v3</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-426">
                                                <a
                                                    href="../product/carhartt-american-script-sweat-tobacco/index27db.html?theme_template_id=422"><span>Product
                                                        — Layout v4</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-435">
                                                <a
                                                    href="../product/carhartt-american-script-sweat-tobacco/index978a.html?theme_template_id=430"><span>Product
                                                        — Layout v5</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-436">
                                        <a href="#"><span>Product Pages</span></a>
                                        <ul class="menu vertical nested">
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-437">
                                                <a
                                                    href="../product/carhartt-detroit-jacket-summer-zeus-rigid/index.html"><span>Product
                                                        — Simple</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-438">
                                                <a
                                                    href="../product/the-north-face-denali-jacket-summit-gold/index.html"><span>Product
                                                        — Variable</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-439">
                                                <a href="../product/carhartt-hooded-coach-jacket-cypress/index.html"><span>Product
                                                        — Grouped</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-440">
                                                <a
                                                    href="../product/carhartt-windbreaker-pullover-winter-black/index.html"><span>Product
                                                        — External / Affiliate</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-441">
                                                <a
                                                    href="../product/polar-welcome-to-the-new-age-ls-tee-black/index.html"><span>Product
                                                        — Out of Stock</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-442">
                                        <a href="#"><span>Core Pages</span></a>
                                        <ul class="menu vertical nested">
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445">
                                                <a href="../my-account/index.html"><span>My account</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-447">
                                                <a href="../cart/index.html"><span>Shopping Cart</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-446">
                                                <a href="../checkout/index.html"><span>Checkout</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-443">
                                                <a href="../order-tracking/index.html"><span>Order Tracking</span></a>
                                            </li>
                                            <li
                                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-444">
                                                <a href="../wishlist/index.html"><span>Wishlist</span></a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-80">
                                <a href="#"><span>Pages</span></a>
                                <ul class="menu vertical nested">
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-83"><a
                                            href="../about-us/index.html"><span>About Us</span></a></li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-81"><a
                                            href="../faqs/index.html"><span>FAQs</span></a></li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-82"><a
                                            href="../order-tracking/index.html"><span>Order Tracking</span></a></li>
                                </ul>
                            </li>
                            <li
                                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-77">
                                <a href="../blog/index.html"><span>Blog</span></a>
                                <ul class="menu vertical nested">
                                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-644">
                                        <a href="../blog/index.html"><span>Blog — Style 01</span></a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-643"><a
                                            href="../blog/indexc144.html?theme_template_id=637"><span>Blog — Style
                                                02</span></a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-652"><a
                                            href="../blog/index0f67.html?theme_template_id=646"><span>Blog — Style
                                                03</span></a></li>
                                    <li class="menu-item menu-item-type-post_type menu-item-object-post menu-item-645">
                                        <a
                                            href="../2023/12/gentlemans-gazette-a-guide-to-timeless-mens-fashion/index.html"><span>Blog
                                                — Single</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-84"><a
                                    href="../contact-us/index.html"><span>Contact Us</span></a></li>
                        </ul> <button class="close-button" aria-label="Close menu" type="button" data-close>
                            <svg class="nova-close-canvas">
                                <use xlink:href="#nova-close-canvas"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div id="headerSearchModal" class="full-search-reveal">
                <button id="btn-close-search-modal" class="close-button close-headerSearchModal" aria-label="Close menu"
                    type="button" data-close>
                    <svg class="nova-close-canvas">
                        <use xlink:href="#nova-close-canvas"></use>
                    </svg>
                </button>
                <div class="site-search full-screen">
                    <div class="header-search">


                        <form class="header_search_form" role="search" method="get"
                            action="https://mixtas.novaworks.net/">
                            <div class="header_search_form_inner">
                                <div class="header_search_input_wrapper">
                                    <input name="s" id="search_750" class="header_search_input" type="search"
                                        autocomplete="off" value="" data-min-chars="3" placeholder="Product Search" />

                                    <input type="hidden" name="post_type" value="product" />
                                </div>
                                <div class="header_search_button_wrapper">
                                    <button class="header_search_button" type="submit">
                                        <svg class="mixtas-btn-search">
                                            <use xlink:href="#mixtas-btn-search"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="header_search_ajax_loading">
                                <span></span>
                            </div>
                            <div class="header_search_ajax_results_wrapper">
                                <div class="header_search_ajax_results">
                                    <div class="header_search_icon">
                                        <svg class="mixtas-search-product-icon">
                                            <use xlink:href="#mixtas-search-product-icon"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="kitify-offcanvas minicart-canvas site-canvas-menu off-canvas position-right"
                id="MiniCartCanvas_4cfba4d5" data-off-canvas data-transition="overlap">
                <h2 class="title">Shopping Cart<span class="nova_js_count_bag_item_canvas count-item-canvas">0</span>
                </h2>
                <div class="add_ajax_loading">
                    <span></span>
                </div>
                <div class="widget woocommerce widget_shopping_cart">
                    <h2 class="widgettitle">Cart</h2>
                    <div class="widget_shopping_cart_content"></div>
                </div> <button class="close-button" aria-label="Close menu" type="button" data-close>
                    <svg class="nova-close-canvas">
                        <use xlink:href="#nova-close-canvas"></use>
                    </svg>
                </button>
            </div>
        </div>
        <div id="svg-defs" class="svg-defs hide">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <symbol id="mixtas-burger-menu" fill="none" viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M0 0h22v2H0zM0 7h10v2H0zM0 14h16v2H0z" />
                    </symbol>
                    <symbol id="mixtas-search" fill="none" viewBox="0 0 19 20">
                        <path d="M18.0211 18.4375L12.8824 13.2988" stroke="currentColor" stroke-width="1.2"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M8.02112 15.3125C11.8181 15.3125 14.8961 12.2345 14.8961 8.4375C14.8961 4.64054 11.8181 1.5625 8.02112 1.5625C4.22416 1.5625 1.14612 4.64054 1.14612 8.4375C1.14612 12.2345 4.22416 15.3125 8.02112 15.3125Z"
                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </symbol>
                    <symbol id="mixtas-bag" fill="none" viewBox="0 0 18 21" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3.50856 19.6429H13.6343C15.4114 19.6429 16.8571 18.1972 16.8571 16.42V6.78573C16.8571 6.47144 16.6 6.2143 16.2857 6.2143H12.8571V5.35716C12.8571 2.9943 10.9343 1.07144 8.57142 1.07144C6.20856 1.07144 4.2857 2.9943 4.2857 5.35716V6.2143H0.857134C0.542848 6.2143 0.285706 6.47144 0.285706 6.78573V16.42C0.285706 18.1972 1.73142 19.6429 3.50856 19.6429ZM5.42856 5.35716C5.42856 3.62287 6.83713 2.2143 8.57142 2.2143C10.3057 2.2143 11.7143 3.62287 11.7143 5.35716V6.2143H5.42856V5.35716ZM1.42856 7.35716H4.2857V8.78573C4.2857 9.10001 4.54285 9.35716 4.85713 9.35716C5.17142 9.35716 5.42856 9.10001 5.42856 8.78573V7.35716H11.7143V8.78573C11.7143 9.10001 11.9714 9.35716 12.2857 9.35716C12.6 9.35716 12.8571 9.10001 12.8571 8.78573V7.35716H15.7143V16.42C15.7143 17.5657 14.78 18.5 13.6343 18.5H3.50856C2.36285 18.5 1.42856 17.5657 1.42856 16.42V7.35716Z"
                            fill="currentColor"></path>
                    </symbol>
                    <symbol fill="none" id="mixtas-wishlist" viewBox="0 0 20 18" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M4.10276 0.535722C1.83186 1.44929 -0.014983 3.82623 0.26654 7.33722C0.477821 9.97215 1.93049 12.1153 3.64664 13.7278C5.36367 15.3411 7.39577 16.4739 8.89721 17.0966C9.41075 17.3094 9.98779 17.3218 10.512 17.1222C12.0881 16.5221 14.1129 15.3949 15.8125 13.7748C17.5105 12.1562 18.9254 10.004 19.1783 7.35969C19.6544 3.79445 17.7508 1.42311 15.4153 0.528745C13.4653 -0.218011 11.0862 0.0495936 9.7063 1.64133C8.31911 0.037531 6.02213 -0.236441 4.10276 0.535722ZM4.59785 1.76639C6.37434 1.05172 8.28816 1.53022 9.1221 3.13029C9.23724 3.35128 9.46656 3.48906 9.71577 3.48697C9.96498 3.4849 10.192 3.3433 10.3035 3.12042C11.0791 1.56961 13.0744 1.05272 14.941 1.76755C16.7373 2.45542 18.2576 4.26655 17.8619 7.19546C17.8607 7.20431 17.8596 7.21324 17.8588 7.22208C17.6487 9.45569 16.4499 11.3346 14.8972 12.8146C13.3432 14.2958 11.4761 15.3357 10.0401 15.8825C9.8371 15.9597 9.61062 15.9563 9.40536 15.8712C8.01666 15.2953 6.13049 14.2415 4.55499 12.761C2.9786 11.2799 1.76454 9.42244 1.58883 7.23119C1.35374 4.29929 2.86493 2.46355 4.59785 1.76639Z"
                            fill="currentColor"></path>
                    </symbol>
                    <symbol id="mixtas-menu-user" fill="none" viewBox="0 0 20 21" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_15_749)">
                            <path
                                d="M0.833313 19.6667C0.833313 15.0642 4.56415 11.3333 9.16665 11.3333H10.8333C15.4358 11.3333 19.1666 15.0642 19.1666 19.6667"
                                stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M10 11.3333C12.7614 11.3333 15 9.09477 15 6.33334C15 3.57192 12.7614 1.33334 10 1.33334C7.23858 1.33334 5 3.57192 5 6.33334C5 9.09477 7.23858 11.3333 10 11.3333Z"
                                stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                    </symbol>
                    <symbol id="mixtas-shopbycat" viewBox="0 0 27 14">
                        <g fill="currentColor" fill-rule="evenodd">
                            <path
                                d="M26.085 1.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 4.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 7.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M26.085 10.342H1.135c-.314 0-.568-.225-.568-.5 0-.278.254-.501.567-.501h24.951c.313 0 .567.223.567.501 0 .275-.254.5-.567.5M14.744 13.342H1.134c-.313 0-.567-.225-.567-.5 0-.278.254-.501.567-.501h13.61c.313 0 .567.223.567.501 0 .275-.254.5-.567.5" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-addtocart" viewBox="0 0 14 16" fill="none">
                        <path d="M7.6 14.6H1V4.40002H11.8V8.60002" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path
                            d="M4 6.20002V3.80002C4 2.47462 5.0746 1.40002 6.4 1.40002C7.7254 1.40002 8.8 2.47462 8.8 3.80002V6.20002"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M11.2 11V14.6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                        <path d="M9.39996 12.8H13" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </symbol>
                    <symbol id="mixtas-mc-fb" viewBox="0 0 26 26">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M-2-2h30v30H-2z" />
                            <path
                                d="M15.1 11.75h-1.7a.4.4 0 0 1-.4-.4v-.85a3.75 3.75 0 0 1 3.75-3.75h2.1c.22 0 .4.18.4.4v1.7a.4.4 0 0 1-.4.4h-2.1c-.69 0-1.25.56-1.25 1.25v.85a.4.4 0 0 1-.4.4z"
                                fill="var(--site-accent-color)" />
                            <path
                                d="M13 23v-7.5h-2a.5.5 0 0 1-.5-.5v-1.5a.5.5 0 0 1 .5-.5h7.75a.5.5 0 0 1 .5.5V15a.5.5 0 0 1-.5.5H15.5V23H18a5 5 0 0 0 5-5V8a5 5 0 0 0-5-5H8a5 5 0 0 0-5 5v10a5 5 0 0 0 5 5h5zM8 .5h10A7.5 7.5 0 0 1 25.5 8v10a7.5 7.5 0 0 1-7.5 7.5H8A7.5 7.5 0 0 1 .5 18V8A7.5 7.5 0 0 1 8 .5z"
                                fill="currentColor" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-btn-search" viewBox="0 0 22 22">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.962 14.12l4.86 4.86a.6.6 0 0 1-.42 1.02.603.603 0 0 1-.422-.177l-4.86-4.86a8.493 8.493 0 0 1-5.592 2.092C3.827 17.055 0 13.228 0 8.528 0 3.827 3.823 0 8.528 0c4.7 0 8.527 3.823 8.527 8.528 0 2.137-.789 4.093-2.093 5.592zM8.523 1.197c-4.04 0-7.33 3.286-7.33 7.33 0 4.045 3.29 7.336 7.33 7.336 4.045 0 7.33-3.295 7.33-7.335s-3.285-7.33-7.33-7.33z"
                            fill="currentColor" />
                    </symbol>
                    <symbol id="mixtas-search-product-icon" viewBox="0 0 48 48">
                        <g transform="translate(.5 .5)" fill="none" stroke="currentColor" stroke-miterlimit="10">
                            <path data-cap="butt" data-color="color-2" d="M46 43l-5.757-5.757" />
                            <circle data-color="color-2" stroke-linecap="square" cx="36" cy="33" r="6" />
                            <path stroke-linecap="square"
                                d="M24 31H2v0a6 6 0 0 0 6 6h16M6 26V10a4 4 0 0 1 4-4h28a4 4 0 0 1 4 4v11M23 12h2" />
                        </g>
                    </symbol>
                    <symbol id="nova-close-canvas" viewBox="0 0 22 22">
                        <path
                            d="M12.592 11.015l8.988-8.939c.43-.426.43-1.117 0-1.542a1.108 1.108 0 0 0-1.558 0l-8.98 8.931L1.977.401A1.1 1.1 0 0 0 .42.4a1.107 1.107 0 0 0 0 1.562l9.057 9.058-9.09 9.039a1.084 1.084 0 0 0 0 1.543c.43.426 1.129.426 1.558 0l9.082-9.032 9.028 9.028a1.1 1.1 0 0 0 1.557 0c.43-.432.43-1.131 0-1.562l-9.02-9.022z"
                            fill="currentColor" fill-rule="evenodd" />
                    </symbol>
                    <symbol id="mixtas-settings-bar" viewBox="0 0 26 26">
                        <g stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M3.694 5.381c.031-.037.069-.081.106-.119.456-.468.919-.924 1.388-1.387.612-.6 1.35-.656 2.05-.156.374.268.75.531 1.112.806.119.087.213.106.356.038.419-.194.838-.37 1.263-.538.137-.05.194-.125.219-.262.074-.475.13-.957.25-1.425a2.87 2.87 0 0 1 .38-.832c.188-.281.52-.381.826-.487h2.618a.554.554 0 0 0 .107.05c.625.175.987.594 1.106 1.225.088.475.169.95.238 1.425.018.137.075.212.212.262.456.175.906.375 1.363.55a.356.356 0 0 0 .287-.025c.394-.262.775-.544 1.163-.819.718-.506 1.443-.45 2.068.17l.306.305M22.07 5.076c.02.02-.03-.03 0 0M22.637 6.175c.063.381-.05.713-.33 1.119-.27.381-.55.756-.807 1.144a.355.355 0 0 0-.031.287c.168.444.362.875.531 1.319.05.131.125.181.25.2.475.075.956.131 1.425.25.281.069.556.2.794.362.287.194.4.525.5.844v2.619a.746.746 0 0 0-.05.1c-.181.631-.607.993-1.25 1.112-.475.088-.95.163-1.425.231-.144.02-.213.088-.263.22-.169.424-.337.85-.525 1.268-.062.144-.05.238.038.356.281.375.544.756.812 1.138.488.694.438 1.425-.156 2.031-.456.469-.919.931-1.387 1.388-.607.593-1.338.65-2.032.156-.394-.275-.781-.563-1.181-.838a.35.35 0 0 0-.262-.031c-.45.175-.894.356-1.332.55a.372.372 0 0 0-.187.244c-.094.475-.163.95-.244 1.425-.094.556-.394.956-.912 1.181-.1.044-.2.075-.3.112h-2.62c-.018-.012-.037-.03-.056-.037-.687-.175-1.062-.631-1.168-1.325-.069-.456-.156-.906-.225-1.356-.019-.138-.075-.213-.213-.269-.094-.038-.181-.069-.275-.106M8.575 21.469a.22.22 0 0 0-.088.037c-.406.275-.8.563-1.2.844-.693.487-1.418.431-2.025-.169-.462-.45-.918-.906-1.368-1.369-.6-.612-.657-1.343-.163-2.05.263-.375.531-.75.806-1.118.094-.119.1-.219.038-.356a18.06 18.06 0 0 1-.525-1.244c-.056-.157-.144-.213-.294-.238-.475-.075-.956-.143-1.425-.243a2.544 2.544 0 0 1-.7-.288c-.337-.206-.469-.563-.594-.919v-.931M1.031 12.113v-.375a.746.746 0 0 0 .05-.1c.182-.638.613-.994 1.25-1.107.475-.087.95-.15 1.425-.244a.363.363 0 0 0 .225-.18c.194-.438.375-.888.544-1.338a.32.32 0 0 0-.025-.263c-.281-.412-.575-.812-.856-1.218a1.862 1.862 0 0 1-.207-.375" />
                            <path
                                d="M11.044 16.325c.07.04.03-.04.1 0m1.319.444c.175.025.35.037.525.037 2.087.019 3.83-1.719 3.825-3.812 0-2.094-1.7-3.8-3.807-3.813C10.92 9.162 9.181 10.9 9.181 13c0 .906.319 1.737.85 2.394" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-menu-bar" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 12h22M1 5h22M1 19h22" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"
                            stroke-linecap="square" />
                    </symbol>
                    <symbol id="mixtas-user-bar" viewBox="0 0 24 25">
                        <g fill="none" fill-rule="evenodd">
                            <circle stroke="currentColor" stroke-linecap="round" cx="12" cy="12" r="11.52" />
                            <path d="M0 0h24v24H0z" />
                            <path
                                d="M14.368 17.053c-.07-.773-.043-1.313-.043-2.02.35-.184.978-1.356 1.084-2.347.275-.022.71-.291.837-1.352.069-.57-.204-.89-.37-.991.448-1.349 1.38-5.52-1.722-5.951-.32-.56-1.137-.844-2.2-.844-4.249.078-4.762 3.209-3.83 6.795-.166.1-.438.421-.37.99.128 1.062.562 1.33.837 1.353.106.99.758 2.163 1.11 2.347 0 .707.026 1.247-.044 2.02-.605 1.628-3.714 1.755-5.507 3.324 1.875 1.888 4.913 3.238 8.12 3.238 3.206 0 6.975-2.531 7.602-3.222-1.782-1.584-4.897-1.707-5.504-3.34z"
                                stroke="currentColor" stroke-linecap="round" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-wishlist-bar" viewBox="0 0 28 25">
                        <path
                            d="M3.205 13.395A7.52 7.52 0 1 1 13.837 2.757 7.52 7.52 0 0 1 24.47 13.395L13.837 24 3.205 13.395z"
                            stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </symbol>
                    <symbol id="mixtas-bag-bar" viewBox="0 0 18 22">
                        <g stroke="currentColor" stroke-width="1" fill="none" fill-rule="evenodd">
                            <path
                                d="M16.106 21H1.45A.457.457 0 0 1 1 20.552V6.448C1 6.207 1.207 6 1.45 6h14.656c.242 0 .45.207.45.448v14.104a.457.457 0 0 1-.45.448z"
                                stroke-linecap="square" />
                            <path d="M4.333 6c0-5 4.445-5 4.445-5s4.444 0 4.444 5" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-grid" viewBox="0 0 20 20">
                        <g stroke="currentColor" fill="none" fill-rule="evenodd">
                            <path d="M.5.5h8v8h-8zM11.5.5h8v8h-8zM11.5 11.5h8v8h-8zM.5 11.5h8v8h-8z" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-list" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 2H2v7h7V2zM9 15H2v7h7v-7zM14 3h8M14 8h8M14 16h8M14 21h8" stroke="currentColor"
                            stroke-width="1" stroke-miterlimit="10" stroke-linecap="square" />
                    </symbol>
                    <symbol id="mixtas-product-wishlist-btn" viewBox="0 0 21 19">
                        <path
                            d="M2.74 8.648l7.833 8.665 7.81-8.665c.01-.015.021-.033.035-.048a4.515 4.515 0 0 0 1.142-2.995 4.52 4.52 0 0 0-4.518-4.517 4.536 4.536 0 0 0-4.11 2.644c-.132.293-.61.293-.744 0A4.535 4.535 0 0 0 6.08 1.088 4.52 4.52 0 0 0 1.56 5.605c0 1.105.406 2.16 1.143 2.995a.472.472 0 0 1 .037.048zm7.834 9.68a.418.418 0 0 1-.304-.132L2.087 9.148c-.017-.025-.032-.042-.045-.058a5.34 5.34 0 0 1-1.3-3.485A5.34 5.34 0 0 1 6.08.27c1.822 0 3.508.933 4.481 2.439A5.345 5.345 0 0 1 15.042.27a5.34 5.34 0 0 1 5.337 5.335 5.33 5.33 0 0 1-1.304 3.485c-.012.016-.025.033-.04.058l-8.158 9.048a.416.416 0 0 1-.303.131z"
                            fill="currentColor" fill-rule="evenodd" />
                    </symbol>
                    <symbol id="mixtas-product-quickview-btn" viewBox="0 0 19 12">
                        <g fill="currentColor" fill-rule="evenodd">
                            <path
                                d="M1.529 6.341a9.749 9.749 0 0 0 8.192 4.429c3.325 0 6.365-1.65 8.193-4.429C16.086 3.56 13.046 1.91 9.721 1.91c-3.325 0-6.365 1.65-8.192 4.431zm8.192 5.429C5.943 11.77 2.5 9.841.51 6.6a.492.492 0 0 1 0-.52C2.5 2.84 5.943.911 9.721.911c3.779 0 7.222 1.929 9.211 5.169a.492.492 0 0 1 0 .52c-1.989 3.241-5.432 5.17-9.211 5.17z" />
                            <path
                                d="M9.721 4.14a2.204 2.204 0 0 0-2.197 2.201c0 1.209.986 2.199 2.197 2.199 1.212 0 2.197-.99 2.197-2.199 0-1.21-.985-2.201-2.197-2.201zm0 5.4a3.205 3.205 0 0 1-3.197-3.199A3.205 3.205 0 0 1 9.721 3.14a3.205 3.205 0 0 1 3.197 3.201A3.205 3.205 0 0 1 9.721 9.54zM13.564 11.03a.499.499 0 0 1-.368-.169.493.493 0 0 1 .03-.701 5.2 5.2 0 0 0 1.676-3.819 5.194 5.194 0 0 0-1.68-3.821.503.503 0 0 1-.03-.709c.186-.2.503-.21.706-.03a6.206 6.206 0 0 1 2.004 4.56 6.17 6.17 0 0 1-2 4.549.498.498 0 0 1-.338.14M5.882 11.03a.487.487 0 0 1-.338-.13 6.204 6.204 0 0 1-2.003-4.559c0-1.73.729-3.391 2.001-4.551a.494.494 0 0 1 .707.03c.187.2.173.521-.031.7a5.199 5.199 0 0 0-1.677 3.821c0 1.449.612 2.839 1.679 3.819.204.19.218.501.031.711a.53.53 0 0 1-.369.159" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-product-bag-btn" viewBox="0 0 18 19">
                        <g fill="currentColor" fill-rule="evenodd">
                            <path
                                d="M13.375 8.88A.373.373 0 0 1 13 8.506V3.255c0-1.477-1.426-2.25-2.834-2.25h-.75C7.903 1.005 7 1.845 7 3.255v5.25c0 .21-.168.375-.375.375a.373.373 0 0 1-.375-.374V3.255c0-1.822 1.242-3 3.166-3h.75c1.737 0 3.584 1.05 3.584 3v5.25c0 .21-.168.375-.375.375" />
                            <path
                                d="M11.5 18.256H1.166a.375.375 0 0 1-.356-.495L4.56 6.51a.378.378 0 0 1 .356-.255h9.75c.16 0 .303.104.354.255l1.672 4.889a.372.372 0 0 1-.233.473.373.373 0 0 1-.476-.233l-1.586-4.634H5.186l-3.5 10.5H11.5c.207 0 .375.164.375.374s-.168.376-.375.376" />
                            <path
                                d="M15.75 17.13c-.276 0-.5-.165-.5-.375v-3.75c0-.21.224-.374.5-.374s.5.165.5.375v3.749c0 .21-.224.376-.5.376" />
                            <path
                                d="M17.5 15.505h-3.75c-.207 0-.375-.22-.375-.5s.168-.5.375-.5h3.75c.207 0 .375.22.375.5s-.168.5-.375.5" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-zoom" viewBox="0 0 26 26">
                        <g fill="currentColor" fill-rule="evenodd">
                            <path d="M24 0h2v8.308h-2z" />
                            <path d="M24.083.76l1.372 1.405-9.858 8.153-1.372-1.405z" />
                            <path d="M17 0h9v2h-9zM0 0h13v2H0z" />
                            <path d="M0 0h2v24H0z" />
                            <path d="M0 23.077h26v2H0z" />
                            <path d="M24 12h2v12h-2z" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-play-video" viewBox="0 0 22 28">
                        <path d="M0 0v28l22-14z" fill="currentColor" fill-rule="evenodd" />
                    </symbol>
                    <symbol id="mixtas-arrow-right" viewBox="0 0 40 36">
                        <path d="M37.098 18.756L20.864 34.9 21.9 36 40 18 21.9 0l-1.036 1.1 16.234 16.144H0v1.512z"
                            fill="currentColor" fill-rule="evenodd" />
                    </symbol>
                    <symbol id="mixtas-filter-icon" viewBox="0 0 20 17">
                        <g fill="currentColor" fill-rule="evenodd">
                            <path d="M0 0h20v1H0zM0 8h15v1H0zM0 16h10v1H0z" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-button-arrow" viewBox="0 0 24 24">
                        <g class="nc-icon-wrapper" stroke-linecap="square" stroke-linejoin="miter" stroke-width="2"
                            fill="currentColor" stroke="currentColor">
                            <line data-cap="butt" data-color="color-2" fill="none" stroke-miterlimit="10" x1="2" y1="12"
                                x2="22" y2="12" stroke-linecap="butt" />
                            <polyline fill="none" stroke="currentColor" stroke-miterlimit="10"
                                points="15,5 22,12 15,19 " />
                        </g>
                    </symbol>
                    <symbol id="mixtas-video-play" viewBox="0 0 70 70" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" fill-rule="evenodd" transform="translate(1.913 1.26)">
                            <path fill="currentColor" fill-rule="nonzero"
                                d="M45.13 34.348c0-.287-.19-.574-.382-.765L27.53 21.148c-.287-.191-.67-.287-1.052-.096-.287.191-.478.478-.478.861v24.87c0 .382.191.67.478.86.192.096.287.096.479.096.19 0 .382-.096.573-.191l17.218-12.435c.191-.191.382-.478.382-.765z" />
                            <circle cx="33.087" cy="33.739" r="33" stroke="currentColor" stroke-width="4" />
                        </g>
                    </symbol>
                    <symbol id="mixtas-plus" fill="none" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"
                            fill="currentColor" />
                    </symbol>
                    <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13 15" id="mixtas-calendar">
                        <path
                            d="M3.4375 0.75C3.65625 0.75 3.875 0.96875 3.875 1.1875V2.5H9.125V1.1875C9.125 0.96875 9.31641 0.75 9.5625 0.75C9.78125 0.75 10 0.96875 10 1.1875V2.5H10.875C11.832 2.5 12.625 3.29297 12.625 4.25V13C12.625 13.9844 11.832 14.75 10.875 14.75H2.125C1.14062 14.75 0.375 13.9844 0.375 13V4.25C0.375 3.29297 1.14062 2.5 2.125 2.5H3V1.1875C3 0.96875 3.19141 0.75 3.4375 0.75ZM11.75 6H8.90625V7.96875H11.75V6ZM11.75 8.84375H8.90625V11.0312H11.75V8.84375ZM11.75 11.9062H8.90625V13.875H10.875C11.3398 13.875 11.75 13.4922 11.75 13V11.9062ZM8.03125 11.0312V8.84375H4.96875V11.0312H8.03125ZM4.96875 13.875H8.03125V11.9062H4.96875V13.875ZM4.09375 11.0312V8.84375H1.25V11.0312H4.09375ZM1.25 11.9062V13C1.25 13.4922 1.63281 13.875 2.125 13.875H4.09375V11.9062H1.25ZM1.25 7.96875H4.09375V6H1.25V7.96875ZM4.96875 7.96875H8.03125V6H4.96875V7.96875ZM10.875 3.375H2.125C1.63281 3.375 1.25 3.78516 1.25 4.25V5.125H11.75V4.25C11.75 3.78516 11.3398 3.375 10.875 3.375Z"
                            fill="currentColor"></path>
                    </symbol>
                    <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="mini-cart-add">
                        <path d="M12 7V17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                        <path d="M17 12H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </symbol>
                    <symbol fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="mini-cart-delete">
                        <path d="M17 12H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </symbol>
                </defs>
            </svg>
        </div>
        <div class="nova-overlay-global"></div>
    </div>


    <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:52 -->


    @endsection