<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-3">Chỉnh sửa sản phẩm: <strong><?php echo e($product->name); ?></strong></h3>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $product->name)); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" value="<?php echo e($product->product_code); ?>" disabled>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select">
                <option value="">-- Chọn danh mục --</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"
                        <?php echo e((int) old('category_id', $product->category_id) === $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Chất liệu</label>
            <input type="text" name="material" class="form-control" value="<?php echo e(old('material', $product->material)); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"><?php echo e(old('description', $product->description)); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Hiển thị trang chủ</label>
            <select name="onpage" class="form-select">
                <option value="0" <?php echo e((int) old('onpage', $product->onpage) === 0 ? 'selected' : ''); ?>>Không</option>
                <option value="1" <?php echo e((int) old('onpage', $product->onpage) === 1 ? 'selected' : ''); ?>>Có</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh hiện tại</label><br>
            <?php if($product->image): ?>
                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="image" width="140" class="rounded mb-2 border">
            <?php else: ?>
                <p class="text-muted">Chưa có ảnh</p>
            <?php endif; ?>

            <label class="form-label mt-2">Thay ảnh (nếu muốn)</label>
            <input type="file" name="image" class="form-control">
            <small class="form-text text-muted">Bỏ trống nếu không muốn thay ảnh.</small>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>