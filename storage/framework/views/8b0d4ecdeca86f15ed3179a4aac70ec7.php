<?php $__env->startSection('content'); ?>
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">

            <div class="col-lg-4">
                
                <div class="card">
                    <div class="card-body">
                        <!-- Crossfade hình ảnh -->
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?php $__currentLoopData = $product->photoAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e(asset('storage/' . $photo->image)); ?>" alt="<?php echo e($product->name); ?>"
                                            class="img-fluid bg-light rounded">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </div>
                            <div class="carousel-indicators m-0 mt-2 d-lg-flex d-none position-static h-100">
                                <?php $__currentLoopData = $product->photoAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" data-bs-target="#productGallery"
                                        data-bs-slide-to="<?php echo e($key); ?>"
                                        class="w-auto h-auto rounded bg-light <?php echo e($key == 0 ? 'active' : ''); ?>">
                                        <img src="<?php echo e(asset('storage/' . $photo->image)); ?>" class="d-block avatar-xl"
                                            alt="thumb">
                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star-half"></i>
                                </li>
                            </ul>
                            <p class="mb-0 fw-medium fs-18 text-dark">4.5 <span class="text-muted fs-13">(55
                                    Review)</span></p>
                        </div>
                        <?php
                            $variant = $product->variants->first();
                            $price = $variant ? $variant->price : 0;
                            $sale = $variant && $variant->sale ? $variant->sale : null;
                        ?>
                        <h2 class="fw-medium my-3">
                            <?php if($sale): ?>
                                <?php echo e(number_format($sale, 0, ',', '.')); ?>₫ 
                                <span class="fs-16 text-decoration-line-through text-muted">
                                    <?php echo e(number_format($price, 0, ',', '.')); ?>₫ 
                                </span>
                                <small class="text-danger ms-2">
                                    (Giảm giá <?php echo e(round((1 - $sale / $price) * 100)); ?>%)
                                </small>
                            <?php else: ?>
                                <?php echo e(number_format($price, 0, ',', '.')); ?>₫ 
                            <?php endif; ?>

                            <div class="row align-items-center g-2 mt-3">
                                <div class="col-lg-3">
                                    <div class="">
                                        <h5 class="text-dark fw-medium">Màu sắc:</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group"
                                            aria-label="Basic checkbox toggle button group">
                                            <?php $__currentLoopData = $product->variants->unique('color_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="d-flex flex-wrap gap-2" role="group"
                                                    aria-label="Chọn màu sản phẩm">
                                                    <?php $__currentLoopData = $product->variants->unique('color_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label
                                                            class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                            title="<?php echo e($variant->color->name); ?>">
                                                            <i class="bx bxs-circle fs-18"
                                                                style="color: <?php echo e($variant->color->color_code); ?>"></i>
                                                        </label>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="">
                                        <h5 class="text-dark fw-medium">Size:</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group"
                                            aria-label="Basic checkbox toggle button group">
                                            <?php $__currentLoopData = $product->variants->unique('size_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    for="size-s2"><?php echo e($variant->size->size_code); ?></label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="quantity mt-4">
                                <h4 class="text-dark fw-medium mt-3">Số lượng tồn kho :</h4>
                                <div
                                    class="input-step border bg-body-secondary p-1 mt-1 rounded d-inline-flex overflow-visible">
                                    Còn <?php echo e($product->variants->sum('quantity')); ?> sản phẩm
                                </div>
                            </div>
                            <ul class="d-flex flex-column gap-2 list-unstyled fs-15 my-3">
                                <li>
                                    <i class='bx bx-check text-success'></i> Còn hàng
                                </li>
                                <li>
                                    <i class='bx bx-check text-success'></i> Miễn phí giao hàng.

                                </li>
                                <li>
                                    <i class='bx bx-check text-success'></i> Giảm giá 10% - Khi sử dụng mã: <span
                                        class="text-dark fw-medium">CODE123</span>
                                </li>
                            </ul>
                            <h4 class="text-dark fw-medium">Mô tả chi tiết :</h4>
                            <p class="text-muted"><?php echo e($product->description ?? 'Chưa có mô tả.'); ?>

                                
                            </p>
                            <h4 class="text-dark fw-medium mt-3">Các ưu đãi hiện có :</h4>
                            <div class="d-flex align-items-center mt-2">
                                <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> 10% instant discount
                                    on Bank Debit Cards, up to $30 on orders of $50 and above</p>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <i class="bx bxs-bookmarks text-success me-3 fs-20 mt-1"></i>
                                <p class="mb-0"><span class="fw-medium text-dark">Bank Offer</span> Grab our exclusive
                                    offer now and save 20% on your next purchase! Don't miss out, shop today!</p>
                            </div>
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
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Đánh Giá SẢn Phẩm</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/images/users/avatar-6.jpg" alt="" class="avatar-md rounded-circle">
                            <div>
                                <h5 class="mb-0">Henny K. Mark</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3 mb-1">
                            <ul class="d-flex text-warning m-0 fs-20 list-unstyled">
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star-half"></i>
                                </li>
                            </ul>
                            <p class="fw-medium mb-0 text-dark fs-15">Excellent Quality</p>
                        </div>

                        <p class="mb-0 text-dark fw-medium fs-15">Reviewed in Canada on 16 November 2023</p>
                        <p class="text-muted">Medium thickness. Did not shrink after wash. Good elasticity . XL size
                            Perfectly fit for 5.10 height and heavy body. Did not fade after wash. Only for maroon
                            colour t-shirt colour lightly gone in first wash but not faded. I bought 5 tshirt of
                            different colours. Highly recommended in so low price.</p>
                        <div class="mt-2">
                            <a href="#!" class="fs-14 me-3 text-muted"><i class='bx bx-like'></i> Helpful</a>
                            <a href="#!" class="fs-14 text-muted">Report</a>
                        </div>

                        <hr class="my-3">

                        <div class="d-flex align-items-center gap-2">
                            <img src="assets/images/users/avatar-4.jpg" alt="" class="avatar-md rounded-circle">
                            <div>
                                <h5 class="mb-0">Jorge Herry</h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3 mb-1">
                            <ul class="d-flex text-warning m-0 fs-20 list-unstyled">
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star"></i>
                                </li>
                                <li>
                                    <i class="bx bxs-star-half"></i>
                                </li>
                            </ul>
                            <p class="fw-medium mb-0 text-dark fs-15">Good Quality</p>
                        </div>

                        <p class="mb-0 text-dark fw-medium fs-15">Reviewed in U.S.A on 21 December 2023

                        </p>
                        <p class="text-muted mb-0">I liked the tshirt, it's pure cotton &amp; skin friendly, but the
                            size is smaller to compare standard size.</p>
                        <p class="text-muted mb-0">best rated</p>

                        <div class="mt-2">
                            <a href="#!" class="fs-14 me-3 text-muted"><i class='bx bx-like'></i> Helpful</a>
                            <a href="#!" class="fs-14 text-muted">Report</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/products/show.blade.php ENDPATH**/ ?>