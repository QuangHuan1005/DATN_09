<?php $__env->startSection('content'); ?>
<div class="container-xxl">
    
    <h3 class="fw-bold mb-4">Danh Sách Đơn Hàng</h3>

    
    <?php $__currentLoopData = ['success', 'error']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($msg)): ?>
            <div class="alert alert-<?php echo e($msg == 'success' ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
                <?php echo e(session($msg)); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="d-flex gap-2">
                <input type="search" name="keyword" class="form-control" placeholder="Tìm mã đơn / tên KH"
                        value="<?php echo e(request('keyword')); ?>" style="max-width: 250px;">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        <div class="col-md-6 text-end">
            <form method="GET" action="<?php echo e(route('admin.orders.index')); ?>" class="d-flex gap-2 justify-content-end">
                <input type="date" name="date" class="form-control" value="<?php echo e(request('date')); ?>" style="max-width: 180px;">
                <select name="status" class="form-select w-auto">
                    <option value="">Tất cả trạng thái</option>
                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->id); ?>" <?php echo e(request('status') == $status->id ? 'selected' : ''); ?>>
                            <?php echo e($status->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn btn-success">Lọc</button>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Tạo</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Phương Thức</th> 
                            <th>Thanh Toán</th>   
                            <th>Sản Phẩm</th>
                            <th class="text-center">Hủy Yêu Cầu</th>
                            <th>Trạng Thái Đơn</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                // Logic màu trạng thái đơn hàng
                                $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                                $colorClass = $currentStatus->color_class ?? 'border-secondary text-secondary';
                                
                                // Logic màu trạng thái thanh toán
                                $paymentColors = [
                                    1 => 'badge border border-primary text-primary',
                                    2 => 'badge border border-warning text-warning',
                                    3 => 'badge border border-success text-success',
                                    4 => 'badge border border-danger text-danger',
                                    5 => 'badge border border-secondary text-secondary',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                $paymentName = $order->paymentStatus->name ?? 'Không xác định';

                                // Logic hiển thị phương thức thanh toán
                                $methodColors = [
                                    1 => 'text-dark',      // COD
                                    2 => 'text-primary',   // VNPAY
                                    3 => 'text-danger',    // MOMO
                                ];
                                $methodColor = $methodColors[$order->payment_method_id] ?? 'text-muted';
                                $methodName = $order->paymentMethod->name ?? 'N/A';
                            ?>
                            <tr>
                                <td><span class="fw-bold"><?php echo e($order->order_code); ?></span></td>
                                <td><?php echo e($order->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.users.show', $order->user_id ?? 0)); ?>" class="link-primary">
                                        <?php echo e($order->name ?? 'Khách lẻ'); ?>

                                    </a>
                                </td>
                                <td><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</td>
                                
                                
                                <td>
                                    <span class="fw-medium <?php echo e($methodColor); ?>">
                                        <?php echo e($methodName); ?>

                                    </span>
                                </td>

                                
                                <td>
                                    <span class="<?php echo e($paymentColor); ?> px-2 py-1 fs-13"><?php echo e($paymentName); ?></span>
                                </td>

                                <td>
    <span class="badge bg-light text-dark border px-2 py-1">
        <iconify-icon icon="solar:box-bold" class="align-middle me-1 text-secondary"></iconify-icon>
        <?php echo e($order->details_sum_quantity ?? 0); ?> SP
    </span>
</td>
                                
                                <td class="text-center">
                                    <?php if($order->cancelRequest && $order->cancelRequest->status_id == 1): ?>
                                        <a href="<?php echo e(route('admin.order-cancellations.show', $order->cancelRequest->id)); ?>" 
                                           class="btn btn-warning btn-sm py-1 px-2">
                                            <iconify-icon icon="solar:bell-bing-broken" class="fs-18 me-1"></iconify-icon> Duyệt
                                        </a>
                                    <?php elseif($order->cancelRequest): ?>
                                        <span class="text-success">
                                            <iconify-icon icon="solar:document-check-broken" class="fs-18"></iconify-icon>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                
                                <td>
                                    <form action="<?php echo e(route('admin.orders.status', $order->id)); ?>" method="POST" class="status-form">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="admin_reason" class="admin-reason-field">
                                        <select name="order_status_id" class="form-select form-select-sm w-auto <?php echo e($colorClass); ?>"
                                                onchange="confirmStatusChange(this)">
                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($status->id); ?>"
                                                        data-color="<?php echo e($status->color_class); ?>"
                                                        <?php echo e($order->order_status_id == $status->id ? 'selected' : ''); ?>

                                                        <?php echo e(in_array($status->id, [5,7]) ? 'disabled' : ''); ?>>
                                                    <?php echo e($status->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </form>
                                </td>

                                
                                <td>
                                    <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-soft-info btn-sm">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Không có đơn hàng nào.</td>
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

    // Khởi tạo màu sắc ban đầu cho select
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if(selectedOption && selectedOption.dataset.color){
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
        select.dataset.current = select.value;
    });

    // Xác nhận hủy đơn trong Modal
    const btnConfirm = document.getElementById('btnConfirmCancel');
    if (btnConfirm) {
        btnConfirm.addEventListener('click', function() {
            const reasonInput = document.getElementById('admin_reason_input');
            const reason = reasonInput.value.trim();
            
            if (reason.length < 5) {
                alert('Vui lòng nhập lý do hủy chi tiết hơn (tối thiểu 5 ký tự).');
                return;
            }

            if (window.currentSelect) {
                submitStatusForm(window.currentSelect, reason);
                const modal = bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal'));
                if(modal) modal.hide();
            }
        });
    }

    // Nút đóng Modal
    const btnClose = document.getElementById('btnCancelModal');
    if (btnClose) {
        btnClose.addEventListener('click', function() {
            if (window.currentSelect) resetSelect(window.currentSelect);
            const modal = bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal'));
            if(modal) modal.hide();
        });
    }
});

window.currentSelect = null;

function confirmStatusChange(select) {
    const newValue = select.value;
    const newStatusText = select.selectedOptions[0].text;
    window.currentSelect = select;

    if (newValue == "6") { // ID Trạng thái Hủy
        const modalElement = document.getElementById('cancelReasonModal');
        const modal = new bootstrap.Modal(modalElement);
        document.getElementById('admin_reason_input').value = ''; 
        modal.show();
    } else {
        if (confirm(`Bạn có chắc muốn đổi trạng thái sang "${newStatusText}"?`)) {
            submitStatusForm(select);
        } else {
            resetSelect(select);
        }
    }
}

function submitStatusForm(select, reason = '') {
    const form = select.form;
    const reasonField = form.querySelector('.admin-reason-field');
    if (reasonField) reasonField.value = reason;
    form.submit();
}

function resetSelect(select) {
    select.value = select.dataset.current;
    const currentOption = select.querySelector(`option[value="${select.value}"]`);
    if (currentOption) select.className = 'form-select form-select-sm w-auto ' + currentOption.dataset.color;
}
</script>


<div class="modal fade" id="cancelReasonModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Vui lòng nhập lý do hủy đơn hàng này:</p>
                <textarea id="admin_reason_input" class="form-control" rows="3" placeholder="Sản phẩm hết hàng, không liên lạc được khách..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelModal">Đóng</button>
                <button type="button" class="btn btn-danger" id="btnConfirmCancel">Xác nhận hủy</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>