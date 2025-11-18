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

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                    </div>

                    
                    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="card-body">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="<?php echo e(old('name', $product->name)); ?>" placeholder="Tên sản phẩm">
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
                                                    <?php echo e((int) old('category_id', $product->category_id) === $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <h5 class="text-dark fw-medium">Size:</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php
                                            $allSizes = \App\Models\Size::where('status', 1)->get();
                                            $productSizes = $product->variants->pluck('size_id')->toArray();
                                        ?>
                                        <?php $__currentLoopData = $allSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $id = 'size-' . $size->id; ?>
                                            <input type="checkbox" class="btn-check" id="<?php echo e($id); ?>" name="sizes[]"
                                                value="<?php echo e($size->id); ?>"
                                                <?php echo e(is_array(old('sizes', $productSizes)) && in_array($size->id, old('sizes', $productSizes)) ? 'checked' : ''); ?>>
                                            <label for="<?php echo e($id); ?>"
                                                class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                <?php echo e($size->name); ?>

                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <h5 class="text-dark fw-medium">Màu sắc:</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php
                                            $allColors = \App\Models\Color::where('status', 1)->get();
                                            $productColors = $product->variants->pluck('color_id')->toArray();
                                        ?>
                                        <?php $__currentLoopData = $allColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $colorInputId = 'color-' . $color->id; ?>
                                            <input type="checkbox" class="btn-check" id="<?php echo e($colorInputId); ?>"
                                                name="colors[]" value="<?php echo e($color->id); ?>"
                                                <?php echo e(is_array(old('colors', $productColors)) && in_array($color->id, old('colors', $productColors)) ? 'checked' : ''); ?>>
                                            <label for="<?php echo e($colorInputId); ?>"
                                                class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                <i class="bx bxs-circle fs-18" style="color: <?php echo e($color->color_code); ?>"></i>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>


                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" id="description" rows="7"
                                            placeholder="Mô tả về sản phẩm"><?php echo e(old('description', $product->description)); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_code" class="form-label">Mã Sản Phẩm</label>
                                        <input type="text" id="product_code" name="product_code" class="form-control"
                                            value="<?php echo e(old('product_code', $product->product_code)); ?>"
                                            placeholder="#******">
                                    </div>
                                </div>

                                
                                
                                
                            <div class="col-lg-4">
    <div class="mb-3">
        <label class="form-label">Số Lượng</label>
        <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="variants[<?php echo e($variant->id); ?>][id]" value="<?php echo e($variant->id); ?>">
            <input type="number" 
                   name="variants[<?php echo e($variant->id); ?>][quantity]" 
                   class="form-control mb-2"
                   value="<?php echo e(old('variants.' . $variant->id . '.quantity', $variant->quantity)); ?>" 
                   min="0"
                   placeholder="Số lượng biến thể <?php echo e($variant->id); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

                                
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-material" class="form-label">Chất Liệu</label>
                                        <input type="text" id="product-material" name="material" class="form-control"
                                            value="<?php echo e(old('material', $product->material)); ?>"
                                            placeholder="Cotton 100%, denim...">
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
                                                <option value="0"
                                                    <?php echo e((int) old('onpage', $product->onpage) === 0 ? 'selected' : ''); ?>>
                                                    Không
                                                </option>
                                                <option value="1"
                                                    <?php echo e((int) old('onpage', $product->onpage) === 1 ? 'selected' : ''); ?>>Có
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        Cập nhập
                                    </button>
                                </div>
                                <div class="col-lg-2">
                                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary w-100">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form> 
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\DATN_09\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>