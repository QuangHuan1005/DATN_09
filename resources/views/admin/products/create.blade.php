@extends('admin.master')

@section('content')
<div class="container-xxl">
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                {{-- CARD THÔNG TIN CƠ BẢN --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Tên Sản Phẩm <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Tên sản phẩm">
                                    <div class="text-danger mt-1 small error-msg" id="err_name">@error('name') {{ $message }} @enderror</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="category_id" class="form-label fw-bold">Danh Mục <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                    <option value="">Chọn một danh mục</option>
                                    @foreach ($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger mt-1 small error-msg" id="err_category_id">@error('category_id') {{ $message }} @enderror</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="product_code" class="form-label fw-bold">Mã sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" id="product_code" class="form-control @error('product_code') is-invalid @enderror" name="product_code" value="{{ old('product_code') }}" placeholder="Ví dụ: SP001">
                                    <div class="text-danger mt-1 small error-msg" id="err_product_code">@error('product_code') {{ $message }} @enderror</div>
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
                            <label class="form-label fw-bold">Album Ảnh Tổng Quát (Slider)</label>
                            <input type="file" name="album_images[]" class="form-control shadow-none" multiple accept="image/*">
                            <small class="text-muted italic">Ảnh chung cho toàn bộ sản phẩm</small>
                        </div>
                    </div>
                </div>

                {{-- BƯỚC 1: CHỌN THUỘC TÍNH --}}
                <div class="card mb-4 border-info shadow-sm">
                    <div class="card-header bg-info-subtle d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-info">Bước 1: Chọn Thuộc Tính <span class="text-danger">*</span></h4>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-info" id="selectAllAttributes">Chọn tất cả</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clearAllAttributes">Bỏ chọn</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-primary mb-0">Size:</label>
                                    <input type="text" class="form-control form-control-sm w-50 shadow-none" id="searchSize" placeholder="Tìm size...">
                                </div>
                                <div class="p-3 border rounded bg-light" id="sizeContainer" style="max-height: 200px; overflow-y: auto;">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($sizes as $size)
                                            <div class="size-box">
                                                <input type="checkbox" class="btn-check size-checkbox" id="size_{{ $size->id }}" value="{{ $size->id }}" data-code="{{ $size->size_code }}">
                                                <label class="btn btn-outline-primary btn-sm px-3 shadow-none" for="size_{{ $size->id }}">{{ $size->size_code }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-danger mt-1 small error-msg" id="err_sizes"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label fw-bold text-primary mb-0">Màu sắc:</label>
                                    <input type="text" class="form-control form-control-sm w-50 shadow-none" id="searchColor" placeholder="Tìm màu...">
                                </div>
                                <div class="p-3 border rounded bg-light" id="colorContainer" style="max-height: 200px; overflow-y: auto;">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($colors as $color)
                                            <div class="color-box">
                                                <input type="checkbox" class="btn-check color-checkbox" id="color_{{ $color->id }}" value="{{ $color->id }}" data-code="{{ $color->color_code }}" data-name="{{ $color->name }}">
                                                <label class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-none" for="color_{{ $color->id }}">
                                                    <span style="width:12px; height:12px; background:{{ $color->color_code }}; border-radius:50%; border:1px solid #ddd; display:inline-block"></span>
                                                    {{ $color->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-danger mt-1 small error-msg" id="err_colors"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BƯỚC 2: DANH SÁCH BIẾN THỂ --}}
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary-subtle d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-primary">Bước 2: Chi Tiết Biến Thể & Ảnh Theo Màu <span class="text-danger">*</span></h4>
                        <button type="button" class="btn btn-primary btn-sm shadow-sm" id="btnGenerateVariants">
                            <i class="bx bx-shuffle"></i> Tạo Biến Thể
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="colorImagesSection" class="mb-4" style="display: none;">
                            <h6 class="fw-bold mb-3 text-dark"><i class="bx bx-images"></i> Upload ảnh đại diện theo màu:</h6>
                            <div id="colorImagesContainer" class="d-flex flex-wrap gap-3 p-3 border rounded bg-white shadow-sm"></div>
                            <hr>
                        </div>

                        <div id="variantsTableContainer" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle mb-0 text-center">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Màu Sắc</th>
                                            <th>Kích Thước</th>
                                            <th width="22%">Giá Gốc (₫) <span class="text-danger">*</span></th>
                                            <th width="22%">Giá Sale (₫)</th>
                                            <th width="15%">Số Lượng <span class="text-danger">*</span></th>
                                            <th width="5%">Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variantsTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        <div id="noVariantsMsg" class="text-center py-5">
                            <i class="bx bx-purchase-tag-alt fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0" id="statusMessage">Chưa có biến thể nào. Chọn thuộc tính ở Bước 1 và nhấn Tạo Biến Thể.</p>
                            <div class="text-danger fw-bold mt-2 error-msg" id="err_variants"></div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white mt-4 border rounded d-flex justify-content-end gap-2 shadow-sm">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4 shadow-none">Hủy</a>
                    <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                        <i class="bx bx-save"></i> LƯU SẢN PHẨM
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
    const colorImagesSection = document.getElementById('colorImagesSection');
    const colorImagesContainer = document.getElementById('colorImagesContainer');
    const noMsg = document.getElementById('noVariantsMsg');
    const tbody = document.getElementById('variantsTableBody');

    function clearError(errId, inputId = null) {
        const errEl = document.getElementById(errId);
        if(errEl) errEl.innerText = '';
        if (inputId) {
            const el = document.getElementById(inputId);
            if(el) el.classList.remove('is-invalid');
        }
    }

    // Tìm kiếm nhanh Size & Màu
    const setupSearch = (inputId, itemClass) => {
        const searchInput = document.getElementById(inputId);
        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                let filter = e.target.value.toLowerCase();
                document.querySelectorAll(itemClass).forEach(item => {
                    item.style.display = item.innerText.toLowerCase().includes(filter) ? "" : "none";
                });
            });
        }
    };
    setupSearch('searchSize', '#sizeContainer .size-box');
    setupSearch('searchColor', '#colorContainer .color-box');

    // Chọn/Bỏ chọn tất cả
    document.getElementById('selectAllAttributes').addEventListener('click', () => {
        document.querySelectorAll('.size-checkbox, .color-checkbox').forEach(cb => cb.checked = true);
        clearError('err_sizes'); clearError('err_colors');
    });
    document.getElementById('clearAllAttributes').addEventListener('click', () => {
        document.querySelectorAll('.size-checkbox, .color-checkbox').forEach(cb => cb.checked = false);
    });

    // Logic tạo biến thể
    btnGenerate.addEventListener('click', function() {
        const selectedSizes = Array.from(document.querySelectorAll('.size-checkbox:checked')).map(cb => ({
            id: cb.value, code: cb.dataset.code
        }));
        const selectedColors = Array.from(document.querySelectorAll('.color-checkbox:checked')).map(cb => ({
            id: cb.value, code: cb.dataset.code, name: cb.dataset.name
        }));

        if (selectedSizes.length === 0 || selectedColors.length === 0) {
            document.getElementById('err_sizes').innerText = selectedSizes.length === 0 ? 'Vui lòng chọn size.' : '';
            document.getElementById('err_colors').innerText = selectedColors.length === 0 ? 'Vui lòng chọn màu.' : '';
            return;
        }

        tbody.innerHTML = '';
        colorImagesContainer.innerHTML = '';
        tableContainer.style.display = 'block';
        colorImagesSection.style.display = 'block';
        noMsg.style.display = 'none';
        clearError('err_variants');

        // 1. Render khung upload ảnh theo màu
        selectedColors.forEach(color => {
            const div = document.createElement('div');
            div.className = "text-center border p-2 bg-white rounded shadow-sm";
            div.style.width = "140px";
            div.innerHTML = `
                <div class="small fw-bold mb-2 text-primary text-truncate">${color.name}</div>
                <div class="position-relative">
                    <img src="https://via.placeholder.com/100" id="prev_color_${color.id}" 
                         class="img-thumbnail mb-2" style="width: 100px; height: 100px; object-fit: cover; cursor: pointer" 
                         onclick="document.getElementById('file_color_${color.id}').click()">
                </div>
                <input type="file" name="color_images[${color.id}]" id="file_color_${color.id}" 
                       class="d-none" accept="image/*" onchange="previewVariantImg(this, 'prev_color_${color.id}')">
            `;
            colorImagesContainer.appendChild(div);
        });

        // 2. Render bảng biến thể kèm validate
        let index = 0;
        selectedColors.forEach(color => {
            selectedSizes.forEach(size => {
                const row = document.createElement('tr');
                row.className = "variant-row";
                row.innerHTML = `
                    <td class="bg-light-subtle">
                        <div class="d-flex align-items-center justify-content-center gap-1">
                            <span style="width:10px; height:10px; background:${color.code}; border-radius:50%; display:inline-block; border:1px solid #ddd"></span>
                            <span class="fw-bold">${color.name}</span>
                        </div>
                        <input type="hidden" name="variants[${index}][color_id]" value="${color.id}">
                    </td>
                    <td>
                        <span class="badge bg-info text-dark">${size.code}</span>
                        <input type="hidden" name="variants[${index}][size_id]" value="${size.id}">
                    </td>
                    <td>
                        <input type="number" name="variants[${index}][price]" class="form-control form-control-sm v-price" placeholder="Nhập giá">
                        <div class="text-danger small v-err-price" style="font-size: 11px;"></div>
                    </td>
                    <td>
                        <input type="number" name="variants[${index}][sale]" class="form-control form-control-sm v-sale" placeholder="Giá giảm">
                        <div class="text-danger small v-err-sale" style="font-size: 11px;"></div>
                    </td>
                    <td>
                        <input type="number" name="variants[${index}][quantity]" class="form-control form-control-sm v-qty" value="10">
                        <div class="text-danger small v-err-qty" style="font-size: 11px;"></div>
                    </td>
                    <td><button type="button" class="btn btn-sm btn-soft-danger shadow-none" onclick="this.closest('tr').remove()"><i class="bx bx-trash"></i></button></td>
                `;
                tbody.appendChild(row);
                index++;
            });
        });
    });

    // Validate FORM khi SUBMIT
    document.getElementById('productForm').addEventListener('submit', function(e) {
        let hasError = false;

        // Validate cơ bản
        if (!document.getElementById('name').value.trim()) {
            document.getElementById('err_name').innerText = 'Tên không được để trống.';
            document.getElementById('name').classList.add('is-invalid');
            hasError = true;
        }
        if (!document.getElementById('category_id').value) {
            document.getElementById('err_category_id').innerText = 'Chọn danh mục.';
            document.getElementById('category_id').classList.add('is-invalid');
            hasError = true;
        }
        if (!document.getElementById('product_code').value.trim()) {
            document.getElementById('err_product_code').innerText = 'Mã SP không được để trống.';
            document.getElementById('product_code').classList.add('is-invalid');
            hasError = true;
        }

        // Validate Biến thể
        const rows = document.querySelectorAll('.variant-row');
        if (rows.length === 0) {
            document.getElementById('err_variants').innerText = 'Phải tạo ít nhất 1 biến thể.';
            hasError = true;
        } else {
            document.getElementById('err_variants').innerText = '';
            rows.forEach(row => {
                const pInput = row.querySelector('.v-price');
                const sInput = row.querySelector('.v-sale');
                const qInput = row.querySelector('.v-qty');

                const pErr = row.querySelector('.v-err-price');
                const sErr = row.querySelector('.v-err-sale');
                const qErr = row.querySelector('.v-err-qty');

                // Reset
                pErr.innerText = ''; sErr.innerText = ''; qErr.innerText = '';
                pInput.classList.remove('is-invalid');
                sInput.classList.remove('is-invalid');
                qInput.classList.remove('is-invalid');

                // Check Giá gốc
                if (!pInput.value || pInput.value <= 0) {
                    pErr.innerText = 'Nhập giá > 0';
                    pInput.classList.add('is-invalid');
                    hasError = true;
                }

                // Check Giá sale
                if (sInput.value && parseFloat(sInput.value) >= parseFloat(pInput.value)) {
                    sErr.innerText = 'Sale < Gốc';
                    sInput.classList.add('is-invalid');
                    hasError = true;
                }

                // Check Số lượng
                if (qInput.value === "" || qInput.value < 0) {
                    qErr.innerText = 'Nhập số lượng';
                    qInput.classList.add('is-invalid');
                    hasError = true;
                }
            });
        }

        if (hasError) {
            e.preventDefault();
            const firstErr = document.querySelector('.is-invalid');
            if(firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    ['name', 'category_id', 'product_code'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => {
            clearError('err_' + id, id);
        });
    });
});

function previewVariantImg(input, prevId) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e => document.getElementById(prevId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
    #sizeContainer::-webkit-scrollbar, #colorContainer::-webkit-scrollbar { width: 4px; }
    #sizeContainer::-webkit-scrollbar-thumb, #colorContainer::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 10px; }
    .bg-info-subtle { background-color: #e0f7fa !important; }
    .bg-primary-subtle { background-color: #e8f0fe !important; }
    .btn-soft-danger { background-color: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; }
    .btn-soft-danger:hover { background-color: #ef4444; color: white; }
    .error-msg:empty { display: none; }
    .img-thumbnail:hover { border-color: #3b82f6; }
    .is-invalid { border-color: #dc3545 !important; }
</style>
@endsection