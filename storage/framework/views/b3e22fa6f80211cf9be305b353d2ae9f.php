<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <form action="<?php echo e(route('admin.attributes.colors.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm Màu Sắc Mới</h4>
                        </div>
                        <div class="card-body">
                            
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Màu <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" 
                                            class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('name')); ?>" 
                                            placeholder="Ví dụ: Đỏ, Xanh dương">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="color_code" class="form-label">Mã Màu <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="color_code" name="color_code" 
                                                class="form-control <?php $__errorArgs = ['color_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                value="<?php echo e(old('color_code', '#000000')); ?>" 
                                                placeholder="#FF5733"
                                                maxlength="7">
                                            <input type="color" class="form-control form-control-color" 
                                                id="colorPicker" 
                                                value="<?php echo e(old('color_code', '#000000')); ?>" 
                                                title="Chọn màu">
                                        </div>
                                        <small class="text-muted">Định dạng: #RRGGBB (ví dụ: #FF5733)</small>
                                        <?php $__errorArgs = ['color_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                                        <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            name="status" id="status">
                                            <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Hoạt động</option>
                                            <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Không hoạt động</option>
                                        </select>
                                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-0">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" 
                                            id="description" rows="4"
                                            placeholder="Mô tả về màu sắc (tùy chọn)"><?php echo e(old('description')); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-3">
                                <a href="<?php echo e(route('admin.attributes.colors.index')); ?>" class="btn btn-outline-secondary w-100">
                                    <i class="bx bx-x"></i> Hủy
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-check"></i> Thêm Mới
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Đồng bộ color picker với input text
        const colorPicker = document.getElementById('colorPicker');
        const colorCode = document.getElementById('color_code');

        colorPicker.addEventListener('input', function() {
            colorCode.value = this.value.toUpperCase();
        });

        colorCode.addEventListener('input', function() {
            const value = this.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                colorPicker.value = value;
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/attributes/colors/create.blade.php ENDPATH**/ ?>