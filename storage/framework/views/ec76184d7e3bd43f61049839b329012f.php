

<?php $__env->startSection('title', 'Staff Dashboard'); ?>

<?php $__env->startSection('menu'); ?>
    <?php echo $__env->make('staff.layouts.menu-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Chào mừng nhân viên!</h1>
    <p>Đây là trang dashboard dành riêng cho Staff.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/staff/dashboard.blade.php ENDPATH**/ ?>