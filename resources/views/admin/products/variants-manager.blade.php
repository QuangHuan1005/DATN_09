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

        {{-- Header --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="card-title mb-1">Quản Lý Biến Thể</h4>
                                <p class="text-muted mb-0">Sản phẩm: <strong>{{ $product->name }}</strong> (Mã: {{ $product->product_code }})</p>
                            </div>
                            <div>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách biến thể --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh Sách Biến Thể ({{ $variantsGroupedByColor->flatten()->count() }})</h5>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh (Theo màu)</th>
                                        <th>Kích Thước</th>
                                        <th>Màu Sắc</th>
                                        <th>Giá Gốc</th>
                                        <th>Giá Sale</th>
                                        <th>Số Lượng</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @forelse($variantsGroupedByColor as $colorId => $group)
                                        @foreach($group as $index => $variant)
                                            <tr>
                                                {{-- STT: Parent.Iteration (Màu) . Iteration (Size) --}}
                                                <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>

                                                {{-- CỘT ẢNH: Gộp ô bằng rowspan, chỉ hiện ở dòng đầu tiên của nhóm màu --}}
                                                @if($loop->first)
                                                    <td rowspan="{{ $group->count() }}" class="text-center border-end bg-light-subtle" style="vertical-align: middle;">
                                                        <div class="py-2">
                                                            @if ($variant->image)
                                                                <img src="{{ Storage::url($variant->image) }}" alt="Variant Image"
                                                                    style="width: 75px; height: 75px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                                                            @else
                                                                <div style="width: 75px; height: 75px; background: #f5f5f5; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                                    <i class="bx bx-image text-muted fs-24"></i>
                                                                </div>
                                                            @endif
                                                            <div class="mt-2 small text-primary fw-bold">
                                                                {{ $variant->color->name ?? 'Màu chung' }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif

                                                {{-- KÍCH THƯỚC --}}
                                                <td>
                                                    <span class="badge bg-info-subtle text-info border border-info">
                                                        {{ $variant->size->name ?? 'N/A' }}
                                                    </span>
                                                </td>

                                                {{-- MÀU SẮC --}}
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div style="width: 20px; height: 20px; background-color: {{ $variant->color->color_code ?? '#ccc' }}; border: 1px solid #ddd; border-radius: 50%;"></div>
                                                        <span>{{ $variant->color->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>

                                                {{-- GIÁ & SỐ LƯỢNG --}}
                                                <td>{{ number_format($variant->price, 0, ',', '.') }}đ</td>
                                                <td>{{ $variant->sale ? number_format($variant->sale, 0, ',', '.') . 'đ' : '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $variant->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $variant->quantity }}
                                                    </span>
                                                </td>
                                                
                                                {{-- TRẠNG THÁI --}}
                                                <td>
                                                    @if ($variant->status == 1)
                                                        <span class="badge bg-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-danger">Ẩn</span>
                                                    @endif
                                                </td>

                                                {{-- THAO TÁC --}}
                                                <td>
                                                    <button type="button" class="btn btn-soft-primary btn-sm btn-edit-variant"
                                                        data-id="{{ $variant->id }}" 
                                                        data-size-id="{{ $variant->size_id }}"
                                                        data-color-id="{{ $variant->color_id }}"
                                                        data-price="{{ $variant->price }}" 
                                                        data-sale="{{ $variant->sale }}"
                                                        data-quantity="{{ $variant->quantity }}"
                                                        data-status="{{ $variant->status }}"
                                                        data-image="{{ $variant->image }}">
                                                        <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                    </button>
                                                    
                                                    <form action="{{ route('admin.products.variants.destroy', $variant->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-soft-danger btn-sm" onclick="return confirm('Xóa biến thể này?')">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr><td colspan="9" class="text-center py-4">Chưa có biến thể nào.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Sửa Biến Thể --}}
    <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVariantModalLabel">Chỉnh Sửa Biến Thể</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editVariantForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_size_id" class="form-label">Kích Thước <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_size_id" name="size_id">
                                    <option value="">-- Chọn size --</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }} ({{ $size->size_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_color_id" class="form-label">Màu Sắc <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_color_id" name="color_id">
                                    <option value="">-- Chọn màu --</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" data-color="{{ $color->color_code }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_price" class="form-label">Giá Gốc <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_price" name="price" value="0" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_sale" class="form-label">Giá Sale</label>
                                <input type="number" class="form-control" id="edit_sale" name="sale" value="" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity" value="0" min="0">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Không hoạt động</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_image" class="form-label">Ảnh Biến Thể</label>
                                <input type="file" class="form-control" id="edit_image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                            </div>
                        </div>

                        <div id="edit_current_image_container" style="display: none;" class="mb-3">
                            <label class="form-label">Ảnh Hiện Tại:</label><br>
                            <img id="edit_current_image" src="" alt="Current Image" style="max-width: 150px; border: 1px solid #ddd; border-radius: 4px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-check"></i> Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Dữ liệu từ server
            const sizes = @json($sizes);
            const colors = @json($colors);
            const editForm = document.getElementById('editVariantForm');
            const editModalEl = document.getElementById('editVariantModal');
            const editModal = new bootstrap.Modal(editModalEl);

            // 2. Xử lý khi click nút Edit (Event Delegation)
            document.addEventListener('click', function(event) {
                const btn = event.target.closest('.btn-edit-variant');
                if (!btn) return;

                const variantId = btn.dataset.id;
                const sizeId    = btn.dataset.sizeId;
                const colorId   = btn.dataset.colorId;
                const price     = btn.dataset.price;
                const sale      = btn.dataset.sale;
                const quantity  = btn.dataset.quantity;
                const status    = btn.dataset.status;
                const image     = btn.dataset.image;

                // Cập nhật action cho form
                editForm.action = `/admin/product-variants/${variantId}`;

                // Fill dữ liệu
                document.getElementById('edit_size_id').value = sizeId;
                document.getElementById('edit_color_id').value = colorId;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_sale').value = (sale && sale !== "null") ? sale : '';
                document.getElementById('edit_quantity').value = quantity;
                document.getElementById('edit_status').value = status;

                // Ảnh hiện tại
                const currentImgContainer = document.getElementById('edit_current_image_container');
                const currentImgTag = document.getElementById('edit_current_image');

                if (image && image !== "null" && image !== "") {
                    currentImgTag.src = `/storage/${image}`;
                    currentImgContainer.style.display = 'block';
                } else {
                    currentImgContainer.style.display = 'none';
                }

                editModal.show();
            });

            // Reset form khi đóng modal
            editModalEl.addEventListener('hidden.bs.modal', function () {
                editForm.reset();
            });
        });
    </script>
@endsection