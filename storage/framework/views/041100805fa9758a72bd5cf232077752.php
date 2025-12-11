<?php
    use Illuminate\Support\Arr;

    // Toàn bộ query hiện tại
    $qs = request()->query();

    // Helper: tạo URL thêm/ghi đè tham số (giữ nguyên các tham số khác)
    $with = fn(array $extra) => route('products.index', array_merge($qs, $extra));

    // Helper: toggle 1 giá trị trong mảng tham số (colors[], sizes[])
    $toggleInArray = function (string $key, $val) use ($qs) {
        $current = (array) ($qs[$key] ?? []);
        if (in_array($val, $current)) {
            $next = array_values(array_diff($current, [$val]));
        } else {
            $next = array_values(array_unique(array_merge($current, [$val])));
        }
        $newQs = $qs;
        if (empty($next)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $next;
        }
        return route('products.index', $newQs);
    };

    // Helper: remove 1 tham số
    $removeKey = function (string $key) use ($qs) {
        $newQs = $qs;
        unset($newQs[$key]);
        return route('products.index', $newQs);
    };

    // Helper: remove 1 giá trị trong mảng tham số
    $removeFromArray = function (string $key, $val) use ($qs) {
        $newQs = $qs;
        $arr = (array) ($newQs[$key] ?? []);
        $arr = array_values(array_diff($arr, [$val]));
        if (empty($arr)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $arr;
        }
        return route('products.index', $newQs);
    };

    $selectedCategory = request('category');
    $selectedMin = request('min_price');
    $selectedMax = request('max_price');
    $selectedColors = (array) request('colors', []);
    $selectedSizes = (array) request('sizes', []);
?>

<div class="elementor-element elementor-element-36fb1d54 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
    data-id="36fb1d54" data-element_type="container">
    <div class="elementor-element elementor-element-21e8bcb4 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child elementor-sticky"
        data-id="21e8bcb4" data-element_type="container"
        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:50,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}"
        style="">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-71c3e12b elementor-widget kitify elementor-kitify-sidebar"
                data-id="71c3e12b" data-element_type="widget" data-widget_type="kitify-sidebar.default">
                <div class="elementor-widget-container">
                    <div class="kitify-sidebar kitify-sidebar-layout_01 kitify-toggle-sidebar" data-breakpoint="1024">
                        <div class="kitify-toggle-sidebar__overlay js-column-toggle"></div>
                        <div class="kitify-toggle-sidebar__container"><a
                                class="kitify-toggle-sidebar__toggle js-column-toggle" href="javascript:void(0)"></a>
                            <div class="toggle-column-btn__wrap"><a class="toggle-column-btn js-column-toggle"
                                    href="javascript:void(0)"></a></div>
                            <div class="kitify-toggle-sidebar__inner nova_box_ps ps ps--theme_default"
                                data-ps-id="e5ca9d68-7638-a48c-e4c8-434062a0d4ed">
                                <aside id="novaapf-active-filters-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-active-filters">
                                    <div class="widget-title">Bộ lọc đang áp dụng</div>
                                    <div class="novaapf-active-filters">
                                        <?php
                                            $hasAny = false;
                                        ?>
                                        <?php if($selectedCategory): ?>
                                            <?php
                                                $hasAny = true;
                                            ?>

                                            <a href="<?php echo e($removeKey('category')); ?>">
                                                <?php echo e(optional($categories->firstWhere('id', (int) $selectedCategory))->name ?? '#' . $selectedCategory); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if($selectedMin || $selectedMax): ?>
                                            <?php
                                                $hasAny = true;
                                            ?>
                                            <a href="<?php echo e($removeKey('min_price')); ?>">
                                                <?php echo e(number_format((int) $selectedMin, 0, ',', '.')); ?>₫
                                            </a>
                                            <a href="<?php echo e($removeKey('max_price')); ?>">
                                                <?php echo e(number_format((int) $selectedMax, 0, ',', '.')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php $__currentLoopData = $selectedColors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $c = $colors->firstWhere('id', (int) $cid);
                                                $hasAny = true;
                                            ?>
                                            <a href="<?php echo e($removeFromArray('colors', $cid)); ?>">
                                                <?php echo e($c->name ?? '#' . $cid); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $selectedSizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $s = $sizes->firstWhere('id', (int) $sid);
                                                $hasAny = true;
                                            ?>
                                            <a href="<?php echo e($removeFromArray('sizes', $sid)); ?>">
                                                <?php echo e($s->name ?? '#' . $sid); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!$hasAny): ?>
                                            <span class="text-muted">Chưa có bộ lọc nào.</span>
                                        <?php endif; ?>
                                        <?php if($hasAny): ?>
                                            <a href="<?php echo e(route('products.index')); ?>" class="reset"
                                                data-location="<?php echo e(route('products.index')); ?>">Xóa tất cả bộ lọc</a>
                                        <?php endif; ?>
                                    </div>
                                </aside>
                                <aside id="novaapf-category-filter-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-category-filter">
                                    <div class="widget-title">Danh Mục Sản Phẩm</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $active = (int) $selectedCategory === (int) $cat->id;
                                                    $url = $with(['category' => $cat->id]); // giữ các filter khác
                                                ?>
                                                <li class="<?php echo e($active ? 'chosen' : ''); ?>"><a
                                                        href="<?php echo e($url); ?>"><span class="name">
                                                            <?php echo e($cat->name); ?>

                                                        </span></a><span
                                                        class="count">(<?php echo e($cat->products_count); ?>)</span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-price-filter-2"
                                    class="woocommerce novaapf-price-filter-widget novaapf-ajax-term-filter widget widget_novaapf-price-filter">
                                    <div class="widget-title">Giá</div>
                                    <div class="novaapf-layered-nav">
                                        <ul>
                                            <?php $__currentLoopData = [[0, 100000], [100000, 200000], [200000, 300000], [300000, 400000], [400000, 500000], [500000, 600000]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$min, $max]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $isActive =
                                                        (int) $selectedMin === $min && (int) $selectedMax === $max;
                                                    $url = $with(['min_price' => $min, 'max_price' => $max]);
                                                ?>
                                                <li class="<?php echo e($active ? 'chosen' : ''); ?>"><a
                                                        href="<?php echo e($url); ?>">
                                                        <span
                                                            class="min"><?php echo e(number_format($min, 0, ',', '.')); ?>₫</span>
                                                        <span class="to"> - </span>
                                                        <span
                                                            class="max"><?php echo e(number_format($max, 0, ',', '.')); ?>₫</span></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-attribute-filter-2"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Màu Sắc</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            
                                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $active = in_array($color->id, $selectedColors);
                                                    // $url = $toggleInArray('colors', $color->id);
                                                    $url = route('products.index', ['color' => $color->id]);

                                                ?>
                                                <li class="<?php echo e($active ? 'chosen' : ''); ?>"><a
                                                        href="<?php echo e($url); ?>" class="et-color-swatch">
                                                        <span class="et-swatch-circle"><span
                                                                style="background-color:<?php echo e($color->color_code); ?>"></span></span><span
                                                            class="name"><?php echo e($color->name); ?></span></a><span
                                                        class="count">(<?php echo e($color->products_count); ?>)</span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </aside>
                                <aside id="novaapf-attribute-filter-3"
                                    class="woocommerce novaapf-ajax-term-filter widget widget_novaapf-attribute-filter">
                                    <div class="widget-title">Size</div>
                                    <div class="novaapf-layered-nav et-list-novaapf">
                                        <ul>
                                            <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $active = in_array($size->id, $selectedSizes);
                                                    // $url = $toggleInArray('sizes', $size->id);
                                                    $url = route('products.index', ['size' => $size->id]);

                                                ?>
                                                <li class="<?php echo e($active ? 'chosen' : ''); ?>">
                                                    <a href="<?php echo e($url); ?>"><span
                                                            class="name"><?php echo e($size->name); ?></span></a><span
                                                        class="count">(<?php echo e($size->products_count); ?>)</span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </ul>
                                    </div>
                                </aside>
                                
                                <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px;">
                                    <div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

    // Toàn bộ query hiện tại
    $qs = request()->query();

    // Helper: tạo URL thêm/ghi đè tham số (giữ nguyên các tham số khác)
    $with = fn(array $extra) => route('products.index', array_merge($qs, $extra));

    // Helper: toggle 1 giá trị trong mảng tham số (colors[], sizes[])
    $toggleInArray = function (string $key, $val) use ($qs) {
        $current = (array) ($qs[$key] ?? []);
        if (in_array($val, $current)) {
            $next = array_values(array_diff($current, [$val]));
        } else {
            $next = array_values(array_unique(array_merge($current, [$val])));
        }
        $newQs = $qs;
        if (empty($next)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $next;
        }
        return route('products.index', $newQs);
    };

    // Helper: remove 1 tham số
    $removeKey = function (string $key) use ($qs) {
        $newQs = $qs;
        unset($newQs[$key]);
        return route('products.index', $newQs);
    };

    // Helper: remove 1 giá trị trong mảng tham số
    $removeFromArray = function (string $key, $val) use ($qs) {
        $newQs = $qs;
        $arr = (array) ($newQs[$key] ?? []);
        $arr = array_values(array_diff($arr, [$val]));
        if (empty($arr)) {
            unset($newQs[$key]);
        } else {
            $newQs[$key] = $arr;
        }
        return route('products.index', $newQs);
    };

    $selectedCategory = request('category');
    $selectedMin = request('min_price');
    $selectedMax = request('max_price');
    $selectedColors = (array) request('colors', []);
    $selectedSizes = (array) request('sizes', []);
?>































<?php /**PATH C:\laragon\www\DATN09\resources\views/products/partials/filters.blade.php ENDPATH**/ ?>