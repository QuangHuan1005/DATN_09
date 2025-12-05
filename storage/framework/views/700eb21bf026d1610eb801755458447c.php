
<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Quản Lý Kích Thước</h4>
                        <a href="<?php echo e(route('admin.attributes.sizes.create')); ?>" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Thêm Kích Thước
                        </a>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Kích Thước</th>
                                        <th>Mã Kích Thước</th>
                                        <th>Mô Tả</th>
                                        <th>Trạng Thái</th>
                                        <th>Số Biến Thể</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($sizes->firstItem() + $index); ?></td>
                                            <td>
                                                <p class="text-dark fw-medium fs-15 mb-0"><?php echo e($size->name); ?></p>
                                            </td>
                                            <td>
                                                <code><?php echo e($size->size_code); ?></code>
                                            </td>
                                            <td><?php echo e($size->description ?? '-'); ?></td>
                                            <td>
                                                <?php if($size->status === 'active'): ?>
                                                    <span class="badge bg-success">Hoạt động</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Không hoạt động</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($size->variants()->count()); ?></span>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('admin.attributes.sizes.edit', $size->id)); ?>"
                                                    class="btn btn-soft-primary btn-sm">
                                                    <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                                </a>

                                                <form action="<?php echo e(route('admin.attributes.sizes.destroy', $size->id)); ?>"
                                                    method="POST" style="display:inline-block;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-soft-danger btn-sm"
                                                        onclick="return confirm('Bạn có chắc muốn xóa kích thước này?\n\nLưu ý: Không thể xóa nếu kích thước đang được sử dụng trong biến thể sản phẩm.')">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                            class="align-middle fs-18"></iconify-icon>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">Chưa có kích thước nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            <?php echo e($sizes->links()); ?>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09-main\resources\views/admin/attributes/sizes/index.blade.php ENDPATH**/ ?>