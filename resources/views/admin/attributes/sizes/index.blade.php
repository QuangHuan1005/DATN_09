@extends('admin.master')
@section('content')
    <div class="container-xxl">
        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Quản Lý Kích Thước</h4>
                        <a href="{{ route('admin.attributes.sizes.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Thêm Kích Thước
                        </a>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Kích Thước</th>
                                        <th>Mã Kích Thước</th>
                                        <th>Mô Tả</th>
                                        <th>Trạng Thái</th>
                                        <th>Số Biến Thể</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sizes as $index => $size)
                                        <tr>
                                            <td>{{ $sizes->firstItem() + $index }}</td>
                                            <td>
                                                <p class="text-dark fw-medium fs-15 mb-0">{{ $size->name }}</p>
                                            </td>
                                            <td>
                                                <code>{{ $size->size_code }}</code>
                                            </td>
                                            <td>{{ $size->description ?? '-' }}</td>
                                            <td>
                                                @if($size->status === 'active')
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $size->variants()->count() }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.attributes.sizes.edit', $size->id) }}"
                                                    class="btn btn-soft-primary btn-sm">
                                                    <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                </a>

                                                <form action="{{ route('admin.attributes.sizes.destroy', $size->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-soft-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa kích thước này?\n\nLưu ý: Không thể xóa nếu kích thước đang được sử dụng trong biến thể sản phẩm.')">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                            class="align-middle fs-18"></iconify-icon>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">Chưa có kích thước nào.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $sizes->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

