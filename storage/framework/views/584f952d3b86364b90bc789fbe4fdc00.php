<?php $__env->startSection('title', 'Sửa biến thể sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <!-- Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <a href="<?php echo e($type ? route('admin.products.variants.type', $type) : route('admin.products.variants')); ?>" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <h1 class="h2 mb-0">Sửa <?php echo e($typeName ?? 'biến thể'); ?></h1>
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
                            <form action="<?php echo e(route('admin.products.variants.update', $variant)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <input type="hidden" name="type" value="<?php echo e($type); ?>">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên <?php echo e($typeName ?? 'biến thể'); ?></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo e(old('name', $variant->name)); ?>" required>
                                </div>

                                <?php if($type === 'size'): ?>
                                <div class="mb-3">
                                    <label for="size_code" class="form-label">Giá trị</label>
                                    <input type="text" class="form-control" id="size_code" name="size_code" 
                                           value="<?php echo e(old('size_code', $variant->size_code)); ?>" 
                                           placeholder="VD: S, M, L, XL">
                                </div>
                                <?php elseif($type === 'color'): ?>
                                <div class="mb-3">
                                    <label for="color_code" class="form-label">Giá trị</label>
                                    <input type="text" class="form-control" id="color_code" name="color_code" 
                                           value="<?php echo e(old('color_code', $variant->color_code)); ?>" 
                                           placeholder="VD: #FF0000, #0000FF">
                                </div>
                                <?php endif; ?>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo e(old('description', $variant->description)); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" <?php echo e(old('status', $variant->status) === 'active' ? 'selected' : ''); ?>>Hoạt động</option>
                                        <option value="inactive" <?php echo e(old('status', $variant->status) === 'inactive' ? 'selected' : ''); ?>>Không hoạt động</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="<?php echo e($type ? route('admin.products.variants.type', $type) : route('admin.products.variants')); ?>" class="btn btn-secondary">
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/products/edit-variant.blade.php ENDPATH**/ ?>