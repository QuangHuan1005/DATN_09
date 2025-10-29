<?php $__env->startSection('title', 'Danh sách sản phẩm'); ?>

<?php $__env->startSection('content'); ?>

    <body
        class="archive post-type-archive post-type-archive-product wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-shop woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-mobile wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-342 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  shop-pagination-infinite_scroll shop-sidebar-active shop-sidebar-left blog-pagination-default kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div id="site-content" class="site-content-wrapper">
                    <div data-elementor-type="product-archive" data-elementor-id="342"
                        class="elementor elementor-342 elementor-location-archive product">
                        <div class="elementor-element elementor-element-154c7994 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="154c7994" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-48a016be kitify-breadcrumbs-page-title-yes kitify-breadcrumbs-align-center elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="48a016be" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <h3 class="kitify-breadcrumbs__title">Shop</h3>
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a href="../index.html"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Home">Home</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><span
                                                            class="kitify-breadcrumbs__item-target">Shop</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-62eaf656 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="62eaf656" data-element_type="container">
                            <div class="e-con-inner">
                                <?php echo $__env->make('products.partials.filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <div class="elementor-element elementor-element-55be2b48 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="55be2b48" data-element_type="container">
                                    <div class="elementor-element elementor-element-3d2f7267 custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-wooproducts"
                                        data-id="3d2f7267" data-element_type="widget"
                                        data-widget_type="kitify-wooproducts.default">
                                        <div class="elementor-widget-container">
                                            <div
                                                class="woocommerce  kitify_wc_widget_3d2f7267_0 kitify_wc_widget_current_query">
                                                <div class="novaapf-before-products">
                                                    <div class="woocommerce-notices-wrapper"></div>
                                                    <?php echo $__env->make('products.partials.toolbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                    <div class="kitify-products" data-widget_current_query="yes">
                                                        <div class="kitify-products__list_wrapper">
                                                            <ul
                                                                class="products ul_products kitify-products__list products-grid products-grid-1 col-row columns-3">


                                                                <ul
                                                                    class="products kitify-products__list products-grid row">
                                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            // Lấy biến thể rẻ nhất để tính giá hiển thị
                                                                            $sortedVariants = $item->variants->sortBy(
                                                                                function ($v) {
                                                                                    // Ưu tiên giá sale nếu có sale < price, nếu không dùng price
                                                                                    $effectivePrice =
                                                                                        $v->sale !== null &&
                                                                                        $v->sale < $v->price
                                                                                            ? $v->sale
                                                                                            : $v->price;
                                                                                    return $effectivePrice;
                                                                                },
                                                                            );

                                                                            $bestVariant = $sortedVariants->first(); // có thể null nếu chưa có biến thể

                                                                            // Chuẩn bị giá
                                                                            $hasSale =
                                                                                $bestVariant &&
                                                                                $bestVariant->sale !== null &&
                                                                                $bestVariant->sale <
                                                                                    $bestVariant->price;

                                                                            $originalPrice =
                                                                                $bestVariant->price ?? null;
                                                                            $salePrice = $hasSale
                                                                                ? $bestVariant->sale
                                                                                : null;
                                                                            $finalPrice = $hasSale
                                                                                ? $bestVariant->sale
                                                                                : $bestVariant->price ?? null;

                                                                            // Tính % giảm
                                                                            $discountPercent = null;
                                                                            if ($hasSale && $originalPrice > 0) {
                                                                                $discountPercent = round(
                                                                                    (($originalPrice - $salePrice) /
                                                                                        $originalPrice) *
                                                                                        100,
                                                                                );
                                                                            }

                                                                            // Ảnh chính
                                                                            $mainImage = $item->firstPhoto?->image
                                                                                ? asset(
                                                                                    'storage/' .
                                                                                        $item->firstPhoto->image,
                                                                                )
                                                                                : 'https://via.placeholder.com/700x700?text=No+Image';

                                                                            // Ảnh hover (second image). Nếu có album khác thì lấy ảnh kế tiếp
                                                                            $secondPhoto = $item->photoAlbums
                                                                                ->skip(1) // bỏ ảnh đầu tiên
                                                                                ->first();

                                                                            $hoverImage = $secondPhoto?->image
                                                                                ? asset(
                                                                                    'storage/' . $secondPhoto->image,
                                                                                )
                                                                                : $mainImage; // fallback chính nó
                                                                        ?>

                                                                        <li
                                                                            class="product_item product-grid-item product type-product instock
                kitify-product col-desk-4 col-tabp-2 col-tab-3 col-lap-4">

                                                                            <div class="product-item">
                                                                                
                                                                                <div class="product-item__badges">
                                                                                    <?php if($discountPercent): ?>
                                                                                        <span
                                                                                            class="onsale"><?php echo e($discountPercent); ?>%</span>
                                                                                    <?php endif; ?>
                                                                                </div>

                                                                                
                                                                                <div class="product-item__thumbnail">
                                                                                    <div
                                                                                        class="product-item__thumbnail_overlay">
                                                                                    </div>

                                                                                    
                                                                                    <a class="product-item-link"
                                                                                        href="<?php echo e(route('products.show', ['id' => $item->id])); ?>"></a>

                                                                                    
                                                                                    <div
                                                                                        class="product-item__description--top-actions">
                                                                                        <a href="<?php echo e(route('products.show', ['id' => $item->id])); ?>?add_to_wishlist=<?php echo e($item->id); ?>"
                                                                                            data-product-id="<?php echo e($item->id); ?>"
                                                                                            data-product-type="variable"
                                                                                            class="nova_product_wishlist_btn add_to_wishlist"
                                                                                            rel="nofollow">
                                                                                            <i
                                                                                                class="inova ic-favorite"></i>
                                                                                            <span
                                                                                                class="hidden add-text">Add
                                                                                                to wishlist</span>
                                                                                            <span
                                                                                                class="hidden added-text">Browse
                                                                                                wishlist</span>
                                                                                        </a>

                                                                                        <a href="#"
                                                                                            class="nova_product_quick_view_btn"
                                                                                            data-product-id="<?php echo e($item->id); ?>"
                                                                                            rel="nofollow">
                                                                                            <i class="inova ic-zoom"></i>
                                                                                        </a>

                                                                                        <a href="<?php echo e(route('products.show', ['id' => $item->id])); ?>"
                                                                                            data-quantity="1"
                                                                                            class="button product_type_variable add_to_cart_button"
                                                                                            data-product_id="<?php echo e($item->id); ?>"
                                                                                            aria-label="Select options for <?php echo e($item->name); ?>"
                                                                                            rel="nofollow">
                                                                                            <svg class="mixtas-addtocart">
                                                                                                <use xlink:href="#mixtas-addtocart"
                                                                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                                </use>
                                                                                            </svg>
                                                                                            <span class="text">Select
                                                                                                options</span>
                                                                                        </a>

                                                                                        <span
                                                                                            id="woocommerce_loop_add_to_cart_link_describedby_<?php echo e($item->id); ?>"
                                                                                            class="screen-reader-text">
                                                                                            This product has multiple
                                                                                            variants. The options
                                                                                            may be chosen on the product
                                                                                            page
                                                                                        </span>
                                                                                    </div>

                                                                                    
                                                                                    <div
                                                                                        class="product-item__thumbnail-placeholder second_image_enabled">
                                                                                        <a
                                                                                            href="<?php echo e(route('products.show', ['id' => $item->id])); ?>">
                                                                                            <img loading="lazy"
                                                                                                decoding="async"
                                                                                                width="700"
                                                                                                height="700"
                                                                                                src="<?php echo e($mainImage); ?>"
                                                                                                class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                                alt="<?php echo e($item->name); ?>"
                                                                                                srcset="<?php echo e($mainImage); ?> 700w, <?php echo e($mainImage); ?> 300w, <?php echo e($mainImage); ?> 150w, <?php echo e($mainImage); ?> 768w, <?php echo e($mainImage); ?> 250w, <?php echo e($mainImage); ?> 50w, <?php echo e($mainImage); ?> 100w, <?php echo e($mainImage); ?> 1000w"
                                                                                                sizes="(max-width: 700px) 100vw, 700px" />

                                                                                            <span
                                                                                                class="product_second_image"
                                                                                                style="background-image: url('<?php echo e($hoverImage); ?>')"></span>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>

                                                                                
                                                                                <div class="product-item__description">
                                                                                    <div
                                                                                        class="product-item__description--info">
                                                                                        <div class="info-left">
                                                                                            
                                                                                            <?php if($item->category): ?>
                                                                                                <div
                                                                                                    class="product-item__category">
                                                                                                    <a class="content-product-cat"
                                                                                                        href="<?php echo e(route('products.category', ['slug' => $item->category->slug])); ?>"
                                                                                                        rel="tag">
                                                                                                        <?php echo e($item->category->name); ?>

                                                                                                    </a>
                                                                                                </div>
                                                                                            <?php endif; ?>

                                                                                            
                                                                                            <a href="<?php echo e(route('products.show', ['id' => $item->id])); ?>"
                                                                                                class="title">
                                                                                                <h3
                                                                                                    class="woocommerce-loop-product__title">
                                                                                                    <?php echo e($item->name); ?>

                                                                                                </h3>
                                                                                            </a>
                                                                                        </div>

                                                                                        
                                                                                        <div class="info-right">
                                                                                            <?php if($bestVariant): ?>
                                                                                                <?php if($hasSale): ?>
                                                                                                    
                                                                                                    <span class="price">
                                                                                                        <del
                                                                                                            aria-hidden="true">
                                                                                                            <span
                                                                                                                class="woocommerce-Price-amount amount">
                                                                                                                <bdi>
                                                                                                                    <?php echo e(number_format($originalPrice, 0, ',', '.')); ?>₫
                                                                                                                </bdi>
                                                                                                            </span>
                                                                                                        </del>
                                                                                                        <ins
                                                                                                            aria-hidden="true">
                                                                                                            <span
                                                                                                                class="woocommerce-Price-amount amount">
                                                                                                                <bdi>
                                                                                                                    <?php echo e(number_format($salePrice, 0, ',', '.')); ?>₫
                                                                                                                </bdi>
                                                                                                            </span>
                                                                                                        </ins>
                                                                                                    </span>
                                                                                                <?php else: ?>
                                                                                                    
                                                                                                    <span class="price">
                                                                                                        <ins
                                                                                                            aria-hidden="true">
                                                                                                            <span
                                                                                                                class="woocommerce-Price-amount amount">
                                                                                                                <bdi>
                                                                                                                    <?php echo e(number_format($finalPrice ?? 0, 0, ',', '.')); ?>₫
                                                                                                                </bdi>
                                                                                                            </span>
                                                                                                        </ins>
                                                                                                    </span>
                                                                                                <?php endif; ?>
                                                                                            <?php else: ?>
                                                                                                
                                                                                                <span class="price">
                                                                                                    <ins
                                                                                                        aria-hidden="true">
                                                                                                        <span
                                                                                                            class="woocommerce-Price-amount amount">
                                                                                                            <bdi>
                                                                                                                
                                                                                                                0₫
                                                                                                            </bdi>
                                                                                                        </span>
                                                                                                    </ins>
                                                                                                </span>
                                                                                            <?php endif; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <nav class=" kitify-pagination clearfix "
                                                        aria-label="Product Pagination">
                                                        
                                                        <?php echo e($products->links('pagination::bootstrap-5')); ?>


                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- .site-content-wrapper -->
                <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="nova-overlay-global"></div>
            </div>

            <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/products/index.blade.php ENDPATH**/ ?>