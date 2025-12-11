<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Quản trị sản phẩm'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Thanh menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('admin.products.index')); ?>">Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link">Sản phẩm</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Đơn hàng</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Người dùng</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Nội dung -->
    <main class="py-4 container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/layouts/admin.blade.php ENDPATH**/ ?>