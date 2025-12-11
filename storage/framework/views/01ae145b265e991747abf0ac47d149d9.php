<?php $__env->startSection('content'); ?>
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Chỉnh sửa Voucher: <?php echo e($voucher->voucher_code); ?></h3>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading fs-15"><i class="bi bi-exclamation-triangle me-2"></i> Lỗi nhập liệu</h5>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($err); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="card">
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.vouchers.update', $voucher->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mã voucher <span class="text-danger">*</span></label>
                        <input type="text" name="voucher_code" value="<?php echo e(old('voucher_code', $voucher->voucher_code)); ?>"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" id="discount_type" class="form-select" required>
                            <option value="fixed"
                                <?php echo e(old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : ''); ?>>Giảm cố định (VNĐ)</option>
                            <option value="percent"
                                <?php echo e(old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : ''); ?>>Giảm theo %</option>
                        </select>
                    </div>
                </div>

                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số lượng (Tổng cộng)</label>
                        <input type="number" name="quantity" value="<?php echo e(old('quantity', $voucher->quantity)); ?>"
                            class="form-control" min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giới hạn mỗi người (Số lần sử dụng)</label>
                        <input type="number" name="user_limit" value="<?php echo e(old('user_limit', $voucher->user_limit)); ?>"
                            class="form-control" min="1">
                    </div>
                </div>
                
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Giá trị giảm (<span id="discount_label" class="text-primary"><?php echo e($voucher->discount_type == 'fixed' ? 'VNĐ' : '%'); ?></span>) <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="discount_value" id="discount_value"
                            value="<?php echo e(old('discount_value', $voucher->discount_value)); ?>" class="form-control" step="1" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                        <input type="number" name="min_order_value"
                            value="<?php echo e(old('min_order_value', $voucher->min_order_value)); ?>" class="form-control" step="1" required min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị giảm tối đa (Sale Price)</label>
                        <input type="number" name="sale_price" value="<?php echo e(old('sale_price', $voucher->sale_price)); ?>"
                            class="form-control" step="1000" min="0">
                        <small class="text-muted">Đặt giới hạn tối đa cho mức giảm (chỉ áp dụng nếu Loại giảm giá là %) </small>
                    </div>
                </div>

                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                        
                        <input type="date" name="start_date"
                            value="<?php echo e(old('start_date', substr($voucher->start_date, 0, 10))); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" value="<?php echo e(old('end_date', substr($voucher->end_date, 0, 10))); ?>"
                            class="form-control" required>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" <?php echo e(old('status', $voucher->status) == 1 ? 'selected' : ''); ?>>Hoạt động</option>
                        <option value="0" <?php echo e(old('status', $voucher->status) == 0 ? 'selected' : ''); ?>>Ngừng hoạt động</option>
                    </select>
                </div>

                
                <div class="mb-4">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Mô tả chi tiết về điều kiện áp dụng nếu cần"><?php echo e(old('description', $voucher->description)); ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?php echo e(route('admin.vouchers.index')); ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Cập nhật voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    // Cập nhật nhãn đơn vị giảm giá khi thay đổi Loại giảm giá
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('discount_type');
        const label = document.getElementById('discount_label');
        
        // Hàm cập nhật nhãn
        function updateDiscountLabel() {
            label.textContent = typeSelect.value === 'fixed' ? 'VNĐ' : '%';
        }

        // Cập nhật ngay khi tải trang (để đảm bảo trạng thái old() hoặc $voucher ban đầu là đúng)
        updateDiscountLabel(); 
        
        // Thêm sự kiện thay đổi
        typeSelect.addEventListener('change', updateDiscountLabel);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/vouchers/edit.blade.php ENDPATH**/ ?>