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
                            data-id="154c7994" data-element_type="container"
                            style="background-image: url('assets/images/background/shop-bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 80px 0;">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-48a016be kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="48a016be" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">
                                        <div class="kitify-breadcrumbs">
                                            <h3 class="kitify-breadcrumbs__title">Shop</h3>
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item">
                                                        <a href="../index.html"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Home">Home</a>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <span class="kitify-breadcrumbs__item-target">Shop</span>
                                                    </div>
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
                                @include('products.partials.filters')
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
                                                    @include('products.partials.toolbar')
                                                    <div class="kitify-products" data-widget_current_query="yes">
                                                        <div class="kitify-products__list_wrapper">
                                                            <ul
                                                                class="products ul_products kitify-products__list products-grid products-grid-1 col-row columns-3">
                                                                @foreach ($products as $item)
                                                                    @php
                                                                        // Lấy biến thể rẻ nhất để tính giá hiển thị
                                                                        $sortedVariants = $item->variants->sortBy(
                                                                            function ($v) {
                                                                                // Ưu tiên giá sale nếu có sale < price, nếu không dùng price
                                                                                $effectivePrice =
                                                                                    $v->sale !== null &&
                                                                                    $v->sale < $v->price
                                                                                        ? $v->sale
                                                                                        : $v->price;
                                                                                return $effectivePrice;
                                                                            },
                                                                        );

                                                                        $bestVariant = $sortedVariants->first(); // có thể null nếu chưa có biến thể

                                                                        // Chuẩn bị giá
                                                                        $hasSale =
                                                                            $bestVariant &&
                                                                            $bestVariant->sale !== null &&
                                                                            $bestVariant->sale < $bestVariant->price;

                                                                        $originalPrice = $bestVariant->price ?? null;
                                                                        $salePrice = $hasSale
                                                                            ? $bestVariant->sale
                                                                            : null;
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
                                                                            ? asset(
                                                                                'storage/' . $item->firstPhoto->image,
                                                                            )
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
                                                                        class="product_item product-grid-item product type-product post-1558 status-publish first instock product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products has-post-thumbnail shipping-taxable purchasable product-type-variable has-default-attributes kitify-product col-desk-3 col-tabp-2 col-tab-3 col-lap-3">
                                                                        <div class="product-item">
                                                                            <div class="product-item__badges">
                                                                                @if ($discountPercent)
                                                                                    <span
                                                                                        class="onsale">{{ $discountPercent }}%</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="product-item__thumbnail">
                                                                                <div
                                                                                    class="product-item__thumbnail_overlay">
                                                                                </div>
                                                                                <a class="product-item-link"
                                                                                    href="{{ route('products.show', ['id' => $item->id]) }}"></a>
                                                                                <div
                                                                                    class="product-item__description--top-actions">

                                                                                    <a href="{{ route('products.show', ['id' => $item->id]) }}?add_to_wishlist={{ $item->id }}"
                                                                                        data-product-id="{{ $item->id }}"
                                                                                        data-product-type="variable"
                                                                                        class="nova_product_wishlist_btn add_to_wishlist"
                                                                                        rel="nofollow">
                                                                                        <i class="inova ic-favorite"></i>
                                                                                        <span class="hidden add-text">Add
                                                                                            to wishlist</span>
                                                                                        <span
                                                                                            class="hidden added-text">Browse
                                                                                            wishlist</span>
                                                                                    </a>


                                                                                    <a href="{{ route('products.show', ['id' => $item->id]) }}"
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
                                                                                            options</span></a>
                                                                                    <span
                                                                                        id="woocommerce_loop_add_to_cart_link_describedby_1558"
                                                                                        class="screen-reader-text">
                                                                                        This product has multiple variants.
                                                                                        The
                                                                                        options may be chosen on the product
                                                                                        page </span>
                                                                                </div>


                                                                                <div
                                                                                    class="product-item__thumbnail-placeholder second_image_enabled">
                                                                                    <a
                                                                                        href="{{ route('products.show', ['id' => $item->id]) }}">
                                                                                        <img loading="lazy" decoding="async"
                                                                                            width="700" height="700"
                                                                                            src="{{ $mainImage }}"
                                                                                            class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                            alt="{{ $item->name }}"
                                                                                            srcset="{{ $mainImage }} 700w, {{ $mainImage }} 300w, {{ $mainImage }} 150w, {{ $mainImage }} 768w, {{ $mainImage }} 250w, {{ $mainImage }} 50w, {{ $mainImage }} 100w, {{ $mainImage }} 1000w"
                                                                                            sizes="(max-width: 700px) 100vw, 700px" />

                                                                                        <span class="product_second_image"
                                                                                            style="background-image: url('{{ $hoverImage }}')"></span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>

                                                                            <div class="product-item__description">

                                                                                <div
                                                                                    class="product-item__description--info">
                                                                                    <div class="info-left">
                                                                                        <div class="product-item__category">
                                                                                            <a class="content-product-cat"
                                                                                                href="{{ route('products.category', ['slug' => $item->category->slug]) }}"
                                                                                                rel="tag">
                                                                                                {{ $item->category->name }}
                                                                                            </a>
                                                                                        </div> <a
                                                                                            href="../product/adidas-x-pop-beckenbauer-track-jacket/index.html"
                                                                                            class="title">
                                                                                            <h3
                                                                                                class="woocommerce-loop-product__title">
                                                                                                {{ $item->name }}</h3>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="info-right">
                                                                                        @if ($bestVariant)
                                                                                            @if ($hasSale)
                                                                                                {{-- Có khuyến mãi --}}
                                                                                                <span class="price">
                                                                                                    <del
                                                                                                        aria-hidden="true">
                                                                                                        <span
                                                                                                            class="woocommerce-Price-amount amount">
                                                                                                            <bdi>
                                                                                                                {{ number_format($originalPrice, 0, ',', '.') }}₫
                                                                                                            </bdi>
                                                                                                        </span>
                                                                                                    </del>
                                                                                                    <ins
                                                                                                        aria-hidden="true">
                                                                                                        <span
                                                                                                            class="woocommerce-Price-amount amount">
                                                                                                            <bdi>
                                                                                                                {{ number_format($salePrice, 0, ',', '.') }}₫
                                                                                                            </bdi>
                                                                                                        </span>
                                                                                                    </ins>
                                                                                                </span>
                                                                                            @else
                                                                                                {{-- Không khuyến mãi --}}
                                                                                                <span class="price">
                                                                                                    <ins
                                                                                                        aria-hidden="true">
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
                                                                                            {{-- Không có biến thể nào (trường hợp hiếm / dữ liệu chưa nhập variant) --}}
                                                                                            <span class="price">
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            {{-- fallback 0₫ vì bảng products hiện không có cột price --}}
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
                                                    {{ $products->links() }}

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
                @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div>

            @include('layouts.js')

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:52 -->
        @endsection






        <script>
    const variantMap = @json($variantMap);

    let selectedColorId = null;
    let selectedSizeId  = null;

    const priceEl    = document.getElementById('js-product-price');
    const originalEl = document.getElementById('js-product-original-price');
    const discountEl = document.getElementById('js-product-discount');

    const colorSelect = document.getElementById('pa_color');
    const sizeSelect  = document.getElementById('pa_size');

    const colorItems = document.querySelectorAll('.js-color-item');
    const sizeItems  = document.querySelectorAll('.js-size-item');

    // Nếu bạn có nút thêm giỏ / mua ngay
    const btnAddToCart = document.querySelector('.js-submit-cartcart');
    const btnBuyNow    = document.querySelector('.js-submit-cart');

    const defaultPrice       = {{ (float) $displayPrice }};
    const defaultOriginal    = {{ (float) $originalPrice }};
    const defaultHasDiscount = {{ $discountPercent ? 'true' : 'false' }};
    const defaultDiscount    = {{ (int) ($discountPercent ?? 0) }};

    function formatCurrency(value) {
        if (!value) return '0₫';
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND',
            maximumFractionDigits: 0
        }).format(value);
    }

    function disableAddToCartButtons() {
        if (!btnAddToCart || !btnBuyNow) return;
        btnAddToCart.classList.add('woocommerce-variation-add-to-cart-disabled');
        btnBuyNow.classList.add('woocommerce-variation-add-to-cart-disabled');
        btnAddToCart.disabled = true;
        btnBuyNow.disabled    = true;
    }

    function enableAddToCartButtons() {
        if (!btnAddToCart || !btnBuyNow) return;
        btnAddToCart.classList.remove('woocommerce-variation-add-to-cart-disabled');
        btnBuyNow.classList.remove('woocommerce-variation-add-to-cart-disabled');
        btnAddToCart.disabled = false;
        btnBuyNow.disabled    = false;
    }

    // ===== CẬP NHẬT GIÁ THEO BIẾN THỂ =====
    function updatePriceByVariant() {
        if (!selectedColorId || !selectedSizeId) {
            disableAddToCartButtons();
            return;
        }

        const key = `${selectedColorId}_${selectedSizeId}`;
        const variant = variantMap[key];

        if (!variant || variant.stock <= 0) {
            disableAddToCartButtons();
            return;
        }

        enableAddToCartButtons();

        const originalPrice = Number(variant.price);
        const salePrice     = variant.sale && variant.sale > 0 ? Number(variant.sale) : null;

        if (salePrice && salePrice < originalPrice) {
            priceEl.textContent    = formatCurrency(salePrice);
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
    }

    // ===== DISABLE SIZE THEO MÀU =====
    function updateAvailableSizes() {
        sizeItems.forEach(item => {
            const sizeId = item.dataset.sizeId;

            // Mặc định enable tất cả nếu chưa chọn màu
            if (!selectedColorId) {
                item.classList.remove('is-disabled');
                item.setAttribute('aria-disabled', 'false');
                return;
            }

            const key = `${selectedColorId}_${sizeId}`;
            const variant = variantMap[key];

            // Không tồn tại variant hoặc hết hàng => disable
            if (!variant || variant.stock <= 0) {
                item.classList.add('is-disabled');
                item.setAttribute('aria-disabled', 'true');

                // Nếu đang được chọn thì bỏ chọn
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

    // ===== DISABLE MÀU THEO SIZE =====
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

    // ===== RESET =====
    function clearSelection() {
        selectedColorId = null;
        selectedSizeId  = null;

        if (colorSelect) colorSelect.value = '';
        if (sizeSelect) sizeSelect.value  = '';

        colorItems.forEach(i => {
            i.classList.remove('selected', 'is-disabled');
            i.setAttribute('aria-checked', 'false');
            i.setAttribute('aria-disabled', 'false');
        });

        sizeItems.forEach(i => {
            i.classList.remove('selected', 'is-disabled');
            i.setAttribute('aria-checked', 'false');
            i.setAttribute('aria-disabled', 'false');
        });

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

        disableAddToCartButtons();
    }

    // ===== EVENT: CHỌN MÀU =====
    colorItems.forEach(item => {
        item.addEventListener('click', function () {
            if (this.classList.contains('is-disabled')) return;

            const colorId = this.dataset.colorId;
            selectedColorId = colorId;

            if (colorSelect) colorSelect.value = colorId;

            colorItems.forEach(i => {
                i.classList.remove('selected');
                i.setAttribute('aria-checked', 'false');
            });
            this.classList.add('selected');
            this.setAttribute('aria-checked', 'true');

            // Cập nhật size theo màu
            updateAvailableSizes();
            updatePriceByVariant();
        });
    });

    // ===== EVENT: CHỌN SIZE =====
    sizeItems.forEach(item => {
        item.addEventListener('click', function () {
            if (this.classList.contains('is-disabled')) return;

            const sizeId = this.dataset.sizeId;
            selectedSizeId = sizeId;

            if (sizeSelect) sizeSelect.value = sizeId;

            sizeItems.forEach(i => {
                i.classList.remove('selected');
                i.setAttribute('aria-checked', 'false');
            });
            this.classList.add('selected');
            this.setAttribute('aria-checked', 'true');

            // Cập nhật màu theo size
            updateAvailableColors();
            updatePriceByVariant();
        });
    });

    // ===== NÚT CLEAR (nếu có) =====
    const resetBtn = document.getElementById('js-reset-variations');
    if (resetBtn) {
        resetBtn.addEventListener('click', function (e) {
            e.preventDefault();
            clearSelection();
        });
    }

    // Mặc định disable nút mua khi chưa chọn biến thể
    disableAddToCartButtons();
</script>
