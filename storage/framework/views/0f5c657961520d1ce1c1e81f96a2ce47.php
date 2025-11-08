

<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
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
        <div class="row">
            
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Tất Cả Sản Phẩm</h4>
                        <form method="GET" action="<?php echo e(route('staff.orders.index')); ?>" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo mã đơn hoặc tên KH ..." value="<?php echo e(request('keyword')); ?>">
                        </form>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                                <a href="<?php echo e(route('staff.orders.index', ['status' => null])); ?>" class="dropdown-item">Tất cả
                                    trạng
                                    thái</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 1])); ?>" class="dropdown-item">Chờ xác
                                    nhận</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 2])); ?>" class="dropdown-item">Xác
                                    nhận</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 3])); ?>" class="dropdown-item">Đang giao
                                    hàng</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 4])); ?>" class="dropdown-item">Đã giao
                                    hàng</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 5])); ?>" class="dropdown-item">Hoàn
                                    thành</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 6])); ?>" class="dropdown-item">Hủy</a>
                                <a href="<?php echo e(route('staff.orders.index', ['status' => 7])); ?>" class="dropdown-item">Hoàn
                                    hàng</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>Mã Đơn Hàng</th>
                                        <th>Ngày Tạo</th>
                                        <th>Khách Hàng</th>
                                        <th>Tổng Tiền</th>
                                        <th>Trạng Thái Thanh Toán</th>
                                        <th>Số Sản Phẩm</th>
                                        <th>Trạng Thái Đơn Hàng</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            // Lấy trạng thái đơn hàng
                                            $currentStatus = collect($statuses)->firstWhere(
                                                'id',
                                                $order->order_status_id,
                                            );
                                            $colorClass = $currentStatus
                                                ? $currentStatus->color_class
                                                : 'border-secondary text-secondary';
                                            $statusName = $currentStatus ? $currentStatus->name : 'Không xác định';
                                        ?>

                                        <tr>
                                            <td><?php echo e($order->order_code); ?></td>

                                            <td><?php echo e($order->created_at ? $order->created_at->format('d/m/Y H:i') : '-'); ?>

                                            </td>

                                            <td>
                                                <a href="#"
                                                    class="link-primary fw-medium">
                                                    <?php echo e($order->name ?? 'Khách lẻ'); ?>

                                                </a>
                                            </td>

                                            <td><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</td>


                                            <td>
                                                <?php
                                                    // Định nghĩa màu nhãn cho từng trạng thái
                                                    $paymentColors = [
                                                        1 => 'badge border border-primary text-primary', // Chưa thanh toán
                                                        2 => 'badge border border-warning text-warning', // Đang xử lý
                                                        3 => 'badge border border-success text-success', // Đã thanh toán
                                                        4 => 'badge border border-danger text-danger', // Thanh toán thất bại
                                                        5 => 'badge border border-secondary text-secondary', // Hoàn tiền
                                                    ];

                                                    $paymentName = $order->paymentStatus->name ?? 'Không xác định';
                                                    $color =
                                                        $paymentColors[$order->payment_status_id] ??
                                                        'bg-light text-dark';
                                                ?>

                                                <span class="badge <?php echo e($color); ?> px-2 py-1 fs-13">
                                                    <?php echo e($paymentName); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php echo e($order->details_sum_quantity ?? 0); ?> sản phẩm
                                            </td>

                                            <td>
                                                <form action="<?php echo e(route('staff.orders.status', $order->id)); ?>"
                                                    method="POST" class="status-form">
                                                    <?php echo csrf_field(); ?>
                                                    <select name="order_status_id"
                                                        class="form-select form-select-sm w-auto <?php echo e($colorClass); ?>"
                                                        onchange="changeStatusColor(this); this.form.submit()">
                                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($status->id); ?>"
                                                                data-color="<?php echo e($status->color_class); ?>"
                                                                <?php echo e($order->order_status_id == $status->id ? 'selected' : ''); ?>

                                                                <?php echo e(in_array($status->id, [5, 6, 7]) ? 'disabled' : ''); ?>>
                                                                <?php echo e($status->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </form>

                                            </td>

                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="<?php echo e(route('staff.orders.show', $order->id)); ?>"
                                                        class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                                        <iconify-icon icon="solar:eye-broken"
                                                            class="align-middle fs-18"></iconify-icon>
                                                    </a>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                Không có đơn hàng nào.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            <?php echo e($orders->links()); ?>

                            
                        </nav>
                    </div>
                </div>
            </div>
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

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/staff/orders/index.blade.php ENDPATH**/ ?>