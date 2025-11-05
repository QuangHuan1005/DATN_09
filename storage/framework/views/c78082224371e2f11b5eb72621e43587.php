

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Sửa người dùng</h1>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.users.update', $user->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Điện thoại</label>
            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo e(old('phone', $user->phone)); ?>">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" id="address" name="address" class="form-control" value="<?php echo e(old('address', $user->address)); ?>">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Vai trò</label>
            <select id="role_id" name="role_id" class="form-control" required>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php echo e($user->role_id == $role->id ? 'selected' : ''); ?>>
                        <?php echo e($role->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="is_locked" name="is_locked" value="1" <?php echo e($user->is_locked ? 'checked' : ''); ?>>
            <label class="form-check-label" for="is_locked">Khóa tài khoản</label>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh đại diện</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <?php if($user->image): ?>
        <div class="mb-3">
            <img src="<?php echo e(asset('uploads/users/' . $user->image)); ?>" alt="Ảnh đại diện" style="max-width: 150px;" class="img-thumbnail">
        </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>