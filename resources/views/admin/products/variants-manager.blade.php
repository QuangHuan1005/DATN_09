@extends('admin.master')

@section('content')
    <div class="container-xxl">
        {{-- Thông báo phản hồi --}}
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="bx bx-error-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Thanh điều hướng --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1 fw-bold text-dark">Quản Lý Biến Thể Chi Tiết</h4>
                            <p class="text-muted mb-0">Sản phẩm: <span class="badge bg-primary-subtle text-primary">{{ $product->name }}</span></p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                                <i class="bx bx-plus me-1"></i> THÊM BIẾN THỂ MỚI
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light border btn-sm">
                                <i class="bx bx-left-arrow-alt"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- FORM LƯU TẬP TRUNG --}}
        <form action="{{ route('admin.products.variants.bulkUpdate', $product->id) }}" method="POST" enctype="multipart/form-data" id="main-form">
            @csrf
            @method('PUT')
            
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-dark">Danh Sách Biến Thể ({{ $variantsGroupedByColor->flatten()->count() }})</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 border">
                            <thead class="bg-light text-uppercase">
                                <tr style="font-size: 11px;" class="text-muted">
                                    <th class="ps-4" style="width: 50px;">STT</th>
                                    <th class="text-center" style="width: 120px;">Ảnh màu</th>
                                    <th>Thông tin</th>
                                    <th style="width: 180px;">Giá gốc (₫)</th>
                                    <th style="width: 180px;">Giá giảm (₫)</th>
                                    <th style="width: 100px;">Kho</th>
                                    <th class="text-center" style="width: 80px;">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($variantsGroupedByColor as $colorId => $group)
                                    @foreach($group as $index => $variant)
                                        <tr class="variant-row">
                                            <td class="ps-4 text-muted small">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                            
                                            @if($loop->first)
                                                <td rowspan="{{ $group->count() }}" class="text-center border-start border-end bg-light-subtle" style="vertical-align: middle;">
                                                    <div class="py-2">
                                                        <div class="image-upload-wrapper" onclick="document.getElementById('file-{{ $colorId }}').click();" style="cursor: pointer;">
                                                            <img src="{{ $variant->image ? Storage::url($variant->image) : 'https://placehold.co/80x80?text=No+Image' }}" 
                                                                 id="preview-{{ $colorId }}" class="rounded shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;">
                                                            <div class="image-overlay rounded"><i class="bx bx-edit-alt text-white"></i></div>
                                                        </div>
                                                        <input type="file" id="file-{{ $colorId }}" name="color_images[{{ $colorId }}]" class="d-none" accept="image/*" onchange="previewImg(this, 'preview-{{ $colorId }}')">
                                                        <div class="mt-1 small fw-bold text-primary text-uppercase">{{ $variant->color->name }}</div>
                                                    </div>
                                                </td>
                                            @endif

                                            <td>
                                                <div class="fw-bold text-dark">{{ $variant->color->name }}</div>
                                                <span class="badge bg-secondary-subtle text-secondary border">Size: {{ $variant->size->name }}</span>
                                                <input type="hidden" name="variants[{{ $variant->id }}][id]" value="{{ $variant->id }}">
                                            </td>

                                            <td>
                                                <input type="text" name="variants[{{ $variant->id }}][price]" value="{{ number_format($variant->price) }}" class="form-control form-control-sm currency-input border-dashed fw-bold input-price-field">
                                            </td>
                                            <td>
                                                <input type="text" name="variants[{{ $variant->id }}][sale]" value="{{ number_format($variant->sale) }}" class="form-control form-control-sm currency-input border-dashed text-danger fw-bold input-sale-field">
                                                <div class="error-text text-danger" style="font-size: 10px; display: none;">Giá giảm > Giá gốc!</div>
                                            </td>
                                            <td>
                                                <input type="number" name="variants[{{ $variant->id }}][quantity]" value="{{ $variant->quantity }}" class="form-control form-control-sm input-quantity border-dashed text-center">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-link text-danger p-0" onclick="deleteVariant('{{ route('admin.products.variants.destroy', $variant->id) }}')">
                                                    <i class="bx bx-trash-alt fs-18"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr><td colspan="7" class="text-center py-5">Chưa có biến thể nào được tạo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-4 d-flex justify-content-center shadow-sm">
                    <button type="submit" class="btn btn-success btn-lg fw-bold px-5 shadow-lg" id="btn-submit-main">
                        <i class="bx bx-save me-2"></i> LƯU TOÀN BỘ THAY ĐỔI
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- MODAL THÊM BIẾN THỂ MỚI --}}
    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" id="add-variant-form">
                @csrf
                <div class="modal-header bg-primary py-3">
                    <h5 class="modal-title fw-bold text-white">Thêm Biến Thể Mới</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        {{-- Phần chọn ảnh mới --}}
                        <div class="col-12 text-center mb-2">
                            <label class="form-label d-block fw-bold small text-muted">Ảnh minh họa cho màu sắc</label>
                            <div class="image-upload-wrapper mx-auto" onclick="document.getElementById('add_new_variant_image').click();">
                                <img src="https://placehold.co/120x120?text=+" id="new_variant_preview" class="rounded shadow-sm border" style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="image-overlay rounded"><i class="bx bx-camera text-white fs-24"></i></div>
                            </div>
                            <input type="file" name="image" id="add_new_variant_image" class="d-none" accept="image/*" onchange="previewImg(this, 'new_variant_preview')">
                            <p class="text-muted mt-2 mb-0" style="font-size: 11px;">Nhấn vào khung trên để chọn ảnh</p>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Màu sắc</label>
                            <select name="color_id" class="form-select" required>
                                <option value="">-- Chọn màu --</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Kích thước</label>
                            <select name="size_id" class="form-select" required>
                                <option value="">-- Chọn size --</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Giá gốc (₫)</label>
                            <input type="text" name="price" id="modal_price" class="form-control currency-input fw-bold" required placeholder="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Giá khuyến mãi (₫)</label>
                            <input type="text" name="sale" id="modal_sale" class="form-control currency-input fw-bold text-danger" placeholder="0">
                            <div id="modal-sale-error" class="text-danger mt-1" style="font-size: 10px; display: none;">Không được lớn hơn giá gốc!</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-dark">Số lượng kho</label>
                            <input type="number" name="quantity" class="form-control text-center fw-bold" value="1" min="1" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm" id="btn-submit-modal">XÁC NHẬN TẠO</button>
                </div>
            </form>
        </div>
    </div>

    <form id="delete-form" method="POST" style="display: none;">@csrf @method('DELETE')</form>

    <script>
        // --- ĐỊNH DẠNG VND KHI NHẬP ---
        function formatCurrency(input) {
            let val = input.value.replace(/\D/g, "");
            val = val.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = val;
        }

        // --- VALIDATE GIÁ GIẢM <= GIÁ GỐC ---
        function validatePrices(priceInput, saleInput, errorElement, submitBtn) {
            const price = parseInt(priceInput.value.replace(/,/g, '')) || 0;
            const sale = parseInt(saleInput.value.replace(/,/g, '')) || 0;

            if (sale > price && price > 0) {
                saleInput.classList.add('is-invalid');
                errorElement.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                saleInput.classList.remove('is-invalid');
                errorElement.style.display = 'none';
                submitBtn.disabled = false;
            }
        }

        // Áp dụng định dạng và validate cho toàn bộ input currency
        document.querySelectorAll('.currency-input').forEach(input => {
            input.addEventListener('input', function() { 
                formatCurrency(this);

                // Nếu là input trong Modal
                if (this.id === 'modal_price' || this.id === 'modal_sale') {
                    validatePrices(
                        document.getElementById('modal_price'),
                        document.getElementById('modal_sale'),
                        document.getElementById('modal-sale-error'),
                        document.getElementById('btn-submit-modal')
                    );
                }

                // Nếu là input trong Bảng chính
                if (this.classList.contains('input-price-field') || this.classList.contains('input-sale-field')) {
                    const row = this.closest('tr');
                    validatePrices(
                        row.querySelector('.input-price-field'),
                        row.querySelector('.input-sale-field'),
                        row.querySelector('.error-text'),
                        document.getElementById('btn-submit-main')
                    );
                }
            });
        });

        // Xử lý gửi form (xóa dấu phẩy trước khi gửi lên server)
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                this.querySelectorAll('.currency-input').forEach(input => {
                    input.value = input.value.replace(/,/g, '');
                });
            });
        });

        // --- PREVIEW ẢNH ---
        function previewImg(input, id) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById(id);
                    img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- XÓA BIẾN THỂ ---
        function deleteVariant(url) {
            if (confirm('Lưu ý: Hành động này sẽ xóa vĩnh viễn biến thể. Bạn chắc chắn chứ?')) {
                const f = document.getElementById('delete-form');
                f.action = url; 
                f.submit();
            }
        }
    </script>

    <style>
        .image-upload-wrapper { position: relative; cursor: pointer; display: inline-block; transition: all 0.3s ease; border-radius: 8px; overflow: hidden; }
        .image-upload-wrapper:hover { transform: scale(1.05); filter: brightness(90%); }
        .image-overlay { position: absolute; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); display:flex; align-items:center; justify-content:center; opacity:0; transition:0.3s; }
        .image-upload-wrapper:hover .image-overlay { opacity:1; }
        
        .border-dashed { border-style: dashed !important; border-color: #dce0e4 !important; }
        .variant-row:hover { background-color: #fcfcfc !important; }
        .card-footer { position: sticky; bottom: 0; z-index: 100; background: #fff !important; border-top: 1px solid #eee; }
        
        .is-invalid { border-color: #dc3545 !important; }
        .modal-header.bg-primary { border-bottom: 0; }
        .form-select, .form-control { border-radius: 6px; border: 1px solid #dce0e4; }
        .form-select:focus, .form-control:focus { border-color: #5a8dee; box-shadow: 0 3px 8px 0 rgba(0,0,0,0.05); }
    </style>
@endsection