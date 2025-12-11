@extends('admin.master')
@section('content')
    <style>
        /* Wrapper chỉ đủ hiển thị 3 ảnh */
        .thumb-slider-wrapper {
            width: calc(75px * 3 + 16px * 2);
            /* 3 ảnh + 2 khoảng gap */
            overflow: hidden;
            margin: 0 auto;
            /* căn giữa */
        }

        .thumb-slider {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            padding-bottom: 6px;
        }

        .thumb-slider::-webkit-scrollbar {
            height: 6px;
        }

        .thumb-slider::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .thumb-item {
            flex: 0 0 75px;
            height: 75px;
            padding: 0;
            border: none;
            background: transparent;
            overflow: hidden;
            border-radius: 8px;
            scroll-snap-align: start;
        }

        .thumb-item.active {
            border: 2px solid #c1995a;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Ẩn scrollbar trên Chrome, Edge, Safari */
        .thumb-slider::-webkit-scrollbar {
            display: none;
        }

        /* Ẩn scrollbar trên Firefox */
        .thumb-slider {
            scrollbar-width: none;
        }
    </style>

    <div class="container-xxl">
  
       
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Crossfade -->
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                @forelse($images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}"
                                            class="img-fluid bg-light rounded">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <img src="{{ asset('assets/images/no-image.png') }}" alt="No image"
                                            class="img-fluid bg-light rounded">
                                    </div>
                                @endforelse
                                <a class="carousel-control-prev rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                            <div class="thumb-slider-wrapper mt-2 d-lg-block d-none">
                                <div class="thumb-slider">
                                    @foreach ($images as $index => $image)
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="{{ $index }}"
                                            class="thumb-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="thumb-{{ $index }}">
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if ($product->created_at >= now()->subDays(2))
                            <h4 class="badge bg-success text-light fs-14 py-1 px-2">Sản phẩm mới</h4>
                        @endif
                        <p class="mb-1">
                            <a href="#!" class="fs-24 text-dark fw-medium">{{ $product->name }}</a>
                        </p>
                        <div class="d-flex gap-2 align-items-center">
                            <ul class="d-flex text-warning m-0 fs-20  list-unstyled">
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $starValue = $i;
                                    @endphp
                                    @if ($avgRating >= $starValue)
                                        <li>
                                            <i class="bx bxs-star"></i>
                                        </li>
                                    @elseif($avgRating >= $starValue - 0.5)
                                        <li>
                                            <i class="bx bxs-star-half"></i>
                                        </li>
                                    @else
                                        <li>
                                            <i class="bx bx-star"></i>
                                        </li>
                                    @endif
                                @endfor

                            </ul>
                            <p class="mb-0 fw-medium fs-18 text-dark">{{ $avgRating }} <span
                                    class="text-muted fs-13">({{ $ratingCount }}
                                    Đánh giá)</span></p>
                        </div>
                        <h2 class="fw-medium my-3">
                            @if ($displayPrice)
                                {{ number_format($displayPrice, 0, ',', '.') }} đ
                            @else
                                Giá đang cập nhật
                            @endif
                            @if ($originalPrice && $originalPrice > $displayPrice)
                                <span class="fs-16 text-decoration-line-through ms-2">
                                    {{ number_format($originalPrice, 0, ',', '.') }} đ
                                </span>
                            @endif
                            @if ($discountPercent)
                                <small class="text-danger ms-2">(Giảm {{ $discountPercent }}%)</small>
                            @endif
                        </h2>
                        @php

                            $total_stock = $product->variants->sum('quantity');
                            $total_sold = $product->orderDetails->sum('quantity');

                            $stock = (int) ($total_stock ?? 0) - (int) ($total_sold ?? 0);
                            if ($stock < 0) {
                                $stock = 0;
                            }
                            $sold = (int) ($total_sold ?? 0);
                        @endphp
                        <div class="quantity mt-4">
                            <h4 class="text-dark fw-medium mt-3">Tồn kho :
                                {{ $stock }} sản phẩm</h4>
                            {{-- <pre>{{ json_encode($product->variants, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre> --}}

                            <div
                                class="input-step border bg-body-secondary p-1 mt-1 rounded d-inline-flex overflow-visible">
                                Đã bán : {{ $sold }} sản phẩm
                            </div>
                        </div>
                        <ul class="d-flex flex-column gap-2 list-unstyled fs-15 my-3">
                            {{-- <li>
                                @if ($sold == $total_stock)
                                    <i class='bx bx-check text-danger'></i> Hết hàng
                                @else
                                    <i class='bx bx-check text-success'></i> Còn hàng
                                @endif

                            </li>
                            <li>
                                <i class='bx bx-check text-success'></i> Miễn phí giao hàng.

                            </li>
                            <li>
                                <i class='bx bx-check text-success'></i> Giảm giá 10% - Khi sử dụng mã: <span
                                    class="text-dark fw-medium">CODE123</span>
                            </li> --}}
                        </ul>
                        <h4 class="text-dark fw-medium">Mô tả chi tiết :</h4>
                        <p class="text-muted">{{ $product->description ?? 'Chưa có mô tả.' }}
                            {{-- <a href="#!" class="link-primary">Read more</a> --}}
                        </p>
                        {{-- <h4 class="text-dark fw-medium mt-3">Các ưu đãi hiện có :</h4>
                            <div class="d-flex align-items-center mt-2">
                                <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> 10% instant discount
                                    on Bank Debit Cards, up to $30 on orders of $50 and above</p>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> Grab our exclusive
                                    offer now and save 20% on your next purchase! Don't miss out, shop today!</p>
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-light-subtle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:kick-scooter-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Miễn phí vận chuyển cho các đơn hàng từ
                                            200.000₫</p>
                                        <p class="mb-0">Chỉ áp dụng trong tuần này</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:ticket-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Ưu đãi đặc biệt dành cho khách hàng</p>
                                        <p class="mb-0">Mã giảm giá lên đến 100.000₫</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:gift-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Gói quà miễn phí</p>
                                        <p class="mb-0">Kèm thiệp nhắn tùy chỉnh</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:headphones-round-sound-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Dịch vụ khách hàng chuyên nghiệp</p>
                                        <p class="mb-0">Hoạt động từ 8h - 20h, 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Chi tiết mặt hàng --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết mặt hàng</h4>
                    </div>
                    <div class="card-body">
                        <ul class="d-flex flex-column gap-2 list-unstyled fs-14 text-muted mb-0">
                            <li>
                                <span class="fw-medium text-dark">Mã sản phẩm</span>
                                <span class="mx-2">:</span>
                                {{ $product->product_code }}
                            </li>
                            <li>
                                <span class="fw-medium text-dark">Danh mục</span>
                                <span class="mx-2">:</span>
                                {{ $product->category->name ?? 'Đang cập nhật' }}
                            </li>
                            <li>
                                <span class="fw-medium text-dark">Chất liệu</span>
                                <span class="mx-2">:</span>
                                {{ $product->material ?? 'Đang cập nhật' }}
                            </li>
                            <li>
                                <span class="fw-medium text-dark">Ngày thêm</span>
                                <span class="mx-2">:</span>
                                {{ $product->created_at ? $product->created_at->format('d/m/Y') : '—' }}
                            </li>
                            <li>
                                <span class="fw-medium text-dark">Trọng lượng tham khảo</span>
                                <span class="mx-2">:</span>
                                500 g
                            </li>
                            {{-- <li>
                                <span class="fw-medium text-dark">Loại</span>
                                <span class="mx-2">:</span>
                                Áo phông
                            </li> --}}
                        </ul>

                        {{-- <div class="mt-3">
                            <a href="javascript:void(0)" class="link-primary text-decoration-underline link-offset-2">
                                Xem thêm chi tiết
                                <i class="bx bx-arrow-to-right align-middle fs-16"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh Sách Biến Thể ({{ $product->variants->count() }})</h5>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Thuộc Tính</th>
                                        <th>Giá Gốc</th>
                                        <th>Giá Sale</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variantMap as $key => $variant)
                                        <tr>
                                            <td>VRT-{{ $variant['id'] }}{{ $key }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        @if ($variant['image'])
                                                            <img src="{{ asset('storage/' . $variant['image']) }}"
                                                                alt="Variant {{ $variant['id'] }}" class="avatar-md">
                                                        @else
                                                            <span class="text-muted">No image</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-muted mb-0 mt-1 fs-13"><span>Kích thước :
                                                        </span>{{ $variant['size_name'] }}</p>
                                                    <p class="text-muted mb-0 mt-1 fs-13"><span>Màu sắc :
                                                        </span>{{ $variant['color_name'] }}</p>
                                                </div>
                                            </td>
                                            <td>{{ number_format($variant['price']) }}đ</td>
                                            <td>{{ number_format($variant['sale']) }}đ</td>

                                            <td>
                                                <p class="mb-1 text-muted">
                                                    @if ($variant['remaining'] > 0)
                                                        <span class="text-dark fw-medium">Tồn kho :
                                                            {{ $variant['remaining'] }}</span>
                                                    @else
                                                        <span class="text-danger">Hết hàng</span>
                                                    @endif
                                                </p>
                                                <p class="mb-0 text-muted">Đã bán : {{ $variant['sold'] }}</p>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $variantsPaginate->links() }}
                        </div>
                        <!-- end table-responsive -->
                    </div>

                </div>
            </div>

        </div>

    </div>
    <script>
        const carousel = document.querySelector('#carouselExampleFade');
        const thumbs = document.querySelectorAll('.thumb-item');
        const slider = document.querySelector('.thumb-slider');

        function scrollToThumb(thumb) {
            slider.scrollTo({
                left: thumb.offsetLeft - slider.clientWidth / 2 + thumb.clientWidth / 2,
                behavior: 'smooth'
            });
        }

        // Click thumbnail
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                bsCarousel.to(index);

                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');

                scrollToThumb(thumb);
            });
        });

        // Khi slide trong carousel thay đổi
        if (carousel) {
            carousel.addEventListener('slide.bs.carousel', function(e) {
                thumbs.forEach(t => t.classList.remove('active'));
                const target = thumbs[e.to];
                target.classList.add('active');
                scrollToThumb(target);
            });
        }
    </script>

@endsection
