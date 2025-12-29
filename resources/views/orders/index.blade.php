@extends('master')
@section('content')

<body class="wp-singular page-template-fullwidth woocommerce-account woocommerce-page woocommerce-orders ltr" data-elementor-device-mode="laptop">
  <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

  <div class="site-wrapper">
    <div class="kitify-site-wrapper elementor-459kitify">
      @include('layouts.header')

      <div id="site-content" class="site-content-wrapper">
        <div class="container py-4">
          <div class="grid-x">
            <div class="cell small-12">
              <div class="site-content">
                {{-- Breadcrumb gọn gàng hơn --}}
                <div class="page-header-content mb-4">
                  <nav class="woocommerce-breadcrumb">
                    <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                    <a href="{{ route('account.dashboard') }}">My account</a><span class="delimiter">/</span>Orders
                  </nav>
                  <h1 class="page-title" style="font-size: 28px; font-weight: 700;">Đơn hàng của tôi</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">
                    {{-- Giữ nguyên hệ thống màu sắc cũ, chỉ thêm tinh chỉnh bố cục --}}
                    <style>
                      body.woocommerce-account.woocommerce-page #site-content.site-content-wrapper{ padding-top: 10px !important; }
                      .woocommerce-account .woocommerce{ display: flex; gap: 30px; margin-top: 10px; }
                      .woocommerce-MyAccount-navigation{ flex: 0 0 250px; background: #fff; border-radius: 12px; }
                      .woocommerce-MyAccount-content{ flex: 1; background: #fff; border-radius: 12px; }
                      
                      /* Table Layout tối ưu */
                      .account-orders-table{ width:100%; border-collapse: separate; border-spacing: 0; border: 1px solid #f0f2f5; border-radius: 12px; overflow: hidden; }
                      .account-orders-table thead th{ background:#f8fafc; font-weight:600; padding:16px; text-align: left; font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
                      .account-orders-table tbody td{ padding:16px; vertical-align:middle; border-top:1px solid #f1f5f9; font-size: 14px; }
                      
                      /* Giữ nguyên màu sắc badge của bạn */
                      .badge{ display:inline-flex; align-items:center; gap:.4rem; padding:.4rem .8rem; border-radius:8px; font-size:.75rem; font-weight:700 }
                      .badge::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor; opacity:.85}
                      .badge-processing{background:#eaf3ff;color:#1d4ed8}
                      .badge-shipping{background:#e9fdf4;color:#047857}
                      .badge-completed{background:#eafaf0;color:#166534}
                      .badge-cancelled{background:#fff1f1;color:#b91c1c}
                      .badge-on-hold{background:#fff6ea;color:#9a3412}
                      .badge-refunded{background:#f3efff;color:#6d28d9}
                      
                      .method-pill{ display:inline-block; padding:.2rem .6rem; border-radius:6px; font-size:.7rem; background:#f1f5f9; color:#475569; font-weight:600; border: 1px solid #e2e8f0; }
                      
                      /* Header Filter đồng bộ Admin */
                      .orders-header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap; }
                      .orders-search-box { position: relative; flex: 1; max-width: 400px; }
                      .orders-search-box input { width: 100%; padding: 10px 15px 10px 40px !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important; font-size: 14px; }
                      .orders-search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
                      .orders-select { padding: 10px 35px 10px 15px !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important; background-color: #fff !important; font-size: 14px; min-width: 200px; }
                    </style>

                    <div class="woocommerce">
                      @include('account.partials.navigation')

                      <div class="woocommerce-MyAccount-content">
                        {{-- Thông báo --}}
                        <div class="woocommerce-notices-wrapper">
                          @if(session('error')) <div class="woocommerce-error" style="background: #fef2f2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px;">{{ session('error') }}</div> @endif
                          @if(session('success')) <div class="woocommerce-message" style="background: #ecfdf5; color: #059669; padding: 15px; border-radius: 8px; margin-bottom: 20px;">{{ session('success') }}</div> @endif
                        </div>

                        {{-- Toolbar: Tìm kiếm + Lọc --}}
                        <div class="orders-header-bar">
                          <div class="orders-search-box">
                            <i class="iconify" data-icon="solar:magnifer-linear"></i>
                            <form method="GET" action="{{ route('orders.index') }}">
                                <input type="text" name="keyword" placeholder="Tìm theo mã đơn hàng..." value="{{ request('keyword') }}">
                            </form>
                          </div>
                          
                          <form method="GET" action="{{ route('orders.index') }}">
                            <select name="status_id" class="orders-select" onchange="this.form.submit()">
                              <option value="0" {{ (int)$statusId === 0 ? 'selected' : '' }}>Tất cả đơn hàng</option>
                              @foreach($statuses as $st)
                                <option value="{{ $st->id }}" {{ (int)$statusId === (int)$st->id ? 'selected' : '' }}>{{ $st->name }} ({{ $counts[$st->id] ?? 0 }})</option>
                              @endforeach
                            </select>
                          </form>
                        </div>

                        @if($orders->isEmpty())
                          <div class="text-center py-5" style="background: #f8fafc; border-radius: 12px; border: 2px dashed #e2e8f0;">
                            <iconify-icon icon="solar:box-minimalistic-linear" style="font-size: 64px; color: #94a3b8;"></iconify-icon>
                            <p class="text-muted mt-3">Không tìm thấy đơn hàng nào phù hợp.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm rounded-pill px-4">Mua sắm ngay</a>
                          </div>
                        @else
                          <table class="account-orders-table">
                            <thead>
                              <tr>
                                <th>Mã đơn</th>
                                <th>Ngày mua</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Phương thức</th>
                                <th>Tổng cộng</th>
                                <th class="text-center">Chi tiết</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($orders as $order)
                                @php
                                  $orderCls = match((int)$order->order_status_id){
                                      1 => 'badge-on-hold', 2 => 'badge-processing', 3 => 'badge-shipping',
                                      4, 5 => 'badge-completed', 6 => 'badge-cancelled', 7 => 'badge-refunded',
                                      default => 'badge-default'
                                  };
                                  $pStatusId = (int)$order->payment_status_id;
                                  $payCls = ($pStatusId === 2) ? 'badge-completed' : (($pStatusId === 3) ? 'badge-refunded' : 'badge-on-hold');
                                  $payLabel = $order->paymentStatus->name ?? ($pStatusId === 2 ? 'Đã thanh toán' : 'Chưa thanh toán');
                                @endphp
                                <tr>
                                  <td class="fw-bold"><a href="{{ route('orders.show', $order->id) }}" style="color: #2563eb;">#{{ $order->order_code }}</a></td>
                                  <td>
                                    <div class="text-dark">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                                  </td>
                                  <td><span class="badge {{ $orderCls }}">{{ $order->status->name ?? '—' }}</span></td>
                                  <td><span class="badge {{ $payCls }}">{{ $payLabel }}</span></td>
                                  <td><span class="method-pill">{{ $order->paymentMethod->name ?? '—' }}</span></td>
                                  <td class="fw-bold text-dark">{{ number_format($order->total_amount) }}₫</td>
                                  <td class="text-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn-view-order">
                                      <iconify-icon icon="solar:eye-broken" style="font-size:22px; color:#64748b"></iconify-icon>
                                    </a>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                          
                          <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include('layouts.footer')
    </div>
    @include('layouts.js')
  </div>
</body>
@endsection