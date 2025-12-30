@extends('admin.master')

@section('content')
<div class="container-xxl">
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Tên Sản Phẩm</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Tên sản phẩm">
                                    @error('name') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="category_id" class="form-label fw-bold">Danh Mục</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">Chọn một danh mục</option>
                                    @foreach ($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="product_code" class="form-label fw-bold">Mã sản phẩm</label>
                                    <input type="text" id="product_code" class="form-control shadow-none" name="product_code" value="{{ old('product_code') }}" placeholder="#******">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="material" class="form-label fw-bold">Chất Liệu</label>
                                    <input type="text" id="material" class="form-control shadow-none" name="material" value="{{ old('material') }}" placeholder="Cotton, Denim...">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="onpage" class="form-label fw-bold">Hiển Thị Trang Chủ</label>
                                <select class="form-control" id="onpage" name="onpage">
                                    <option value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Mô Tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả sản phẩm...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Album Ảnh Sản Phẩm</label>
                            <input type="file" name="album_images[]" class="form-control" multiple accept="image/*">
                            <small class="text-muted italic">Có thể chọn nhiều ảnh cùng lúc</small>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info-subtle d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-info">Bước 1: Chọn Thuộc Tính Muốn Tạo</h4>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-info" id="selectAllAttributes">Chọn tất cả</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllAttributes">Bỏ chọn</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-primary mb-0">Kích thước (Size):</label>
                                    <input type="text" class="form-control form-control-sm w-50" id="searchSize" placeholder="Tìm size...">
                                </div>
                                <div class="p-3 border rounded bg-light" id="sizeContainer" style="max-height: 220px; overflow-y: auto;">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($sizes as $size)
                                            <div class="attribute-item size-box">
                                                <input type="checkbox" class="btn-check size-checkbox" id="size_{{ $size->id }}" value="{{ $size->id }}" data-code="{{ $size->size_code }}" data-name="{{ $size->name }}">
                                                <label class="btn btn-outline-primary btn-sm px-3" for="size_{{ $size->id }}">{{ $size->size_code }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-primary mb-0">Màu sắc (Color):</label>
                                    <input type="text" class="form-control form-control-sm w-50" id="searchColor" placeholder="Tìm màu...">
                                </div>
                                <div class="p-3 border rounded bg-light" id="colorContainer" style="max-height: 220px; overflow-y: auto;">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($colors as $color)
                                            <div class="attribute-item color-box">
                                                <input type="checkbox" class="btn-check color-checkbox" id="color_{{ $color->id }}" value="{{ $color->id }}" data-code="{{ $color->color_code }}" data-name="{{ $color->name }}">
                                                <label class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" for="color_{{ $color->id }}">
                                                    <span style="width:12px; height:12px; background:{{ $color->color_code }}; border-radius:50%; border:1px solid #ddd; display:inline-block"></span>
                                                    {{ $color->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary-subtle d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-primary">Bước 2: Danh Sách Biến Thể Chi Tiết</h4>
                        <button type="button" class="btn btn-primary btn-sm shadow-sm" id="btnGenerateVariants">
                            <i class="bx bx-shuffle"></i> Tạo Biến Thể Đã Chọn
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div id="variantsTableContainer" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-centered align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="5%" class="text-center">STT</th>
                                            <th>Phân Loại (Size - Màu)</th>
                                            <th width="20%">Giá Gốc (₫) <span class="text-danger">*</span></th>
                                            <th width="20%">Giá Sale (₫)</th>
                                            <th width="15%">Số Lượng <span class="text-danger">*</span></th>
                                            <th width="5%" class="text-center">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantsTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="noVariantsMsg" class="text-center py-5">
                            <i class="bx bx-purchase-tag-alt fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">Vui lòng chọn thuộc tính ở Bước 1 và nhấn "Tạo Biến Thể".</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white mt-4 border rounded d-flex justify-content-end gap-2 shadow-sm">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Hủy</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                        <i class="bx bx-save"></i> LƯU SẢN PHẨM & BIẾN THỂ
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnGenerate = document.getElementById('btnGenerateVariants');
    const tableContainer = document.getElementById('variantsTableContainer');
    const noMsg = document.getElementById('noVariantsMsg');
    const tbody = document.getElementById('variantsTableBody');

    // 1. TÌM KIẾM NHANH SIZE
    document.getElementById('searchSize').addEventListener('input', function(e) {
        let filter = e.target.value.toLowerCase();
        document.querySelectorAll('#sizeContainer .size-box').forEach(item => {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // 2. TÌM KIẾM NHANH MÀU
    document.getElementById('searchColor').addEventListener('input', function(e) {
        let filter = e.target.value.toLowerCase();
        document.querySelectorAll('#colorContainer .color-box').forEach(item => {
            let text = item.innerText.toLowerCase();
            item.style.display = text.includes(filter) ? "" : "none";
        });
    });

    // 3. CHỌN/BỎ CHỌN TẤT CẢ
    document.getElementById('selectAllAttributes').addEventListener('click', function() {
        document.querySelectorAll('.size-checkbox, .color-checkbox').forEach(cb => cb.checked = true);
    });
    document.getElementById('clearAllAttributes').addEventListener('click', function() {
        document.querySelectorAll('.size-checkbox, .color-checkbox').forEach(cb => cb.checked = false);
    });

    // 4. LOGIC TẠO BIẾN THỂ
    btnGenerate.addEventListener('click', function() {
        const selectedSizes = Array.from(document.querySelectorAll('.size-checkbox:checked')).map(cb => ({
            id: cb.value,
            code: cb.dataset.code,
            name: cb.dataset.name
        }));

        const selectedColors = Array.from(document.querySelectorAll('.color-checkbox:checked')).map(cb => ({
            id: cb.value,
            code: cb.dataset.code,
            name: cb.dataset.name
        }));

        if (selectedSizes.length === 0 || selectedColors.length === 0) {
            alert('Vui lòng chọn ít nhất 1 Size và 1 Màu sắc ở Bước 1!');
            return;
        }

        tbody.innerHTML = '';
        tableContainer.style.display = 'block';
        noMsg.style.display = 'none';

        let index = 0;
        selectedSizes.forEach(size => {
            selectedColors.forEach(color => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="text-center text-muted small">${index + 1}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info-subtle text-info border border-info px-2">${size.code}</span>
                            <div style="width: 14px; height: 14px; background:${color.code}; border-radius:50%; border:1px solid #ddd"></div>
                            <span class="fw-medium">${size.name} - ${color.name}</span>
                        </div>
                        <input type="hidden" name="variants[${index}][size_id]" value="${size.id}">
                        <input type="hidden" name="variants[${index}][color_id]" value="${color.id}">
                    </td>
                    <td><input type="number" name="variants[${index}][price]" class="form-control form-control-sm" placeholder="Nhập giá bán" min="0" required></td>
                    <td><input type="number" name="variants[${index}][sale]" class="form-control form-control-sm" placeholder="0" min="0"></td>
                    <td><input type="number" name="variants[${index}][quantity]" class="form-control form-control-sm" value="10" min="0" required></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-link text-danger p-0" onclick="this.closest('tr').remove()">
                            <i class="bx bx-trash fs-18"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
                index++;
            });
        });
        
        // Cuộn mượt đến bảng sau khi tạo
        tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    // 5. VALIDATION TRƯỚC KHI SUBMIT
    document.getElementById('productForm').addEventListener('submit', function(e) {
        if (tbody.children.length === 0) {
            e.preventDefault();
            alert('Bạn chưa khởi tạo danh sách biến thể sản phẩm ở Bước 2!');
        }
    });
});
</script>

<style>
    /* Custom Scrollbar cho vùng chọn thuộc tính */
    #sizeContainer::-webkit-scrollbar, #colorContainer::-webkit-scrollbar {
        width: 6px;
    }
    #sizeContainer::-webkit-scrollbar-thumb, #colorContainer::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-primary-subtle { background-color: #e8f0fe !important; }
    .btn-check:checked + .btn-outline-primary { background-color: #0d6efd; color: #fff; }
    .btn-check:checked + .btn-outline-secondary { background-color: #6c757d; color: #fff; }
    .card { box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
    .form-control:focus { border-color: #0d6efd; box-shadow: none; }
</style>
@endsection