<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h3 class="mb-3">Quản lý Voucher</h3>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="btn btn-primary">+ Thêm voucher</a>
        </div>

        <div class="table-responsive ">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>#</th>
                        <th>Mã voucher</th>
                        <th>Loại giảm giá</th>
                        <th>Giá trị giảm</th>
                        <th>Giá sau giảm tối thiểu</th>
                        <th>Điều kiện (đơn tối thiểu)</th>
                        <th>Số lượng</th>
                        <th>Đã dùng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($key + 1); ?></td>
                            <td><?php echo e($item->voucher_code); ?></td>
                            <td>
                                <?php echo e($item->discount_type == 'fixed' ? 'Giảm cố định' : 'Giảm %'); ?>

                            </td>
                            <td>
                                <?php echo e($item->discount_type == 'fixed' ? number_format($item->discount_value) . 'đ' : $item->discount_value . '%'); ?>

                            </td>
                              <td>
                                <?php echo e($item->sale_price ? number_format($item->sale_price, 0, ',', '.') . ' đ' : '—'); ?>

                            </td>
                            <td><?php echo e(number_format($item->min_order_value)); ?>đ</td>
                            <td><?php echo e($item->quantity); ?></td>
                            <td><?php echo e($item->total_used); ?></td>
                            <td><?php echo e($item->start_date); ?></td>
                            <td><?php echo e($item->end_date); ?></td>
                            <td>
                                <?php if($item->status == 1): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Ngừng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-nowrap">
                                <a href="<?php echo e(route('admin.vouchers.edit', $item->id)); ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>

                                <form action="<?php echo e(route('admin.vouchers.destroy', $item->id)); ?>" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa voucher này?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted">Chưa có voucher nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            <?php echo e($vouchers->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/vouchers/index.blade.php ENDPATH**/ ?>