<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <div class="row bg-dark text-white py-2">
            <div class="col-6">
                <a href="{{ route('home') }}" class="text-white text-decoration-none">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </div>
            <div class="col-6 text-end">
                <span>Admin Dashboard</span>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h2">Admin Dashboard</h1>
                </div>
            </div>

            <!-- Navigation Cards -->
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-palette fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Biến thể sản phẩm</h5>
                            <p class="card-text">Quản lý kích thước và màu sắc</p>
                            <a href="{{ route('admin.products.variants') }}" class="btn btn-success btn-lg">Quản lý biến thể</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <h3>Thao tác nhanh</h3>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.products.variants') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Thêm biến thể sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
