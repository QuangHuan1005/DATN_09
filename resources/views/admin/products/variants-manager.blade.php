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
                                <p class="text-muted mb-0">Sản phẩm: <strong>{{ $product->name }}</strong> (Mã:
                                    {{ $product->product_code }})</p>
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
                        <h5 class="card-title mb-0">Danh Sách Biến Thể ({{ $variants->count() }})</h5>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Kích Thước</th>
                                        <th>Màu Sắc</th>
                                        <th>Giá Gốc</th>
                                        <th>Giá Sale</th>
                                        <th>Số Lượng</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($variants as $index => $variant)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if ($variant->image)
                                                    {{-- DEBUG: KIỂM TRA ĐƯỜNG DẪN LƯU TRỮ --}}
                                                    @php
                                                        // Lấy đường dẫn ảnh hoàn chỉnh được tạo bởi Laravel
                                                        $imageUrl = Storage::url($variant->image);
                                                    @endphp

                                                    <img src="{{ $imageUrl }}" alt="Variant Image"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    {{-- Hiển thị placeholder nếu không có ảnh --}}
                                                    <div
                                                        style="width: 50px; height: 50px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $variant->size->name ?? 'N/A' }}
                                                    ({{ $variant->size->size_code ?? '' }})</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        style="width: 25px; height: 25px; background-color: {{ $variant->color->color_code ?? '#ccc' }}; border: 1px solid #ddd; border-radius: 4px;">
                                                    </div>
                                                    <span>{{ $variant->color->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ number_format($variant->price, 0, ',', '.') }}đ</td>
                                            <td>
                                                @if ($variant->sale)
                                                    <span
                                                        class="text-success fw-bold">{{ number_format($variant->sale, 0, ',', '.') }}đ</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $variant->quantity > 10 ? 'bg-success' : ($variant->quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $variant->quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($variant->status == 1)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-soft-primary btn-sm btn-edit-variant"
                                                    data-id="{{ $variant->id }}" data-size-id="{{ $variant->size_id }}"
                                                    data-color-id="{{ $variant->color_id }}"
                                                    data-price="{{ $variant->price }}" data-sale="{{ $variant->sale }}"
                                                    data-quantity="{{ $variant->quantity }}"
                                                    data-status="{{ $variant->status }}"
                                                    data-image="{{ $variant->image }}">
                                                    <iconify-icon icon="solar:pen-2-broken"
                                                        class="align-middle fs-18"></iconify-icon>
                                                </button>
                                                <form action="{{ route('admin.products.variants.destroy', $variant->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-soft-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa biến thể này?')">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                            class="align-middle fs-18"></iconify-icon>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="bx bx-box fs-48 text-muted d-block mb-2"></i>
                                                <p class="text-muted">Chưa có biến thể nào. Nhấn "Thêm Biến Thể" để bắt đầu.
                                                </p>
                                            </td>
                                        </tr>
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
    <div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel"
        aria-hidden="true">
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
                                <label for="edit_size_id" class="form-label">Kích Thước <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="edit_size_id" name="size_id">
                                    <option value="">-- Chọn size --</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }} ({{ $size->size_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_color_id" class="form-label">Màu Sắc <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="edit_color_id" name="color_id">
                                    <option value="">-- Chọn màu --</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" data-color="{{ $color->color_code }}">
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_price" class="form-label">Giá Gốc <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_price" name="price"
                                    value="0" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_sale" class="form-label">Giá Sale</label>
                                <input type="number" class="form-control" id="edit_sale" name="sale" value=""
                                    min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_quantity" class="form-label">Số Lượng <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity"
                                    value="0" min="0">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Trạng Thái <span
                                        class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Không hoạt động</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_image" class="form-label">Ảnh Biến Thể</label>
                                <input type="file" class="form-control" id="edit_image" name="image" 
                                    accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                            </div>
                        </div>


                        <div id="edit_current_image_container" style="display: none;" class="mb-3">
                            <label class="form-label">Ảnh Hiện Tại:</label><br>
                            <img id="edit_current_image" src="" alt="Current Image"
                                style="max-width: 150px; border: 1px solid #ddd; border-radius: 4px;">
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
            // Dữ liệu sizes và colors từ server
            const sizes = @json($sizes);
            const colors = @json($colors);

            console.log('Sizes:', sizes);
            console.log('Colors:', colors);

            let variantsData = [];


            // Nút "Trộn Tự Động"
            const btnGenerate = document.getElementById('btnGenerateVariants');
            if (!btnGenerate) {
                console.error('Button btnGenerateVariants not found!');
                return;
            }


            btnGenerate.addEventListener('click', function() {
                console.log('Button clicked!');
                generateAllVariants();
                document.getElementById('generateBtnContainer').style.display = 'none';
                document.getElementById('variantsTableContainer').style.display = 'block';
            });


            // Nút "Quay Lại"
            document.getElementById('btnBackToGenerate').addEventListener('click', function() {
                document.getElementById('generateBtnContainer').style.display = 'block';
                document.getElementById('variantsTableContainer').style.display = 'none';
                variantsData = [];
            });



            // ==================== EDIT VARIANT MODAL ====================

            // Xử lý khi click nút Edit
            document.querySelectorAll('.btn-edit-variant').forEach(btn => {
                btn.addEventListener('click', function() {
                    const variantId = this.dataset.id;
                    const sizeId = this.dataset.sizeId;
                    const colorId = this.dataset.colorId;
                    const price = this.dataset.price;
                    const sale = this.dataset.sale;
                    const quantity = this.dataset.quantity;
                    const status = this.dataset.status;
                    const image = this.dataset.image;


                    console.log('Edit variant:', variantId);


                    // Set form action
                    const form = document.getElementById('editVariantForm');
                    form.action = `/admin/product-variants/${variantId}`;


                    // Fill dữ liệu vào form
                    document.getElementById('edit_size_id').value = sizeId;
                    document.getElementById('edit_color_id').value = colorId;
                    document.getElementById('edit_price').value = price;
                    document.getElementById('edit_sale').value = sale || '';
                    document.getElementById('edit_quantity').value = quantity;
                    document.getElementById('edit_status').value = status;


                    // Hiển thị ảnh hiện tại nếu có
                    if (image) {
                        document.getElementById('edit_current_image').src = `/storage/${image}`;
                        document.getElementById('edit_current_image_container').style.display =
                            'block';
                    } else {
                        document.getElementById('edit_current_image_container').style.display =
                            'none';
                    }


                    // Mở modal
                    const modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                    modal.show();
                });
            });


        }); // End DOMContentLoaded
    </script>
@endsection