@extends('master')
@section('content')
@php

    $statusClass = match($order->order_status_id) {
        1 => 'status-pending',
        2 => 'status-confirmed',
        3 => 'status-shipping',
        4 => 'status-delivered',
        5 => 'status-done',
        6 => 'status-cancel',
        default => 'status-pending',
    };

    $payClass = match($order->payment_status_id) {
        1 => 'pay-unpaid',
        2 => 'pay-paid',
        3 => 'pay-refund',
        default => 'pay-unpaid',
    };


    // Trạng thái hiện tại của đơn
    $currentStatus = (int) $order->order_status_id;

    // Thông tin cho từng bước trên thanh trạng thái
    $stepMeta = [
        1 => ['label' => 'Chờ xác nhận',    'desc' => 'Đặt hàng thành công'],
        2 => ['label' => 'Đã xác nhận',     'desc' => 'Cửa hàng đã xác nhận'],
        3 => ['label' => 'Đang giao hàng', 'desc' => 'Đơn đang được giao'],
        4 => ['label' => 'Đã giao hàng',    'desc' => 'Hàng đã tới địa chỉ nhận'],
        5 => ['label' => 'Hoàn thành',      'desc' => 'Khách xác nhận đã nhận'],
         6 => ['label' => 'Đã hủy',        'desc' => 'Đơn hàng đã bị hủy'],
    ];

    // Gom log theo trạng thái: [status_id => collection các log]
    $logsByStatus = $order->statusLogs->groupBy('order_status_id');

    // Thông tin hiển thị badge trạng thái
    $statusId   = $currentStatus;
    $statusName = $order->status?->name ?? '—';
    $tagClass   = match($statusId) {
        1 => 'tag-amber',    // Chờ xác nhận
        2 => 'tag-primary',  // Đã xác nhận
        3 => 'tag-amber',    // Đang giao
        4 => 'tag-green',    // Đã giao
        5 => 'tag-green',    // Hoàn thành
        6 => 'tag-red',      // Hủy
        7 => 'tag-gray',     // Hoàn hàng
        default => 'tag-gray',
    };

    // Map trạng thái đơn vào mốc 1..5 trên thanh tiến trình
    $activeStep = match (true) {
        $statusId === 6 => 6,          // Hủy -> chỉ coi như ở bước 1
        $statusId === 1 => 1,
        $statusId === 2 => 2,
        $statusId === 3 => 3,
        $statusId === 4 => 4,
        $statusId >= 5  => 5,
        default         => 1,
    };
@endphp



<body
  class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
  data-elementor-device-mode="laptop">

  <style>
    /* ====== cosmetic nâng cấp nhé ====== */
    .order-header {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      padding: 14px 16px;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      background: #fff
    }

    .order-header .meta {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      color: #6b7280;
      font-size: .92rem
    }

    .tag {
      display: inline-flex;
      align-items: center;
      gap: .35rem;
      padding: .28rem .55rem;
      border-radius: 999px;
      font-weight: 600;
      font-size: .78rem
    }

    .tag-primary {
      background: #eef2ff;
      color: #3730a3
    }

    .tag-green {
      background: #ecfdf5;
      color: #047857
    }

    .tag-amber {
      background: #fff7ed;
      color: #9a3412
    }

    .tag-red {
      background: #fef2f2;
      color: #b91c1c
    }

    .tag-gray {
      background: #f3f4f6;
      color: #374151
    }

    /* progress trạng thái */
    .order-progress {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 10px 0 0
    }

    .order-progress .step {
      display: flex;
      align-items: center;
      gap: 8px
    }

    .order-progress .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #e5e7eb
    }

    .order-progress .dot.active {
      background: #111827
    }

    .order-progress .bar {
      height: 2px;
      width: 46px;
      background: #e5e7eb
    }

    .order-progress .bar.active {
      background: #111827
    }

    /* bảng sản phẩm */
    .order_details tbody tr:hover {
      background: #fafafa
    }

    .product-name .thumb {
      width: 64px;
      height: 64px;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid #eee
    }

    .product-name .meta {
      color: #6b7280;
      font-size: .85rem
    }

    /* card chung */
    .card {
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      background: #fff
    }

    .card .card-hd {
      padding: 12px 14px;
      border-bottom: 1px solid #e5e7eb;
      font-weight: 600
    }

    .card .card-bd {
      padding: 14px
    }

    .sum-row {
      display: flex;
      justify-content: space-between;
      margin: .25rem 0
    }

    .sum-row.total {
      font-weight: 700;
      border-top: 1px dashed #e5e7eb;
      padding-top: .5rem
    }

    /* invoice / tool buttons */
    .order-tools {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-top: 10px
    }

    .btn-lite {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 12px;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      background: #fff;
      text-decoration: none
    }

    .btn-danger-outline {
      border: 1px solid #ef4444;
      color: #b91c1c;
      background: #fff;
      padding: 9px 12px;
      border-radius: 8px
    }

    .btn-danger-outline:hover {
      background: #fef2f2
    }

    /* mobile spacing */
    @media (max-width: 768px) {
      .order-header {
        padding: 12px
      }
    }

    /* ===== Bố cục mới: 2 box dưới thanh trạng thái ===== */
    .order-info-flex {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.order-info-flex .card {
    flex: 1;              /* mỗi box chiếm 50% */
}


    /* Footer: tổng tiền góc phải */
    .order-bottom {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 18px;
      align-items: flex-start;
    }

    .order-bottom-left {
      flex: 1 1 auto;
      min-width: 0;
    }

    .order-total-card {
      min-width: 260px;
      margin-left: auto;
    }

    /* Gom badge + các nút trên 1 hàng, căn phải gọn gàng */
    .order-header>div:last-child {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      gap: 8px;
      flex-wrap: wrap;
      text-align: right;
    }

    .order-header>div:last-child .order-tools {
      margin-top: 0;
    }

    .order-header .tag {
      margin: 0 2px 0 0;
    }

    /* Nút hành động: luôn nền trắng, viền xám; hover xám rất nhẹ */
    .btn-lite {
      background: #fff !important;
      color: #111827 !important;
      border: 1px solid #e5e7eb !important;
      cursor: pointer;
    }

    .btn-lite:hover {
      background: #f9fafb !important;
      border-color: #d1d5db !important;
      color: #111827 !important;
    }

    .btn-lite:focus-visible {
      outline: 2px solid #11182722;
      outline-offset: 2px;
    }

    .btn-lite:active {
      transform: translateY(0.5px);
    }

    /* Nút "ĐÃ NHẬN HÀNG" nổi bật riêng */
    .btn-complete {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 8px 14px;
      border-radius: 999px;
      border: 1px solid #16a34a;
      background: #16a34a;
      color: #fff !important;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
    }

    .btn-complete:hover {
      background: #15803d;
      border-color: #15803d;
      color: #fff !important;
    }

    .btn-complete:active {
      transform: translateY(0.5px);
    }

    /* Mobile: đưa badge + nút căn trái để đỡ chật */
    @media (max-width: 768px) {
      .order-header>div:last-child {
        justify-content: flex-start;
        text-align: left;
      }
    }

    .btn-danger-outline:hover {
      background: #fef2f2 !important;
      color: #b91c1c !important;
      border-color: #ef4444 !important;
    }

    /* ==== Giảm khoảng trắng phần My account & đơn hàng ==== */

    /* Thu bớt padding trên container của trang xem đơn */
    body.woocommerce-view-order .site-content-wrapper .container {
      padding-top: 18px;
    }

    /* Thu khoảng trắng giữa breadcrumb / title và nội dung */
    body.woocommerce-view-order .page-header-content {
      margin-bottom: 0px !important;
      padding-bottom: 0 !important;
    }

    /* Tiêu đề "My account" không cách quá xa breadcrumb */
    body.woocommerce-view-order .page-header-content .page-title {
      margin-top: 6px !important;
      margin-bottom: 0 !important;
    }

    /* Nội dung tài khoản sát lên một chút */
    body.woocommerce-view-order .woocommerce-MyAccount-content {
      margin-top: 0px !important;
    }

    /* Header đơn hàng dính nhẹ lên trên cho gọn hơn */
    body.woocommerce-view-order .order-header {
      margin-top: 0px;
    }

    /* ===== Modal hủy đơn (thay cho alert/confirm) ===== */
    .cancel-order-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, .45);
      z-index: 9999;
      display: none;
      align-items: center;
      justify-content: center;
    }

    .cancel-order-overlay.is-open {
      display: flex;
    }

    .cancel-order-modal {
      background: #fff;
      border-radius: 16px;
      padding: 20px 24px;
      max-width: 360px;
      width: 100%;
      box-shadow: 0 18px 45px rgba(15, 23, 42, .25);
      text-align: center;
    }

    .cancel-order-modal h3 {
      margin: 0 0 6px;
      font-size: 18px;
      font-weight: 700;
    }

    .cancel-order-modal p {
      margin: 0 0 18px;
      font-size: 14px;
      color: #4b5563;
    }

    .cancel-order-actions {
      display: flex;
      justify-content: flex-end;
      gap: 8px;
    }

    .btn-cancel-close,
    .btn-cancel-ok {
      border-radius: 999px;
      padding: 8px 18px;
      font-size: 14px;
      cursor: pointer;
      border: 1px solid transparent;
    }

    .btn-cancel-close {
      background: #fff;
      border-color: #e5e7eb;
      color: #111827;
    }

    .btn-cancel-ok {
      background: #b04b64;
      color: #fff;
      border-color: #b04b64;
    }

    .btn-cancel-ok:hover {
      opacity: .9;
    }

    /* ===== Modal xác nhận ĐÃ NHẬN HÀNG ===== */
    .complete-order-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, .45);
      z-index: 9999;
      display: none;
      align-items: center;
      justify-content: center;
    }

    .complete-order-overlay.is-open {
      display: flex;
    }
    .status-badge {
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    display: inline-block;
}

strong {
    font-weight: 700 !important;
}
/* Trạng thái đơn hàng */
.status-pending   { background:#fff3cd; color:#856404; }   /* Chờ xác nhận */
.status-confirmed { background:#cce5ff; color:#004085; }   /* Đã xác nhận */
.status-shipping  { background:#ffeeba; color:#856404; }   /* Đang giao */
.status-delivered { background:#d4edda; color:#155724; }   /* Đã giao */
.status-done      { background:#d4edda; color:#155724; }   /* Hoàn thành */
.status-cancel    { background:#f8d7da; color:#721c24; }   /* Hủy */

/* Trạng thái thanh toán */
.pay-unpaid { background:#f8d7da; color:#721c24; }   /* Chưa thanh toán */
.pay-paid   { background:#d4edda; color:#155724; }   /* Đã thanh toán */
.pay-refund { background:#fff3cd; color:#856404; }   /* Hoàn tiền */

  </style>

  <div class="site-wrapper">
    <div class="kitify-site-wrapper elementor-459kitify">
      @include('layouts.header')

      <div id="site-content" class="site-content-wrapper">
        <div class="container">
          <div class="grid-x">
            <div class="cell small-12">
              <div class="site-content">
                <div class="page-header-content">
                  <nav class="woocommerce-breadcrumb">
                    <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                    <a href="{{ route('orders.index') }}">My account</a><span class="delimiter">/</span>
                    Order #{{ $order->order_code }}
                  </nav>
                  <h1 class="page-title">My account</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">
                    <div class="woocommerce">
                      @include('account.partials.navigation')

                      <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper">
                          @if(session('error')) <div class="woocommerce-error">{{ session('error') }}</div> @endif
                          @if(session('success')) <div class="woocommerce-message">{{ session('success') }}</div> @endif
                        </div>

                        {{-- ======= HEADER TÓM TẮT ======= --}}           

                        <div class="order-header">
                          <div>
                            <div style="font-weight:700;font-size:1.05rem">Đơn hàng #{{ $order->order_code }}</div>
                            <div class="meta">
                              <span>Đặt lúc {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
                              <span>•</span>
                              <span>Tổng: <strong>₫{{ number_format($calc_total) }}</strong></span>
                            </div>

                            {{-- progress dùng log: hiển thị Người dùng / Hệ thống + thời gian --}}
                            <div class="order-progress" aria-label="Tiến trình đơn hàng">
                              @foreach($stepMeta as $sid => $meta)
                                @php
                                    // Bước này đã được đi qua chưa?
                                    $isReached   = $activeStep >= $sid;

                                    // Lấy log đầu tiên của trạng thái này (thời điểm chuyển sang trạng thái)
                                    $logsForStep = $logsByStatus->get($sid);
                                    $firstLog    = $logsForStep ? $logsForStep->first() : null;
                                @endphp

                                <div class="step">
                                  <span class="dot {{ $isReached ? 'active' : '' }}"></span>

                                  <div style="display:flex;flex-direction:column;align-items:flex-start">
                                    {{-- Tiêu đề + mô tả --}}
                                    <span style="font-size:.83rem;color:#374151">{{ $meta['label'] }}</span>
                                    <span style="font-size:.78rem;color:#6b7280">{{ $meta['desc'] }}</span>

                                    {{-- Người dùng / Hệ thống + thời gian --}}
                                    @if($firstLog)
                                      <span style="font-size:.75rem;color:#9ca3af">
                                        {{ $firstLog->actor_label }}
                                        • {{ $firstLog->created_at->format('H:i d/m/Y') }}
                                      </span>
                                    @endif
                                  </div>
                                </div>

                                @if($sid < count($stepMeta))
                                  <span class="bar {{ $sid < $activeStep ? 'active' : '' }}"></span>
                                @endif
                              @endforeach
                            </div>

                          </div>

                          <div style="text-align:right">
                            <span class="tag {{ $tagClass }}">{{ $statusName }}</span>
                            <div class="order-tools">
                              @if($order->invoice)
                                <a href="#" class="btn-lite">In hoá đơn: {{ $order->invoice->invoice_code }}</a>
                              @endif

                              {{-- Nút ĐÃ NHẬN HÀNG: chỉ hiển thị khi trạng thái là ĐÃ GIAO (4) --}}
                              @if($order->order_status_id == 4)
                                <form id="complete-order-form" method="POST" action="{{ route('orders.complete', $order->id) }}">
                                  @csrf
                                  <button
                                    class="btn-complete"
                                    type="button"
                                    id="btnOpenCompleteModal"
                                    title="Xác nhận đã nhận hàng"
                                  >
                                    Hoàn thành
                                  </button>
                                </form>
                              @endif
@if($order->cancelable)
    {{-- Nút Hủy đơn: Dùng thuộc tính data-bs-toggle và data-bs-target để kích hoạt Modal Bootstrap --}}
    <button type="button" 
            class="btn btn-outline-danger" 
            data-bs-toggle="modal"  
            data-bs-target="#cancelOrderModal"> Hủy đơn
    </button>
@endif

<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- FORM SUBMIT POST ĐỂ GỬI YÊU CẦU HỦY --}}
            <form method="POST" action="{{ route('orders.cancel', $order->id) }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận Yêu cầu Hủy Đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Vui lòng nhập **lý do chi tiết** để gửi yêu cầu hủy đơn hàng này. Yêu cầu sẽ được admin xem xét.</p>
                    
                    <div class="mb-3">
                        <label for="cancelReason" class="form-label required">Lý do hủy đơn</label>
                        {{-- Ô nhập lý do phải có name="reason" --}}
                        <textarea class="form-control @error('reason') is-invalid @enderror" 
                                  id="cancelReason" 
                                  name="reason" 
                                  rows="3" 
                                  required 
                                  placeholder="Ví dụ: Đặt nhầm sản phẩm hoặc thay đổi nhu cầu.">{{ old('reason') }}</textarea>
                        
                        {{-- Hiển thị lỗi Validation nếu Controller redirect lại --}}
                        @error('reason')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Gửi Yêu Cầu Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
                            </div>
                          </div>
                        </div>

                        {{-- ======= 2 BOX: ĐƠN HÀNG & THÔNG TIN NGƯỜI NHẬN ======= --}}
                          <div class="order-info-grid">

    {{-- Box Đơn hàng --}}
   <div class="order-info-flex">

    {{-- Box Đơn hàng --}}
    <div class="card">
        <div class="card-hd">Đơn hàng</div>
        <div class="card-bd">

            <div class="sum-row">
                <span>Mã đơn</span>
                <span>#{{ $order->order_code }}</span>
            </div>

            <div class="sum-row">
                <span>Trạng thái đơn</span>
                <span>
                    <span class="status-badge {{ $statusClass }}">
                        {{ $order->status?->name ?? '—' }}
                    </span>
                </span>
            </div>

            <div class="sum-row">
                <span>Trạng thái thanh toán</span>
                <span>
                    <span class="status-badge {{ $payClass }}">
                        {{ $order->paymentStatus?->name ?? '—' }}
                    </span>
                </span>
            </div>

            <div class="sum-row">
                <span>Phương thức thanh toán</span>
                <span>{{ $order->paymentMethod?->name ?? '—' }}</span>
            </div>

            <div class="sum-row">
                <span>Thời gian đặt</span>
                <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
            </div>

        </div>
    </div>


    {{-- Box Thông tin người nhận --}}
    <div class="card">
        <div class="card-hd">Thông tin người nhận</div>

        <div class="card-bd pt-2">

            <p class="mb-1"><strong>Họ tên:</strong> {{ $order->name }}</p>
            <p class="mb-1"><strong>Điện thoại:</strong> {{ $order->phone }}</p>
            <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->address }}</p>

            @if($order->user?->email)
                <p class="mb-1">
                    <strong>Email:</strong>
                    <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                </p>
            @endif

            @if($order->note)
                <p class="mt-2 text-muted"><strong>Ghi chú:</strong> {{ $order->note }}</p>
            @endif

        </div>
    </div>

</div>


                        {{-- ======= CHI TIẾT ĐƠN HÀNG (BẢNG SẢN PHẨM) ======= --}}
                        <section class="woocommerce-order-details card" style="margin-top:18px">
                          <div class="card-hd">Chi tiết đơn hàng</div>
                          <div class="card-bd" style="padding:0">
                            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details" style="margin:0">
                              <thead>
                                <tr>
                                  <th style="width:60px">STT</th>
                                  <th class="product-name">Sản phẩm</th>
                                  <th class="product-quantity" style="width:90px">SL</th>
                                  <th class="product-total" style="width:150px">Thành tiền</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($lines as $it)
                                  <tr class="order_item">
                                    <td style="text-align:center">{{ $loop->iteration }}</td>
                                    <td class="product-name">
                                      <div style="display:flex; gap:12px; align-items:center">
{{-- @php
$firstImage = $it->photoAlbums->first()?->image;
@endphp

<img src="{{ $firstImage ? asset('storage/products/' . $firstImage) : asset('images/no-image.png') }}"
     alt="{{ $it->product_name ?? 'Sản phẩm' }}"
     class="avatar-md"> --}}


                                          <strong>{{ $it->product_name }}</strong>
                                          <div class="meta">
                                            @if($it->variant_text) {{ $it->variant_text }} · @endif
                                            Đơn giá: ₫{{ number_format($it->unit_price) }}
                                            @if($it->eta)
                                              · Dự kiến: {{ \Carbon\Carbon::parse($it->eta)->format('d/m') }}
                                            @endif
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td class="product-quantity" style="text-align:center">{{ $it->qty }}</td>
                                    <td class="product-total" style="text-align:right">
                                      <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">₫</span>{{ number_format($it->line_total) }}
                                      </span>
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </section>

                    {{-- ======= FOOTER: THÔNG ĐIỆP + TỔNG TIỀN GÓC PHẢI ======= --}}
<div class="order-bottom">

    {{-- phần bên trái (bạn giữ nguyên nếu có) --}}
    <div class="order-bottom-left">
        @if($order->order_status_id == 5)
            <div class="woocommerce-message">
                Đơn hàng đã hoàn thành.
                <a class="button" href="#">Viết đánh giá</a>
            </div>
        @endif
    </div>

    {{-- BOX TỔNG THANH TOÁN BÊN PHẢI --}}
    <div class="order-total-card card">

        <div class="card-hd">Tổng thanh toán</div>

        <div class="card-bd">

            <div class="sum-row">
                <span>Tạm tính</span>
                <span>₫{{ number_format($calc_subtotal) }}</span>
            </div>

            <div class="sum-row">
                <span>Phí vận chuyển</span>
                <span>₫{{ number_format($calc_shipping_fee ?? 0) }}</span>
            </div>

            <div class="sum-row">
                <span>Giảm giá</span>
                <span>-₫{{ number_format($calc_discount ?? 0) }}</span>
            </div>

            <div class="sum-row">
                <span>Voucher</span>
                <span>{{ $order->voucher->voucher_code ?? 'Không có' }}</span>
            </div>

            <div class="sum-row">
                <span>Trạng thái thanh toán</span>
                <span>{{ $order->paymentStatus?->name ?? 'Chưa xác định' }}</span>
            </div>

            <div class="sum-row total">
                <span>Tổng thanh toán</span>
                <span>₫{{ number_format($calc_total) }}</span>
            </div>

        </div>
    </div>

</div>


                        {{-- ===== Modal xác nhận ĐÃ NHẬN HÀNG ===== --}}
                        <div class="complete-order-overlay" id="completeOrderOverlay">
                          <div class="cancel-order-modal">
                            <h3>Đã nhận hàng</h3>
                            <p>Bạn đã nhận đầy đủ hàng và muốn hoàn thành đơn này?</p>
                            <div class="cancel-order-actions">
                              <button type="button" class="btn-cancel-close" id="btnCompleteClose">Không</button>
                              <button type="button" class="btn-cancel-ok" id="btnCompleteOk">Đồng ý</button>
                            </div>
                          </div>
                        </div>

                      </div><!-- /.woocommerce-MyAccount-content -->
                    </div><!-- /.woocommerce -->
                  </div><!-- .entry-content -->
                </article>
              </div>
            </div>
          </div>
        </div>
      </div><!-- .site-content-wrapper -->

      @include('layouts.footer')
      <div class="nova-overlay-global"></div>
    </div><!-- .kitify-site-wrapper -->

    {{-- JS điều khiển modal hủy đơn & đã nhận hàng --}}
   {{-- JS điều khiển modal hủy đơn & đã nhận hàng --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- Logic cho Modal Hủy Đơn (Sử dụng Bootstrap JS API) ---
        
        // Tự động mở lại Modal nếu có lỗi Validation (Lỗi 'reason' từ Controller)
        @if ($errors->has('reason'))
            var modalElement = document.getElementById('cancelOrderModal');
            // Kiểm tra xem Bootstrap đã được tải chưa
            if (modalElement && typeof bootstrap !== 'undefined') {
                var cancelModal = new bootstrap.Modal(modalElement);
                cancelModal.show(); // Mở Modal khi có lỗi
            }
        @endif

        // --- Logic cho Modal Đã Nhận Hàng (Nếu vẫn dùng Overlay/Vanilla JS) ---
        
        // Nếu bạn muốn giữ nguyên logic Overlay/JS tự tạo cho "Đã nhận hàng"
        const completeOpen = document.getElementById('btnOpenCompleteModal');
        const completeOverlay = document.getElementById('completeOrderOverlay');
        const completeClose = document.getElementById('btnCompleteClose');
        const completeOk = document.getElementById('btnCompleteOk');
        const completeForm = document.getElementById('complete-order-form');

        if (completeOpen && completeOverlay && completeClose && completeOk && completeForm) {
            completeOpen.addEventListener('click', function () {
                completeOverlay.classList.add('is-open');
            });

            completeClose.addEventListener('click', function () {
                completeOverlay.classList.remove('is-open');
            });

            completeOverlay.addEventListener('click', function (e) {
                if (e.target === completeOverlay) {
                    completeOverlay.classList.remove('is-open');
                }
            });

            completeOk.addEventListener('click', function () {
                // Bạn sẽ cần đảm bảo có nút/form/ID tương ứng cho "Đã nhận hàng"
                completeForm.submit();
            });
        }
    });
</script>
  </div>
@endsection
