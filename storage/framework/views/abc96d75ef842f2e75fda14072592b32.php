<?php $__env->startSection('content'); ?>

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">
        <div class="site-wrapper">
            <div class="kitify-site-wrapper elementor-459kitify">
                <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb">
                                            <a href="/">Home</a><span class="delimiter">/</span>Tài khoản của tôi
                                        </nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                                                <div class="woocommerce-MyAccount-content">
                                                    

                                                    <p>
                                                        Xin chào,
                                                        <strong><?php echo e($user->name); ?>!</strong> (nếu
                                                        không phải
                                                        <strong><?php echo e(Str::afterLast(Auth::user()->name, ' ')); ?></strong>?

                                                        <a href=""
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                                            Đăng xuất</a>)

                                                    <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>"
                                                        style="display:none;">
                                                        <?php echo csrf_field(); ?>
                                                    </form>

                                                    </p>

                                                    <p>
                                                        Từ bảng điều khiển tài khoản của bạn, bạn có thể xem <a
                                                            href="https://mixtas.novaworks.net/my-account/orders/">đơn hàng
                                                            gần đây</a>, <a
                                                            href="https://mixtas.novaworks.net/my-account/edit-address/">địa
                                                            chỉ giao hàng
                                                            và thanh toán </a>
                                                        <a href="">chỉnh
                                                            sửa mật khẩu</a> và <a
                                                            href="https://mixtas.novaworks.net/my-account/edit-account/">thông
                                                            tin tài khoản của bạn</a>.
                                                    </p>

                                                </div>

                                            </div>
                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/account/dashboard.blade.php ENDPATH**/ ?>