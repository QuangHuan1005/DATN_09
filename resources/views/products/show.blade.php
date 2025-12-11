@extends('master')
@section('content')

    <style>
        /* Item mặc định */
        .variable-item.color-variable-item {
            border: 1px solid #e2e2e2;
            border-radius: 1px;
            padding: 3px;
            transition: all 0.2s ease;
        }

        /* Hover */
        .variable-item.color-variable-item:hover {
            border-color: #c1995a;
            /* gold theo brand */
        }

        /* Khi được chọn */
        .variable-item.color-variable-item.active,
        .variable-item.color-variable-item[aria-checked="true"] {
            border-color: #c1995a;
            box-shadow: 0 0 0 2px rgba(193, 153, 90, 0.3);
        }

        /* Viền bo cho ô màu */
        .variable-item-span-color {
            border-radius: 4px;
        }
    </style>

    <body
        class="wp-singular product-template-default single single-product postid-1558 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-383 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                @include('layouts.header')
                <div id="site-content" class="site-content-wrapper">
                    <div class="woocommerce-notices-wrapper">
                        @if (session('cart_success'))
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
                        @endif
                    </div>
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

                                                                    <div data-thumb="{{ $imgUrl }}"
                                                                        data-thumb-alt="{{ $alt }}"
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
                                                                            <img fetchpriority="high" width="1000"
                                                                                height="1000" src="{{ $imgUrl }}"
                                                                                class="{{ $index == 0 ? 'wp-post-image' : '' }}"
                                                                                alt="{{ $alt }}" data-caption=""
                                                                                data-src="{{ $imgUrl }}"
                                                                                data-large_image="{{ $imgUrl }}"
                                                                                data-large_image_width="1000"
                                                                                data-large_image_height="1000"
                                                                                decoding="async"
                                                                                srcset="{{ $imgUrl }} 1000w,
                                                                            {{ $imgUrl }} 300w,
                                                                            {{ $imgUrl }} 150w,
                                                                            {{ $imgUrl }} 768w,
                                                                            {{ $imgUrl }} 700w,
                                                                            {{ $imgUrl }} 250w,
                                                                            {{ $imgUrl }} 50w,
                                                                            {{ $imgUrl }} 100w"
                                                                                sizes="(max-width: 1000px) 100vw, 1000px"
                                                                                @if ($index === 0) id="js-main-image"
                                                                                        data-image-base="{{ asset('storage') }}" @endif />
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

                    <script>
                    (function(){
                    const form      = document.getElementById('addToCartForm');
                    if (!form) return;
                    const btnAdd    = document.getElementById('btnAddToCart');
                    const btnBuyNow = document.getElementById('btnBuyNow');
                    const miniCartCount = document.getElementById('miniCartCount');

                    // Lấy CSRF token
                    function getCsrfToken(){
                        const meta = document.querySelector('meta[name="csrf-token"]');
                        if (meta && meta.content) return meta.content;
                        const inp  = form.querySelector('input[name="_token"]');
                        return inp ? inp.value : '';
                    }

                    form.addEventListener('submit', async function(e){
                        // Chỉ “bắt” khi nhấn nút Thêm Vào Giỏ Hàng; nút Mua Ngay giữ nguyên hành vi
                        const submitter = e.submitter || document.activeElement;
                        if (!submitter || submitter.id !== 'btnAddToCart') return;

                        e.preventDefault();

                        // Yêu cầu chọn biến thể nếu có
                        const variantId = document.getElementById('variantId');
                        if (variantId && !variantId.value) {
                        Swal.fire({icon:'warning', title:'Thiếu lựa chọn', text:'Vui lòng chọn màu & size trước khi thêm vào giỏ.'});
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
                            const msg = (data && (data.message || data.error)) || 'Không thể thêm vào giỏ hàng.';
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
                        Swal.fire({icon:'error', title:'Lỗi', text: err.message || 'Đã xảy ra lỗi.'});
                        } finally {
                        btnAdd.disabled = false;
                        btnAdd.innerHTML = oldText;
                        }
                    });
                    })();
                    </script>

                        function showQtyAlert() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Số lượng không hợp lệ',
                                text: 'Vui lòng kiểm tra lại số lượng, không được vượt quá tồn kho.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'custom-variant-alert'
                                },
                                buttonsStyling: true,
                                allowOutsideClick: true,
                                allowEscapeKey: true
                            });
                        }
                    </script>
                    @if (session('cart_limit_error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Giới hạn mua hàng',
                                    text: @json(session('cart_limit_error')),
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'custom-variant-alert'
                                    },
                                    buttonsStyling: true,
                                    allowOutsideClick: true,
                                    allowEscapeKey: true
                                });
                            });
                        </script>
                    @endif




<!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:13:29 -->
@endsection
