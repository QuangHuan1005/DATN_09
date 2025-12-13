@extends('admin.master')
@section('content')
    <div class="container-xxl">
        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Tất Cả Danh Mục</h4>
                        <form method="GET" action="{{ route('admin.categories.index') }}" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo tên danh mục ..." value="{{ request('keyword') }}">
                        </form>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                            Thêm Danh Mục
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
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>STT</th>
                                        <th>Tên Danh Mục</th>
                                        <th>Slug</th>
                                        <th>Danh Mục Cha</th>
                                        <th>Mô Tả</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr @if ($category->trashed()) class="table-danger" @endif>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2"></label>
                                                </div>
                                            </td>
                                            <td>{{ $category->id }}</td>

                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    {{-- <div
                                                    class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                    <img src="assets/images/product/p-1.png" alt=""
                                                        class="avatar-md">
                                                </div> --}}
                                                    <p class="text-dark fw-medium fs-15 mb-0">{{ $category->name }}
                                                    </p>
                                                </div>

                                            </td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                @if ($category->parent)
                                                    {{ $category->parent->name }}
                                                @else
                                                    <em>(Danh mục gốc)</em>
                                                @endif
                                            </td>
                                            <td>{{ $category->description ?? ' -' }} </td>
                                            <td>
                                                @if (!$category->trashed())
                                                    <a href="{{ route('admin.categories.show', $category->id) }}"
                                                        class="btn btn-soft-info btn-sm"><iconify-icon
                                                            icon="solar:eye-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>
                                                    <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                        class="btn btn-soft-primary btn-sm"><iconify-icon
                                                            icon="solar:pen-2-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>

                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}"
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
                                                    <form action="{{ route('admin.categories.restore', $category->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-soft-success btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn khôi phục danh mục này?')">
                                                            <iconify-icon
                                                                icon="solar:restart-circle-broken"class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.categories.forceDelete', $category->id) }}"
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
                            {{ $categories->links() }}
                            {{-- <ul class="pagination justify-content-end mb-0">
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
