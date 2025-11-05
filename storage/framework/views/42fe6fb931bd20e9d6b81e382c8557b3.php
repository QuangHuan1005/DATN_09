<?php $__env->startSection('content'); ?>
<body
    class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-lost-password woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active ">
    <div class="site-wrapper">
        <div class="kitify-site-wrapper elementor-459kitify">
            
            <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div id="site-content" class="site-content-wrapper">
                <div class="nova-container">
                    <div class="grid-x">
                        <div class="cell small-12">
                            <div class="site-content">
                                <div class="page-header-content">
                                    <nav class="woocommerce-breadcrumb">
                                        <a href="<?php echo e(url('/')); ?>">Home</a>
                                        <span class="delimiter">/</span>Forgot Password
                                    </nav>
                                </div>

                                <article id="post-11" class="post-11 page type-page status-publish hentry">
                                    <div class="entry-content">
                                        <div class="woocommerce">
                                            <div class="container">
                                                <div class="woocommerce-notices-wrapper"></div>

                                                
                                                <?php if(session('success')): ?>
                                                    <div style="color:green; margin-bottom:10px;">
                                                        <?php echo e(session('success')); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <?php if(session('error')): ?>
                                                    <div style="color:red; margin-bottom:10px;">
                                                        <?php echo e(session('error')); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <?php if($errors->any()): ?>
                                                    <div style="color:red; margin-bottom:10px;">
                                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <p><?php echo e($error); ?></p>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php endif; ?>

                                                
                                                <form method="POST" action="<?php echo e(route('password.email')); ?>"
                                                    class="woocommerce-ResetPassword lost_reset_password">
                                                    <?php echo csrf_field(); ?>

                                                    <p>Quên mật khẩu? Vui lòng nhập địa chỉ email của bạn, chúng tôi sẽ gửi
                                                        liên kết để đặt lại mật khẩu.</p>

                                                    <p class="woocommerce-form-row form-row form-row-first">
                                                        <label for="email">Địa chỉ Email&nbsp;
                                                            <span class="required" aria-hidden="true">*</span>
                                                        </label>
                                                        <input class="woocommerce-Input woocommerce-Input--text input-text"
                                                            type="email" name="email" id="email"
                                                            value="<?php echo e(old('email')); ?>"
                                                            placeholder="Nhập email của bạn..." required />
                                                    </p>

                                                    <div class="clear"></div>

                                                    <p class="woocommerce-form-row form-row">
                                                        <button type="submit" class="woocommerce-Button button">
                                                            Gửi liên kết đặt lại mật khẩu
                                                        </button>
                                                    </p>

                                                    <p class="form-actions-extra">
                                                        <a href="<?php echo e(route('login')); ?>" class="button" style="margin-top:10px;">
                                                            Quay lại đăng nhập
                                                        </a>
                                                    </p>
                                                </form>

                                            </div>
                                        </div>
                                    </div><!-- .entry-content -->
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>