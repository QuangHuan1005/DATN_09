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
                <input type="search" name="keyword" class="form-control me-2"
                        placeholder="Tìm mã voucher..." value="<?php echo e(request('keyword')); ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        <div class="col-md-6 text-end">
            <a href="<?php echo e(route('admin.vouchers.create')); ?>" class="btn btn-success">
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
                            <th class="text-center" style="width: 15%;">Giá trị</th> 
                            <th class="text-center">Giảm tối đa</th> 
                            <th class="text-center">Đơn tối thiểu</th> 
                            <th class="text-center">SL còn/Tổng</th> 
                            <th class="text-center" style="width: 10%;">Bắt đầu</th> 
                            <th class="text-center" style="width: 10%;">Kết thúc</th> 
                            <th class="text-center">TT</th>
                            <th class="text-center">SP áp dụng</th> 
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($vouchers->firstItem() + $key); ?></td>
                                <td class="text-center fw-bold"><?php echo e($item->voucher_code); ?></td>

                                
                                <td class="text-center">
                                    <?php if($item->discount_type === 'fixed'): ?>
                                        <?php echo e(number_format($item->discount_value)); ?>đ 
                                        <span class="badge text-bg-secondary">Cố định</span>
                                    <?php else: ?>
                                        <?php echo e($item->discount_value); ?>% 
                                        <span class="badge text-bg-secondary">Phần trăm</span>
                                    <?php endif; ?>
                                </td>
                                
                                
                                <td class="text-center">
                                    <?php if($item->discount_type === 'fixed'): ?>
                                        <span class="text-muted">—</span> 
                                    <?php else: ?>
                                        <?php echo e($item->sale_price ? number_format($item->sale_price) . 'đ' : '—'); ?>

                                    <?php endif; ?>
                                </td>

                                
                                <td class="text-center">
                                    <?php echo e(number_format($item->min_order_value)); ?>đ
                                </td>
                                
                                
                                <td class="text-center fw-medium">
                                    <?php echo e($item->quantity - $item->total_used); ?> / <?php echo e($item->quantity); ?>

                                </td>

                                
                                <td class="text-center"><?php echo e(\Carbon\Carbon::parse($item->start_date)->format('d-m H:i')); ?></td>
                                <td class="text-center"><?php echo e(\Carbon\Carbon::parse($item->end_date)->format('d-m H:i')); ?></td>

                                
                                <td class="text-center">
                                    <span class="badge px-2 py-1 fs-13 
                                        <?php echo e($item->status == 1 ? 'bg-success text-light' : 'bg-danger text-light'); ?>">
                                        <?php echo e($item->status == 1 ? 'Hoạt động' : 'Ngừng'); ?>

                                    </span>
                                </td>
                                
                                
                                <td class="text-center">
                                    <?php if($item->products->count() > 0): ?>
                                        <span class="badge text-bg-info" 
                                              data-bs-toggle="tooltip" 
                                              data-bs-placement="top" 
                                              title="<?php echo e($item->products->pluck('name')->implode(', ')); ?>">
                                            <?php echo e($item->products->count()); ?> SP <i class="bi bi-tag-fill"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">Tất cả</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td class="text-center text-nowrap">
                                    
                                    
                                    <a href="<?php echo e(route('admin.vouchers.edit', $item->id)); ?>"
                                        class="btn btn-warning btn-sm px-1 py-0 me-1" title="Sửa voucher">
                                         <iconify-icon icon="solar:pen-new-square-broken" class="fs-18"></iconify-icon>
                                    </a>

                                    
                                    <form action="<?php echo e(route('admin.vouchers.destroy', $item->id)); ?>"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa voucher <?php echo e($item->voucher_code); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm px-1 py-0" title="Xóa voucher">
                                             <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="fs-18"></iconify-icon>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    Không có voucher nào.
                                </td>
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
        // Tự ẩn alert sau 3 giây
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);
        });

        // Kích hoạt Tooltips cho cột Sản phẩm áp dụng và các nút icon (Bootstrap)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/vouchers/index.blade.php ENDPATH**/ ?>