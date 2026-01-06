@extends('admin.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">
                            {{ request('trash') ? 'Thùng Rác Sản Phẩm' : 'Danh Sách Sản Phẩm' }}
                        </h4>

                        {{-- Form Tìm kiếm --}}
                        <form method="GET" action="{{ route('admin.products.index') }}" class="search-bar me-3">
                            {{-- Giữ trạng thái thùng rác khi tìm kiếm --}}
                            @if(request('trash')) <input type="hidden" name="trash" value="1"> @endif
                            
                            <div class="position-relative">
                                <input type="search" name="keyword" id="search" class="form-control"
                                    placeholder="Tìm theo tên, mã sản phẩm..." value="{{ request('keyword') }}">
                            </div>
                        </form>

                        <div class="d-flex gap-2">
                            @if(request('trash'))
                                {{-- Nút quay lại danh sách chính --}}
                                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bx bx-arrow-back"></i> Quay lại danh sách
                                </a>
                            @else
                                {{-- Nút đi tới thùng rác --}}
                                <a href="{{ route('admin.products.index', ['trash' => 1]) }}" class="btn btn-sm btn-outline-danger">
                                    <i class="bx bx-trash"></i> Thùng rác
                                </a>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                                    Thêm Sản Phẩm Mới
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check ms-1">
                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
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
                                    @forelse ($products as $product)
                                        <tr @if ($product->trashed()) class="table-danger-subtle" @endif>
                                            <td>
                                                <div class="form-check ms-1">
                                                    <input type="checkbox" class="form-check-input checkItem"
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
                                                            <img src="{{ asset('storage/' . $productImage) }}" alt="Ảnh" class="avatar-md rounded">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" alt="No image" class="avatar-md rounded">
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
                                                    $prices = $product->variants->map(function($v) {
                                                        return ($v->sale > 0 && $v->sale < $v->price) ? $v->sale : $v->price;
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
                                                        {{-- NHÓM NÚT KHI ĐANG BÁN --}}
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
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="Đưa sản phẩm vào thùng rác?">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-danger btn-sm" title="Xóa tạm thời">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    @else
                                                        {{-- NHÓM NÚT KHI TRONG THÙNG RÁC --}}
                                                        <form action="{{ route('admin.products.restore', $product->id) }}"
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="Khôi phục sản phẩm này về danh sách bán?">
                                                            @csrf
                                                            <button type="submit" class="btn btn-soft-success btn-sm" title="Khôi phục">
                                                                <iconify-icon icon="solar:restart-circle-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.products.forceDelete', $product->id) }}"
                                                            method="POST" class="d-inline-block swal-confirm-form" data-text="XÓA VĨNH VIỄN: Dữ liệu và hình ảnh sẽ mất hoàn toàn!">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-soft-secondary btn-sm" title="Xóa cứng">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="align-middle fs-18"></iconify-icon>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Không có dữ liệu nào để hiển thị.</td>
                                        </tr>
                                    @endforelse
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
            // Cấu hình Toast
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

            // Xử lý xác nhận Form
            $(document).on('submit', '.swal-confirm-form', function(e) {
                e.preventDefault();
                const form = this;
                const text = $(form).data('text');

                Swal.fire({
                    title: 'Xác nhận?',
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

            // Chọn tất cả Checkbox
            $('#checkAll').on('change', function() {
                $('.checkItem').prop('checked', this.checked);
            });
        });
    })(jQuery);
</script>

<style>
    /* Làm mờ nhẹ hàng trong thùng rác */
    .table-danger-subtle {
        background-color: rgba(255, 0, 0, 0.03);
    }
    .avatar-md {
        object-fit: cover;
    }
</style>
@endsection