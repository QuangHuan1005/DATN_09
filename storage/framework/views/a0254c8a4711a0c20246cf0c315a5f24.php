<?php $__env->startSection('content'); ?>

    <body
        class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-edit-account woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
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
                                                href="https://mixtas.novaworks.net/my-account/">Tài khoản của tôi</a><span
                                                class="delimiter">/</span>Chi tiết tài khoản</nav>
                                        <h1 class="page-title">Tài khoản của tôi</h1>
                                    </div>
                                    <article id="post-11" class="post-11 page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce">
                                                <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <div class="woocommerce-MyAccount-content">
                                                    <div class="woocommerce-notices-wrapper">
                                                        
                                                        <?php if($errors->any()): ?>
                                                            <ul class="alert woocommerce-error" role="alert"
                                                                tabindex="-1">
                                                                <li>
                                                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <strong>Lỗi:</strong>
                                                                        <?php echo e($error); ?> <br>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </li>

                                                            </ul>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(session('success')): ?>
                                                            <ul class="woocommerce-message" role="status" tabindex="-1">
                                                                <li>
                                                                    <strong>Thành công:</strong>
                                                                    <?php echo e(session('success')); ?>

                                                                </li>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </div>
                                                    <form class="woocommerce-EditAccountForm edit-account"
                                                        action="<?php echo e(route('account.update')); ?>" method="POST"
                                                        enctype="multipart/form-data">
                                                        <?php echo csrf_field(); ?>

                                                        
                                                        <p class="woocommerce-form-row form-row-wide">
                                                            <label for="image">Ảnh đại diện</label>
                                                        <div style="text-align:center;">
                                                            <img id="avatar-preview"
                                                                src="<?php echo e(asset('storage/' . $user->image)); ?>" alt="Avatar"
                                                                style="width:100px;height:100px;border-radius:50%;object-fit:cover;display:block;margin:0 auto 12px;">
                                                            <label for="image" class="button"
                                                                style="display:inline-block;padding:8px 16px;border:1px solid #ccc;border-radius:6px;cursor:pointer;">
                                                                Chọn ảnh
                                                            </label>
                                                            <input type="file" name="image" id="image"
                                                                accept="image/*" style="display:none;">

                                                            <p class="description" style="color:#666;font-size:12px;">
                                                                PNG/JPG ≤ 2MB. Tỷ lệ 1:1 hiển thị đẹp.
                                                            </p>
                                                        </div>
                                                        </p>

                                                        <p class="woocommerce-form-row form-row-wide">
                                                            <label for="username">Tên tài khoản <span
                                                                    class="required">*</span></label>
                                                            <input type="text"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="username" id="username"
                                                                value="<?php echo e(old('username', $user->username)); ?>">
                                                            <small class="text-muted d-block">
                                                                Đây là tên hiển thị trong tài khoản và phần đánh giá.
                                                            </small>
                                                        </p>

                                                        <div class="clear"></div>

                                                        <p class="woocommerce-form-row form-row-first">
                                                            <label for="name">Họ tên <span
                                                                    class="required">*</span></label>
                                                            <input type="text"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="name" id="name"
                                                                value="<?php echo e(old('name', $user->name)); ?>">
                                                        </p>

                                                        <p class="woocommerce-form-row form-row-last">
                                                            <label for="phone">Số điện thoại</label>
                                                            <input type="tel"
                                                                class="woocommerce-Input woocommerce-Input--text input-text"
                                                                name="phone" id="phone"
                                                                value="<?php echo e(old('phone', $user->phone)); ?>">
                                                        </p>
                                                        <div class="clear"></div>
                                                        <p class="woocommerce-form-row form-row-wide">
                                                            <label for="email">Địa chỉ email <span
                                                                    class="required">*</span></label>
                                                            <input type="email"
                                                                class="woocommerce-Input woocommerce-Input--email input-text"
                                                                name="email" id="email"
                                                                value="<?php echo e(old('email', $user->email)); ?>">
                                                        </p>

                                                        <p class="mt-2">
                                                            <button type="submit"
                                                                class="woocommerce-Button button">Lưu</button>
                                                        </p>
                                                    </form>


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

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/account/profile.blade.php ENDPATH**/ ?>