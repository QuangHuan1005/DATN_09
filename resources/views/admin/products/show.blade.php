@extends('admin.master')
@section('content')
    <div class="container-xxl">

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
<<<<<<< HEAD
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
                                {{-- <a class="carousel-control-prev rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a> --}}
                            </div>
                            @if (count($images) > 0)
                                <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
                                    @foreach ($images as $index => $image)
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="{{ $index }}" aria-label="Ảnh {{ $index + 1 }}"
                                            class="w-auto h-auto rounded bg-light {{ $index === 0 ? 'active' : '' }}"
                                            {{ $index === 0 ? 'aria-current=true' : '' }}>
                                            <img src="{{ asset('storage/' . $image) }}" class="d-block avatar-xl"
                                                alt="thumb-{{ $index }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
=======
                        <!-- Crossfade hình ảnh -->
                     <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner" role="listbox">
        @php
            // Gộp ảnh từ photoAlbums và variants
            $images = $product->photoAlbums->pluck('image')->toArray();
            $variantImages = $product->variants->pluck('image')->filter()->toArray();
            $allImages = array_merge($images, $variantImages);
        @endphp

        @foreach ($allImages as $key => $image)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="img-fluid bg-light rounded">
            </div>
        @endforeach
    </div>

    @if(count($allImages) > 1)
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </a>
    @endif

    <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
        @foreach ($allImages as $key => $image)
            <button type="button" data-bs-target="#carouselExampleFade" data-bs-slide-to="{{ $key }}"
                class="w-auto h-auto rounded bg-light {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $image) }}" class="d-block avatar-xl" alt="thumb">
            </button>
        @endforeach
    </div>
</div>

>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8
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

                        <div class="row align-items-center g-2 mt-3">
                            <div class="col-lg-5">
                                <div class="">
                                    <h5 class="text-dark fw-medium">Màu sắc:
                                        {{-- <span class="text-muted">
                                                    {{ $colors->first()->name ?? 'Đang cập nhật' }}
                                                </span> --}}
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        @foreach ($colors as $idx => $color)
                                            <div class="d-flex flex-wrap gap-2" role="group"
                                                aria-label="Chọn màu sản phẩm">
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    title="{{ $color->name }}">
                                                    <i class="bx bxs-circle fs-18"
                                                        style="color: {{ $color->color_code ?? null }}"></i>
                                                </label>
                                                {{-- <h6>{{ $color }}</h6> --}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="">
                                    <h5 class="text-dark fw-medium">Size:
                                        {{-- <span class="text-muted">
                                                {{ $sizes->first()->name ?? 'Đang cập nhật' }}
                                            </span> --}}
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        @foreach ($sizes as $idx => $size)
                                            <label
                                                class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">{{ $size->size_code ?? null }}</label>
                                            {{-- <h6>{{$size}}</h6> --}}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <li>
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
                            </li>
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
            <div class="col-lg-6">
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
                            <li>
                                <span class="fw-medium text-dark">Loại</span>
                                <span class="mx-2">:</span>
                                Áo phông
                            </li>
                        </ul>

                        <div class="mt-3">
                            <a href="javascript:void(0)" class="link-primary text-decoration-underline link-offset-2">
                                Xem thêm chi tiết
                                <i class="bx bx-arrow-to-right align-middle fs-16"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Đánh giá hàng đầu --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Đánh giá hàng đầu</h4>
                    </div>
                   <div class="card-body">
    @forelse($topReviews as $index => $review)
        @php
            $user     = $review->order->user ?? null;
            $userName = $user->name ?? 'Khách ẩn danh';

            $avatar = $user && $user->image
                ? asset('storage/' . $user->image)
                : asset('assets/images/users/avatar-' . ($index + 4) . '.jpg');
        @endphp

        <div class="py-3">
            <div class="d-flex">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    <img src="{{ $avatar }}" alt="avatar"
                         class="rounded-circle border bg-light"
                         style="width:48px;height:48px;object-fit:cover;">
                </div>

                <div class="flex-grow-1 ms-3">
                    {{-- Hàng trên: tên + ngày + sao --}}
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $userName }}</h6>
                            <small class="text-muted">
                                {{ optional($review->created_at)->format('F d, Y') }}
                                @if ($review->order_id)
                                    · <span class="text-success">Đã mua tại cửa hàng</span>
                                @endif
                            </small>
                        </div>

                        <ul class="d-flex text-warning m-0 fs-18 list-unstyled ms-3">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($review->rating >= $i)
                                    <li><i class="bx bxs-star"></i></li>
                                @elseif ($review->rating >= $i - 0.5)
                                    <li><i class="bx bxs-star-half"></i></li>
                                @else
                                    <li><i class="bx bx-star"></i></li>
                                @endif
                            @endfor
                        </ul>
                    </div>

                    {{-- Nội dung --}}
                    <p class="text-muted mt-2 mb-2">{{ $review->content }}</p>

                    {{-- Hành động --}}
                    <div class="d-flex align-items-center gap-3 small">
                        <a href="javascript:void(0)" class="text-muted d-inline-flex align-items-center gap-1">
                            <i class="bx bx-like"></i><span>Hữu ích</span>
                        </a>
                        <span class="text-muted">|</span>
                        <a href="javascript:void(0)" class="text-muted d-inline-flex align-items-center gap-1">
                            <i class="bx bx-flag"></i><span>Báo cáo</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if (! $loop->last)
            <hr class="my-0">
        @endif

    @empty
        <p class="text-muted mb-0">Chưa có đánh giá nào cho sản phẩm này.</p>
    @endforelse
</div>

                </div>
            </div>
        </div>

    </div>
@endsection
