

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-4">Quản lý đơn hàng</h3>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="mb-3 d-flex align-items-center gap-2">
        <select name="status" class="form-select w-auto">
            <option value="">-- Tất cả trạng thái --</option>
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($status->id); ?>" <?php echo e(request('status') == $status->id ? 'selected' : ''); ?>>
                    <?php echo e($status->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <input type="text" name="keyword" value="<?php echo e(request('keyword')); ?>" class="form-control w-25"
               placeholder="Tìm theo mã đơn hoặc tên KH">

        <button class="btn btn-primary">Lọc</button>
    </form>

    
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Mã đơn</th>
                    <th>Tên KH</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                        $colorClass = $currentStatus ? $currentStatus->color_class : '';
                    ?>
                    <tr>
                        <td><?php echo e($order->order_code); ?></td>
                        <td><?php echo e($order->name); ?></td>
                        <td><?php echo e($order->phone); ?></td>
                        <td><?php echo e($order->address); ?></td>
                        <td><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?> đ</td>
                        <td>
                            <form action="<?php echo e(route('admin.orders.status', $order->id)); ?>" method="POST" class="status-form">
                                <?php echo csrf_field(); ?>
                               <select name="order_status_id" 
        class="form-select form-select-sm w-auto <?php echo e($colorClass); ?>" 
        onchange="changeStatusColor(this); this.form.submit()">
    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($status->id); ?>" 
                data-color="<?php echo e($status->color_class); ?>"
                <?php echo e($order->order_status_id == $status->id ? 'selected' : ''); ?>

                <?php echo e(in_array($status->id, [5,6,7]) ? 'disabled' : ''); ?>>
            <?php echo e($status->name); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>

                            </form>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-info btn-sm">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Không có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="mt-3">
        <?php echo e($orders->links('pagination::bootstrap-5')); ?>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tự ẩn alert sau 3s
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('hide');
        }, 3000);
    });

    // Set màu ban đầu cho tất cả select
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if (selectedOption && selectedOption.dataset.color) {
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
    });
});

// Hàm thay đổi màu khi đổi select
function changeStatusColor(select) {
    const colorClass = select.selectedOptions[0].dataset.color || '';
    select.className = 'form-select form-select-sm w-auto ' + colorClass;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>