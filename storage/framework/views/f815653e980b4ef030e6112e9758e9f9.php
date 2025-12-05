<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/adminLogin.css')); ?>">
    <style>
        .error-messages {
            color: #ff4d4f;
            font-size: 15px;
            display: block;
            margin-top: 5px;
            margin-left: 2px;
        }

        .input-wrapper input.is-invalid {
            border-color: #ff4d4f !important;
        }

        .form-general-error {
            background-color: #ffeaea;
            border: 1px solid #ff4d4f;
            color: #ff4d4f;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Đăng nhập Quản trị</h2>
                <p>Nhập thông tin để truy cập hệ thống quản lý</p>
            </div>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <?php if($message != 'Vui lòng nhập địa chỉ email.' && $message != 'Địa chỉ email không đúng định dạng.'): ?>
                    <div class="form-general-error">
                        <?php echo e($message); ?>

                    </div>
                <?php endif; ?>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <form class="login-form" method="POST" action="<?php echo e(route('admin.login')); ?>" novalidate>
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email"
                            class="<?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" required
                            autocomplete="email">
                        <label for="email">Địa chỉ Email</label>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php
                            $isValidationError = ($message == 'Vui lòng nhập địa chỉ email.' || $message == 'Địa chỉ email không đúng định dạng.');
                        ?>
                        <?php if($isValidationError): ?>
                            <span class="error-messages"><?php echo e($message); ?></span>
                        <?php endif; ?>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password"
                            class="<?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>" required
                            autocomplete="current-password">
                        <label for="password">Mật khẩu</label>
                        <button type="button" class="password-toggle" id="passwordToggle"
                            aria-label="Hiện/Ẩn mật khẩu">
                            <span class="eye-icon"></span>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-messages"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-options">
                    <label class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                        <span class="checkbox-label">
                            <span class="checkmark"></span>
                            Nhớ đăng nhập
                        </span>
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="forgot-password">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Đăng nhập</span>
                    <span class="btn-loader"></span>
                </button>
            </form>

            <div class="signup-link">
                <p>Không có tài khoản? (Liên hệ Admin)</p>
            </div>

        </div>
    </div>

    <script>
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        if (passwordToggle) {
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('is-visible');
            });
        }

        const inputs = document.querySelectorAll('.input-wrapper input');
        inputs.forEach(input => {
            if (input.value.length > 0) {
                input.classList.add('has-value');
            }
            input.addEventListener('input', () => {
                if (input.value.length > 0) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });

            input.addEventListener('change', () => {
                if (input.value.length > 0) {
                    input.classList.add('has-value');
                } else {
                    input.classList.remove('has-value');
                }
            });
        });
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>