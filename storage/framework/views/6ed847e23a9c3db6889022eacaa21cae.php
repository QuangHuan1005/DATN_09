<nav class="sidebar">
  <h2>Admin Panel</h2>

  
  <div class="sidebar-avatar" style="text-align: center; margin-bottom: 20px;">
    <img src="<?php echo e(auth()->user()->avatar ?? 'https://via.placeholder.com/80'); ?>" 
         alt="Avatar" 
         style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
    <p style="color: #ecf0f1; margin-top: 10px;"><?php echo e(auth()->user()->name ?? 'Admin'); ?></p>
  </div>

    <a href="<?php echo e(route('admin.users.index')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
    <i class="fas fa-tachometer-alt"></i> Quản lý tài khoản
  </a>

  <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
    <i class="fas fa-tachometer-alt"></i> Quản lý biến thể
  </a>
  <a href="<?php echo e(route('admin.categories.index')); ?>" class="<?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
    <i class="fas fa-users"></i> Quản lý danh mục
  </a>
  <a href="<?php echo e(route('admin.products.index')); ?>" class="<?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
    <i class="fas fa-box-open"></i> Quản lý sản phẩm
  </a>
  <a href="<?php echo e(route('admin.orders.index')); ?>" class="<?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
    <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
  </a>

  <a href="<?php echo e(route('logout')); ?>"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
     style="margin-top: auto; color: #e74c3c; font-weight: bold;">
    <i class="fas fa-sign-out-alt"></i> Logout
  </a>

  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
      <?php echo csrf_field(); ?>
  </form>
</nav>
<?php /**PATH C:\xampp\htdocs\DATN_09\resources\views/layouts/admin/sidebar.blade.php ENDPATH**/ ?>