<?php $__env->startSection('content'); ?>
<div class="container-xxl">
    <h3 class="mb-3">Quản lý Voucher</h3>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            
            <form method="GET" action="<?php echo e(route('admin.vouchers.index')); ?>" class="d-flex">
                <input type="search" name="keyword" class="form-control me-2" placeholder="Tìm mã voucher"
                    value="<?php echo e(request('keyword')); ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
        <div class="col-md-6 text-end">
            
            <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-square"></i> Thêm voucher
            </a>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Mã voucher</th>
                            <th class="text-center">Loại giảm giá</th>
                            <th class="text-center">Giá trị giảm</th>
                            <th class="text-center">Giảm tối đa</th>
                            <th class="text-center">Đơn tối thiểu</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Đã dùng</th>
                            <th class="text-center">Ngày bắt đầu</th>
                            <th class="text-center">Ngày kết thúc</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($vouchers->firstItem() + $key); ?></td>
                                <td class="text-center"><strong><?php echo e($item->voucher_code); ?></strong></td>
                                <td class="text-center">
                                    <?php echo e($item->discount_type == 'fixed' ? 'Giảm cố định' : 'Giảm %'); ?>

                                </td>
                                <td class="text-center">
                                    <?php echo e($item->discount_type == 'fixed' ? number_format($item->discount_value) . 'đ' : $item->discount_value . '%'); ?>

                                </td>
                                <td class="text-center">
                                    <?php echo e($item->sale_price ? number_format($item->sale_price, 0, ',', '.') . ' đ' : '—'); ?>

                                </td>
                                <td class="text-center"><?php echo e(number_format($item->min_order_value, 0, ',', '.')); ?>đ</td>
                                <td class="text-center"><?php echo e($item->quantity); ?></td>
                                <td class="text-center"><?php echo e($item->total_used); ?></td>
                                <td class="text-center"><?php echo e($item->start_date); ?></td>
                                <td class="text-center"><?php echo e($item->end_date); ?></td>
                                <td class="text-center">
                                    <?php if($item->status == 1): ?>
                                        <span class="badge bg-success border-success text-success px-2 py-1 fs-13">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger border-danger text-danger px-2 py-1 fs-13">Ngừng</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap text-center">
                                    
                                    <a href="<?php echo e(route('admin.vouchers.edit', $item->id)); ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>

                                    
                                    <form action="<?php echo e(route('admin.vouchers.destroy', $item->id)); ?>" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa voucher <?php echo e($item->voucher_code); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="12" class="text-center py-4 text-muted">Không có voucher nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        
        <div class="card-footer">
            <?php echo e($vouchers->withQueryString()->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ẩn alert sau 3s
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => alert.classList.add('d-none'), 3000);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/vouchers/index.blade.php ENDPATH**/ ?>