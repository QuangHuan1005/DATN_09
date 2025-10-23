@extends('master')

@section('content')
@include('layouts.header')
<div class="site-wrapper">
  <div class="kitify-site-wrapper elementor-459kitify">
    <div id="site-content" class="site-content-wrapper">
      <div class="container">
        <div class="grid-x">
          <div class="cell small-12">
            <div class="site-content">
              <div class="page-header-content">
                <nav class="woocommerce-breadcrumb">
                  <a href="{{ route('home') }}">Home</a>
                  <span class="delimiter">/</span>
                  Tài khoản của tôi
                </nav>
                {{-- <h1 class="page-title">Tài khoản của tôi</h1> --}}
              </div>

              <article class="post-11 page type-page status-publish hentry">
                <div class="entry-content">
                  <div class="woocommerce">
                    {{-- Menu trái --}}
                    @include('account.partials.navigation')

                    <div class="woocommerce-MyAccount-content">
                      <p>
                        Xin chào
                        <strong>{{ Str::afterLast(Auth::user()->name, ' ') }}</strong>
                        (không phải bạn?
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          Đăng xuất
                        </a>)
                      </p>

                      <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                        @csrf
                      </form>

                      <p>
                        Từ bảng điều khiển, bạn có thể xem
                        <a href="{{ route('account.orders.index') }}">đơn hàng gần đây</a>,
                        quản lý <a href="{{ route('account.profile') }}">thông tin tài khoản</a>.
                      </p>
                    </div>
                  </div>
                </div><!-- .entry-content -->
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- .kitify-site-wrapper -->
</div>
@endsection
