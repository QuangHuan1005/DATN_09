<nav class="woocommerce-MyAccount-navigation" aria-label="Account pages">
    <ul>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard is-active">
            <a href="<?php echo e(route('account.dashboard')); ?>" aria-current="page">
                Dashboard </a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders">
            <a href="<?php echo e(route('orders.index')); ?>">
                Đơn hàng </a>
        </li>

        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address">
            <a href="<?php echo e(route('account.addresses')); ?>">
                Địa chỉ </a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account">
            <a href="<?php echo e(route('account.profile')); ?>">
                Chi tiết tài khoản </a>
        </li>
        <li
            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--downloads">
            <a href="<?php echo e(route('account.password')); ?>">Đổi mật khẩu</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
            <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                Đăng xuất</a>

            <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" style="display:none;">
                <?php echo csrf_field(); ?>
            </form>
        </li>
    </ul>
</nav>
<?php /**PATH C:\laragon\www\DATN09\resources\views/account/partials/navigation.blade.php ENDPATH**/ ?>