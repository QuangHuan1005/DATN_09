<div class="shop_header_placeholder kitify-active">
    <header class="woocommerce-archive-header">
        <div class="woocommerce-archive-header-inside">
            <p class="woocommerce-result-count">
                Hiển thị <?php echo e($products->firstItem()); ?>&ndash;<?php echo e($products->lastItem()); ?> / <?php echo e($products->total()); ?> kết
                quả</p>
            <div class="woocommerce-archive-toolbar sh--color">
                <div class="nova-product-filter" data-breakpoint="1024">
                    <button class="js-column-toggle"><span class="icon-filter"><i class="inova ic-options"></i></span><span
                            class="title-filter">Filters</span></button>
                </div>
                 <label for="sort" class="nova-custom-view">Sắp xếp:</label>
                <form class="woocommerce-ordering" method="get" action="<?php echo e(route('products.index')); ?>">
                    <?php $__currentLoopData = request()->except('sort'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($val); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <select name="sort" class="orderby" id="sort" aria-label="Shop order"
                        onchange="this.form.submit()">
                        <option value="default" selected='selected'>
                            Mặc định</option>
                        <option value="newest" <?php echo e(request('sort') == 'newest' ? 'selected' : ''); ?>>Mới nhất</option>
                        <option value="bestseller" <?php echo e(request('sort') == 'bestseller' ? 'selected' : ''); ?>>Bán chạy
                        </option>
                        <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Giá tăng dần
                        </option>
                        <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Giá giảm dần
                        </option>
                    </select>
                    </select>
                    <input type="hidden" name="paged" value="1" />
                </form>
                <div class="shop-display-type">
                    <span class="shop-display-grid active">
                        <svg class="mixtas-grid-icon">
                            <use xlink:href="#mixtas-grid"></use>
                        </svg>
                    </span>
                    <span class="shop-display-list">
                        <svg class="mixtas-list-icon">
                            <use xlink:href="#mixtas-list"></use>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </header>
</div>
<?php /**PATH C:\laragon\www\DATN09\resources\views/products/partials/toolbar.blade.php ENDPATH**/ ?>