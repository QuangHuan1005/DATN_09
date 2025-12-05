{{-- <nav class="sidebar">
    <h2>Admin Panel</h2>

    {{-- Avatar user (cột trong DB là image, không phải avatar) --}}
    <div class="sidebar-avatar" style="text-align: center; margin-bottom: 20px;">
        <img src="{{ auth()->user()->image ?? 'https://via.placeholder.com/80' }}" alt="Avatar"
            style="border-radius: 50%; width: 80px; height: 80px; object-fit: cover;">
        <p style="color: #ecf0f1; margin-top: 10px;">{{ auth()->user()->name ?? 'Admin' }}</p>
    </div>

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
    </a>

    {{-- Kho hàng (mới) --}}
    <a href="{{ route('admin.inventory.index') }}"
        class="{{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
        <i class="fas fa-warehouse"></i> Kho hàng
    </a>

    {{-- Biến thể sản phẩm (trang tổng hợp biến thể) --}}
    <a href="{{ route('admin.products.variants') }}"
        class="{{ request()->routeIs('admin.products.variants*') ? 'active' : '' }}">
        <i class="fas fa-palette"></i> Quản lý biến thể
    </a>

    {{-- Danh mục --}}
    <a href="{{ route('admin.categories.index') }}"
        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="fas fa-layer-group"></i> Quản lý danh mục
    </a>

    {{-- Sản phẩm --}}
    <a href="{{ route('admin.products.index') }}"
        class="{{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.variants*') ? 'active' : '' }}">
        <i class="fas fa-box-open"></i> Quản lý sản phẩm
    </a>

    {{-- Đơn hàng --}}
    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
    </a>

    {{-- Người dùng --}}
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Quản lý tài khoản
    </a>

    {{-- Quay về website (đặt ngay trên Đăng xuất) --}}
    @if (Route::has('home'))
        <a href="{{ route('home') }}" style="margin-top: 16px; color:#1abc9c; font-weight:600;">
            <i class="fas fa-home"></i> Về trang web
        </a>
    @else
        <a href="{{ url('/') }}" style="margin-top: 16px; color:#1abc9c; font-weight:600;">
            <i class="fas fa-home"></i> Về trang web
        </a>
    @endif

    {{-- Logout: dùng route admin.logout cho khu admin --}}
    <a href="{{ route('admin.logout') }}"
        onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
        style="margin-top: auto; color: #e74c3c; font-weight: bold;">
        <i class="fas fa-sign-out-alt"></i> Đăng xuất
    </a>

    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</nav> --}}
