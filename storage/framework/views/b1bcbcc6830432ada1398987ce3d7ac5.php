

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3>Chi tiết đơn hàng: <?php echo e($order->order_code); ?></h3>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="row mt-3">
        
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Thông tin khách hàng</div>
                <div class="card-body">
                    <p><strong>Tên:</strong> <?php echo e($order->name); ?></p>
                    <p><strong>Email:</strong> <?php echo e($order->user?->email ?? 'Không có'); ?></p>
                    <p><strong>Điện thoại:</strong> <?php echo e($order->phone); ?></p>
                    <p><strong>Địa chỉ:</strong> <?php echo e($order->address); ?></p>
                </div>
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p><strong>Mã đơn:</strong> <?php echo e($order->order_code); ?></p>
                    <p><strong>Trạng thái:</strong>
                        <?php if($order->status): ?>
                            <span class="badge bg-<?php echo e($order->status->color); ?>">
                                <?php echo e($order->status->name); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-muted">Chưa có</span>
                        <?php endif; ?>
                    </p>
                    <p><strong>Phương thức thanh toán:</strong> <?php echo e($order->payment?->method?->name ?? 'Chưa chọn'); ?></p>
                    <p><strong>Tổng tiền:</strong> <?php echo e(number_format($order->calc_total,0,',','.')); ?> đ</p>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-header">Chi tiết sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
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
                    <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($line->image): ?>
                                    <img src="<?php echo e(asset('storage/'.$line->image)); ?>" alt="image" style="width:60px;">
                                <?php else: ?>
                                    <span>Không có</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($line->product_name); ?></td>
                            <td><?php echo e($line->variant_text ?? '-'); ?></td>
                            <td><?php echo e(number_format($line->unit_price,0,',','.')); ?> đ</td>
                            <td><?php echo e($line->qty); ?></td>
                            <td><?php echo e(number_format($line->line_total,0,',','.')); ?> đ</td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-body text-end">
            <p><strong>Tạm tính:</strong> <?php echo e(number_format($calc_subtotal,0,',','.')); ?> đ</p>
            <p><strong>Giảm giá:</strong> <?php echo e(number_format($calc_discount,0,',','.')); ?> đ</p>
            <p><strong>Tổng cộng:</strong> <?php echo e(number_format($calc_total,0,',','.')); ?> đ</p>
        </div>
    </div>

    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>