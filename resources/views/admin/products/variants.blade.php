<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý biến thể sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-dark text-white py-2">
            <div class="col-6">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </div>
            <div class="col-6 text-end">
                <span>Biến thể sản phẩm</span>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2">Quản lý biến thể sản phẩm</h1>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search and Add New Variant -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('admin.products.variants') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" 
                               placeholder="Tìm kiếm biến thể..." 
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.products.variants') }}" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times"></i> Xóa
                            </a>
                        @endif
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                        <i class="fas fa-plus"></i> Thêm biến thể
                    </button>
                </div>
            </div>

            <!-- Search Results Info -->
            @if(request('search'))
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Kết quả tìm kiếm cho: "<strong>{{ request('search') }}</strong>"
                            - Tìm thấy {{ $sizeVariants->count() + $colorVariants->count() }} biến thể
                        </div>
                    </div>
                </div>
            @endif

            <!-- Size Variants Section -->
            <div class="row mb-5">
                <div class="col-12">
                    <h3 class="h4 mb-3">
                        <i class="fas fa-ruler"></i> Kích thước
                        @if(request('search'))
                            <span class="badge bg-info">{{ $sizeVariants->count() }} kết quả</span>
                        @endif
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên kích thước</th>
                                    <th>Giá trị</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sizeVariants as $variant)
                                    <tr>
                                        <td>{{ $variant->id }}</td>
                                        <td>{{ $variant->name }}</td>
                                        <td>{{ $variant->value }}</td>
                                        <td>{{ $variant->description ?? 'Không có mô tả' }}</td>
                                        <td>
                                            <span class="badge {{ $variant->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $variant->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.products.variants.edit', $variant) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('admin.products.variants.destroy', $variant) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Chưa có kích thước nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Color Variants Section -->
            <div class="row">
                <div class="col-12">
                    <h3 class="h4 mb-3">
                        <i class="fas fa-palette"></i> Màu sắc
                        @if(request('search'))
                            <span class="badge bg-info">{{ $colorVariants->count() }} kết quả</span>
                        @endif
                    </h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên màu</th>
                                    <th>Mã màu</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($colorVariants as $variant)
                                    <tr>
                                        <td>{{ $variant->id }}</td>
                                        <td>{{ $variant->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-preview me-2" 
                                                     style="width: 20px; height: 20px; background-color: {{ $variant->value }}; border: 1px solid #ccc; border-radius: 3px;"></div>
                                                {{ $variant->value }}
                                            </div>
                                        </td>
                                        <td>{{ $variant->description ?? 'Không có mô tả' }}</td>
                                        <td>
                                            <span class="badge {{ $variant->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $variant->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.products.variants.edit', $variant) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('admin.products.variants.destroy', $variant) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa biến thể này?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Chưa có màu sắc nào</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Variant Modal -->
    <div class="modal fade" id="addVariantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm biến thể mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.products.variants.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type" class="form-label">Loại biến thể</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Chọn loại biến thể</option>
                                <option value="size">Kích thước</option>
                                <option value="color">Màu sắc</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên biến thể</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Giá trị</label>
                            <input type="text" class="form-control" id="value" name="value" required 
                                   placeholder="VD: S, M, L hoặc #FF0000">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm biến thể</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
