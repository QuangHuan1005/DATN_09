<?php $__env->startSection('content'); ?>
    <div class="site-wrapper">
        <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div id="site-content" class="site-content-wrapper">
            <div class="nova-container">
                <nav class="woocommerce-breadcrumb" style="margin:16px 0;">
                    <a href="<?php echo e(url('/')); ?>">Home</a> <span class="delimiter">/</span> Register
                </nav>

                <div class="nova-login-wrapper no_popup" style="display:flex; justify-content:center;">
                    <div id="nova-register-form" style="width:100%; max-width:420px;">
                        <h2 class="page-title" style="text-align:center; margin-bottom:18px;">Đăng ký</h2>

                        
                        <?php if(session('error')): ?>
                            <div style="color:#d00; margin-bottom:10px;"><?php echo e(session('error')); ?></div>
                        <?php endif; ?>
                        <?php if(session('success')): ?>
                            <div style="color:#0a0; margin-bottom:10px;"><?php echo e(session('success')); ?></div>
                        <?php endif; ?>

                        
                        <?php if($errors->any()): ?>
                            <div style="color:#d00; margin-bottom:10px;">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p style="margin:4px 0;"><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('register')); ?>"
                            class="woocommerce-form woocommerce-form-register register">
                            <?php echo csrf_field(); ?>

                            <p class="woocommerce-form-row form-row form-row-wide">
                                <input type="text" name="name" id="reg_name"
                                    class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Họ tên"
                                    value="<?php echo e(old('name')); ?>" required autocomplete="name">
                            </p>

                            <p class="woocommerce-form-row form-row form-row-wide">
                                <input type="email" name="email" id="reg_email"
                                    class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Địa chỉ email"
                                    value="<?php echo e(old('email')); ?>" required autocomplete="email">
                            </p>

                            <p class="woocommerce-form-row form-row form-row-wide" style="position:relative;">
                                <input type="password" name="password" id="reg_password"
                                    class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Mật khẩu"
                                    required autocomplete="new-password" style="padding-right:40px;">
                                <span id="togglePassword"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </p>

                            <p class="woocommerce-form-row form-row form-row-wide" style="position:relative;">
                                <input type="password" name="password_confirmation" id="reg_password_confirmation"
                                    class="woocommerce-Input woocommerce-Input--text input-text"
                                    placeholder="Nhập lại mật khẩu" required autocomplete="new-password"
                                    style="padding-right:40px;">
                                <span id="togglePasswordConfirm"
                                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#888;">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </p>

                            <div class="woocommerce-privacy-policy-text" style="font-size:13px; color:#666;">
                                Dữ liệu cá nhân của bạn sẽ được dùng để quản lý tài khoản theo
                                <a href="#" target="_blank">chính sách bảo mật</a>.
                            </div>

                            <p class="form-actions" style="margin-top:12px;">
                                <button type="submit"
                                    class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit"
                                    style="width:100%;">
                                    Đăng ký
                                </button>
                            </p>

                            <p class="form-actions-extra" style="text-align:center; margin-top:10px;">
                                Đã có tài khoản? <a href="<?php echo e(route('login')); ?>" class="login-control">Đăng nhập</a>
                            </p>

                            <hr style="margin:18px 0;">
                            <p style="text-align:center;">
                                <a href="<?php echo e(route('auth.google')); ?>" class="button">Đăng nhập bằng Google</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const pw = document.querySelector("#reg_password");
        if (togglePassword && pw) {
            togglePassword.addEventListener("click", function() {
                const type = pw.getAttribute("type") === "password" ? "text" : "password";
                pw.setAttribute("type", type);
                this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' :
                    '<i class="fa fa-eye-slash"></i>';
            });
        }
        const togglePasswordConfirm = document.querySelector("#togglePasswordConfirm");
        const pwc = document.querySelector("#reg_password_confirmation");
        if (togglePasswordConfirm && pwc) {
            togglePasswordConfirm.addEventListener("click", function() {
                const type = pwc.getAttribute("type") === "password" ? "text" : "password";
                pwc.setAttribute("type", type);
                this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' :
                    '<i class="fa fa-eye-slash"></i>';
            });
        }
    </script>

    
    <style>
        button.show-password-input {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
    </style>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/auth/register.blade.php ENDPATH**/ ?>