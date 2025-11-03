<?php $__env->startSection('content'); ?>

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-edit-address woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
        data-elementor-device-mode="laptop">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div id="site-content" class="site-content-wrapper">
                    <div class="container">
                        <div class="grid-x">
                            <div class="cell small-12">
                                <div class="site-content">
                                    <div class="page-header-content">
                                        <nav class="woocommerce-breadcrumb"><a
                                                href="https://mixtas.novaworks.net">Home</a><span
                                                class="delimiter">/</span><a
                                                href="https://mixtas.novaworks.net/my-account/">My account</a><span
                                                class="delimiter">/</span>Addresses</nav>
                                        <h1 class="page-title">My account</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper"></div>

                                                    <p>Các địa chỉ sau đây sẽ được sử dụng trên trang thanh toán theo mặc
                                                        định.</p>

                                                    <div class="u-columns woocommerce-Addresses col2-set addresses">


                                                        <div class="u-column1 col-1 woocommerce-Address">
                                                            <header class="woocommerce-Address-title title">
                                                                <h2>Địa chỉ thanh toán</h2>
                                                                <a href="https://mixtas.novaworks.net/my-account/edit-address/billing/"
                                                                    class="edit">
                                                                    Chỉnh sửa địa chỉ thanh toán </a>
                                                            </header>
                                                            <address>
                                                                <?php echo e($user->name); ?> <br><?php echo e($user->address); ?><br>Hà
                                                                Nội<br>Vietnam </address>
                                                        </div>


                                                        <div class="u-column2 col-2 woocommerce-Address">
                                                            <header class="woocommerce-Address-title title">
                                                                <h2>Địa chỉ giao hàng</h2>
                                                                <a href="https://mixtas.novaworks.net/my-account/edit-address/shipping/"
                                                                    class="edit">
                                                                    Chỉnh sửa địa chỉ giao hàng </a>
                                                            </header>
                                                            <address>
                                                                <?php echo e($user->name); ?> <br><?php echo e($user->address); ?><br>Hà
                                                                Nội<br>Vietnam </address>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div><!-- .site-content-wrapper -->
                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/account/addresses.blade.php ENDPATH**/ ?>