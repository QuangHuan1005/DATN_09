<?php $__env->startSection('title', 'Quản lý ' . $typeName); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <a href="<?php echo e(route('admin.products.variants')); ?>" class="btn btn-outline-secondary me-3">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <h1 class="h2 mb-0">
                            <i class="fas <?php echo e($type === 'size' ? 'fa-ruler' : 'fa-palette'); ?>"></i> 
                            Quản lý <?php echo e($typeName); ?>

                        </h1>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Search and Add New Variant -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="<?php echo e(route('admin.products.variants.type', $type)); ?>" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" 
                               placeholder="Tìm kiếm <?php echo e(strtolower($typeName)); ?>..." 
                               value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <?php if(request('search')): ?>
                            <a href="<?php echo e(route('admin.products.variants.type', $type)); ?>" class="btn btn-outline-secondary ms-2">
                                <i class="fas fa-times"></i> Xóa
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                        <i class="fas fa-plus"></i> Thêm <?php echo e(strtolower($typeName)); ?>

                    </button>
                </div>
            </div>

            <!-- Search Results Info -->
            <?php if(request('search')): ?>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            Kết quả tìm kiếm cho: "<strong><?php echo e(request('search')); ?></strong>"
                            - Tìm thấy <?php echo e($variants->count()); ?> <?php echo e(strtolower($typeName)); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Variants Table -->
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên <?php echo e($typeName); ?></th>
                                    <th>Giá trị</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($variant->id); ?></td>
                                        <td><?php echo e($variant->name); ?></td>
                                        <td>
                                            <?php if($type === 'color'): ?>
                                                <div class="d-flex align-items-center">
                                                    <div class="color-preview me-2" 
                                                         style="width: 20px; height: 20px; background-color: <?php echo e($variant->value); ?>; border: 1px solid #ccc; border-radius: 3px;"></div>
                                                    <?php echo e($variant->value); ?>

                                                </div>
                                            <?php else: ?>
                                                <?php echo e($variant->value); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($variant->description ?? 'Không có mô tả'); ?></td>
                                        <td>
                                            <span class="badge <?php echo e($variant->status === 'active' ? 'bg-success' : 'bg-secondary'); ?>">
                                                <?php echo e($variant->status_text); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($variant->created_at->format('d/m/Y H:i')); ?></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?php echo e(route('admin.products.variants.edit', $variant)); ?>" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <form action="<?php echo e(route('admin.products.variants.destroy', $variant)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa <?php echo e(strtolower($typeName)); ?> này?')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <?php if(request('search')): ?>
                                                Không tìm thấy <?php echo e(strtolower($typeName)); ?> nào phù hợp
                                            <?php else: ?>
                                                Chưa có <?php echo e(strtolower($typeName)); ?> nào
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
                    <h5 class="modal-title">Thêm <?php echo e(strtolower($typeName)); ?> mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('admin.products.variants.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="<?php echo e($type); ?>">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên <?php echo e($typeName); ?></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Giá trị</label>
                            <input type="text" class="form-control" id="value" name="value" required 
                                   placeholder="<?php echo e($type === 'size' ? 'VD: S, M, L, XL' : 'VD: #FF0000, #0000FF'); ?>">
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
                        <button type="submit" class="btn btn-primary">Thêm <?php echo e(strtolower($typeName)); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/products/variants-list.blade.php ENDPATH**/ ?>