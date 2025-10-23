<nav class="account-navigation">
  <ul class="account-menu list-unstyled">
    <li class="{{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
      <a href="{{ route('account.dashboard') }}"><i class="fa fa-home me-2"></i> Bảng điều khiển</a>
    </li>
    <li class="{{ request()->routeIs('account.orders.*') ? 'active' : '' }}">
      <a href="{{ route('account.orders.index') }}"><i class="fa fa-shopping-bag me-2"></i> Đơn hàng của tôi</a>
    </li>
    <li class="{{ request()->routeIs('account.history') ? 'active' : '' }}">
      <a href="{{ route('account.history') }}"><i class="fa fa-history me-2"></i> Lịch sử mua hàng</a>
    </li>
    <li class="{{ request()->routeIs('account.profile') ? 'active' : '' }}">
      <a href="{{ route('account.profile') }}"><i class="fa fa-user me-2"></i> Thông tin tài khoản</a>
    </li>
    <li>
      <a href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
         <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </li>
  </ul>
</nav>

<style>
.account-navigation{border:1px solid #eee;border-radius:10px;padding:16px;background:#fff}
.account-menu li{padding:10px 0;border-bottom:1px solid #f2f2f2}
.account-menu li:last-child{border-bottom:none}
.account-menu a{display:flex;align-items:center;color:#333;text-decoration:none}
.account-menu a:hover,.account-menu li.active a{color:#286a46;font-weight:600}
</style>
