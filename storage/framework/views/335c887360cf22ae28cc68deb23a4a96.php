<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
        

        <?php if(session('success')): ?>
            <div class="alert alert-<?php echo e(session('type') ? 'success' : 'warning'); ?> alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
        

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Tất Cả Người Dùng</h4>
                        </div>
                        
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>Tên Người Dùng</th>
                                        <th>Email</th>
                                        <th>Số Điện Thoại</th>
                                        <th>Vai Trò</th>
                                        <th>Ngày Tạo</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td><img src="<?php echo e(asset('storage/' . $user->image)); ?> "
                                                    class="avatar-sm rounded-circle me-2" alt="..."><?php echo e($user->name); ?>

                                            </td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td> <?php echo e($user->phone ?? 'Chưa có SĐT'); ?>

                                            </td>
                                            <td>
                                                <?php if($user->role_id == 1): ?>
                                                    <span class="badge bg-success-subtle text-success py-1 px-2">
                                                        <?php echo e($user->role->name); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary-subtle text-primary py-1 px-2">
                                                        <?php echo e($user->role->name); ?></span>
                                                <?php endif; ?>

                                            </td>
                                            <td> <?php echo e($user->created_at->format('d/m/Y')); ?>

                                            </td>
                                            <td>
                                                <?php if($user->trashed()): ?>
                                                    <span class="text-muted">Đã ẩn</span>
                                                <?php else: ?>
                                                    <?php echo e($user->is_locked ? 'Đã khóa' : 'Đang hoạt động'); ?>

                                                <?php endif; ?>
                                                

                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <?php if(!$user->trashed()): ?>
                                                        <a href="<?php echo e(route('admin.users.show', $user->id)); ?>"
                                                            class="btn btn-soft-info btn-sm"><iconify-icon
                                                                icon="solar:eye-broken"
                                                                class="align-middle fs-18"></iconify-icon></a>
                                                        <form action="<?php echo e(route('admin.users.toggleLock', $user->id)); ?>"
                                                            method="post">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="btn btn-soft-<?php echo e($user->is_locked ? 'success' : 'warning'); ?> btn-sm">
                                                                
                                                                <iconify-icon
                                                                    icon="<?php echo e($user->is_locked ? 'solar:user-check-broken' : 'solar:user-block-broken'); ?>"
                                                                    class="align-middle fs-18"></iconify-icon>

                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                    <?php endif; ?>

                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <td colspan="8" class="text-center">Không có người dùng nào</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            <?php echo e($users->links()); ?>


                            
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/users/index.blade.php ENDPATH**/ ?>