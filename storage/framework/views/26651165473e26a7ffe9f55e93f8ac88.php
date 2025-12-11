<?php $__env->startSection('content'); ?>
    <div class="container-xxl">

        <div class="row">
            <!-- Cột trái: Thông tin người dùng -->
            <div class="col-lg-4">
                <!-- Thông tin cơ bản -->
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="bg-primary profile-bg rounded-top p-5 position-relative mx-n3 mt-n3">
                            <img src="<?php echo e($users->image ? asset('storage/' . $users->image) : asset('assets/images/users/avatar-2.jpg')); ?>"
                                alt="<?php echo e($users->name); ?>"
                                class="avatar-lg border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                        </div>

                        <div class="mt-4 pt-3">
                            <h4 class="mb-1">
                                <?php echo e($users->name); ?>

                                <?php if($users->is_verified): ?>
                                    <i class="bx bxs-badge-check text-success align-middle"></i>
                                <?php endif; ?>
                            </h4>
                            <div class="mt-2">
                                <a href="#!"
                                    class="link-primary fs-15"><?php echo e(Str::slug($users->name, '_') . '_' . $users->id); ?></a>
                                <p class="fs-15 mb-1 mt-1"><span class="fw-semibold text-dark">Email:</span>
                                    <?php echo e($users->email); ?></p>
                                <p class="fs-15 mb-0 mt-1"><span class="fw-semibold text-dark">Phone:</span>
                                    <?php echo e($users->phone ?? 'Chưa cập nhật'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top gap-1 hstack">
                        <a href="#!" class="btn btn-primary w-100">Gửi tin nhắn</a>
                        <a href="#!" class="btn btn-light w-100">Phân tích</a>
                        <a href="<?php echo e(route('admin.users.edit', $users->id)); ?>"
                            class="btn btn-soft-dark d-inline-flex align-items-center justify-content-center rounded avatar-sm">
                            <i class="bx bx-edit-alt fs-18"></i>
                        </a>
                    </div>
                </div>

                <!-- Chi tiết khách hàng -->
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Chi tiết khách hàng</h4>
                        <span
                            class="badge <?php echo e($users->is_locked ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success'); ?>">
                            <?php echo e($users->is_locked ? 'Tài khoản bị khóa' : 'Đang hoạt động'); ?>

                        </span>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Account ID:</td>
                                        <td class="px-0 text-dark">#USR<?php echo e(str_pad($users->id, 6, '0', STR_PAD_LEFT)); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Email hóa đơn:</td>
                                        <td class="px-0 text-dark"><?php echo e($users->email); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Địa chỉ giao hàng:</td>
                                        <td class="px-0 text-dark"><?php echo e($users->address ?? 'Chưa cập nhật'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Ngôn ngữ:</td>
                                        <td class="px-0 text-dark">Tiếng Việt</td>
                                    </tr>
                                    <tr>
                                        <td class="px-0 fw-semibold text-dark">Mã đơn gần nhất:</td>
                                        <td class="px-0 text-dark"><?php echo e($latestOrder->code ?? 'Chưa có đơn hàng'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Hóa đơn gần nhất -->
                <div class="card">
                    <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Hóa đơn gần nhất</h4>
                        <a href="#!" class="btn btn-primary btn-sm">Xem tất cả</a>
                    </div>
                    <div class="card-body">
                        
                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-lg-8">
                <!-- Thống kê -->
                <div class="row">
                    <div class="col-lg-4">
                        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['title' => 'Tổng hóa đơn','value' => ''.e($invoiceCount).'','icon' => 'solar:bill-list-bold-duotone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tổng hóa đơn','value' => ''.e($invoiceCount).'','icon' => 'solar:bill-list-bold-duotone']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['title' => 'Tổng đơn hàng','value' => ''.e($orderCount).'','icon' => 'solar:box-bold-duotone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tổng đơn hàng','value' => ''.e($orderCount).'','icon' => 'solar:box-bold-duotone']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
                    </div>
                    <div class="col-lg-4">
                        <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['title' => 'Tổng chi tiêu','value' => ''.e(number_format($totalExpense, 0, ',', '.')).'₫','icon' => 'solar:chat-round-money-bold-duotone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tổng chi tiêu','value' => ''.e(number_format($totalExpense, 0, ',', '.')).'₫','icon' => 'solar:chat-round-money-bold-duotone']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
                    </div>
                </div>

                <!-- Lịch sử giao dịch -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title">Lịch sử giao dịch</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>Mã HĐ</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                        <th>Ngày thanh toán</th>
                                        <th>Phương thức</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><a href="#" class="text-body">#<?php echo e($t->order_code); ?></a></td>
                                            <td>
                                                <?php
                                                    $badgeClass = match ($t->order_status_id) {
                                                        1 => 'bg-primary-subtle text-primary',
                                                        2 => 'bg-warning-subtle text-warning',
                                                        3 => 'bg-success-subtle text-success',
                                                        4 => 'bg-success-subtle text-success',
                                                        5 => 'bg-primary-subtle text-primary',
                                                        6 => 'bg-danger-subtle text-danger',
                                                        default => 'bg-secondary-subtle text-secondary',
                                                    };
                                                ?>
                                                <span class="badge <?php echo e($badgeClass); ?> py-1 px-2 text-capitalize">
                                                    <?php echo e($t->status->name); ?>

                                                </span>
                                            </td>
                                            <td><?php echo e(number_format($t->total_amount, 0, ',', '.')); ?>₫</td>
                                            <td><?php echo e($t->created_at->format('d M, Y')); ?></td>
                                            <td><?php echo e(ucfirst($t->payment_method)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Chưa có giao dịch nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/users/show.blade.php ENDPATH**/ ?>