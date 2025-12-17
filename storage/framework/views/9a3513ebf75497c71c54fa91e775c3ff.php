<?php $__env->startSection('content'); ?>

    <style>
        /* Item mặc định */
        .variable-item.color-variable-item {
            border: 1px solid #e2e2e2;
            border-radius: 1px;
            padding: 3px;
            transition: all 0.2s ease;
        }

        /* Hover */
        .variable-item.color-variable-item:hover {
            border-color: #c1995a;
            /* gold theo brand */
        }

        /* Khi được chọn */
        .variable-item.color-variable-item.active,
        .variable-item.color-variable-item[aria-checked="true"] {
            border-color: #c1995a;
            box-shadow: 0 0 0 2px rgba(193, 153, 90, 0.3);
        }

        /* Viền bo cho ô màu */
        .variable-item-span-color {
            border-radius: 4px;
        }
    </style>

    <body
        class="wp-singular product-template-default single single-product postid-1558 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce woocommerce-page woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-383 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active  kitify--enabled">
        <div class="site-wrapper">

            <div class="kitify-site-wrapper elementor-459kitify">
                <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div id="site-content" class="site-content-wrapper">
                    <div class="woocommerce-notices-wrapper">
                        <?php if(session('cart_success')): ?>
                            <?php
                                $cartSuccess = session('cart_success');
                                $addedName = $cartSuccess['product_name'] ?? ($product->name ?? 'Sản phẩm');
                            ?>
                            <div class="woocommerce-message" role="alert" tabindex="-1">
                                <p class="with-button">
                                    “<?php echo e($addedName); ?>” đã được thêm vào giỏ hàng.
                                    <a href="<?php echo e(route('cart.index')); ?>" class="button wc-forward">
                                        Xem giỏ hàng
                                    </a>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="woocommerce-notices-wrapper"></div>
                    <div data-elementor-type="product" data-elementor-id="383"
                        class="elementor elementor-383 elementor-location-single post-1558 product type-product status-publish has-post-thumbnail product_cat-jackets product_cat-men product_cat-tshirts product_tag-clothing product_tag-etc product_tag-fashion product_tag-m81 product_tag-men product_tag-products first instock shipping-taxable purchasable product-type-variable has-default-attributes product">
                        <div class="elementor-element elementor-element-39b316d e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="39b316d" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-58d624c5 elementor-widget kitify elementor-kitify-breadcrumbs"
                                    data-id="58d624c5" data-element_type="widget"
                                    data-widget_type="kitify-breadcrumbs.default">
                                    <div class="elementor-widget-container">

                                        <div class="kitify-breadcrumbs">
                                            <div class="kitify-breadcrumbs__content">
                                                <div class="kitify-breadcrumbs__wrap">
                                                    <div class="kitify-breadcrumbs__item"><a href="/"
                                                            class="kitify-breadcrumbs__item-link is-home" rel="home"
                                                            title="Trang Chủ">Trang Chủ</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><a
                                                            href="<?php echo e(route('products.index')); ?>"
                                                            class="kitify-breadcrumbs__item-link" rel="tag"
                                                            title="Sản Phẩm">Sản Phẩm</a></div>
                                                    <div class="kitify-breadcrumbs__item">
                                                        <div class="kitify-breadcrumbs__item-sep"><span>/</span></div>
                                                    </div>
                                                    <div class="kitify-breadcrumbs__item"><span
                                                            class="kitify-breadcrumbs__item-target"><?php echo e($product->name); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-2e5f5a67 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                            data-id="2e5f5a67" data-element_type="container">
                            <div class="e-con-inner">
                                <div class="elementor-element elementor-element-7f1d1720 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="7f1d1720" data-element_type="container">
                                    <div class="elementor-element elementor-element-951389e e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                        data-id="951389e" data-element_type="container"
                                        data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet_extra&quot;,&quot;laptop&quot;],&quot;sticky_offset&quot;:1,&quot;sticky_parent&quot;:&quot;yes&quot;,&quot;sticky_effects_offset&quot;:0}">
                                        <div class="e-con-inner">
                                            <div class="elementor-element elementor-element-1f95cbfc elementor-widget kitify elementor-kitify-wooproduct-images"
                                                data-id="1f95cbfc" data-element_type="widget"
                                                data-widget_type="kitify-wooproduct-images.default">
                                                <div class="elementor-widget-container">
                                                    <div class="kitify-product-images layout-type-1">
                                                        <div class="woocommerce-product-gallery
                                                                    woocommerce-product-gallery--with-images
                                                                    woocommerce-product-gallery--columns-6 images"
                                                            data-columns="<?php echo e(min(6, max($images ?? [], 6)) ?? null); ?>"
                                                            style="opacity: 0; transition: opacity .25s ease-in-out;">
                                                            <div class="woocommerce-product-gallery__wrapper">

                                                                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        $imgUrl = asset('storage/' . $img);
                                                                        $alt =
                                                                            $product->name . '- Image' . ($index + 1);
                                                                    ?>

                                                                    <div data-thumb="<?php echo e($imgUrl); ?>"
                                                                        data-thumb-alt="<?php echo e($alt); ?>"
                                                                        data-thumb-srcset="<?php echo e($imgUrl); ?> 250w,
                                                                            <?php echo e($imgUrl); ?> 300w,
                                                                            <?php echo e($imgUrl); ?> 150w,
                                                                            <?php echo e($imgUrl); ?> 768w,
                                                                            <?php echo e($imgUrl); ?> 700w,
                                                                            <?php echo e($imgUrl); ?> 50w,
                                                                            <?php echo e($imgUrl); ?> 100w,
                                                                            <?php echo e($imgUrl); ?> 1000w"
                                                                        data-thumb-sizes="(max-width: 250px) 100vw, 250px"
                                                                        class="woocommerce-product-gallery__image">

                                                                        <a href="<?php echo e($imgUrl); ?>">
                                                                            <img fetchpriority="high" width="1000"
                                                                                height="1000" src="<?php echo e($imgUrl); ?>"
                                                                                class="<?php echo e($index == 0 ? 'wp-post-image' : ''); ?>"
                                                                                alt="<?php echo e($alt); ?>" data-caption=""
                                                                                data-src="<?php echo e($imgUrl); ?>"
                                                                                data-large_image="<?php echo e($imgUrl); ?>"
                                                                                data-large_image_width="1000"
                                                                                data-large_image_height="1000"
                                                                                decoding="async"
                                                                                srcset="<?php echo e($imgUrl); ?> 1000w,
                                                                            <?php echo e($imgUrl); ?> 300w,
                                                                            <?php echo e($imgUrl); ?> 150w,
                                                                            <?php echo e($imgUrl); ?> 768w,
                                                                            <?php echo e($imgUrl); ?> 700w,
                                                                            <?php echo e($imgUrl); ?> 250w,
                                                                            <?php echo e($imgUrl); ?> 50w,
                                                                            <?php echo e($imgUrl); ?> 100w"
                                                                                sizes="(max-width: 1000px) 100vw, 1000px"
                                                                                <?php if($index === 0): ?> id="js-main-image"
                                                                                        data-image-base="<?php echo e(asset('storage')); ?>" <?php endif; ?> />
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="elementor-element elementor-element-7c6682b4 e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-con e-child"
                                    data-id="7c6682b4" data-element_type="container">
                                    <div class="elementor-element elementor-element-757ccde elementor-widget kitify elementor-kitify-wooproduct-title"
                                        data-id="757ccde" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-title.default">
                                        <div class="elementor-widget-container">
                                            <h1 class="kitify-post-title "><?php echo e($product->name); ?></h1>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4176e03d elementor-widget elementor-widget-spacer"
                                        data-id="4176e03d" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-22a6034f elementor-widget kitify elementor-kitify-wooproduct-rating"
                                        data-id="22a6034f" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-rating.default">
                                        <div class="elementor-widget-container">
                                            <div class="woocommerce-product-rating">
                                                <?php
                                                    $percent = ($avgRating / 5) * 100;
                                                    $total_stock = $product->variants->sum('quantity');
                                                    $total_sold = $product->orderDetails->sum('quantity');

                                                    $stock = (int) ($total_stock ?? 0) - (int) ($total_sold ?? 0);
                                                    if ($stock < 0) {
                                                        $stock = 0;
                                                    }
                                                    $sold = (int) ($total_sold ?? 0);
                                                ?>

                                                <div class="star-rating" role="img"
                                                    aria-label="Rated <?php echo e($avgRating); ?> out of 5">
                                                    <span style="width:<?php echo e($percent); ?>%">Rated <strong
                                                            class="rating"><?php echo e($avgRating); ?></strong>
                                                        out of
                                                        5 based on <span class="rating">1</span> customer rating</span>
                                                </div><a href="#reviews" class="woocommerce-review-link" rel="nofollow">
                                                    (<?php echo e($avgRating); ?>) |
                                                    <span class="count"><?php echo e($ratingCount); ?></span> đánh
                                                    giá | <span class="count">đã bán <?php echo e($sold); ?></span></a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-42e852fe elementor-widget elementor-widget-spacer"
                                        data-id="42e852fe" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-4fae2f47 elementor-widget kitify elementor-kitify-wooproduct-price"
                                        data-id="4fae2f47" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-price.default">
                                        <div class="elementor-widget-container">
                                            <p class="price position-relative">
                                                <ins aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol"
                                                                id="js-product-price" data-product-price>
                                                                <?php echo e(number_format($displayPrice, 0, ',', '.')); ?>₫
                                                            </span>
                                                        </bdi>

                                                    </span>

                                                </ins>
                                                <span class="screen-reader-text" id="js-product-price" data-product-price>
                                                    Original price was: <?php echo e(number_format($displayPrice, 0, ',', '.')); ?>₫.
                                                </span>

                                                <del aria-hidden="true">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol"
                                                                id="js-product-original-price"
                                                                data-product-original-price><?php echo e(number_format($originalPrice, 0, ',', '.')); ?>₫
                                                            </span>
                                                        </bdi>
                                                    </span>
                                                </del>

                                                <span class="screen-reader-text" id="js-product-original-price"
                                                    data-product-original-price>
                                                    Current price is: <?php echo e(number_format($originalPrice, 0, ',', '.')); ?>₫.
                                                </span>

                                                
                                                <span
                                                    class="badge bg-danger price-discount-badge <?php echo e($discountPercent ? '' : 'd-none'); ?>"
                                                    id="js-product-discount" data-product-discount>
                                                    -<?php echo e($discountPercent); ?>%
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6233891c elementor-widget elementor-widget-spacer"
                                        data-id="6233891c" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="elementor-element elementor-element-53d89609 elementor-widget kitify elementor-kitify-wooproduct-addtocart"
                                        data-id="53d89609" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-addtocart.default">
                                        <div class="elementor-widget-container">

                                            <div class="elementor-add-to-cart elementor-product-variable">


                                                <?php if(isset($variantMap) && $variantMap->count() > 0): ?>
                                                    <form class="variations_form cart" action="<?php echo e(route('cart.add')); ?>"
                                                        method="post" id="addToCartForm" enctype='multipart/form-data'
                                                        data-product_id="<?php echo e($product->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <div data-product_id="<?php echo e($product->id); ?>">
                                                            <table class="variations" cellspacing="0"
                                                                role="presentation">
                                                                <tbody>
                                                                    <tr>
                                                                        <th class="label"><label for="pa_color">Màu
                                                                                sắc</label>
                                                                        </th>
                                                                        <td class="value">
                                                                            <select style="display:none" id="pa_color"
                                                                                class=" woo-variation-raw-select"
                                                                                name="color_id"
                                                                                data-attribute_name="color_id"
                                                                                data-show_option_none="yes">
                                                                                <option value="">Choose an option
                                                                                </option>
                                                                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <option value="<?php echo e($color->id); ?>">
                                                                                        <?php echo e($color->name); ?>

                                                                                    </option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                            <ul role="radiogroup" aria-label="Color"
                                                                                class="variable-items-wrapper color-variable-items-wrapper wvs-style-squared"
                                                                                data-attribute_name="color_id">
                                                                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <li aria-checked="false"
                                                                                        tabindex="0"
                                                                                        data-attribute_name="color_id"
                                                                                        data-wvstooltip="<?php echo e($color->name); ?>"
                                                                                        class="variable-item color-variable-item js-color-item"
                                                                                        title="<?php echo e($color->name); ?>"
                                                                                        data-title="<?php echo e($color->name); ?>"
                                                                                        data-color-id="<?php echo e($color->id); ?>"
                                                                                        data-value="<?php echo e($color->id); ?>"
                                                                                        role="radio">
                                                                                        <div
                                                                                            class="variable-item-contents">
                                                                                            <span
                                                                                                class="variable-item-span variable-item-span-color"
                                                                                                style="background-color:<?php echo e($color->color_code ?? '#cccccc'); ?>;"></span>
                                                                                        </div>
                                                                                    </li>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </ul>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th class="label"><label
                                                                                for="pa_size">Size</label>
                                                                        </th>
                                                                        <td class="value">
                                                                            <select style="display:none" id="pa_size"
                                                                                class=" woo-variation-raw-select"
                                                                                name="size_id"
                                                                                data-attribute_name="size_id"
                                                                                data-show_option_none="yes">
                                                                                <option value="">Choose an option
                                                                                </option>
                                                                                <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <option value="<?php echo e($size->id); ?>">
                                                                                        <?php echo e($size->name); ?>

                                                                                    </option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                            <ul role="radiogroup" aria-label="Size"
                                                                                class="variable-items-wrapper button-variable-items-wrapper wvs-style-squared"
                                                                                data-attribute_name="size_id">
                                                                                <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <li aria-checked="false"
                                                                                        tabindex="0"
                                                                                        data-attribute_name="size_id"
                                                                                        data-wvstooltip="<?php echo e($size->name); ?>"
                                                                                        class="variable-item button-variable-item js-size-item"
                                                                                        title="<?php echo e($size->name); ?>"
                                                                                        data-title="<?php echo e($size->name); ?>"
                                                                                        data-size-id="<?php echo e($size->id); ?>"
                                                                                        data-value="<?php echo e($size->id); ?>"
                                                                                        role="radio">
                                                                                        <div
                                                                                            class="variable-item-contents">
                                                                                            <span
                                                                                                class="variable-item-span variable-item-span-button"><?php echo e($size->size_code); ?></span>
                                                                                        </div>
                                                                                    </li>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </ul><a class="reset_variations"
                                                                                href="#" id="js-reset-variations"
                                                                                aria-label="Clear options">Clear</a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="reset_variations_alert screen-reader-text"
                                                                role="alert" aria-live="polite" aria-relevant="all">
                                                                <div class="single_variation_wrap">
                                                                    <div class="woocommerce-variation single_variation">
                                                                        <div class="woocommerce-variation-description">
                                                                        </div>
                                                                        <div class="woocommerce-variation-price"></div>
                                                                        <div class="woocommerce-variation-availability">
                                                                            <p class="stock out-of-stock">Hết hàng</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="single_variation_wrap">
                                                                <div class="woocommerce-variation single_variation"></div>
                                                                <div
                                                                    class="woocommerce-variation-add-to-cart variations_button ">
                                                                    <div class="woocommerce-product-details__add-to-cart">
                                                                        <div class="quantity">
                                                                            <span
                                                                                class="nova-minicart-qty-button decrease">
                                                                                <svg class="icon">
                                                                                    <use xlink:href="#mini-cart-delete">
                                                                                    </use>
                                                                                </svg>
                                                                            </span>
                                                                            <label class="screen-reader-text"
                                                                                for="quantity_input_<?php echo e($product->id); ?>">
                                                                                Số lượng <?php echo e($product->name); ?>

                                                                            </label>
                                                                            <input type="number"
                                                                                id="quantity_input_<?php echo e($product->id); ?>"
                                                                                class="input-text qty text"
                                                                                name="quantity" value="1"
                                                                                aria-label="Product quantity"
                                                                                min="" max=""
                                                                                step="1" placeholder=""
                                                                                inputmode="numeric" autocomplete="off" />
                                                                            <span
                                                                                class="nova-minicart-qty-button increase">
                                                                                <svg class="icon">
                                                                                    <use xlink:href="#mini-cart-add"></use>
                                                                                </svg>
                                                                            </span>
                                                                        </div>

                                                                        

                                                                        <p class="mb-2">
                                                                            <span id="js-variant-stock"
                                                                                class="fw-medium text-body-secondary">
                                                                                Vui lòng chọn màu và size
                                                                            </span>
                                                                        </p>
                                                                        
                                                                        <input type="hidden" name="product_id"
                                                                            value="<?php echo e($product->id); ?>">
                                                                        <input type="hidden" name="product_variant_id"
                                                                            id="js-variant-id" value="">
                                                                        <input type="hidden" name="action_type"
                                                                            id="js-action-type" value="add_to_cart">

                                                                        
                                                                        <button type="submit"
                                                                            class="single_add_to_cart_button button alt me-2 js-submit-cart"
                                                                            data-action="add_to_cart">
                                                                            Thêm vào giỏ hàng
                                                                        </button>

                                                                        
                                                                        <button type="submit"
                                                                            class="single_add_to_cart_button button btn-primary js-submit-cart"
                                                                            data-action="buy_now">
                                                                            Mua ngay
                                                                        </button>
                                                                    </div>


                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                <?php endif; ?>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6685eeb6 elementor-widget elementor-widget-spacer"
                                        data-id="6685eeb6" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-3aedd8b5 elementor-widget kitify elementor-kitify-wishlist-button"
                                        data-id="3aedd8b5" data-element_type="widget"
                                        data-widget_type="kitify-wishlist-button.default">
                                        <div class="elementor-widget-container">

                                            <div class="yith-wcwl-add-to-wishlist add-to-wishlist-1558 yith-wcwl-add-to-wishlist--link-style yith-wcwl-add-to-wishlist--single wishlist-fragment on-first-load"
                                                data-fragment-ref="1558"
                                                data-fragment-options="{&quot;base_url&quot;:&quot;&quot;,&quot;product_id&quot;:1558,&quot;parent_product_id&quot;:0,&quot;product_type&quot;:&quot;variable&quot;,&quot;is_single&quot;:true,&quot;in_default_wishlist&quot;:false,&quot;show_view&quot;:true,&quot;browse_wishlist_text&quot;:&quot;Browse wishlist&quot;,&quot;already_in_wishslist_text&quot;:&quot;The product is already in your wishlist!&quot;,&quot;product_added_text&quot;:&quot;Product added!&quot;,&quot;available_multi_wishlist&quot;:false,&quot;disable_wishlist&quot;:false,&quot;show_count&quot;:false,&quot;ajax_loading&quot;:false,&quot;loop_position&quot;:&quot;after_add_to_cart&quot;,&quot;item&quot;:&quot;add_to_wishlist&quot;}">

                                                <!-- ADD TO WISHLIST -->

                                                
                                                <!-- COUNT TEXT -->

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="elementor-element elementor-element-55b36d48 elementor-woo-meta--view-table elementor-widget kitify elementor-kitify-wooproduct-meta"
                                        data-id="55b36d48" data-element_type="widget"
                                        data-widget_type="kitify-wooproduct-meta.default">
                                        <div class="elementor-widget-container">
                                            <div class="product_meta">


                                                <span class="sku_wrapper detail-container"><span
                                                        class="detail-label">SKU</span> <span
                                                        class="sku"><?php echo e($product->product_code); ?></span></span>

                                                <span class="posted_in detail-container">
                                                    <span class="detail-label">Danh mục</span>
                                                    <span class="detail-content">
                                                        <a href="../../product-category/jackets/index.html"
                                                            rel="categories"><?php echo e($product->category->name); ?>

                                                        </a>
                                                    </span>
                                                </span>

                                                <span class="material detail-container">
                                                    <span class="detail-label">Chất liệu</span>
                                                    <span class="detail-content">
                                                        <a href="#" rel="material"><?php echo e($product->material); ?></a>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="elementor-element elementor-element-6faf664c elementor-widget elementor-widget-spacer"
                                        data-id="6faf664c" data-element_type="widget" data-widget_type="spacer.default">
                                        <div class="elementor-widget-container">
                                            <div class="elementor-spacer">
                                                <div class="elementor-spacer-inner"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-6cf878e4 elementor-widget kitify elementor-kitify-wooproduct-datatabs"
                            data-id="6cf878e4" data-element_type="widget"
                            data-widget_type="kitify-wooproduct-datatabs.default">
                            <div class="container">
                                <div class="kitify-product-tabs layout-type-accordion">
                                    <div class="nova-woocommerce-tabs">

                                        <ul class="tabs"
                                            data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-accordion"
                                            data-allow-all-closed="true" id="single_product_tab">
                                            <li class="title"><span>Mô tả sản phẩm</span></a></li>
                                            
                                        </ul>
                                        <div class="tabs-content">
                                            <div class="tabs-panel is-active" id="panel_description">
                                                <div data-elementor-type="container" data-elementor-id="121"
                                                    class="elementor elementor-121">
                                                    <div class="elementor-element elementor-element-bae4132 e-flex e-con-boxed kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                                                        data-id="bae4132" data-element_type="container">
                                                        <div class="e-con-inner">
                                                            <div class="elementor-element elementor-element-5faa12c elementor-widget elementor-widget-text-editor"
                                                                data-id="5faa12c" data-element_type="widget"
                                                                data-widget_type="text-editor.default">
                                                                <div class="elementor-widget-container">
                                                                    <p><?php echo e($product->description); ?></p>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <ul class="tabs"
                                            data-responsive-accordion-tabs="tabs small-accordion medium-accordion large-accordion"
                                            data-allow-all-closed="true" id="single_product_tab">
                                            
                                            <li class="title"><span>Đánh giá</span></a></li>
                                        </ul>
                                        <div class="tabs-content ">
                                            <div id="reviews" class="woocommerce-Reviews">
                                                <div id="comments">
                                                    <?php if($ratingCount > 0): ?>
                                                        <ol class="commentlist">
                                                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $user = optional(optional($review->order)->user);
                                                                    $name = $user->name ?? 'Khách ẩn danh';
                                                                    $avatar = $user->image
                                                                        ? asset('storage/' . $user->image)
                                                                        : asset('assets/images/users/avatar-1.jpg'); // avatar mặc định
                                                                    $ratingPercent = max(
                                                                        0,
                                                                        min(100, ($review->rating / 5) * 100),
                                                                    );
                                                                ?>

                                                                <li class="review even thread-even depth-1"
                                                                    id="li-comment-<?php echo e($review->id); ?>">
                                                                    <div id="comment-<?php echo e($review->id); ?>"
                                                                        class="comment_container">
                                                                        <img alt="<?php echo e($name); ?>"
                                                                            src="<?php echo e($avatar); ?>"
                                                                            class="avatar avatar-60 photo" height="60"
                                                                            width="60" />

                                                                        <div class="comment-text">

                                                                            
                                                                            <div class="star-rating" role="img"
                                                                                aria-label="Rated <?php echo e($review->rating); ?> out of 5">
                                                                                <span style="width:<?php echo e($ratingPercent); ?>%">
                                                                                    Rated
                                                                                    <strong
                                                                                        class="rating"><?php echo e($review->rating); ?></strong>
                                                                                    out of 5
                                                                                </span>
                                                                            </div>

                                                                            <p class="meta">
                                                                                <strong class="woocommerce-review__author">
                                                                                    <?php echo e($name); ?>

                                                                                </strong>
                                                                                <span
                                                                                    class="woocommerce-review__dash">&ndash;</span>
                                                                                <time
                                                                                    class="woocommerce-review__published-date"
                                                                                    datetime="<?php echo e($review->created_at->toIso8601String()); ?>">
                                                                                    <?php echo e($review->created_at->format('d/m/Y H:i')); ?>

                                                                                </time>
                                                                            </p>

                                                                            <div class="description">
                                                                                <p><?php echo e($review->content); ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ol>
                                                        <div id="review_form_wrapper" class="mt-4">
                                                            <div id="review_form">
                                                                <div id="respond" class="comment-respond">
                                                                    <span id="reply-title" class="comment-reply-title"
                                                                        role="heading" aria-level="3">
                                                                        Thêm đánh giá
                                                                    </span>

                                                                    <?php if(auth()->guard()->check()): ?>
                                                                        <?php if($canReview): ?>
                                                                            
                                                                            <form
                                                                                action="<?php echo e(route('reviews.store', $product->id)); ?>"
                                                                                method="post" id="commentform"
                                                                                class="comment-form">
                                                                                <?php echo csrf_field(); ?>

                                                                                <p class="comment-notes">
                                                                                    <span class="required-field-message">
                                                                                        Các trường có dấu <span
                                                                                            class="required">*</span> là bắt
                                                                                        buộc.
                                                                                    </span>
                                                                                </p>

                                                                                
                                                                                <div class="comment-form-rating mb-3">
                                                                                    <label for="rating"
                                                                                        id="comment-form-rating-label">
                                                                                        Đánh giá của bạn&nbsp;<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <select name="rating" id="rating"
                                                                                        required class="form-select">
                                                                                        <option value="">Chọn đánh giá…
                                                                                        </option>
                                                                                        <option value="5">Rất tốt (5★)
                                                                                        </option>
                                                                                        <option value="4">Tốt (4★)
                                                                                        </option>
                                                                                        <option value="3">Bình thường (3★)
                                                                                        </option>
                                                                                        <option value="2">Tạm được (2★)
                                                                                        </option>
                                                                                        <option value="1">Tệ (1★)</option>
                                                                                    </select>
                                                                                </div>

                                                                                
                                                                                <p class="comment-form-comment mb-3">
                                                                                    <label for="comment">
                                                                                        Nội dung đánh giá&nbsp;<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <textarea id="comment" name="content" cols="45" rows="5" class="form-control" required><?php echo e(old('content')); ?></textarea>
                                                                                </p>

                                                                                
                                                                                <p class="comment-form-author mb-3">
                                                                                    <label for="author">Tên</label>
                                                                                    <input id="author" type="text"
                                                                                        class="form-control"
                                                                                        value="<?php echo e(auth()->user()->name); ?>"
                                                                                        readonly />
                                                                                </p>
                                                                                <p class="comment-form-email mb-3">
                                                                                    <label for="email">Email</label>
                                                                                    <input id="email" type="email"
                                                                                        class="form-control"
                                                                                        value="<?php echo e(auth()->user()->email); ?>"
                                                                                        readonly />
                                                                                </p>

                                                                                <p class="form-submit mb-0">
                                                                                    <button type="submit" id="submit"
                                                                                        class="btn btn-primary">
                                                                                        Gửi đánh giá
                                                                                    </button>
                                                                                </p>
                                                                            </form>
                                                                        <?php elseif($hasReviewed): ?>
                                                                            <p class="mt-2 text-muted">
                                                                                Bạn đã gửi đánh giá cho sản phẩm này trước đó.
                                                                            </p>
                                                                        <?php else: ?>
                                                                            <p class="mt-2 text-muted">
                                                                                Chỉ khách đã mua sản phẩm này mới có thể gửi
                                                                                đánh giá.
                                                                            </p>
                                                                        <?php endif; ?>
                                                                    <?php else: ?>
                                                                        <p class="mt-2">
                                                                            Vui lòng <a href="<?php echo e(route('login')); ?>">đăng
                                                                                nhập</a> để viết đánh giá.
                                                                        </p>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="mt-3">
                                                            <?php echo e($reviews->links()); ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <p class="woocommerce-noreviews mb-0">
                                                            Chưa có đánh giá nào cho sản phẩm này.
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="elementor-element elementor-element-3b561aea e-con-full e-flex kitify-col-width-auto-no ignore-docs-style-no kitify-disable-relative-no e-root-container elementor-top-section e-con e-parent"
                                data-id="3b561aea" data-element_type="container">
                                <div class="elementor-element elementor-element-56e87309 elementor-widget elementor-widget-heading"
                                    data-id="56e87309" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <h2 class="elementor-heading-title elementor-size-default">Sản Phẩm Liên
                                            Quan</h2>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-eef8dba custom-carousel-preset-default kitify-carousel-item-effect-slide elementor-widget kitify elementor-kitify-wooproducts"
                                    data-id="eef8dba" data-element_type="widget"
                                    data-widget_type="kitify-wooproducts.default">
                                    <div class="elementor-widget-container">
                                        <div class="woocommerce  kitify_wc_widget_eef8dba_0">
                                            <div class="kitify-products kitify-carousel"
                                                data-slider_options="{&quot;slidesToScroll&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;rows&quot;:{&quot;desktop&quot;:&quot;1&quot;,&quot;laptop&quot;:&quot;1&quot;,&quot;tablet&quot;:&quot;1&quot;,&quot;mobile_extra&quot;:&quot;1&quot;},&quot;autoplaySpeed&quot;:5000,&quot;autoplay&quot;:true,&quot;infinite&quot;:false,&quot;centerMode&quot;:false,&quot;pauseOnHover&quot;:false,&quot;pauseOnInteraction&quot;:false,&quot;reverseDirection&quot;:false,&quot;infiniteEffect&quot;:false,&quot;speed&quot;:500,&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;variableWidth&quot;:false,&quot;prevArrow&quot;:&quot;.kitify-carousel__prev-arrow-eef8dba_0&quot;,&quot;nextArrow&quot;:&quot;.kitify-carousel__next-arrow-eef8dba_0&quot;,&quot;dotsElm&quot;:&quot;.kitify-carousel__dots_eef8dba_0&quot;,&quot;rtl&quot;:false,&quot;effect&quot;:&quot;slide&quot;,&quot;coverflowEffect&quot;:{&quot;rotate&quot;:null,&quot;stretch&quot;:null,&quot;depth&quot;:null,&quot;modifier&quot;:null,&quot;slideShadows&quot;:null},&quot;dotType&quot;:&quot;bullets&quot;,&quot;direction&quot;:&quot;horizontal&quot;,&quot;uniqueID&quot;:&quot;kitify_carousel_eef8dba_0&quot;,&quot;asFor&quot;:&quot;&quot;,&quot;autoHeight&quot;:false,&quot;slidesToShow&quot;:{&quot;desktop&quot;:4,&quot;mobile&quot;:1,&quot;mobile_extra&quot;:2,&quot;tablet&quot;:3,&quot;tablet_extra&quot;:3,&quot;laptop&quot;:4}}"
                                                dir="ltr">
                                                <div class="kitify-carousel-inner">
                                                    <div class="kitify-products__list_wrapper swiper-container">
                                                        <ul
                                                            class="products ul_products kitify-products__list products-grid products-grid-1 swiper-wrapper columns-4">
                                                            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    // Lấy biến thể rẻ nhất để tính giá hiển thị
                                                                    $sortedVariants = $item->variants->sortBy(function (
                                                                        $v,
                                                                    ) {
                                                                        // Ưu tiên giá sale nếu có sale < price, nếu không dùng price
                                                                        $effectivePrice =
                                                                            $v->sale !== null && $v->sale < $v->price
                                                                                ? $v->sale
                                                                                : $v->price;
                                                                        return $effectivePrice;
                                                                    });

                                                                    $bestVariant = $sortedVariants->first(); // có thể null nếu chưa có biến thể

                                                                    // Chuẩn bị giá
                                                                    $hasSale =
                                                                        $bestVariant &&
                                                                        $bestVariant->sale !== null &&
                                                                        $bestVariant->sale < $bestVariant->price;

                                                                    $originalPrice = $bestVariant->price ?? null;
                                                                    $salePrice = $hasSale ? $bestVariant->sale : null;
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
                                                                        ? asset('storage/' . $item->firstPhoto->image)
                                                                        : 'https://via.placeholder.com/700x700?text=No+Image';

                                                                    // Ảnh hover (second image). Nếu có album khác thì lấy ảnh kế tiếp
                                                                    $secondPhoto = $item->photoAlbums
                                                                        ->skip(1) // bỏ ảnh đầu tiên
                                                                        ->first();

                                                                    $hoverImage = $secondPhoto?->image
                                                                        ? asset('storage/' . $secondPhoto->image)
                                                                        : $mainImage; // fallback chính nó
                                                                ?>
                                                                <li
                                                                    class="product_item product-grid-item product type-product post-960 status-publish instock product_cat-hoodies product_cat-tshirts product_cat-women product_tag-clothing product_tag-etc product_tag-fashion product_tag-m41 product_tag-products product_tag-women has-post-thumbnail sale shipping-taxable purchasable product-type-variable has-default-attributes kitify-product swiper-slide">


                                                                    <div class="product-item">
                                                                        <div class="product-item__badges">

                                                                            <?php if($discountPercent): ?>
                                                                                <span
                                                                                    class="onsale"><?php echo e($discountPercent); ?>%</span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        <div class="product-item__thumbnail">
                                                                            <div class="product-item__thumbnail_overlay">
                                                                            </div>
                                                                            <a class="product-item-link"
                                                                                href="<?php echo e(route('products.show', ['id' => $item->id])); ?>"></a>
                                                                            <div
                                                                                class="product-item__description--top-actions">

                                                                                <a href="<?php echo e(route('products.show', ['id' => $item->id])); ?>?add_to_wishlist=<?php echo e($item->id); ?>"
                                                                                    data-product-id="<?php echo e($item->id); ?>"
                                                                                    data-product-type="variable"
                                                                                    data-browse-wishlist-text="Browse wishlist"
                                                                                    class="nova_product_wishlist_btn add_to_wishlist"
                                                                                    rel="nofollow">
                                                                                    <i class="inova ic-favorite"></i>
                                                                                    <span class="hidden add-text">Add to
                                                                                        wishlist</span>
                                                                                    <span class="hidden added-text">Browse
                                                                                        wishlist</span>
                                                                                </a>

                                                                                <a href="#"
                                                                                    class="nova_product_quick_view_btn"
                                                                                    data-product-id="<?php echo e($item->id); ?>"
                                                                                    rel="nofollow"><i
                                                                                        class="inova ic-zoom"></i></a>
                                                                                <a href="<?php echo e(route('products.show', ['id' => $item->id])); ?>"
                                                                                    data-quantity="1"
                                                                                    class="button product_type_variable add_to_cart_button"
                                                                                    data-product_id="<?php echo e($item->id); ?>"
                                                                                    data-product_sku=""
                                                                                    aria-label="Select options for <?php echo e($item->name); ?>"
                                                                                    rel="nofollow"><svg
                                                                                        class="mixtas-addtocart">
                                                                                        <use xlink:href="#mixtas-addtocart"
                                                                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                                        </use>
                                                                                    </svg><span class="text">Select
                                                                                        options</span></a> <span
                                                                                    id="woocommerce_loop_add_to_cart_link_describedby_<?php echo e($item->id); ?>"
                                                                                    class="screen-reader-text">
                                                                                    This product has multiple variants. The
                                                                                    options
                                                                                    may be chosen on the product page
                                                                                </span>
                                                                            </div>


                                                                            <div
                                                                                class="product-item__thumbnail-placeholder second_image_enabled">
                                                                                <a
                                                                                    href="<?php echo e(route('products.show', ['id' => $item->id])); ?>">
                                                                                    <img loading="lazy" width="700"
                                                                                        height="700"
                                                                                        src="<?php echo e($mainImage); ?>"
                                                                                        class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                                        alt="<?php echo e($item->name); ?>"
                                                                                        decoding="async"
                                                                                        srcset="<?php echo e($mainImage); ?> 700w,
                                                                                                                                                                                                                                                     <?php echo e($mainImage); ?> 300w, <?php echo e($mainImage); ?> 150w, <?php echo e($mainImage); ?> 768w, <?php echo e($mainImage); ?> 250w, <?php echo e($mainImage); ?> 50w, <?php echo e($mainImage); ?> 100w, <?php echo e($mainImage); ?> 1000w"
                                                                                        sizes="(max-width: 700px) 100vw, 700px" /><span
                                                                                        class="product_second_image"
                                                                                        style="background-image: url('<?php echo e($hoverImage); ?>')"></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="product-item__description">

                                                                            <div class="product-item__description--info">
                                                                                <div class="info-left">
                                                                                    <?php if($item->category): ?>
                                                                                        <div
                                                                                            class="product-item__category">
                                                                                            <a class="content-product-cat"
                                                                                                href="<?php echo e(route('products.category', ['slug' => $item->category->slug])); ?>"
                                                                                                rel="tag"><?php echo e($item->category->name); ?></a>
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
                                                                                                <del aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount">
                                                                                                        <bdi>
                                                                                                            <?php echo e(number_format($originalPrice, 0, ',', '.')); ?>₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </del>
                                                                                                <ins aria-hidden="true">
                                                                                                    <span
                                                                                                        class="woocommerce-Price-amount amount m-2">
                                                                                                        <bdi>
                                                                                                            <?php echo e(number_format($salePrice, 0, ',', '.')); ?>₫
                                                                                                        </bdi>
                                                                                                    </span>
                                                                                                </ins>
                                                                                            </span>
                                                                                        <?php else: ?>
                                                                                            
                                                                                            <span class="price">
                                                                                                <ins aria-hidden="true">
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
                                                                                            <ins aria-hidden="true">
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
                                                    </div>
                                                </div>
                                                <div class="kitify-carousel__prev-arrow-eef8dba_0 kitify-arrow prev-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-left"></i>
                                                </div>
                                                <div class="kitify-carousel__next-arrow-eef8dba_0 kitify-arrow next-arrow">
                                                    <i aria-hidden="true" class="novaicon-arrow-right"></i>
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
                    <script>
                        const variantMap = <?php echo json_encode($variantMap, 15, 512) ?>;

                        // Giá mặc định ban đầu (Blade đổ xuống)
                        const defaultPrice = <?php echo e((float) $displayPrice); ?>;
                        const defaultOriginal = <?php echo e((float) $originalPrice); ?>;
                        const defaultHasDiscount = <?php echo e($discountPercent ? 'true' : 'false'); ?>;
                        const defaultDiscount = <?php echo e((int) ($discountPercent ?? 0)); ?>;

                        let selectedColorId = null;
                        let selectedSizeId = null;
                        let currentVariantStock = null; // <<=== STOCK CỦA BIẾN THỂ HIỆN TẠI

                        const priceEl = document.getElementById('js-product-price');
                        const originalEl = document.getElementById('js-product-original-price');
                        const discountEl = document.getElementById('js-product-discount');
                        const stockEl = document.getElementById('js-variant-stock');

                        const colorSelect = document.getElementById('pa_color');
                        const sizeSelect = document.getElementById('pa_size');

                        const variantIdInput = document.getElementById('js-variant-id');
                        const actionTypeInput = document.getElementById('js-action-type');
                        const addToCartForm = document.getElementById('addToCartForm');

                        const colorItems = document.querySelectorAll('.js-color-item');
                        const sizeItems = document.querySelectorAll('.js-size-item');

                        // Ô số lượng + form lỗi
                        const quantityInput = document.getElementById('quantity_input_<?php echo e($product->id); ?>');
                        const qtyErrorEl = document.getElementById('js-qty-error');

                        function formatCurrency(value) {
                            if (!value) return '0₫';
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND',
                                maximumFractionDigits: 0
                            }).format(value);
                        }

                        // ====== FORM THÔNG BÁO LỖI SỐ LƯỢNG ======
                        function showQtyError(message) {
                            if (!qtyErrorEl) return;
                            qtyErrorEl.textContent = message;
                            qtyErrorEl.style.display = 'block';
                        }

                        function clearQtyError() {
                            if (!qtyErrorEl) return;
                            qtyErrorEl.textContent = '';
                            qtyErrorEl.style.display = 'none';
                        }

                        function resetPriceAndStock() {
                            // Reset giá
                            priceEl.textContent = formatCurrency(defaultPrice);

                            if (defaultHasDiscount === true || defaultHasDiscount === 'true') {
                                originalEl.textContent = formatCurrency(defaultOriginal);
                                originalEl.classList.remove('d-none');

                                discountEl.textContent = `-${defaultDiscount}%`;
                                discountEl.classList.remove('d-none');
                            } else {
                                originalEl.classList.add('d-none');
                                discountEl.classList.add('d-none');
                            }

                            // Reset stock + variant id
                            if (stockEl) {
                                stockEl.textContent = 'Vui lòng chọn màu và size';
                                stockEl.classList.remove('text-danger');
                                stockEl.classList.add('text-body-secondary');
                            }

                            if (variantIdInput) {
                                variantIdInput.value = '';
                            }
                        }

                        // Cập nhật UI theo 1 biến thể cụ thể
                        function updateUIByVariant(variant) {
                            const originalPrice = Number(variant.price);
                            const salePrice = variant.sale && variant.sale > 0 ? Number(variant.sale) : null;

                            if (salePrice && salePrice < originalPrice) {
                                priceEl.textContent = formatCurrency(salePrice);
                                originalEl.textContent = formatCurrency(originalPrice);

                                const percent = Math.round((originalPrice - salePrice) / originalPrice * 100);

                                originalEl.classList.remove('d-none');
                                discountEl.classList.remove('d-none');
                                discountEl.textContent = `-${percent}%`;
                            } else {
                                priceEl.textContent = formatCurrency(originalPrice);
                                originalEl.classList.add('d-none');
                                discountEl.classList.add('d-none');
                            }

                            if (variantIdInput) {
                                variantIdInput.value = variant.id;
                            }
                            currentVariantStock = Number(variant.stock ?? 0); // <<=== LƯU LẠI STOCK HIỆN TẠI

                            if (stockEl) {
                                if (variant.stock > 0) {
                                    stockEl.textContent = `Còn ${variant.stock} sản phẩm`;
                                    stockEl.classList.remove('text-danger');
                                    stockEl.classList.add('text-body-secondary');
                                } else {
                                    stockEl.textContent = 'Hết hàng';
                                    stockEl.classList.remove('text-body-secondary');
                                    stockEl.classList.add('text-danger');
                                }
                            }
                            clearQtyError();
                            if (quantityInput && currentVariantStock > 0 && quantityInput.value > currentVariantStock) {
                                quantityInput.value = currentVariantStock;
                            }
                        }

                        function updatePriceByVariant() {
                            if (!selectedColorId || !selectedSizeId) {
                                resetPriceAndStock();
                                return;
                            }

                            const key = `${selectedColorId}_${selectedSizeId}`;
                            const variant = variantMap[key];

                            if (!variant) {
                                if (stockEl) {
                                    stockEl.textContent = 'Biến thể này hiện không có sẵn';
                                    stockEl.classList.add('text-danger');
                                }
                                if (variantIdInput) {
                                    variantIdInput.value = '';
                                }
                                currentVariantStock = null;
                                clearQtyError();
                                return;
                            }

                            updateUIByVariant(variant);
                        }

                        // ===== LỌC CHÉO: SIZE THEO MÀU =====
                        function updateAvailableSizes() {
                            sizeItems.forEach(item => {
                                const sizeId = item.dataset.sizeId;

                                if (!selectedColorId) {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                    return;
                                }

                                const key = `${selectedColorId}_${sizeId}`;
                                const variant = variantMap[key];

                                if (!variant || variant.stock <= 0) {
                                    item.classList.add('is-disabled');
                                    item.setAttribute('aria-disabled', 'true');

                                    if (item.classList.contains('selected')) {
                                        item.classList.remove('selected');
                                        item.setAttribute('aria-checked', 'false');
                                        selectedSizeId = null;
                                        if (sizeSelect) sizeSelect.value = '';
                                    }
                                } else {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                }
                            });
                        }

                        // ===== LỌC CHÉO: MÀU THEO SIZE =====
                        function updateAvailableColors() {
                            colorItems.forEach(item => {
                                const colorId = item.dataset.colorId;

                                if (!selectedSizeId) {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                    return;
                                }

                                const key = `${colorId}_${selectedSizeId}`;
                                const variant = variantMap[key];

                                if (!variant || variant.stock <= 0) {
                                    item.classList.add('is-disabled');
                                    item.setAttribute('aria-disabled', 'true');

                                    if (item.classList.contains('selected')) {
                                        item.classList.remove('selected');
                                        item.setAttribute('aria-checked', 'false');
                                        selectedColorId = null;
                                        if (colorSelect) colorSelect.value = '';
                                    }
                                } else {
                                    item.classList.remove('is-disabled');
                                    item.setAttribute('aria-disabled', 'false');
                                }
                            });
                        }

                        function clearSelection() {
                            selectedColorId = null;
                            selectedSizeId = null;

                            if (colorSelect) colorSelect.value = '';
                            if (sizeSelect) sizeSelect.value = '';

                            colorItems.forEach(item => {
                                item.classList.remove('selected', 'is-disabled');
                                item.setAttribute('aria-checked', 'false');
                                item.setAttribute('aria-disabled', 'false');
                            });

                            sizeItems.forEach(item => {
                                item.classList.remove('selected', 'is-disabled');
                                item.setAttribute('aria-checked', 'false');
                                item.setAttribute('aria-disabled', 'false');
                            });

                            resetPriceAndStock();
                        }

                        // ===== EVENT: CHỌN / BỎ CHỌN MÀU =====
                        colorItems.forEach(item => {
                            item.addEventListener('click', function() {
                                if (this.classList.contains('is-disabled')) return;

                                const colorId = this.dataset.colorId;

                                // Nếu đang được chọn -> click lần 2 để HUỶ CHỌN màu
                                if (this.classList.contains('selected')) {
                                    this.classList.remove('selected');
                                    this.setAttribute('aria-checked', 'false');
                                    selectedColorId = null;
                                    if (colorSelect) colorSelect.value = '';

                                    // Khi không còn màu được chọn, enable lại size theo logic hiện tại
                                    updateAvailableSizes();

                                    // Không đủ cặp color+size -> reset giá/stock
                                    updatePriceByVariant();
                                    return;
                                }

                                // Chọn màu mới
                                selectedColorId = colorId;

                                if (colorSelect) {
                                    colorSelect.value = colorId;
                                }

                                colorItems.forEach(i => {
                                    i.classList.remove('selected');
                                    i.setAttribute('aria-checked', 'false');
                                });
                                this.classList.add('selected');
                                this.setAttribute('aria-checked', 'true');

                                updateAvailableSizes();
                                updatePriceByVariant();
                            });
                        });

                        // ===== EVENT: CHỌN / BỎ CHỌN SIZE =====
                        sizeItems.forEach(item => {
                            item.addEventListener('click', function() {
                                if (this.classList.contains('is-disabled')) return;

                                const sizeId = this.dataset.sizeId;

                                // Nếu đang được chọn -> click lần 2 để HUỶ CHỌN size
                                if (this.classList.contains('selected')) {
                                    this.classList.remove('selected');
                                    this.setAttribute('aria-checked', 'false');
                                    selectedSizeId = null;
                                    if (sizeSelect) sizeSelect.value = '';

                                    updateAvailableColors();
                                    updatePriceByVariant();
                                    return;
                                }

                                // Chọn size mới
                                selectedSizeId = sizeId;

                                if (sizeSelect) {
                                    sizeSelect.value = sizeId;
                                }

                                sizeItems.forEach(i => {
                                    i.classList.remove('selected');
                                    i.setAttribute('aria-checked', 'false');
                                });
                                this.classList.add('selected');
                                this.setAttribute('aria-checked', 'true');

                                updateAvailableColors();
                                updatePriceByVariant();
                            });
                        });

                        // Nút Clear
                        const resetBtn = document.getElementById('js-reset-variations');
                        if (resetBtn) {
                            resetBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                clearSelection();
                            });
                        }

                        // Bắt action_type cho 2 nút submit (Add to cart / Mua ngay)
                        document.querySelectorAll('.js-submit-cart').forEach(btn => {
                            btn.addEventListener('click', function() {
                                if (actionTypeInput) {
                                    actionTypeInput.value = this.dataset.action;
                                }
                            });
                        });

                        function showFormAlert(message) {
                            const box = document.getElementById('js-form-alert');
                            const text = document.getElementById('js-form-alert-text');
                            if (!box || !text) return;

                            text.textContent = message;
                            box.style.display = 'block';

                            // Auto hide sau 3s
                            setTimeout(() => {
                                box.style.display = 'none';
                            }, 3000);
                        }

                        // Tắt khi ấn nút X
                        document.getElementById('js-form-alert-close')?.addEventListener('click', () => {
                            document.getElementById('js-form-alert').style.display = 'none';
                        });

                        // Validate trước khi submit form
                        if (addToCartForm) {
                            addToCartForm.addEventListener('submit', function(e) {
                                // 1. Bắt buộc chọn biến thể
                                if (!variantIdInput || !variantIdInput.value) {
                                    e.preventDefault();
                                    showMissingVariantAlert();
                                    return;
                                }

                                // 2. Check số lượng
                                if (!validateQuantity()) {
                                    e.preventDefault();
                                    showQtyAlert();
                                    return;
                                }
                            });
                        }

                        function validateQuantity() {
                            if (!quantityInput) return;

                            let qty = parseInt(quantityInput.value, 10);
                            if (isNaN(qty)) qty = 1;

                            clearQtyError();

                            // 1. Không cho nhỏ hơn 1
                            if (qty <= 0) {
                                qty = 1;
                                quantityInput.value = 1;
                                showQtyError('Số lượng không thể nhỏ hơn 1');
                                return false;
                            }

                            // 2. Không vượt quá stock của biến thể (nếu có)
                            if (currentVariantStock !== null && currentVariantStock >= 0 && qty > currentVariantStock) {
                                qty = currentVariantStock || 1;
                                quantityInput.value = qty;
                                showQtyError('Số lượng bạn chọn đã đạt mức tối đa của sản phẩm này');
                                return false;
                            }

                            // Hợp lệ
                            quantityInput.value = qty;
                            return true;
                        }

                        // Lắng nghe thay đổi số lượng (gõ tay)
                        if (quantityInput) {
                            quantityInput.addEventListener('change', validateQuantity);
                            quantityInput.addEventListener('blur', validateQuantity);
                            quantityInput.addEventListener('keyup', function() {
                                // Không spam thông báo quá nhiều, chỉ kiểm tra logic số học
                                let val = parseInt(this.value, 10);
                                if (isNaN(val) || val <= 0) return; // để cho user gõ xong rồi mới báo
                            });
                        }

                        // Bắt sự kiện nút +/- nếu có (giữ nguyên class của bạn)
                        document.querySelectorAll('.quantity').forEach(qtyBox => {
                            const input = qtyBox.querySelector('input[name="quantity"]');
                            const decBtn = qtyBox.querySelector('.nova-minicart-qty-button.decrease');
                            const incBtn = qtyBox.querySelector('.nova-minicart-qty-button.increase');

                            if (!input) return;

                            if (decBtn) {
                                decBtn.addEventListener('click', function() {
                                    let val = parseInt(input.value, 10);
                                    if (isNaN(val)) val = 1;
                                    val = val - 1;
                                    input.value = val;
                                    validateQuantity();
                                });
                            }

                            if (incBtn) {
                                incBtn.addEventListener('click', function() {
                                    let val = parseInt(input.value, 10);
                                    if (isNaN(val)) val = 1;
                                    val = val + 1;
                                    input.value = val;
                                    validateQuantity();
                                });
                            }
                        });

                        // Bắt action_type cho 2 nút submit (Add to cart / Mua ngay) – GIỮ NGUYÊN
                        document.querySelectorAll('.js-submit-cart').forEach(btn => {
                            btn.addEventListener('click', function() {
                                if (actionTypeInput) {
                                    actionTypeInput.value = this.dataset.action;
                                }
                            });
                        });
                    </script>
                    <script>
                        function showMissingVariantAlert() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Thiếu lựa chọn',
                                text: 'Vui lòng chọn màu & size trước khi thêm vào giỏ.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'custom-variant-alert'
                                },
                                buttonsStyling: true,
                                allowOutsideClick: true,
                                allowEscapeKey: true
                            });
                        }

                        function showQtyAlert() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Số lượng không hợp lệ',
                                text: 'Vui lòng kiểm tra lại số lượng, không được vượt quá tồn kho.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    popup: 'custom-variant-alert'
                                },
                                buttonsStyling: true,
                                allowOutsideClick: true,
                                allowEscapeKey: true
                            });
                        }
                    </script>
                    <?php if(session('cart_limit_error')): ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Giới hạn mua hàng',
                                    text: <?php echo json_encode(session('cart_limit_error'), 15, 512) ?>,
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        popup: 'custom-variant-alert'
                                    },
                                    buttonsStyling: true,
                                    allowOutsideClick: true,
                                    allowEscapeKey: true
                                });
                            });
                        </script>
                    <?php endif; ?>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/products/show.blade.php ENDPATH**/ ?>