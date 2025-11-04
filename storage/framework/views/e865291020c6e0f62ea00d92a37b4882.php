<nav class="sidebar">
  <h2>Admin Panel</h2>

  
  <div class="sidebar-avatar" style="text-align: center; margin-bottom: 20px;">
    <img src="<?php echo e(auth()->user()->image ?? 'https://via.placeholder.com/80'); ?>"
         alt="Avatar"
         style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
    <p style="color: #ecf0f1; margin-top: 10px;"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
  </div>

  
  <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
    <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
  </a>

  
  <a href="<?php echo e(route('admin.inventory.index')); ?>" class="<?php echo e(request()->routeIs('admin.inventory.*') ? 'active' : ''); ?>">
    <i class="fas fa-warehouse"></i> Kho hàng
  </a>

  
  <a href="<?php echo e(route('admin.products.variants')); ?>" class="<?php echo e(request()->routeIs('admin.products.variants*') ? 'active' : ''); ?>">
    <i class="fas fa-palette"></i> Quản lý biến thể
  </a>

  
  <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
    <i class="fas fa-layer-group"></i> Quản lý danh mục
  </a>

  
  <a href="<?php echo e(route('admin.products.index')); ?>" class="<?php echo e(request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.variants*') ? 'active' : ''); ?>">
    <i class="fas fa-box-open"></i> Quản lý sản phẩm
  </a>

  
  <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
    <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
  </a>

  
  <a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
    <i class="fas fa-users"></i> Quản lý tài khoản
  </a>

    
  <?php if(Route::has('home')): ?>
    <a href="<?php echo e(route('home')); ?>"
       style="margin-top: 16px; color:#1abc9c; font-weight:600;">
      <i class="fas fa-home"></i> Về trang web
    </a>
  <?php else: ?>
    <a href="<?php echo e(url('/')); ?>"
       style="margin-top: 16px; color:#1abc9c; font-weight:600;">
      <i class="fas fa-home"></i> Về trang web
    </a>
  <?php endif; ?>

  
  <a href="<?php echo e(route('admin.logout')); ?>"
     onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
     style="margin-top: auto; color: #e74c3c; font-weight: bold;">
    <i class="fas fa-sign-out-alt"></i> Đăng xuất
  </a>

  <form id="admin-logout-form" action="<?php echo e(route('admin.logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
  </form>
</nav>
<?php /**PATH C:\laragon\www\DATN_09\resources\views/layouts/admin/sidebar.blade.php ENDPATH**/ ?>