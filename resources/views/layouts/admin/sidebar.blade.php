<nav class="sidebar">
  <h2>Admin Panel</h2>

  {{-- Avatar user --}}
  <div class="sidebar-avatar" style="text-align: center; margin-bottom: 20px;">
    <img src="{{ auth()->user()->avatar ?? 'https://via.placeholder.com/80' }}" 
         alt="Avatar" 
         style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
    <p style="color: #ecf0f1; margin-top: 10px;">{{ auth()->user()->name ?? 'Admin' }}</p>
  </div>

  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt"></i> Quản lý biến thể
  </a>
  <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
    <i class="fas fa-users"></i> Quản lý danh mục
  </a>
  <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
    <i class="fas fa-box-open"></i> Quản lý sản phẩm
  </a>
  <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
  </a>

  <a href="{{ route('logout') }}"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
     style="margin-top: auto; color: #e74c3c; font-weight: bold;">
    <i class="fas fa-sign-out-alt"></i> Logout
  </a>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>
</nav>
