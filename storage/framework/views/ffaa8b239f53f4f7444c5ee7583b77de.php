<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="index.html" class="logo-dark">
            <img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" class="logo-sm" alt="logo sm">
            <img src="<?php echo e(asset('storage/banner/Friday-logo.png')); ?>" class="logo-lg" alt="logo dark">
        </a>

        <a href="index.html" class="logo-light">
            <img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" class="logo-sm" alt="logo sm">
            <img src="<?php echo e(asset('storage/banner/Friday-logo.png')); ?>" class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Tổng quan</li>
            
            </li>

            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:home-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quay về trang web </span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.products.index')); ?>" role="button" aria-expanded="false"
                    aria-controls="sidebarProducts">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý Sản Phẩm </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.categories.index')); ?>" role="button" aria-expanded="false"
                    aria-controls="sidebarCategory">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý Danh Mục </span>
                </a>
            </li>

            <li class="nav-item">
            <div class="collapse" id="sidebarInventory">
                <ul class="nav sub-navbar-nav">

                    <li class="sub-nav-item">
                        <a class="sub-nav-link" href="inventory-warehouse.html">Warehouse</a>
                    </li>
                    <li class="sub-nav-item">
                        <a class="sub-nav-link" href="inventory-received-orders.html">Received Orders</a>
                    </li>
                </ul>
            </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.orders.index')); ?>" role="button" aria-expanded="false"
                    aria-controls="sidebarOrders">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý Đơn Hàng </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.returns.index')); ?>" role="button" aria-expanded="false"
                    aria-controls="sidebarOrders">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:refresh-square-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý hoàn hàng </span>
                </a>
            </li>

            <li class="nav-item">
    <a class="nav-link d-flex align-items-center" href="<?php echo e(route('admin.order-cancellations.index')); ?>" role="button">
        <span class="nav-icon">
            <iconify-icon icon="solar:cart-cross-bold-duotone"></iconify-icon>
        </span>
        <span class="nav-text"> Quản lý hủy hàng </span>
        
        
        <?php
            $pendingCancelCount = \App\Models\OrderCancelRequest::where('status', 'pending')->count();
        ?>
        
        <?php if($pendingCancelCount > 0): ?>
            <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 10px;">
                <?php echo e($pendingCancelCount); ?>

            </span>
        <?php endif; ?>
    </a>
</li>

             <li class="nav-item">
    <a class="nav-link menu-arrow" href="#sidebarVouchers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarVouchers">
        <span class="nav-icon">
            <iconify-icon icon="solar:ticket-bold-duotone"></iconify-icon>
        </span>
        <span class="nav-text"> Quản Lý Voucher </span>
    </a>
    <div class="collapse <?php echo e(request()->routeIs('admin.vouchers.*') ? 'show' : ''); ?>" id="sidebarVouchers">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.vouchers.index') ? 'active' : ''); ?>" href="<?php echo e(route('admin.vouchers.index')); ?>">
                    <span class="nav-text">Danh sách Voucher</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('admin.vouchers.history') ? 'active' : ''); ?>" href="<?php echo e(route('admin.vouchers.history')); ?>">
                    <span class="nav-text">Lịch sử đổi quà</span>
                </a>
            </li>
        </ul>
    </div>
</li>

            <li class="nav-item">
                <a class="nav-link" href="#sidebarPurchases" role="button" aria-expanded="false"
                    aria-controls="sidebarPurchases">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:card-send-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Purchases </span>
                </a>
                <div class="collapse" id="sidebarPurchases">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="purchase-list.html">List</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="purchase-order.html">Order</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="purchase-returns.html">Return</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#sidebarAttributes" role="button" aria-expanded="false"
                    aria-controls="sidebarAttributes">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:confetti-minimalistic-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý Thuộc Tính </span>
                </a>
                <div class="collapse" id="sidebarAttributes">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?php echo e(route('admin.attributes.colors.index')); ?>">Màu Sắc</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?php echo e(route('admin.attributes.sizes.index')); ?>">Kích Thước</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.users.index')); ?>" role="button" aria-expanded="false"
                    aria-controls="sidebarCustomers">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Quản Lý Người Dùng </span>
                </a>
                <div class="collapse" id="sidebarCustomers">
                    <ul class="nav sub-navbar-nav">

                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="customer-list.html">List</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="customer-detail.html">Details</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.chat')); ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Chat </span>
                </a>
            </li>
        </ul>
    </div>
</div><?php /**PATH C:\laragon\www\DATN09\resources\views/admin/layouts/menu-nav.blade.php ENDPATH**/ ?>