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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                                    <i class="bx bx-plus"></i> Thêm Biến Thể
                                </button>
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
                                              @if($variant->image)
    {{-- DEBUG: KIỂM TRA ĐƯỜNG DẪN LƯU TRỮ --}}
    @php
        // Lấy đường dẫn ảnh hoàn chỉnh được tạo bởi Laravel
        $imageUrl = Storage::url($variant->image);
    @endphp
   
    <img src="{{ $imageUrl }}"
         alt="Variant Image"
         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
@else
    {{-- Hiển thị placeholder nếu không có ảnh --}}
    <div style="width: 50px; height: 50px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
        <i class="bx bx-image text-muted"></i>
    </div>
@endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $variant->size->name ?? 'N/A' }} ({{ $variant->size->size_code ?? '' }})</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div style="width: 25px; height: 25px; background-color: {{ $variant->color->color_code ?? '#ccc' }}; border: 1px solid #ddd; border-radius: 4px;"></div>
                                                    <span>{{ $variant->color->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ number_format($variant->price, 0, ',', '.') }}đ</td>
                                            <td>
                                                @if($variant->sale)
                                                    <span class="text-success fw-bold">{{ number_format($variant->sale, 0, ',', '.') }}đ</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $variant->quantity > 10 ? 'bg-success' : ($variant->quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $variant->quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($variant->status == 1)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-danger">Không hoạt động</span>
                                                @endif
                                            </td>
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
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-soft-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa biến thể này?')">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <i class="bx bx-box fs-48 text-muted d-block mb-2"></i>
                                                <p class="text-muted">Chưa có biến thể nào. Nhấn "Thêm Biến Thể" để bắt đầu.</p>
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


    {{-- Modal Thêm Biến Thể --}}
    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVariantModalLabel">Thêm Biến Thể Sản Phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Tabs --}}
                    <ul class="nav nav-pills mb-3" id="variantTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="auto-tab" data-bs-toggle="pill" data-bs-target="#auto"
                                type="button" role="tab" aria-controls="auto" aria-selected="true">
                                <i class="bx bx-shuffle"></i> Trộn Tự Động
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="manual-tab" data-bs-toggle="pill" data-bs-target="#manual"
                                type="button" role="tab" aria-controls="manual" aria-selected="false">
                                <i class="bx bx-add-to-queue"></i> Trộn Thủ Công
                            </button>
                        </li>
                    </ul>


                    <div class="tab-content" id="variantTabsContent">
                        {{-- Tab Trộn Tự Động --}}
                        <div class="tab-pane fade show active" id="auto" role="tabpanel" aria-labelledby="auto-tab">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle"></i>
                                <strong>Trộn tự động:</strong> Nhấn "Trộn Tự Động" để tạo tất cả tổ hợp Size × Màu. Sau đó điều chỉnh giá và số lượng cho từng biến thể trước khi lưu.
                            </div>


                            {{-- Nút Trộn Tự Động --}}
                            <div class="text-center mb-3" id="generateBtnContainer">
                                <button type="button" class="btn btn-lg btn-primary" id="btnGenerateVariants">
                                    <i class="bx bx-shuffle"></i> Trộn Tự Động
                                </button>
                                <p class="text-muted mt-2">Sẽ tạo tổ hợp từ <strong>{{ $sizes->count() }} kích thước</strong> × <strong>{{ $colors->count() }} màu sắc</strong> = <strong>{{ $sizes->count() * $colors->count() }} biến thể</strong></p>
                            </div>


                            {{-- Bảng biến thể (ẩn ban đầu) --}}
                            <div id="variantsTableContainer" style="display: none;">
                                <form action="{{ route('admin.products.variants.bulk-store', $product->id) }}" method="POST" id="autoForm">
                                    @csrf
                                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                        <table class="table table-bordered table-sm">
                                            <thead class="table-light sticky-top">
                                                <tr>
                                                    <th width="5%">STT</th>
                                                    <th width="15%">Kích Thước</th>
                                                    <th width="20%">Màu Sắc</th>
                                                    <th width="20%">Giá Gốc <span class="text-danger">*</span></th>
                                                    <th width="20%">Giá Sale</th>
                                                    <th width="15%">Số Lượng <span class="text-danger">*</span></th>
                                                    <th width="5%">
                                                        <button type="button" class="btn btn-sm btn-danger" id="btnClearAll" title="Xóa tất cả">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTableBody">
                                                {{-- Sẽ được tạo bằng JavaScript --}}
                                            </tbody>
                                        </table>
                                    </div>


                                    <input type="hidden" name="variants_data" id="variantsDataInput">


                                    <div class="alert alert-warning mt-3">
                                        <i class="bx bx-info-circle"></i> Vui lòng kiểm tra kỹ giá và số lượng trước khi lưu!
                                    </div>


                                    <div class="text-end">
                                        <button type="button" class="btn btn-outline-secondary" id="btnBackToGenerate">
                                            <i class="bx bx-arrow-back"></i> Quay Lại
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="btnSaveVariants">
                                            <i class="bx bx-check"></i> Lưu Tất Cả Biến Thể
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        {{-- Tab Trộn Thủ Công --}}
                        <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                            <form action="{{ route('admin.products.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data" id="manualForm">
                                @csrf
                                <div class="alert alert-info">
                                    <i class="bx bx-info-circle"></i>
                                    <strong>Trộn thủ công:</strong> Thêm từng biến thể một cách cụ thể với thông tin chi tiết.
                                </div>


                                <div class="row">
    {{-- Kích Thước (size_id) --}}
    <div class="col-md-3 mb-3">
        <label for="manual_size_id" class="form-label">Kích Thước <span class="text-danger">*</span></label>
        <select class="form-control @error('size_id') is-invalid @enderror" id="manual_size_id" name="size_id">
            <option value="">-- Chọn size --</option>
            @foreach($sizes as $size)
                <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                    {{ $size->name }} ({{ $size->size_code }})
                </option>
            @endforeach
        </select>
        {{-- Hiển thị lỗi cho size_id (chủ yếu là lỗi 'exists') --}}
        @error('size_id')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- Màu Sắc (color_id) --}}
    <div class="col-md-3 mb-3">
        <label for="manual_color_id" class="form-label">Màu Sắc <span class="text-danger">*</span></label>
        <select class="form-control @error('color_id') is-invalid @enderror" id="manual_color_id" name="color_id">
            <option value="">-- Chọn màu --</option>
            @foreach($colors as $color)
                <option value="{{ $color->id }}" data-color="{{ $color->color_code }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                    {{ $color->name }}
                </option>
            @endforeach
        </select>
        {{-- Hiển thị lỗi cho color_id (chủ yếu là lỗi 'exists') --}}
        @error('color_id')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- Giá Gốc (price) --}}
    <div class="col-md-3 mb-3">
        <label for="manual_price" class="form-label">Giá Gốc <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('price') is-invalid @enderror" id="manual_price" name="price"
            value="{{ old('price', 0) }}" min="">
        {{-- Hiển thị lỗi cho price (chủ yếu là lỗi 'numeric' và 'min') --}}
        @error('price')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- Giá Sale (sale) --}}
    <div class="col-md-3 mb-3">
        <label for="manual_sale" class="form-label">Giá Sale</label>
        <input type="number" class="form-control @error('sale') is-invalid @enderror" id="manual_sale" name="sale"
            value="{{ old('sale') }}" min="0">
        {{-- Hiển thị lỗi cho sale (chủ yếu là lỗi 'numeric' và 'min') --}}
        @error('sale')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>


<div class="row">
    {{-- Số Lượng (quantity) --}}
    <div class="col-md-4 mb-3">
        <label for="manual_quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="manual_quantity" name="quantity"
            value="{{ old('quantity', 0) }}" min="0">
        {{-- Hiển thị lỗi cho quantity (chủ yếu là lỗi 'integer' và 'min') --}}
        @error('quantity')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- Trạng Thái (status) --}}
    <div class="col-md-4 mb-3">
        <label for="manual_status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
        <select class="form-control @error('status') is-invalid @enderror" id="manual_status" name="status">
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
        </select>
        {{-- Hiển thị lỗi cho status (chủ yếu là lỗi 'in') --}}
        @error('status')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>


    {{-- Ảnh Biến Thể (image) --}}
    <div class="col-md-4 mb-3">
        <label for="manual_image" class="form-label">Ảnh Biến Thể</label>
        <input type="file" class="form-control @error('image') is-invalid @enderror" id="manual_image" name="image"
            accept="image/jpeg,image/png,image/jpg,image/webp">
        {{-- Hiển thị lỗi cho image (chủ yếu là lỗi 'image', 'mimes', 'max') --}}
        @error('image')
            <div class="text-danger mt-1" style="font-size:13px">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>


                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bx bx-check"></i> Thêm Biến Thể
                                    </button>
                                </div>
                            </form>
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
                                <select class="form-control" id="edit_size_id" name="size_id" >
                                    <option value="">-- Chọn size --</option>
                                    @foreach($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }} ({{ $size->size_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_color_id" class="form-label">Màu Sắc <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_color_id" name="color_id" >
                                    <option value="">-- Chọn màu --</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}" data-color="{{ $color->color_code }}">
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_price" class="form-label">Giá Gốc <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_price" name="price"
                                    value="0" min="0" >
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_sale" class="form-label">Giá Sale</label>
                                <input type="number" class="form-control" id="edit_sale" name="sale"
                                    value="" min="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity"
                                    value="0" min="0" >
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="status" >
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


        // Nút "Xóa Tất Cả"
        document.getElementById('btnClearAll').addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn xóa tất cả các dòng?')) {
                document.getElementById('variantsTableBody').innerHTML = '';
                variantsData = [];
            }
        });


            // Hàm tạo tất cả tổ hợp
            function generateAllVariants() {
                console.log('generateAllVariants called');
                const tbody = document.getElementById('variantsTableBody');
                if (!tbody) {
                    console.error('tbody not found!');
                    return;
                }
                tbody.innerHTML = '';
                variantsData = [];
                let index = 1;


                sizes.forEach(size => {
                    colors.forEach(color => {
                    const rowData = {
                        size_id: size.id,
                        size_name: size.name,
                        size_code: size.size_code,
                        color_id: color.id,
                        color_name: color.name,
                        color_code: color.color_code,
                        price: 0,
                        sale: 0,
                        quantity: 0
                    };


                    variantsData.push(rowData);


                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="text-center">${index}</td>
                        <td>
                            <span class="badge bg-info">${size.size_code}</span> ${size.name}
                            <input type="hidden" name="variants[${index-1}][size_id]" value="${size.id}">
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 20px; height: 20px; background-color: ${color.color_code}; border: 1px solid #ddd; border-radius: 3px;"></div>
                                <span>${color.name}</span>
                            </div>
                            <input type="hidden" name="variants[${index-1}][color_id]" value="${color.id}">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm"
                                name="variants[${index-1}][price]"
                                value="0" min="0"  
                                data-index="${index-1}">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm"
                                name="variants[${index-1}][sale]"
                                value="" min="0"
                                data-index="${index-1}">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm"
                                name="variants[${index-1}][quantity]"
                                value="0" min="0"
                                data-index="${index-1}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-remove-row" data-index="${index-1}">
                                <i class="bx bx-x"></i>
                            </button>
                        </td>
                    `;


                    tbody.appendChild(row);
                    index++;
                });
            });


            // Thêm event listener cho nút xóa từng dòng
            document.querySelectorAll('.btn-remove-row').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (confirm('Bạn có chắc muốn xóa biến thể này?')) {
                        this.closest('tr').remove();
                    }
                });
            });
        }


        // Validation form trước khi submit
        document.getElementById('autoForm').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('#variantsTableBody tr');
           
            if (rows.length === 0) {
                e.preventDefault();
                alert('Vui lòng tạo ít nhất 1 biến thể!');
                return false;
            }


            // Kiểm tra giá và số lượng (tìm tất cả input trong mỗi dòng)
            let hasError = false;
            let errorMessage = '';
           
            rows.forEach((row, idx) => {
                const priceInput = row.querySelector('input[name*="[price]"]');
                const quantityInput = row.querySelector('input[name*="[quantity]"]');
               
                if (!priceInput || !quantityInput) {
                    hasError = true;
                    errorMessage = 'Không tìm thấy input giá hoặc số lượng!';
                    return;
                }
               
                if (priceInput.value === '' || priceInput.value === null || parseFloat(priceInput.value) < 0) {
                    hasError = true;
                    errorMessage = `Dòng ${idx + 1}: Vui lòng nhập giá hợp lệ!`;
                    return;
                }
               
                if (quantityInput.value === '' || quantityInput.value === null || parseInt(quantityInput.value) < 0) {
                    hasError = true;
                    errorMessage = `Dòng ${idx + 1}: Vui lòng nhập số lượng hợp lệ!`;
                    return;
                }
            });


            if (hasError) {
                e.preventDefault();
                alert(errorMessage || 'Vui lòng nhập đầy đủ giá và số lượng cho tất cả các biến thể!');
                return false;
            }
           
            console.log('Form is valid, submitting...');
            return true;
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
                    document.getElementById('edit_current_image_container').style.display = 'block';
                } else {
                    document.getElementById('edit_current_image_container').style.display = 'none';
                }


                // Mở modal
                const modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                modal.show();
            });
        });


        }); // End DOMContentLoaded
    </script>
@endsection

