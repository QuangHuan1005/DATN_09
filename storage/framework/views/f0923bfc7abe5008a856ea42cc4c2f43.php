<div class="kitify-sidebar kitify-sidebar-layout_01">
    
    <h4 class="widget-title">Danh mục sản phẩm</h4>
    <ul class="list-unstyled mb-3">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('products.index', ['category' => $cat->id])); ?>"
                   class="<?php echo e(request('category') == $cat->id ? 'fw-bold text-primary' : ''); ?>">
                    <?php echo e($cat->name); ?>

                </a>
                <span class="text-muted small">(<?php echo e($cat->products_count); ?>)</span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <h4 class="widget-title">Khoảng giá</h4>
    <ul class="list-unstyled mb-3">
        <?php $__currentLoopData = [[0,50000],[50000,100000],[100000,200000],[200000,300000]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$min,$max]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a href="<?php echo e(route('products.index', ['min_price'=>$min,'max_price'=>$max])); ?>">
                    <?php echo e(number_format($min,0,',','.')); ?>đ - <?php echo e(number_format($max,0,',','.')); ?>đ
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <h4 class="widget-title">Màu sắc</h4>
    <ul class="list-unstyled mb-3">
        <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('products.index', ['color'=>$color->id])); ?>">
                    <span class="d-inline-block rounded-circle border me-2"
                          style="width:16px;height:16px;background-color:<?php echo e($color->hex_code); ?>"></span>
                    <?php echo e($color->name); ?>

                </a>
                <span class="text-muted small">(<?php echo e($color->products_count); ?>)</span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    
    <h4 class="widget-title">Kích cỡ</h4>
    <ul class="list-unstyled mb-3">
        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('products.index', ['size'=>$size->id])); ?>">
                    <?php echo e($size->name); ?>

                </a>
                <span class="text-muted small">(<?php echo e($size->products_count); ?>)</span>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary btn-sm w-100">
        Xóa tất cả bộ lọc
    </a>
</div>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/products/partials/filters.blade.php ENDPATH**/ ?>