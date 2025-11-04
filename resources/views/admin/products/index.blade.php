@extends('admin.master')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Tất Cả Sản Phẩm</h4>
                        <form method="GET" action="{{ route('admin.products.index') }}" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo tên sản phẩm ..." value="{{ request('keyword') }}">
                        </form>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            Thêm Sản Phẩm
                        </a>

                        {{-- <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                This Month
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Download</a>
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Export</a>
                                <!-- item-->
                                <a href="#!" class="dropdown-item">Import</a>
                            </div>
                        </div> --}}
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
                                        <th>Tên Sản Phẩm & Size</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                        <th>Danh Mục</th>
                                        <th>Xếp Hạng</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr @if ($product->trashed()) class="table-danger" @endif>
                                            <td>
                                                <div class="form-check ms-1">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        @if ($product->photoAlbums->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $product->photoAlbums->first()->image) }}"
                                                                alt="" class="avatar-md">
                                                        @else
                                                            <img src="{{ asset('images/no-image.png') }}" alt=""
                                                                class="avatar-md">
                                                        @endif

                                                    </div>
                                                    <div>
                                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                                            class="text-dark fw-medium fs-15">{{ $product->name }}</a>
                                                        <p class="text-muted mb-0 mt-1 fs-13"><span>Size : </span>S , M , L
                                                            , Xl
                                                        </p>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                {{ number_format($product->variants->min('sale'), 0, ',', '.') }}₫
                                                {{-- {{ number_format($product->variants->max('price'), 0, ',', '.') }}₫ --}}
                                            </td>


                                            <td>
                                                <p class="mb-1 text-muted"><span class="text-dark fw-medium">486 Item</span>
                                                    Left</p>
                                                <p class="mb-0 text-muted">155 Sold</p>
                                            </td>
                                            <td> {{ $product->category->name ?? 'Chưa phân loại' }}</td>
                                            <td> <span class="badge p-1 bg-light text-dark fs-12 me-1"><i
                                                        class="bx bxs-star align-text-top fs-14 text-warning me-1"></i>
                                                    4.5</span> 55 Review</td>
                                            <td>
                                                @if (!$product->trashed())
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                        class="btn btn-soft-info btn-sm"><iconify-icon
                                                            icon="solar:eye-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="btn btn-soft-primary btn-sm"><iconify-icon
                                                            icon="solar:pen-2-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>

                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-soft-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa mềm danh mục này?')">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.products.restore', $product->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-soft-success btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn khôi phục danh mục này?')">
                                                            <iconify-icon
                                                                icon="solar:restart-circle-broken"class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.products.forceDelete', $product->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-soft-secondary btn-sm"
                                                            onclick="return confirm('Xóa vĩnh viễn, không thể hoàn tác. Tiếp tục?')">
                                                            <iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $products->links() }}
                            {{-- <ul class="pagination justify-content-end mb-0">z
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                            </ul> --}}
                        </nav>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
