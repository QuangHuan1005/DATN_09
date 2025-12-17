<?php $__env->startSection('content'); ?>
    <style>
        /* Wrapper chỉ đủ hiển thị 3 ảnh */
        .thumb-slider-wrapper {
            width: calc(75px * 3 + 16px * 2);
            /* 3 ảnh + 2 khoảng gap */
            overflow: hidden;
            margin: 0 auto;
            /* căn giữa */
        }

        .thumb-slider {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            padding-bottom: 6px;
        }

        .thumb-slider::-webkit-scrollbar {
            height: 6px;
        }

        .thumb-slider::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        .thumb-item {
            flex: 0 0 75px;
            height: 75px;
            padding: 0;
            border: none;
            background: transparent;
            overflow: hidden;
            border-radius: 8px;
            scroll-snap-align: start;
        }

        .thumb-item.active {
            border: 2px solid #c1995a;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Ẩn scrollbar trên Chrome, Edge, Safari */
        .thumb-slider::-webkit-scrollbar {
            display: none;
        }

        /* Ẩn scrollbar trên Firefox */
        .thumb-slider {
            scrollbar-width: none;
        }
    </style>

    <div class="container-xxl">
  
       
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Crossfade -->
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="<?php echo e($product->name); ?>"
                                            class="img-fluid bg-light rounded">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="carousel-item active">
                                        <img src="<?php echo e(asset('assets/images/no-image.png')); ?>" alt="No image"
                                            class="img-fluid bg-light rounded">
                                    </div>
                                <?php endif; ?>
                                <a class="carousel-control-prev rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </a>
                                <a class="carousel-control-next rounded" href="#carouselExampleFade" role="button"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </a>
                            </div>
                            <div class="thumb-slider-wrapper mt-2 d-lg-block d-none">
                                <div class="thumb-slider">
                                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button type="button" data-bs-target="#carouselExampleFade"
                                            data-bs-slide-to="<?php echo e($index); ?>"
                                            class="thumb-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                            <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="thumb-<?php echo e($index); ?>">
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <?php if($product->created_at >= now()->subDays(2)): ?>
                            <h4 class="badge bg-success text-light fs-14 py-1 px-2">Sản phẩm mới</h4>
                        <?php endif; ?>
                        <p class="mb-1">
                            <a href="#!" class="fs-24 text-dark fw-medium"><?php echo e($product->name); ?></a>
                        </p>
                        <div class="d-flex gap-2 align-items-center">
                            <ul class="d-flex text-warning m-0 fs-20  list-unstyled">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?php
                                        $starValue = $i;
                                    ?>
                                    <?php if($avgRating >= $starValue): ?>
                                        <li>
                                            <i class="bx bxs-star"></i>
                                        </li>
                                    <?php elseif($avgRating >= $starValue - 0.5): ?>
                                        <li>
                                            <i class="bx bxs-star-half"></i>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <i class="bx bx-star"></i>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                            </ul>
                            <p class="mb-0 fw-medium fs-18 text-dark"><?php echo e($avgRating); ?> <span
                                    class="text-muted fs-13">(<?php echo e($ratingCount); ?>

                                    Đánh giá)</span></p>
                        </div>
                        <h2 class="fw-medium my-3">
                            <?php if($displayPrice): ?>
                                <?php echo e(number_format($displayPrice, 0, ',', '.')); ?> đ
                            <?php else: ?>
                                Giá đang cập nhật
                            <?php endif; ?>
                            <?php if($originalPrice && $originalPrice > $displayPrice): ?>
                                <span class="fs-16 text-decoration-line-through ms-2">
                                    <?php echo e(number_format($originalPrice, 0, ',', '.')); ?> đ
                                </span>
                            <?php endif; ?>
                            <?php if($discountPercent): ?>
                                <small class="text-danger ms-2">(Giảm <?php echo e($discountPercent); ?>%)</small>
                            <?php endif; ?>
                        </h2>
                        <?php

                            $total_stock = $product->variants->sum('quantity');
                            $total_sold = $product->orderDetails->sum('quantity');

                            $stock = (int) ($total_stock ?? 0) - (int) ($total_sold ?? 0);
                            if ($stock < 0) {
                                $stock = 0;
                            }
                            $sold = (int) ($total_sold ?? 0);
                        ?>
                        <div class="quantity mt-4">
                            <h4 class="text-dark fw-medium mt-3">Tồn kho :
                                <?php echo e($stock); ?> sản phẩm</h4>
                            

                            <div
                                class="input-step border bg-body-secondary p-1 mt-1 rounded d-inline-flex overflow-visible">
                                Đã bán : <?php echo e($sold); ?> sản phẩm
                            </div>
                        </div>
                        <ul class="d-flex flex-column gap-2 list-unstyled fs-15 my-3">
                            
                        </ul>
                        <h4 class="text-dark fw-medium">Mô tả chi tiết :</h4>
                        <p class="text-muted"><?php echo e($product->description ?? 'Chưa có mô tả.'); ?>

                            
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-light-subtle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:kick-scooter-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Miễn phí vận chuyển cho các đơn hàng từ
                                            200.000₫</p>
                                        <p class="mb-0">Chỉ áp dụng trong tuần này</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:ticket-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Ưu đãi đặc biệt dành cho khách hàng</p>
                                        <p class="mb-0">Mã giảm giá lên đến 100.000₫</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:gift-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Gói quà miễn phí</p>
                                        <p class="mb-0">Kèm thiệp nhắn tùy chỉnh</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-light d-flex align-items-center justify-content-center rounded">
                                        <iconify-icon icon="solar:headphones-round-sound-bold-duotone"
                                            class="fs-35 text-primary"></iconify-icon>
                                    </div>

                                    <div>
                                        <p class="text-dark fw-medium fs-16 mb-1">Dịch vụ khách hàng chuyên nghiệp</p>
                                        <p class="mb-0">Hoạt động từ 8h - 20h, 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết mặt hàng</h4>
                    </div>
                    <div class="card-body">
                        <ul class="d-flex flex-column gap-2 list-unstyled fs-14 text-muted mb-0">
                            <li>
                                <span class="fw-medium text-dark">Mã sản phẩm</span>
                                <span class="mx-2">:</span>
                                <?php echo e($product->product_code); ?>

                            </li>
                            <li>
                                <span class="fw-medium text-dark">Danh mục</span>
                                <span class="mx-2">:</span>
                                <?php echo e($product->category->name ?? 'Đang cập nhật'); ?>

                            </li>
                            <li>
                                <span class="fw-medium text-dark">Chất liệu</span>
                                <span class="mx-2">:</span>
                                <?php echo e($product->material ?? 'Đang cập nhật'); ?>

                            </li>
                            <li>
                                <span class="fw-medium text-dark">Ngày thêm</span>
                                <span class="mx-2">:</span>
                                <?php echo e($product->created_at ? $product->created_at->format('d/m/Y') : '—'); ?>

                            </li>
                            <li>
                                <span class="fw-medium text-dark">Trọng lượng tham khảo</span>
                                <span class="mx-2">:</span>
                                500 g
                            </li>
                            
                        </ul>

                        
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh Sách Biến Thể (<?php echo e($product->variants->count()); ?>)</h5>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh</th>
                                        <th>Thuộc Tính</th>
                                        <th>Giá Gốc</th>
                                        <th>Giá Sale</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $variantMap; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>VRT-<?php echo e($variant['id']); ?><?php echo e($key); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        <?php if($variant['image']): ?>
                                                            <img src="<?php echo e(asset('storage/' . $variant['image'])); ?>"
                                                                alt="Variant <?php echo e($variant['id']); ?>" class="avatar-md">
                                                        <?php else: ?>
                                                            <span class="text-muted">No image</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <p class="text-muted mb-0 mt-1 fs-13"><span>Kích thước :
                                                        </span><?php echo e($variant['size_name']); ?></p>
                                                    <p class="text-muted mb-0 mt-1 fs-13"><span>Màu sắc :
                                                        </span><?php echo e($variant['color_name']); ?></p>
                                                </div>
                                            </td>
                                            <td><?php echo e(number_format($variant['price'])); ?>đ</td>
                                            <td><?php echo e(number_format($variant['sale'])); ?>đ</td>

                                            <td>
                                                <p class="mb-1 text-muted">
                                                    <?php if($variant['remaining'] > 0): ?>
                                                        <span class="text-dark fw-medium">Tồn kho :
                                                            <?php echo e($variant['remaining']); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Hết hàng</span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="mb-0 text-muted">Đã bán : <?php echo e($variant['sold']); ?></p>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            <?php echo e($variantsPaginate->links()); ?>

                        </div>
                        <!-- end table-responsive -->
                    </div>

                </div>
            </div>

        </div>

    </div>
    <script>
        const carousel = document.querySelector('#carouselExampleFade');
        const thumbs = document.querySelectorAll('.thumb-item');
        const slider = document.querySelector('.thumb-slider');

        function scrollToThumb(thumb) {
            slider.scrollTo({
                left: thumb.offsetLeft - slider.clientWidth / 2 + thumb.clientWidth / 2,
                behavior: 'smooth'
            });
        }

        // Click thumbnail
        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', function() {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                bsCarousel.to(index);

                thumbs.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');

                scrollToThumb(thumb);
            });
        });

        // Khi slide trong carousel thay đổi
        if (carousel) {
            carousel.addEventListener('slide.bs.carousel', function(e) {
                thumbs.forEach(t => t.classList.remove('active'));
                const target = thumbs[e.to];
                target.classList.add('active');
                scrollToThumb(target);
            });
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/products/show.blade.php ENDPATH**/ ?>