<?php $__env->startSection('title', 'Quản lý biến thể sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
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
                            <a href="<?php echo e(route('admin.products.variants.type', 'size')); ?>" 
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
                            <a href="<?php echo e(route('admin.products.variants.type', 'color')); ?>" 
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
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Tổng kích thước</h5>
                                            <h2 class="mb-0"><?php echo e(\App\Models\Size::count()); ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-ruler fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Tổng màu sắc</h5>
                                            <h2 class="mb-0"><?php echo e(\App\Models\Color::count()); ?></h2>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-palette fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title">Đang hoạt động</h5>
                                            <h2 class="mb-0"><?php echo e(\App\Models\Size::where('status', 'active')->count() + \App\Models\Color::where('status', 'active')->count()); ?></h2>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/products/variants-index.blade.php ENDPATH**/ ?>