<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h3 class="mb-3">Quản lý sản phẩm</h3>

        
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        
    <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên sản phẩm..." value="<?php echo e(request('keyword')); ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>


        <div class="mb-3">
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-success">+ Thêm sản phẩm</a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Mô tả</th>
                    <th>Danh mục</th> 
                    <th>Chất liệu</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($product->deleted_at ? 'table-secondary' : ''); ?>">
                        <td><?php echo e($product->id); ?></td>
                        <td><?php echo e($product->product_code); ?></td>

                        <td><?php echo e($product->name); ?></td>
                       <td>
    <?php if($product->photoAlbums->isNotEmpty()): ?>
        <img src="<?php echo e(asset('storage/' . $product->photoAlbums->first()->image)); ?>" 
             alt="<?php echo e($product->name); ?>"
             width="60" height="60"
             style="object-fit: cover; border-radius: 8px;">
    <?php else: ?>
        <img src="<?php echo e(asset('images/no-image.png')); ?>" 
             alt="No image" width="60" height="60"
             style="object-fit: cover; border-radius: 8px;">
    <?php endif; ?>
</td>

                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo e($product->description ?? 'Không có mô tả'); ?>

                        </td>
                        <td><?php echo e($product->category->name ?? 'Chưa phân loại'); ?></td> 
                        <td><?php echo e($product->material ?? '-'); ?></td>
                        <td>
                            <?php if($product->deleted_at): ?>
                                <span class="badge bg-secondary">Đã ẩn</span>
                            <?php else: ?>
                                <span class="badge bg-success">Hiển thị</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($product->created_at?->format('d/m/Y H:i')); ?></td>
                        <td>
                            <?php if(!$product->deleted_at): ?>
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                    class="btn btn-sm btn-warning">Sửa</a>

                                <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                                    class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn ẨN sản phẩm này?')">
                                        Ẩn
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?php echo e(route('admin.products.restore', $product->id)); ?>" method="POST"
                                    class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-sm btn-success"
                                        onclick="return confirm('Hiển thị lại sản phẩm này?')">
                                        Hiện
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Chưa có sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        
        <div class="mt-3">
            <?php echo e($products->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/products/index.blade.php ENDPATH**/ ?>