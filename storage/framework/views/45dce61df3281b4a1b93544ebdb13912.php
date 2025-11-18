<div class="main-nav">
    <div class="logo-box">
        <a href="<?php echo e(route('home')); ?>" class="logo-dark">
            <img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" class="logo-sm" alt="logo sm">
            <img src="<?php echo e(asset('storage/banner/Friday-logo.png')); ?>" class="logo-lg" alt="logo dark">
        </a>
        <a href="<?php echo e(route('home')); ?>" class="logo-light">
            <img src="<?php echo e(asset('assets/images/logo-sm.png')); ?>" class="logo-sm" alt="logo sm">
            <img src="<?php echo e(asset('storage/banner/Friday-logo.png')); ?>" class="logo-lg" alt="logo light">
        </a>
    </div>

    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Tổng quan</li>

            <!-- Quay về trang web -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:home-2-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Quay về trang web</span>
                </a>
            </li>

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Quản lý sản phẩm -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#sidebarProducts" aria-expanded="false">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Quản Lý Sản Phẩm</span>
                </a>
                <div class="collapse" id="sidebarProducts">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item"><a class="sub-nav-link" href="#">Sản phẩm 1</a></li>
                        <li class="sub-nav-item"><a class="sub-nav-link" href="#">Sản phẩm 2</a></li>
                    </ul>
                </div>
            </li>

            <!-- Quản lý danh mục -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#sidebarCategory" aria-expanded="false">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Quản Lý Danh Mục</span>
                </a>
                <div class="collapse" id="sidebarCategory">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item"><a class="sub-nav-link" href="#">Danh mục 1</a></li>
                        <li class="sub-nav-item"><a class="sub-nav-link" href="#">Danh mục 2</a></li>
                    </ul>
                </div>
            </li>

            <!-- Quản lý đơn hàng -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('staff.orders.index')); ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text">Quản Lý Đơn Hàng</span>
                </a>
            </li>

        </ul>
    </div>
</div>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/staff/layouts/menu-nav.blade.php ENDPATH**/ ?>