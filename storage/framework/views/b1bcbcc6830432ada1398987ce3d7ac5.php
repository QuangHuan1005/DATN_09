

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3 class="mb-4">Chi tiết đơn hàng: <?php echo e($order->order_code); ?></h3>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="row">
        
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light fw-bold">Thông tin tài khoản</div>
                <div class="card-body">
                    <?php if($order->user): ?>
                        <p><strong>Tên tài khoản:</strong> <?php echo e($order->user->name); ?></p>
                        <p><strong>Email:</strong> <?php echo e($order->user->email); ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo e($order->user->phone ?? 'Không có'); ?></p>
                        <p><strong>Ngày đăng ký:</strong> <?php echo e($order->user->created_at->format('d/m/Y')); ?></p>
                    <?php else: ?>
                        <p class="text-muted">Đơn hàng được tạo bởi khách vãng lai (không có tài khoản).</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light fw-bold">Thông tin khách hàng / giao hàng</div>
                <div class="card-body">
                    <p><strong>Tên người nhận:</strong> <?php echo e($order->name); ?></p>
                    <p><strong>Điện thoại:</strong> <?php echo e($order->phone); ?></p>
                    <p><strong>Địa chỉ giao hàng:</strong> <?php echo e($order->address); ?></p>
                    <p><strong>Email liên hệ:</strong> <?php echo e($order->email ?? ($order->user?->email ?? 'Không có')); ?></p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light fw-bold">Thông tin đơn hàng</div>
        <div class="card-body row">
            <div class="col-md-6">
                <p><strong>Mã đơn hàng:</strong> <?php echo e($order->order_code); ?></p>
                <p><strong>Ngày đặt hàng:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                <p><strong>Trạng thái đơn hàng:</strong> <?php echo e($order->status ? $order->status->name : 'Chưa xác định'); ?></p>

            </div>

            <div class="col-md-6">
                <p><strong>Trạng thái thanh toán:</strong> 
                    <?php echo e($order->paymentStatus->name ?? 'Chưa xác định'); ?>

                </p>

                <p><strong>Phương thức thanh toán:</strong> 
                    <?php echo e($order->paymentMethod->name ?? 'Chưa chọn'); ?>

                </p>

                <?php if($order->voucher): ?>
                    <p><strong>Mã giảm giá:</strong> <?php echo e($order->voucher->voucher_code); ?></p>
                    <ul class="list-unstyled ms-2 text-muted">
                        <li>Giảm: <strong><?php echo e(number_format($order->voucher->sale_price, 0, ',', '.')); ?> đ</strong></li>
                        <li>Đơn tối thiểu: <strong><?php echo e(number_format($order->voucher->min_order_value, 0, ',', '.')); ?> đ</strong></li>
                        <li>Mô tả: <?php echo e($order->voucher->description ?? 'Không có'); ?></li>
                    </ul>
                <?php else: ?>
                    <p><strong>Mã giảm giá:</strong> Không sử dụng</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light fw-bold">Chi tiết sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Biến thể</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php if($line->image): ?>
                                    <img src="<?php echo e(asset('storage/' . $line->image)); ?>" width="60" alt="image">
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($line->product_name); ?></td>
                            <td><?php echo e($line->variant_text ?? '-'); ?></td>
                            <td><?php echo e(number_format($line->unit_price, 0, ',', '.')); ?> đ</td>
                            <td><?php echo e($line->qty); ?></td>
                            <td><?php echo e(number_format($line->line_total, 0, ',', '.')); ?> đ</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-muted">Không có sản phẩm nào</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card shadow-sm">
        <div class="card-body text-end">
            <p><strong>Tạm tính:</strong> <?php echo e(number_format($calc_subtotal, 0, ',', '.')); ?> đ</p>
            <p><strong>Giảm giá:</strong> -<?php echo e(number_format($calc_discount, 0, ',', '.')); ?> đ</p>
            <hr>
            <h5><strong>Tổng cộng:</strong> <?php echo e(number_format($calc_total, 0, ',', '.')); ?> đ</h5>
        </div>
    </div>

    
    <div class="mt-4 d-flex justify-content-between">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>

        <div>
            <?php if(in_array($order->order_status, ['pending', 'confirmed'])): ?>
                <form action="<?php echo e(route('orders.cancel', $order->id)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        Hủy đơn hàng
                    </button>
                </form>
            <?php endif; ?>

            
            <?php if(auth()->user()?->isAdmin()): ?>
                <form action="<?php echo e(route('orders.updateStatus', $order->id)); ?>" method="POST" class="d-inline ms-2">
                    <?php echo csrf_field(); ?>
                    <select name="status" class="form-select d-inline w-auto">
                        <option value="pending" <?php echo e($order->order_status=='pending'?'selected':''); ?>>Chờ xác nhận</option>
                        <option value="confirmed" <?php echo e($order->order_status=='confirmed'?'selected':''); ?>>Đã xác nhận</option>
                        <option value="shipping" <?php echo e($order->order_status=='shipping'?'selected':''); ?>>Đang giao</option>
                        <option value="delivered" <?php echo e($order->order_status=='delivered'?'selected':''); ?>>Đã giao</option>
                        <option value="cancelled" <?php echo e($order->order_status=='cancelled'?'selected':''); ?>>Đã hủy</option>
                    </select>
                    <button class="btn btn-primary ms-1">Cập nhật</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>