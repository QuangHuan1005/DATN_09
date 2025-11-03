<?php $__env->startSection('content'); ?>
<body class="wp-singular page-template page-template-elementor_header_footer page page-id-917 wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-no-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-917 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--enabled">
    <div class="site-wrapper">
        <div class="kitify-site-wrapper elementor-1043kitify">
            <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div id="site-content" class="site-content-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-header">
                                <h1 class="page-title">Wishlist</h1>
                                <nav class="breadcrumb">
                                    <a href="<?php echo e(route('home')); ?>">Home</a>
                                    <span class="separator">/</span>
                                    <span class="current">Wishlist</span>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if($wishlistItems->count() > 0): ?>
                                <div class="wishlist-items">
                                    <div class="row">
                                        <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $product = $item->product;
                                            ?>

                                            <?php if($product): ?>
                                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                                    <div class="product-card">
                                                        <div class="product-image">
                                                            <?php
                                                                $image = $product->photoAlbums->count() > 0
                                                                    ? $product->photoAlbums->first()->image
                                                                    : 'images/no-image.jpg';
                                                            ?>
                                                            <img src="<?php echo e(asset($image)); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid">

                                                            <div class="product-actions">
                                                                <button class="btn btn-wishlist remove-from-wishlist" data-product-id="<?php echo e($product->id); ?>">
                                                                    <i class="fas fa-heart"></i>
                                                                </button>
                                                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-view">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="product-info">
                                                            <h3 class="product-name">
                                                                <a href="<?php echo e(route('products.show', $product->id)); ?>"><?php echo e($product->name); ?></a>
                                                            </h3>

                                                            <div class="product-price">
                                                                <?php if($product->variants->count() > 0): ?>
                                                                    <?php
                                                                        $minPrice = $product->variants->min('price');
                                                                        $maxPrice = $product->variants->max('price');
                                                                    ?>
                                                                    <?php if($minPrice == $maxPrice): ?>
                                                                        <span class="price"><?php echo e(number_format($minPrice, 0, ',', '.')); ?>đ</span>
                                                                    <?php else: ?>
                                                                        <span class="price"><?php echo e(number_format($minPrice, 0, ',', '.')); ?>đ - <?php echo e(number_format($maxPrice, 0, ',', '.')); ?>đ</span>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="price">Liên hệ</span>
                                                                <?php endif; ?>
                                                            </div>

                                                            <div class="product-actions-bottom">
                                                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="empty-wishlist text-center py-5">
                                    <div class="empty-icon mb-4">
                                        <i class="fas fa-heart" style="font-size: 64px; color: #ddd;"></i>
                                    </div>
                                    <h3>Wishlist của bạn đang trống</h3>
                                    <p class="text-muted mb-4">Hãy thêm những sản phẩm yêu thích vào wishlist!</p>
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <style>
    /* CSS cho trang wishlist */
    .page-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }
    
    .breadcrumb {
        font-size: 14px;
        color: #666;
    }
    
    .breadcrumb a {
        color: #007bff;
        text-decoration: none;
    }
    
    .breadcrumb .separator {
        margin: 0 10px;
    }
    
    .product-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .product-image {
        position: relative;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    .product-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .product-card:hover .product-actions {
        opacity: 1;
    }
    
    .btn-wishlist, .btn-view {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-wishlist:hover {
        background: #e74c3c;
        color: white;
    }
    
    .btn-view:hover {
        background: #007bff;
        color: white;
    }
    
    .product-info {
        padding: 20px;
    }
    
    .product-name {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .product-name a {
        color: #333;
        text-decoration: none;
    }
    
    .product-name a:hover {
        color: #007bff;
    }
    
    .product-price {
        margin-bottom: 15px;
    }
    
    .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #e74c3c;
    }
    
    .product-actions-bottom {
        margin-top: 15px;
    }
    
    .btn-primary {
        background: #007bff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: #0056b3;
        color: white;
    }
    
    .empty-wishlist {
        padding: 60px 20px;
    }
    
    .empty-icon {
        margin-bottom: 20px;
    }
    
    .empty-wishlist h3 {
        color: #333;
        margin-bottom: 10px;
    }
    
    .empty-wishlist p {
        color: #666;
        margin-bottom: 30px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .product-image img {
            height: 200px;
        }
        
        .product-actions {
            opacity: 1;
        }
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút xóa khỏi wishlist
        document.querySelectorAll('.remove-from-wishlist').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const productCard = this.closest('.product-card').parentElement;
                
                if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi wishlist?')) {
                    fetch('/wishlist/remove', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            productCard.remove();
                            
                            // Trigger event để cập nhật count trong header
                            document.dispatchEvent(new CustomEvent('wishlistUpdated'));
                            
                            // Kiểm tra nếu không còn sản phẩm nào
                            const remainingProducts = document.querySelectorAll('.product-card');
                            if (remainingProducts.length === 0) {
                                location.reload();
                            }
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xóa sản phẩm khỏi wishlist');
                    });
                }
            });
        });
    });
    </script>
</body>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/wishlist/index.blade.php ENDPATH**/ ?>