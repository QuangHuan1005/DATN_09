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
                <span>Quản lý biến thể sản phẩm</span>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2">Quản lý biến thể sản phẩm</h1>
                    <p class="text-muted">Chọn loại biến thể bạn muốn quản lý</p>
                </div>
            </div>

            <!-- Variant Type Cards -->
            <div class="row justify-content-center">
                <div class="col-md-5 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-ruler fa-4x text-primary"></i>
                            </div>
                            <h3 class="card-title">Kích thước</h3>
                            <p class="card-text text-muted mb-4">
                                Quản lý các kích thước sản phẩm như S, M, L, XL...
                            </p>
                            <a href="{{ route('admin.products.variants.type', 'size') }}" 
                               class="btn btn-primary btn-lg">
                                <i class="fas fa-cog"></i> Quản lý kích thước
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-palette fa-4x text-success"></i>
                            </div>
                            <h3 class="card-title">Màu sắc</h3>
                            <p class="card-text text-muted mb-4">
                                Quản lý các màu sắc sản phẩm như Đỏ, Xanh, Vàng...
                            </p>
                            <a href="{{ route('admin.products.variants.type', 'color') }}" 
                               class="btn btn-success btn-lg">
                                <i class="fas fa-cog"></i> Quản lý màu sắc
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="h4 mb-3">Thống kê nhanh</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Tổng biến thể</h5>
                                            <h2 class="mb-0">{{ \App\Models\ProductVariant::count() }}</h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-list fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Đang hoạt động</h5>
                                            <h2 class="mb-0">{{ \App\Models\ProductVariant::where('status', 'active')->count() }}</h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
