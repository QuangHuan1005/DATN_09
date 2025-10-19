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
<form method="POST" action="{{ route('cart.add', ['id' => $product->id]) }}" id="addToCartForm" class="border p-3 rounded">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    {{-- sẽ set động theo lựa chọn --}}
    <input type="hidden" name="product_variant_id" id="variantId" value="">

    {{-- Màu --}}
    <div class="mb-3">
        <label for="selectColor" class="form-label fw-semibold">Màu sắc</label>
        <select id="selectColor" class="form-select">
            <option value="" selected>— Chọn màu —</option>
            @foreach($colors as $c)
                <option value="{{ $c->id }}">
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
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
                id="btnAddToCart" disabled>
        Thêm Vào Giỏ Hàng
        </button>
</form>

{{-- Dữ liệu variants cho JS --}}
<script>
    // map "colorId-sizeId" -> data
    const VARIANTS = @json($variantMap);

    // xây index: colorId -> [{size_id, size_name}]
    const COLOR_SIZES = {};
    @foreach($variants as $v)
        @if($v->color_id && $v->size_id)
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
        priceBox.innerHTML = '<span class="text-muted">Chọn size để xem giá</span>';

        if (mainImg && DEFAULT_SRC) mainImg.src = DEFAULT_SRC;

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

    // khi chọn size -> tìm biến thể, hiện giá, ĐỔI ẢNH CÓ KIỂM TRA TẢI
    selectSize.addEventListener('change', async () => {
        const colorId = selectColor.value || '0';
        const sizeId  = selectSize.value  || '0';
        const key = `${colorId}-${sizeId}`;
        const v = VARIANTS[key];

        if (!v) {
            variantId.value = '';
            btnAdd.disabled = true;
            priceBox.innerHTML = '<span class="text-danger">Biến thể không tồn tại</span>';
            if (mainImg && DEFAULT_SRC) mainImg.src = DEFAULT_SRC;
            return;
        }

        variantId.value = v.id;
        btnAdd.disabled = false;

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

        // === ĐỔI ẢNH: chỉ set src khi chắc chắn có URL load được ===
        if (mainImg) {
            const candidates = buildCandidateUrls(v.image);

            let loadedUrl = null;
            for (const url of candidates) {
                // eslint-disable-next-line no-await-in-loop
                if (await canLoad(url)) { loadedUrl = url; break; }
            }

            if (loadedUrl) {
                mainImg.src = loadedUrl;
            } else if (DEFAULT_SRC) {
                // Không url nào hợp lệ -> quay về ảnh gốc (không vỡ ảnh)
                mainImg.src = DEFAULT_SRC;
            }
        }
    });

    // chặn submit nếu chưa có variant
    document.getElementById('addToCartForm').addEventListener('submit', (e) => {
        if (!variantId.value) {
            e.preventDefault();
            alert('Vui lòng chọn màu và size trước khi thêm vào giỏ hàng.');
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
    qtyInput.value = clampQty((parseInt(qtyInput.value||'1',10) - 1));
    syncQtyButtons();
    });
    btnPlus.addEventListener('click', () => {
    qtyInput.value = clampQty((parseInt(qtyInput.value||'1',10) + 1));
    syncQtyButtons();
    });
    qtyInput.addEventListener('input', () => {
    qtyInput.value = clampQty(qtyInput.value);
    syncQtyButtons();
    });
    syncQtyButtons();

    // Giới hạn số lượng theo tồn kho nếu có
    if (typeof v.stock !== 'undefined' && v.stock !== null) {
    MAX_QTY = parseInt(v.stock, 10);
    } else {
    MAX_QTY = null; // không giới hạn
    }
    qtyInput.value = clampQty(qtyInput.value);
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
</div>
               @include('layouts.footer')
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            @include('layouts.js')

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





<!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 07:13:29 -->
@endsection
