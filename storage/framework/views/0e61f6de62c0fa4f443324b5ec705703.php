<?php $__env->startSection('content'); ?>
<div class="container-xxl">

    
    <?php $__currentLoopData = ['success', 'error']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($msg)): ?>
            <div class="alert alert-<?php echo e($msg == 'success' ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
                <?php echo e(session($msg)); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="d-flex">
                <input type="search" name="keyword" class="form-control me-2" placeholder="Tìm mã đơn / tên KH"
                    value="<?php echo e(request('keyword')); ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <div class="dropdown">
                <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <?php echo e(match (request('status')) {
                        '1' => 'Chờ xác nhận',
                        '2' => 'Xác nhận',
                        '3' => 'Đang giao hàng',
                        '4' => 'Đã giao hàng',
                        '5' => 'Hoàn thành',
                        '6' => 'Hủy',
                        '7' => 'Hoàn hàng',
                        default => 'Tất cả trạng thái',
                    }); ?>

                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="dropdown-item">Tất cả trạng thái</a>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.orders.index', ['status' => $status->id])); ?>" class="dropdown-item">
                            <?php echo e($status->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Ngày Tạo</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Thanh Toán</th>
                            <th>Sản Phẩm</th>
                            <th>Trạng Thái</th>
                            <th>Nhân Viên</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                                $colorClass = $currentStatus->color_class ?? 'border-secondary text-secondary';
                                $paymentColors = [
                                    1 => 'badge border border-primary text-primary',
                                    2 => 'badge border border-warning text-warning',
                                    3 => 'badge border border-success text-success',
                                    4 => 'badge border border-danger text-danger',
                                    5 => 'badge border border-secondary text-secondary',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                $paymentName = $order->paymentStatus->name ?? 'Không xác định';
                            ?>
                            <tr>
                                <td><?php echo e($order->order_code); ?></td>
                                <td><?php echo e($order->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.users.show', $order->user_id ?? 0)); ?>" class="link-primary">
                                        <?php echo e($order->name ?? 'Khách lẻ'); ?>

                                    </a>
                                </td>
                                <td><?php echo e(number_format($order->total_amount,0,',','.')); ?>₫</td>
                                <td>
                                    <span class="badge <?php echo e($paymentColor); ?> px-2 py-1 fs-13"><?php echo e($paymentName); ?></span>
                                </td>
                                <td><?php echo e($order->details_sum_quantity ?? 0); ?> sản phẩm</td>

                                
                                <td>
                                    <form action="<?php echo e(route('admin.orders.status', $order->id)); ?>" method="POST" class="status-form">
                                        <?php echo csrf_field(); ?>
                                        <select name="order_status_id" class="form-select form-select-sm w-auto <?php echo e($colorClass); ?>"
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
                                    <?php if(!$order->staff_id): ?>
                                        <form action="<?php echo e(route('admin.orders.assignStaff', $order->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <select name="staff_id" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">-- Chọn nhân viên --</option>
        <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($staff->id); ?>"><?php echo e($staff->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</form>

                                    <?php else: ?>
                                        <?php
                                            $assignedStaff = collect($staffs)->firstWhere('id', $order->staff_id);

                                        ?>
                                        <span>Đã gán: <strong><?php echo e($assignedStaff?->name ?? 'Không xác định'); ?></strong></span>
                                    <?php endif; ?>
                                </td>

                                
                                <td>
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Không có đơn hàng nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <?php echo e($orders->withQueryString()->links()); ?>

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ẩn alert sau 3s
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => alert.classList.add('d-none'), 3000);
        });

        // Set màu select trạng thái khi load
        document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
            const selectedOption = select.selectedOptions[0];
            if(selectedOption && selectedOption.dataset.color){
                select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
            }
        });
    });

    function changeStatusColor(select){
        const color = select.selectedOptions[0].dataset.color || '';
        select.className = 'form-select form-select-sm w-auto ' + color;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>