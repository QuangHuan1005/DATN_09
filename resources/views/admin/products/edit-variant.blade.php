<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa biến thể sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-dark text-white py-2">
            <div class="col-6">
                <a href="{{ route('admin.products.variants.type', $variant->type) }}" class="text-white text-decoration-none">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="col-6 text-end">
                <span>Sửa biến thể sản phẩm</span>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2">Sửa biến thể sản phẩm</h1>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Thông tin biến thể
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.products.variants.update', $variant) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="type" class="form-label">Loại biến thể</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Chọn loại biến thể</option>
                                        <option value="size" {{ $variant->type === 'size' ? 'selected' : '' }}>Kích thước</option>
                                        <option value="color" {{ $variant->type === 'color' ? 'selected' : '' }}>Màu sắc</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên biến thể</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $variant->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="value" class="form-label">Giá trị</label>
                                    <input type="text" class="form-control" id="value" name="value" 
                                           value="{{ old('value', $variant->value) }}" required 
                                           placeholder="VD: S, M, L hoặc #FF0000">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $variant->description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" {{ $variant->status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ $variant->status === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="{{ route('admin.products.variants.type', $variant->type) }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


