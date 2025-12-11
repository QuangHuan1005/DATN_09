

<?php $__env->startSection('content'); ?>
<h1>Danh sách người dùng</h1>


<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info"><?php echo e(session('info')); ?></div>
<?php endif; ?>


<form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, email, SĐT" value="<?php echo e(request('search')); ?>">
    </div>
    <div class="col-md-3">
        <select name="role_id" class="form-select">
            <option value="">-- Tất cả vai trò --</option>
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($role->id); ?>" <?php echo e(request('role_id') == $role->id ? 'selected' : ''); ?>>
                    <?php echo e($role->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" type="submit">Lọc</button>
    </div>
</form>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr <?php if($user->trashed()): ?> class="table-secondary" <?php endif; ?>>
            <td><?php echo e($user->id); ?></td>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td><?php echo e($user->phone); ?></td>
            <td><?php echo e($user->role->name ?? 'Không xác định'); ?></td>
            <td>
                <?php if($user->trashed()): ?>
                    <span class="text-muted">Đã ẩn</span>
                <?php else: ?>
                    <?php echo e($user->is_locked ? 'Đã khóa' : 'Đang hoạt động'); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if(!$user->trashed()): ?>
                    
                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>" class="btn btn-sm btn-primary">Sửa</a>

                    
                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> 
                        <?php echo method_field('DELETE'); ?>
                        <button onclick="return confirm('Bạn chắc chắn muốn ẩn người dùng này?')" class="btn btn-sm btn-danger">Ẩn</button>
                    </form>

                    
                    <form action="<?php echo e(route('admin.users.toggleLock', $user->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-sm btn-warning">
                            <?php echo e($user->is_locked ? 'Mở khóa' : 'Khóa'); ?>

                        </button>
                    </form>
                <?php else: ?>
                    
                    <form action="<?php echo e(route('admin.users.restore', $user->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button onclick="return confirm('Bạn chắc chắn muốn khôi phục người dùng này?')" class="btn btn-sm btn-success">Khôi phục</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" class="text-center">Không có người dùng nào.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>


<div class="d-flex justify-content-center">
    <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/users/index.blade.php ENDPATH**/ ?>