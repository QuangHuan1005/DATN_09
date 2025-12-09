@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Danh Sách {{ $type == 'colors' ? 'Màu' : 'Kích Thước' }}</h4>
                        </div>

                        <div class="dropdown">
                            <a href="{{ route('admin.attributes.index') }}" class="btn btn-sm btn-outline-secondary">
                                Quay Lại
                            </a>
                            <a href="{{ route('admin.attributes.create', $type) }}" class="btn btn-sm btn-primary">
                                Thêm {{ $type == 'colors' ? 'màu' : 'size' }} mới
                            </a>
                            @if ($type == 'colors')
                                <a href="{{ route('admin.attributes.show', 'sizes') }}" class="btn btn-sm btn-light ">
                                    <iconify-icon icon="solar:refresh-broken" class="align-middle fs-18"></iconify-icon>
                                </a>
                            @else
                                <a href="{{ route('admin.attributes.show', 'colors') }}" class="btn btn-sm btn-light ">
                                    <iconify-icon icon="solar:refresh-broken" class="align-middle fs-18"></iconify-icon>
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
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>Giá trị</th>
                                        <th>
                                            @if ($type == 'colors')
                                                Mã Hex
                                            @else
                                                Mã Size
                                            @endif
                                        </th>
                                        <th>Mô tả</th>
                                        <th>Ngày Tạo</th>
                                        {{-- <th>Trạng Thái</th> --}}
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($items as $item)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($type == 'colors')
                                                <span
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                    <i class="bx bxs-circle fs-30"
                                                        style="color: {{ $item->color_code ?? null }}"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                    {{ $item->size_code ?? '-' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $item->description ?? '-' }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>

                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- <a href="#" class="btn btn-soft-info btn-sm"
                                                    title="Xem chi tiết"><iconify-icon icon="solar:eye-broken"
                                                        class="align-middle fs-18"></iconify-icon></a> --}}
                                                <a href="#" class="btn btn-soft-primary btn-sm"><iconify-icon
                                                        icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon></a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-soft-danger btn-sm sweet-delete"
                                                    data-id="{{ $item->id }}" data-type="{{ $type }}"
                                                    title="Xóa">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                        class="align-middle fs-18"></iconify-icon>
                                                </a>

                                                <form id="delete-form-{{ $type }}-{{ $item->id }}"
                                                    action="{{ route('admin.attributes.destroy', [$type, $item->id]) }}"
                                                    method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>


                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            {{ $items->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.sweet-delete').forEach(function(btn) {
            btn.addEventListener("click", function() {

                let id = this.getAttribute('data-id');
                let type = this.getAttribute('data-type');

                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa?',
                    text: "Dữ liệu sẽ không thể khôi phục!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy',
                    confirmButtonClass: 'btn btn-primary w-xs me-2 mt-2',
                    cancelButtonClass: 'btn btn-danger w-xs mt-2',
                    buttonsStyling: false,
                    showCloseButton: false
                    
                }).then(function(result) {

                    if (result.value) {

                        document.getElementById('delete-form-' + type + '-' + id).submit();

                        Swal.fire({
                            title: 'Đã xóa!',
                            text: 'Dữ liệu đã được xóa.',
                            icon: 'success',
                            confirmButtonClass: 'btn btn-primary w-xs mt-2',
                            buttonsStyling: false
                        });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {

                        Swal.fire({
                            title: 'Đã hủy',
                            text: 'Dữ liệu vẫn được giữ nguyên.',
                            icon: 'error',
                            confirmButtonClass: 'btn btn-primary mt-2',
                            buttonsStyling: false
                        });

                    }
                });
            });
        });
    </script>
@endsection
