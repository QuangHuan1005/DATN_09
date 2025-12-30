@extends('admin.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh Sách Sản Phẩm</h4>
                        <form method="GET" action="{{ route('admin.products.index') }}" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo tên, mã sản phẩm..." value="{{ request('keyword') }}">
                        </form>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            Thêm Sản Phẩm Mới
                        </a>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check ms-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>Sản Phẩm & Biến Thể</th>
                                        <th>Giá Bán (Min - Max)</th>
                                        <th>Tồn Kho & Bán Ra</th>
                                        <th>Danh Mục</th>
                                        <th>Đánh Giá</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr @if ($product->trashed()) class="table-danger" @endif>
                                            <td>
                                                <div class="form-check ms-1">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customCheck_{{ $product->id }}">
                                                    <label class="form-check-label"
                                                        for="customCheck_{{ $product->id }}">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        @php
                                                            $firstVariantWithImage = $product->variants->firstWhere('image', '!=', null);
                                                            $productImage = $firstVariantWithImage ? $firstVariantWithImage->image : null;
                                                        @endphp

                                                        @if ($productImage)
                                                            <img src="{{ asset('storage/' . $productImage) }}" alt="Ảnh" class="avatar-md">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" alt="No image" class="avatar-md">
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                                            class="text-dark fw-medium fs-15">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</a>
                                                        <p class="text-muted mb-0 mt-1 fs-13"><span>Kích cỡ: </span>
                                                            @if ($product->variants->isNotEmpty())
                                                                {{ $product->variants->pluck('size.size_code')->unique()->implode(', ') }}
                                                            @else
                                                                Không áp dụng
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    // Lấy giá bán thấp nhất và cao nhất từ các biến thể
                                                    // Ưu tiên lấy cột 'sale' nếu có, nếu không lấy 'price'
                                                    $prices = $product->variants->map(function($v) {
                                                        return $v->sale > 0 ? $v->sale : $v->price;
                                                    });
                                                    $minPrice = $prices->min();
                                                    $maxPrice = $prices->max();
                                                @endphp
                                                
                                                @if($minPrice > 0)
                                                    <span class="text-dark fw-bold">
                                                        {{ number_format($minPrice, 0, ',', '.') }}₫
                                                        @if($minPrice != $maxPrice)
                                                            - {{ number_format($maxPrice, 0, ',', '.') }}₫
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-muted">Liên hệ</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- Sử dụng dữ liệu từ withSum() trong Controller --}}
                                                <p class="mb-1 text-muted">
                                                    <span class="text-dark fw-medium">
                                                        Tồn: {{ number_format($product->total_stock ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </p>
                                                <p class="mb-0 text-muted">
                                                    Đã bán: <strong class="text-success">{{ number_format($product->total_sold ?? 0, 0, ',', '.') }}</strong>
                                                </p>
                                            </td>
                                            <td> {{ $product->category->name ?? 'Chưa phân loại' }}</td>
                                            <td>
                                                {{-- Sử dụng dữ liệu từ withAvg() và withCount() trong Controller --}}
                                                @php
                                                    $avgRating = number_format($product->avg_rating ?? 0, 1);
                                                    $totalReviews = $product->total_reviews ?? 0;
                                                @endphp
                                                <span class="badge p-1 bg-light text-dark fs-12 me-1 border">
                                                    @if ($totalReviews > 0)
                                                        <i class="bx bxs-star align-text-top fs-14 text-warning me-1"></i>
                                                    @endif
                                                    {{ $avgRating }}
                                                </span>
                                                <p class="text-muted mb-0 mt-1 fs-12">{{ $totalReviews }} lượt đánh giá</p>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    @if (!$product->trashed())
                                                        <a href="{{ route('admin.products.variants.product', $product->id) }}"
                                                            class="btn btn-soft-success btn-sm" title="Quản lý biến thể">
                                                            <iconify-icon icon="solar:list-broken" class="align-middle fs-18"></iconify-icon>
                                                        </a>
                                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                                            class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                                            <iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon>
                                                        </a>
                                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                                            class="btn btn-soft-primary btn-sm" title="Chỉnh sửa">
                                                            <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                        </a>
                                                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="Bạn muốn ẩn sản phẩm này?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.products.restore', $product->id) }}"
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="Khôi phục sản phẩm này?">
                                                            @csrf
                                                            <button type="submit" class="btn btn-soft-success btn-sm">
                                                                <iconify-icon icon="solar:restart-circle-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.products.forceDelete', $product->id) }}"
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="Xóa vĩnh viễn không thể hoàn tác!">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-secondary btn-sm">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $products->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (function($) {
        $(document).ready(function() {
            // 1. Cấu hình Toast hiển thị thông báo
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
            @endif
            @if(session('error'))
                Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
            @endif

            // 2. Xử lý hộp thoại xác nhận SweetAlert2 cho các Form
            $('.swal-confirm-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const text = $(form).data('text');

                Swal.fire({
                    title: 'Xác nhận hành động',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    })(jQuery);
</script>
@endsection