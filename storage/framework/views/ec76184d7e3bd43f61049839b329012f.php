

<?php $__env->startSection('content'); ?>
<div class="container text-center mt-5">
    <h1>Xin chào <?php echo e($user->name); ?>!</h1>
    <p>Chào mừng bạn đến trang làm việc của nhân viên 💼</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/staff/dashboard.blade.php ENDPATH**/ ?>