<?php $__env->startSection('content'); ?>
    <div class="container-xxl">

        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h4 class="fw-medium text-dark d-flex align-items-center gap-2">
                                            #<?php echo e($order->order_code); ?>

                                            
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
                                                    $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                            ?>
                                            <span class="<?php echo e($color); ?> fs-13 px-2 py-1 rounded">
                                                <?php echo e($paymentName); ?></span>
                                        </h4>
                                        <p class="mb-0">Order / Order Details / #<?php echo e($order->order_code); ?> -
                                            <?php echo e($order->created_at ? $order->created_at->format('d/m/Y H:i') : '-'); ?>

                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h4 class="fw-medium text-dark">Tiến độ</h4>
                                </div>

                                <?php
                                    // Map các bước hiển thị trên UI
                                    $steps = [
                                        ['id' => 1, 'label' => 'Chờ xác nhận'],
                                        ['id' => 2, 'label' => 'Xác nhận'],
                                        ['id' => 3, 'label' => 'Đang giao hàng'],
                                        ['id' => 4, 'label' => 'Đã giao hàng'],
                                        ['id' => 5, 'label' => 'Hoàn thành'],
                                    ];

                                    $status = (int) ($order->order_status_id ?? 1);
                                    $isTerminal = in_array($status, [6, 7], true);
                                    $terminalLabel = $status === 6 ? 'Đã hủy' : ($status === 7 ? 'Hoàn hàng' : null);

                                    /**
                                     * Xác định "bước hiện tại" để đổ progress:
                                     * - Trạng thái thường (1..5): current = chính status
                                     * - Trạng thái kết thúc:
                                     *   + Hủy (6): dừng ở bước 2 (đã xác nhận xong rồi bị hủy) — có thể chỉnh theo nghiệp vụ
                                     *   + Hoàn hàng (7): dừng ở bước 4 (đã giao rồi bị hoàn) — có thể chỉnh theo nghiệp vụ
                                     */
                                    $current = $isTerminal ? ($status === 6 ? 2 : 5) : min(max($status, 1), 5);

                                    // Hàm phụ để tính style cho từng bước
                                    $calc = function (int $stepId) use ($current, $isTerminal) {
                                        if ($stepId < $current) {
                                            return [
                                                'width' => 100,
                                                'bar' => 'bg-success',
                                                'state' => 'done',
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        if ($stepId === $current && !$isTerminal) {
                                            $with = in_array($stepId, [4, 5]) ? 100 : 60;
                                            $bar = in_array($stepId, [4, 5]) ? 'bg-success' : 'bg-warning';
                                            $striped = in_array($stepId, [4, 5]) ? 'done' : 'active';

                                            return [
                                                'width' => $with,
                                                'bar' => $bar,
                                                'state' => $striped,
                                                'striped' => true,
                                                'animated' => true,
                                            ];
                                        }
                                        // Chưa tới bước
                                        return [
                                            'width' => 0,
                                            'bar' => 'bg-primary',
                                            'state' => 'todo',
                                            'striped' => true,
                                            'animated' => true,
                                        ];
                                    };
                                ?>
                                <div class="row row-cols-xxl-6 row-cols-md-2 row-cols-1 g-3">
                                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $s = $calc($step['id']);
                                        ?>
                                        <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                <div class="progress-bar progress-bar-striped <?php echo e($s['animated'] ? 'progress-bar-animated' : ''); ?> <?php echo e($s['bar']); ?>"
                                                    role="progressbar" style="width: <?php echo e($s['width']); ?>%"
                                                    aria-valuenow="<?php echo e($s['width']); ?>" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>

                                            <?php if($s['state'] === 'active'): ?>
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <p class="mb-0"><?php echo e($step['label']); ?></p>
                                                    <div class="spinner-border spinner-border-sm text-warning"
                                                        role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </div>
                                            <?php elseif($s['state'] === 'done'): ?>
                                                <div class="d-flex align-items-center gap-2 mt-2">
                                                    <p class="mb-0 mb-0"><?php echo e($step['label']); ?></p>
                                                    <i class="bx bx-check-circle text-success"></i>
                                                </div>
                                            <?php else: ?>
                                                <p class="mb-0 mt-2 text-muted"><?php echo e($step['label']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($isTerminal): ?>
                                        <div class="col">
                                            <div class="progress mt-3" style="height: 10px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated <?php echo e($status === 6 ? 'bg-danger' : 'bg-secondary'); ?>"
                                                    role="progressbar" style="width: 100%" aria-valuenow="100"
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-2">
                                                <p
                                                    class="mb-0 fw-semibold <?php echo e($status === 6 ? 'text-danger' : 'text-secondary'); ?>">
                                                    <?php echo e($terminalLabel); ?></p>
                                                <i
                                                    class="bx <?php echo e($status === 6 ? 'bx-x-circle text-danger' : 'bx-transfer text-secondary'); ?>"></i>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div
                                class="card-footer d-flex flex-wrap align-items-center justify-content-between bg-light-subtle gap-2">
                                <p class="border rounded mb-0 px-2 py-1 bg-body"><i
                                        class='bx bx-arrow-from-left align-middle fs-16'></i> Ngày dự kiến giao hàng:
                                    <span
                                        class="text-dark fw-medium"><?php echo e($order->created_at ? $order->created_at->addDays(2)->format('d/m/Y') : '-'); ?>

                                    </span>
                                </p>
                                <div>
                                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-primary">Quay lại</a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sản Phẩm</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-hover table-centered">
                                        <thead class="bg-light-subtle border-bottom">
                                            <tr>
                                                <th>Tên Sản Phẩm & Size</th>
                                                
                                                <th>Giá</th>
                                                <th>Số Lượng</th>
                                                
                                                <th>Thành Tiền</th>
                                            </tr>
                                        </thead>
                                      <tbody>
                                                <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td>
        <div class="d-flex align-items-center gap-2">
            <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                <!-- ĐÃ SỬA DỨT ĐIỂM: Sử dụng đường dẫn chính xác bạn đã xác nhận là 'storage/product_images/' -->
                <img src="<?php echo e($line->image ? asset('storage/product_images/' . $line->image) : asset('images/no-image.png')); ?>"
                     alt="<?php echo e($line->product_name); ?>"
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                >
            </div>
        </div>
    </td>
    <td>
        <?php echo e($line->product_name); ?>

        
        <!-- ĐÃ GỠ BỎ TOÀN BỘ DÒNG DEBUG -->
        
    </td>
    <td><?php echo e($line->variant_text); ?></td>
    <td><?php echo e(number_format($line->unit_price)); ?>₫</td>
    <td><?php echo e($line->qty); ?></td>
    <td><?php echo e(number_format($line->line_total)); ?>₫</td>
</tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tóm Tắt Đơn Hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:clipboard-text-broken"></iconify-icon> Tạm Tính : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">
                                            <?php echo e(number_format($calc_subtotal, 0, ',', '.')); ?>₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:ticket-broken" class="align-middle"></iconify-icon>
                                                Giảm Giá : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">
                                            -<?php echo e(number_format($calc_discount, 0, ',', '.')); ?>₫</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0">
                                            <p class="d-flex mb-0 align-items-center gap-1"><iconify-icon
                                                    icon="solar:kick-scooter-broken" class="align-middle"></iconify-icon>
                                                Phí giao hàng. : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0">30.000₫</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between bg-light-subtle">
                        <div>
                            <p class="fw-medium text-dark mb-0">Tổng Số Tiền</p>
                        </div>
                        <div>
                            <p class="fw-medium text-dark mb-0"><?php echo e(number_format($calc_total + 30000, 0, ',', '.')); ?>₫
                            </p>
                        </div>

                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/images/users/avatar-1.jpg" alt=""
                                class="avatar rounded-3 border border-light border-3">
                            <div>
                                <p class="mb-1"><?php echo e($order->name ?? 'N/A'); ?></p>
                                <a href="#!" class="link-primary fw-medium"><?php echo e($order->user?->email ?? 'N/A'); ?></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Số Điện Thoại</h5>
                            <div>
                                
                            </div>
                        </div>
                        <p class="mb-1"><?php echo e($order->phone); ?></p>

                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Địa Chỉ Giao Hàng</h5>
                            <div>
                                
                            </div>
                        </div>

                        <div>
                            <p class="mb-1"><?php echo e($order->address); ?></p>
                            
                            <p class=""><?php echo e($order->phone); ?></p>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <h5 class="">Địa Chỉ Thanh Toán</h5>
                            <div>
                                
                            </div>
                        </div>

                        <p class="mb-1">Giống với địa chỉ giao hàng</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>