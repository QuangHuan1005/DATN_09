<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center gap-1">
                        <h4 class="card-title flex-grow-1">Danh Sách Sản Phẩm</h4>
                        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="search-bar me-3">
                            <span><i class="bx bx-search-alt"></i></span>
                            <input type="search" name="keyword" id="search" class="form-control"
                                placeholder="Tìm theo tên, mã sản phẩm..." value="<?php echo e(request('keyword')); ?>">
                        </form>
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-sm btn-primary">
                            Thêm Sản Phẩm Mới
                        </a>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-hover table-centered">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check ms-1">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1"></label>
                                            </div>
                                        </th>
                                        <th>Sản Phẩm & Biến Thể</th>
                                        <th>Giá Bán</th>
                                        <th>Tồn Kho & Bán Ra</th>
                                        <th>Danh Mục</th>
                                        <th>Đánh Giá</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr <?php if($product->trashed()): ?> class="table-danger" <?php endif; ?>>
                                            <td>
                                                <div class="form-check ms-1">
                                                    
                                                    <input type="checkbox" class="form-check-input" id="customCheck_<?php echo e($product->id); ?>">
                                                    <label class="form-check-label" for="customCheck_<?php echo e($product->id); ?>">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div
                                                        class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                                        <?php if($product->photoAlbums->isNotEmpty()): ?>
                                                            <img src="<?php echo e(asset('storage/' . $product->photoAlbums->first()->image)); ?>"
                                                                alt="Ảnh Sản Phẩm" class="avatar-md">
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('images/no-image.png')); ?>" alt="Không có ảnh"
                                                                class="avatar-md">
                                                        <?php endif; ?>

                                                    </div>
                                                    <div>
                                                        <a href="<?php echo e(route('admin.products.show', $product->id)); ?>"
                                                            class="text-dark fw-medium fs-15"><?php echo e($product->name); ?></a>
                                                        <p class="text-muted mb-0 mt-1 fs-13"><span>Kích cỡ: </span>
                                                            <?php if($product->variants->isNotEmpty()): ?>
                                                                <?php echo e($product->variants->pluck('size.name')->unique()->implode(', ')); ?>

                                                            <?php else: ?>
                                                                Không áp dụng
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <?php
                                                    $minSale = $product->variants->min('sale');
                                                    $minPrice = $product->variants->min('price');
                                                ?>

                                                <?php if($minSale > 0): ?>
                                                    <?php echo e(number_format($minSale, 0, ',', '.')); ?>₫
                                                <?php elseif($minPrice > 0): ?>
                                                    <?php echo e(number_format($minPrice, 0, ',', '.')); ?>₫
                                                <?php else: ?>
                                                    0₫
                                                <?php endif; ?>
                                            </td>


                                            <td>
                                                <?php
                                                    $totalQuantity = $product->variants->sum('quantity');
                                                    // LẤY DỮ LIỆU THỰC TẾ: Sử dụng Accessor (hoặc thuộc tính ảo order_details_sum_quantity)
                                                    // Nếu dùng Accessor: $product->sold_count
                                                    // Nếu dùng withSum trong Controller: 
                                                    $soldCount = $product->order_details_sum_quantity ?? 0; 
                                                ?>
                                                
                                                <p class="mb-1 text-muted"><span class="text-dark fw-medium"><?php echo e(number_format($totalQuantity, 0, ',', '.')); ?> Sản phẩm</span>
                                                    còn lại</p> 
                                                <p class="mb-0 text-muted"><?php echo e(number_format($soldCount, 0, ',', '.')); ?> Đã bán</p> 
                                            </td>
                                            
                                            <td> <?php echo e($product->category->name ?? 'Chưa phân loại'); ?></td>
                                            
                                            <td> 
                                                <?php
                                                    // LẤY DỮ LIỆU THỰC TẾ: Sử dụng Accessor (hoặc thuộc tính ảo reviews_avg_rating)
                                                    // Nếu dùng Accessor: $product->average_rating
                                                    $avgRating = number_format($product->reviews_avg_rating ?? 0, 1);
                                                    
                                                    // Nếu dùng Accessor: $product->review_count
                                                    $reviewCount = $product->reviews_count ?? 0;
                                                ?>
                                                
                                                <span class="badge p-1 bg-light text-dark fs-12 me-1">
                                                    
                                                    <?php if($reviewCount > 0): ?>
                                                        <i class="bx bxs-star align-text-top fs-14 text-warning me-1"></i>
                                                    <?php endif; ?>
                                                    <?php echo e($avgRating); ?>

                                                </span> 
                                                <?php echo e($reviewCount); ?> Lượt đánh giá
                                            </td>
                                            <td>
                                                <?php if(!$product->trashed()): ?>
                                                    <a href="<?php echo e(route('admin.products.variants.product', $product->id)); ?>"
                                                        class="btn btn-soft-success btn-sm"
                                                        title="Quản lý biến thể">
                                                        <iconify-icon icon="solar:color-swatch-broken" class="align-middle fs-18"></iconify-icon>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.products.show', $product->id)); ?>"
                                                        class="btn btn-soft-info btn-sm" title="Xem chi tiết"><iconify-icon
                                                            icon="solar:eye-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>
                                                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                                        class="btn btn-soft-primary btn-sm" title="Chỉnh sửa"><iconify-icon
                                                            icon="solar:pen-2-broken"
                                                            class="align-middle fs-18"></iconify-icon></a>

                                                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>"
                                                        method="POST" style="display:inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-soft-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa mềm sản phẩm này?')">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <form action="<?php echo e(route('admin.products.restore', $product->id)); ?>"
                                                        method="POST" style="display:inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-soft-success btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn khôi phục sản phẩm này?')">
                                                            <iconify-icon
                                                                icon="solar:restart-circle-broken"class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                    <form action="<?php echo e(route('admin.products.forceDelete', $product->id)); ?>"
                                                        method="POST" style="display:inline-block;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-soft-secondary btn-sm"
                                                            onclick="return confirm('Xóa vĩnh viễn, không thể hoàn tác. Tiếp tục?')">
                                                            <iconify-icon
                                                                icon="solar:trash-bin-minimalistic-broken"class="align-middle fs-18"></iconify-icon>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>
                        </div>
                        </div>
                    <div class="card-footer border-top">
                        <nav aria-label="Page navigation example">
                            <?php echo e($products->links()); ?>

                        </nav>
                    </div>
                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/products/index.blade.php ENDPATH**/ ?>