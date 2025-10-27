

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Quản lý danh mục</h1>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    
    <form method="GET" action="<?php echo e(route('admin.categories.index')); ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên danh mục..." value="<?php echo e(request('keyword')); ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    
    <div class="mb-3">
        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn btn-success">+ Thêm danh mục</a>
    </div>

    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Mô tả</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr <?php if($category->trashed()): ?> class="table-danger" <?php endif; ?>>
                    <td><?php echo e($category->id); ?></td>
                    <td><?php echo e($category->name); ?></td>
                    <td><?php echo e($category->slug); ?></td>
                    <td><?php echo e($category->description); ?></td>
                    <td>
                        <?php echo e($category->parent ? $category->parent->name : '(Danh mục gốc)'); ?>

                    </td>
                    <td>
                        <?php if($category->trashed()): ?>
                            <span class="badge bg-danger">Đã xóa mềm</span>
                        <?php else: ?>
                            <span class="badge bg-success">Hoạt động</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!$category->trashed()): ?>
                            <a href="<?php echo e(route('admin.categories.show', $category->id)); ?>" class="btn btn-info btn-sm">Xem</a>
                            <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="<?php echo e(route('admin.categories.destroy', $category->id)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa mềm danh mục này?')">
                                    Xóa mềm
                                </button>
                            </form>
                        <?php else: ?>
                            <form action="<?php echo e(route('admin.categories.restore', $category->id)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Bạn có chắc muốn khôi phục danh mục này?')">
                                    Khôi phục
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.categories.forceDelete', $category->id)); ?>" method="POST" style="display:inline-block;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Xóa vĩnh viễn, không thể hoàn tác. Tiếp tục?')">
                                    Xóa cứng
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">Không có danh mục nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
   
<div class="text-center mt-3">

    
    <div class="d-flex justify-content-center">
        <?php echo e($categories->withQueryString()->onEachSide(1)->links()); ?>

    </div>
</div>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>