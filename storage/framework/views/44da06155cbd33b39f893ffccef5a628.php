<?php $__env->startSection('content'); ?>
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12 col-lg-12 ">

                
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($err); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data"class="dropzone"
                    id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                    data-upload-preview-template="#uploadPreviewTemplate">
                    <?php echo csrf_field(); ?>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm ảnh sản phẩm</h4>
                        </div>
                        <div class="card-body">
                            <!-- File Upload -->
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Thả ảnh của bạn vào đây, hoặc <span class="text-primary">nhấp để chọn
                                        tệp.</span></h3>
                                <span class="text-muted fs-13">
                                    Kích thước khuyến nghị 1200 x 1600 (3:4). Cho phép các định dạng PNG, JPG và GIF.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                        </div>

                        

                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="<?php echo e(old('name')); ?>" placeholder="Tên sản phẩm">
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product-categories" class="form-label">Danh Mục Sản Phẩm</label>
                                        <select class="form-control" id="product-categories" name="category_id" data-choices
                                            data-choices-groups data-placeholder="Chọn danh mục">
                                            <option value="">Chọn một danh mục</option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                    <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <div class="mt-3">
                                        <h5 class="text-dark fw-medium">Size :</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group" aria-label="Chọn size">
                                            <?php
                                                $sizesDemo = ['XS', 'S', 'M', 'XL', 'XXL', '3XL'];
                                            ?>
                                            <?php $__currentLoopData = $sizesDemo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    // name="sizes[]" để gửi mảng size[]
                                                    $id = 'size-' . strtolower($s);
                                                ?>
                                                <input type="checkbox" class="btn-check" id="<?php echo e($id); ?>"
                                                    name="sizes[]" value="<?php echo e($s); ?>"
                                                    <?php echo e(is_array(old('sizes')) && in_array($s, old('sizes')) ? 'checked' : ''); ?>>
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    for="<?php echo e($id); ?>"><?php echo e($s); ?></label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size:12px">
                                            (Tạm thời lưu size dạng mảng sizes[]. Sau này map vào bảng product_variants.)
                                        </small>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="mt-3">
                                        <h5 class="text-dark fw-medium">Màu sắc :</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group" aria-label="Chọn màu">
                                            <?php
                                                $colorsDemo = [
                                                    ['id' => 'dark', 'labelClass' => 'text-dark', 'name' => 'Đen'],
                                                    [
                                                        'id' => 'yellow',
                                                        'labelClass' => 'text-warning',
                                                        'name' => 'Vàng',
                                                    ],
                                                    ['id' => 'white', 'labelClass' => 'text-white', 'name' => 'Trắng'],
                                                    [
                                                        'id' => 'blue',
                                                        'labelClass' => 'text-primary',
                                                        'name' => 'Xanh dương',
                                                    ],
                                                    [
                                                        'id' => 'green',
                                                        'labelClass' => 'text-success',
                                                        'name' => 'Xanh lá',
                                                    ],
                                                    ['id' => 'red', 'labelClass' => 'text-danger', 'name' => 'Đỏ'],
                                                    ['id' => 'sky', 'labelClass' => 'text-info', 'name' => 'Xanh nhạt'],
                                                    ['id' => 'gray', 'labelClass' => 'text-secondary', 'name' => 'Xám'],
                                                ];
                                            ?>

                                            <?php $__currentLoopData = $colorsDemo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $colorInputId = 'color-' . $c['id'];
                                                ?>
                                                <input type="checkbox" class="btn-check" id="<?php echo e($colorInputId); ?>"
                                                    name="colors[]" value="<?php echo e($c['name']); ?>"
                                                    <?php echo e(is_array(old('colors')) && in_array($c['name'], old('colors')) ? 'checked' : ''); ?>>
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    for="<?php echo e($colorInputId); ?>">
                                                    <i class="bx bxs-circle fs-18 <?php echo e($c['labelClass']); ?>"></i>
                                                </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size:12px">
                                            (Cũng lưu dạng mảng colors[]. Sau này đưa vào bảng màu/variants thật.)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" id="description" rows="7"
                                            placeholder="Mô tả về sản phẩm"><?php echo e(old('description')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_code" class="form-label">Mã Sản Phẩm</label>
                                        <input type="text" id="product_code" name="product_code" class="form-control"
                                            value="<?php echo e(old('product_code')); ?>" placeholder="#******">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-stock" class="form-label">Số Lượng</label>
                                        <input type="number" id="product-stock" name="quantity" class="form-control"
                                            value="<?php echo e(old('quantity')); ?>" placeholder="0" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-material" class="form-label">Chất Liệu</label>
                                        <input type="text" id="product-material" name="material" class="form-control"
                                            value="<?php echo e(old('material')); ?>" placeholder="Cotton 100%, denim...">
                                    </div>
                                </div>
                            </div>
                        </div> 

                        
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Chi Tiết Giá</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="product-price" class="form-label">Giá</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20">
                                                    <i class='bx bx-dollar'></i>
                                                </span>
                                                <input type="number" id="product-price" name="price"
                                                    class="form-control" value="<?php echo e(old('price')); ?>" placeholder="000"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="product-discount" class="form-label">Giảm Giá</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20">
                                                    <i class='bx bxs-discount'></i>
                                                </span>
                                                <input type="number" id="product-discount" name="sale"
                                                    class="form-control" value="<?php echo e(old('sale')); ?>" placeholder="000"
                                                    min="0">
                                            </div>
                                            <small class="text-muted" style="font-size:12px">
                                                Nếu trống hoặc = 0 thì hiểu là không giảm.
                                            </small>
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="onepage" class="form-label">Hiển Thị Trang Chủ</label>
                                            <select class="form-control" name="onpage" id="onepage" data-choices
                                                data-choices-groups data-placeholder="Select Onepage">
                                                <option value="0" selected>Không</option>
                                                <option value="1">Có</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        Thêm Mới
                                    </button>
                                </div>
                                <div class="col-lg-2">
                                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-primary w-100">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09-main\resources\views/admin/products/create.blade.php ENDPATH**/ ?>