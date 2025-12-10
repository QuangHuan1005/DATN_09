<nav class="woocommerce-MyAccount-navigation" aria-label="Account pages">
    <ul>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dashboard is-active">
            <a href="{{ route('account.dashboard') }}" aria-current="page">
                Dashboard </a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders">
            <a href="{{ route('orders.index') }}">
                Đơn hàng </a>
        </li>

        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-address">
            <a href="{{ route('account.addresses') }}">
                Địa chỉ </a>
        </li>
<<<<<<< HEAD
=======
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--payment">
            <a href="{{ route('account.bank-accounts.index') }}">
                Thanh toán </a>
        </li>
>>>>>>> origin/phong
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account">
            <a href="{{ route('account.profile') }}">
                Chi tiết tài khoản </a>
        </li>
        <li
            class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--downloads">
            <a href="{{ route('account.password') }}">Đổi mật khẩu</a>
        </li>
        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
            <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                Đăng xuất</a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
