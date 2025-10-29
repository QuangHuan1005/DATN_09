<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-3">Thêm Voucher mới</h3>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.vouchers.store')); ?>" method="POST" class="card p-4 shadow-sm">
        <?php echo csrf_field(); ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Mã voucher</label>
                <input type="text" name="voucher_code" value="<?php echo e(old('voucher_code')); ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Loại giảm giá</label>
                <select name="discount_type" class="form-select" id="discount_type">
                    <option value="fixed" <?php echo e(old('discount_type') == 'fixed' ? 'selected' : ''); ?>>Giảm cố định (VNĐ)</option>
                    <option value="percent" <?php echo e(old('discount_type') == 'percent' ? 'selected' : ''); ?>>Giảm theo %</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" value="<?php echo e(old('quantity', 1)); ?>" class="form-control" min="1">
            </div>
            <div class="col-md-6">
                <label class="form-label">Giới hạn mỗi người</label>
                <input type="number" name="user_limit" value="<?php echo e(old('user_limit', 1)); ?>" class="form-control" min="1">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">
                    Giá trị giảm (<span id="discount-label"><?php echo e(old('discount_type') == 'percent' ? '%' : 'VNĐ'); ?></span>)
                </label>
                <input type="number" name="discount_value" value="<?php echo e(old('discount_value')); ?>" class="form-control" min="0" step="1">
                <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="col-md-4">
                <label class="form-label">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" value="<?php echo e(old('min_order_value', 0)); ?>" class="form-control" step="1000" min="0">
            </div>

            <div class="col-md-4">
                <label class="form-label">Giá sau giảm tối thiểu (sale_price)</label>
                <input type="number" name="sale_price" value="<?php echo e(old('sale_price', 0)); ?>" class="form-control" step="1000" min="0">
                <small class="text-muted">Đảm bảo giá sau giảm không thấp hơn mức này</small>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Ngày bắt đầu</label>
                <input type="date" name="start_date" value="<?php echo e(old('start_date')); ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ngày kết thúc</label>
                <input type="date" name="end_date" value="<?php echo e(old('end_date')); ?>" class="form-control">
            </div>
            <div class="">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="1" <?php echo e(old('status') == '1' ? 'selected' : ''); ?>>Hoạt động</option>
                    <option value="0" <?php echo e(old('status') == '0' ? 'selected' : ''); ?>>Ngừng</option>
                </select>
            </div>
            <div class="">
                <label class="form-label">Mô tả</label>
                <textarea name="description" rows="1" class="form-control"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?php echo e(route('admin.vouchers.index')); ?>" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu voucher</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('discount_type');
    const label = document.getElementById('discount-label');

    typeSelect.addEventListener('change', function () {
        label.textContent = this.value === 'fixed' ? 'VNĐ' : '%';
    });
});
</script>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/vouchers/create.blade.php ENDPATH**/ ?>