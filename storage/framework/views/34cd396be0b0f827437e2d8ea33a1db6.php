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
                                                class="delimiter">/</span>Đổi mật khẩu</nav>
                                        <h1 class="page-title">Đổi mật khẩu</h1>
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
                                                        action="<?php echo e(route('account.password.update')); ?>" method="POST"
                                                        novalidate>
                                                        <?php echo csrf_field(); ?>
                                                        
                                                        
                                                        

                                                        
                                                        <label for="current_password">Mật khẩu hiện tại</label>
                                                        <p class="woocommerce-form-row form-row form-row-wide"
                                                            style="position:relative;">
                                                            <input type="password" name="current_password"
                                                                id="current_password"
                                                                class="woocommerce-Input woocommerce-Input--text input-text <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                autocomplete="current-password" style="padding-right:40px;">
                                                            <span id="toggleCurrentPassword"
                                                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                                                                <i class="fa fa-eye"></i>
                                                            </span>
                                                        </p>

                                                        
                                                        <label for="new_password">Mật khẩu mới</label>
                                                        <p class="woocommerce-form-row form-row form-row-wide"
                                                            style="position:relative;">
                                                            <input type="password" name="new_password" id="new_password"
                                                                class="woocommerce-Input woocommerce-Input--text input-text <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                placeholder="Mật khẩu" autocomplete="new-password"
                                                                minlength="8" style="padding-right:40px;">
                                                            <span id="toggleNewPassword"
                                                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                                                                <i class="fa fa-eye"></i>
                                                            </span>
                                                        </p>

                                                        
                                                        <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                                                        <p class="woocommerce-form-row form-row form-row-wide"
                                                            style="position:relative;">
                                                            <input type="password" name="new_password_confirmation"
                                                                id="new_password_confirmation"
                                                                class="woocommerce-Input woocommerce-Input--text input-text <?php $__errorArgs = ['new_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                                placeholder="Nhập lại mật khẩu" autocomplete="new-password"
                                                                style="padding-right:40px;">
                                                            <span id="toggleNewPasswordConfirm"
                                                                style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                                                                <i class="fa fa-eye"></i>
                                                            </span>
                                                        </p>

                                                        <p class="mt-2">
                                                            <button type="submit"
                                                                class="woocommerce-Button button">Lưu</button>
                                                        </p>
                                                    </form>
                                                </div>

                                            </div>


                                        </div><!-- .entry-content -->

                                    </article><!-- #post-## -->
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                
                
                <script>
                    (function() {
                        const toggle = (btnSel, inputSel) => {
                            const btn = document.querySelector(btnSel);
                            const input = document.querySelector(inputSel);
                            if (!btn || !input) return;
                            btn.addEventListener('click', function() {
                                const isPw = input.getAttribute('type') === 'password';
                                input.setAttribute('type', isPw ? 'text' : 'password');
                                this.innerHTML = isPw ? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';
                            });
                        };
                        toggle('#toggleCurrentPassword', '#current_password');
                        toggle('#toggleNewPassword', '#new_password');
                        toggle('#toggleNewPasswordConfirm', '#new_password_confirmation');
                    })();
                </script>

                
                <style>
                    button.show-password-input {
                        display: none !important;
                        visibility: hidden !important;
                        opacity: 0 !important;
                    }
                </style>

                
                <style>
                    button.show-password-input {
                        display: none !important;
                        visibility: hidden !important;
                        opacity: 0 !important;
                    }
                </style>

                
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
                <!-- .site-content-wrapper -->
                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="nova-overlay-global"></div>
            </div><!-- .kitify-site-wrapper -->
            <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page cached by LiteSpeed Cache 6.5.2 on 2025-09-30 06:58:27 -->
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/account/password.blade.php ENDPATH**/ ?>