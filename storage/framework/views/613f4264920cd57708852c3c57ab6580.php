<?php $__env->startSection('title', 'Bảng điều khiển Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <!-- Tiêu đề trang -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Bảng điều khiển Admin</h1>
        </div>
    </div>

    <!-- Thẻ điều hướng -->
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body">
                    <i class="fas fa-palette fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Quản lý biến thể sản phẩm</h5>
                    <p class="card-text">Quản lý kích thước và màu sắc của sản phẩm</p>
                                     
                
                </div>
            </div>
        </div>
    </div>

    <!-- Thao tác nhanh -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <h3>Thao tác nhanh</h3>
            <div class="d-flex justify-content-center gap-2">
              
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>