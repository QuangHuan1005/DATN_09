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




<!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:13:29 -->
@endsection
