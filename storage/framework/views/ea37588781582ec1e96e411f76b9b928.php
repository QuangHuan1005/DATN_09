<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
        <div class="row">
            <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="col-xl-12 col-lg-8 ">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Album ảnh sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <?php if($product->photoAlbums->isEmpty()): ?>
                                <p class="text-muted mb-0">Chưa có ảnh album.</p>
                            <?php else: ?>
                                <div class="row" id="album-list">
                                    <?php $__currentLoopData = $product->photoAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-3 col-6 mb-3" id="album-<?php echo e($album->id); ?>">
                                            <div class="position-relative border rounded overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $album->image)); ?>" class="img-fluid"
                                                    alt="Album image">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btn-delete-album"
                                                    data-id="<?php echo e($album->id); ?>"
                                                    data-url="<?php echo e(route('admin.products.photoAlbums.destroy', [$product->id, $album->id])); ?>">
                                                    &times;
                                                </button>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm Ảnh Sản Phẩm</h4>
                        </div>
                        <div class="card-body">
                            <!-- File Upload -->
                            <div action="" class="dropzone " data-plugin="dropzone">
                                <div class="fallback">
                                    <input type="file" name="album_images[]" multiple class="form-control">
                                </div>
                                <div class="dz-message needsclick">
                                    <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                    <h3 class="mt-4">
                                        Kéo và thả tệp vào đây để tải lên
                                        , hoặc <span class="text-primary">nhấp để tải lên</span></h3>
                                    <span class="text-muted fs-13">
                                        Khuyến nghị kích thước hình ảnh 1600 x 1200 (4:3).
                                        Định dạng tệp được hỗ trợ PNG, JPG và GIF.
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông Tin Sản Phầm</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product-name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('name', $product->name)); ?>" placeholder="Tên sản phẩm">
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-danger mt-1" style="font-size:13px">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label for="product-categories" class="form-label">Danh Mục Sản Phẩm</label>
                                    <select class="form-control <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="product-categories" name="category_id" data-choices data-choices-groups
                                        data-placeholder="Chọn danh mục">
                                        <option value="">Chọn một danh mục</option>
                                        <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"
                                                <?php echo e((int) old('category_id', $product->category_id ?? '') === $category->id ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger" style="font-size:13px">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-code" class="form-label">Mã sản phẩm</label>
                                        <input type="text" id="product-code" class="form-control" name="product_code"
                                            value="<?php echo e(old('product_code', $product->product_code)); ?>"
                                            placeholder="#******">
                                    </div>
                                    <?php $__errorArgs = ['product_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-material" class="form-label">Chất Liệu</label>
                                        <input type="text" id="product-material" class="form-control" name="material"
                                            value="<?php echo e(old('material', $product->material)); ?>"
                                            placeholder="Cotton 100%, denim...">

                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="onpage" class="form-label">Hiển Thị Trang Chủ</label>
                                    <select class="form-control" id="onpage" name="onpage" data-choices
                                        data-choices-groups>
                                        
                                        <?php $__currentLoopData = ['1' => 'Có', '0' => 'Không']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <option value="0"
                                                <?php echo e((int) old('onpage', $product->onpage) === 0 ? 'selected' : ''); ?>>
                                                Không
                                            </option>
                                            <option value="1"
                                                <?php echo e((int) old('onpage', $product->onpage) === 1 ? 'selected' : ''); ?>>Có
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" id="description" rows="7"
                                            placeholder="Mô tả sản phẩm..."name="description"><?php echo e(old('description', $product->description)); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-2">
                                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-primary w-100">Hủy</a>
                            </div>
                            <div class="col-lg-2">

                                <button type="submit"class="btn btn-outline-secondary w-100">
                                    Cập Nhập Sản Phẩm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = '<?php echo e(csrf_token()); ?>';

        document.querySelectorAll('.btn-delete-album').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const url = this.dataset.url;
                const id = this.dataset.id;

                if (!confirm('Bạn chắc chắn muốn xoá ảnh này?')) {
                    return;
                }

                fetch(url, {
                    method: 'POST', // vì mình spoof DELETE bằng _method
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        '_method': 'DELETE'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Delete response:', data);
                    if (data.status === 'success') {
                        const el = document.getElementById('album-' + id);
                        if (el) el.remove();
                    } else {
                        alert(data.message || 'Xoá ảnh thất bại.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Có lỗi xảy ra khi xoá ảnh.');
                });
            });
        });
    });
</script>
<script>
    Dropzone.autoDiscover = false;

new Dropzone(".custom-dropzone", {
    url: "#", // tạm, vì bạn đang dùng submit form Laravel
    autoProcessQueue: false,
    uploadMultiple: true,
    addRemoveLinks: true,
    parallelUploads: 10,
});

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>