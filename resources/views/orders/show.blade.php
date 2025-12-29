@extends('master')
@section('content')
@php
    /**
     * 1. Cấu hình các mốc cho Thanh tiến trình (Progress Bar)
     */
    $stepMeta = [
        1 => ['label' => 'Chờ xác nhận',  'desc' => 'Đặt hàng thành công'],
        2 => ['label' => 'Đã xác nhận',   'desc' => 'Cửa hàng đã xác nhận'],
        3 => ['label' => 'Đang giao hàng', 'desc' => 'Đơn đang được giao'],
        4 => ['label' => 'Đã giao hàng',   'desc' => 'Hàng đã tới địa chỉ nhận'],
        5 => ['label' => 'Hoàn thành',    'desc' => 'Khách xác nhận đã nhận'],
    ];

    /**
     * 2. Xác định trạng thái hiện tại và mốc active cho tiến trình
     */
    $currentStatusId = (int)$order->order_status_id;

    $activeStep = match (true) {
        $currentStatusId === 6 => 1, // Hủy đơn: giữ mốc 1 (đã đặt hàng) nhưng badge sẽ hiện màu đỏ
        $currentStatusId >= 5 => 5,
        default => $currentStatusId,
    };

    /**
     * 3. Xử lý Badge Trạng thái Đơn hàng (Hiển thị đầu trang/Card)
     */
    $statusName = $order->status?->name ?? '—';
    $tagClass = match($currentStatusId) {
        1 => 'tag-amber',   // Chờ xác nhận
        2 => 'tag-primary', // Đã xác nhận
        3 => 'tag-amber',   // Đang giao
        4 => 'tag-green',   // Đã giao
        5 => 'tag-green',   // Hoàn thành
        6 => 'tag-red',     // Hủy
        7 => 'tag-gray',    // Hoàn hàng
        default => 'tag-gray',
    };

    /**
     * 4. Class màu sắc bao quanh Box chi tiết (Dùng cho CSS wrapper)
     */
    $statusClass = match($currentStatusId) {
        1 => 'status-pending',
        2 => 'status-confirmed',
        3 => 'status-shipping',
        4 => 'status-delivered',
        5 => 'status-done',
        6 => 'status-cancel',
        default => 'status-pending',
    };

    /**
     * 5. LOGIC THANH TOÁN (Xác nhận dòng tiền khách đã trả thực tế)
     */
    $pStatusId = (int)$order->payment_status_id;
    $pMethodId = (int)$order->payment_method_id;

    // Logic: Nếu là thanh toán Online (VNPAY/MOMO...) và DB đang là 2 (Đã TT) hoặc 3 (Đã hoàn tiền)
    // thì vẫn hiển thị là "Đã thanh toán" để xác nhận giao dịch gốc thành công.
    if ($pMethodId !== 1 && in_array($pStatusId, [2, 3])) {
        $payLabel = "Đã thanh toán";
        $payClass = "pay-paid"; 
    } 
    // Nếu là COD và đơn đã sang bước Hoàn thành (đã thu tiền tại chỗ)
    elseif ($pMethodId == 1 && $currentStatusId == 5) {
        $payLabel = "Đã thanh toán";
        $payClass = "pay-paid";
    } 
    // Các trường hợp khác (COD đang giao hoặc chưa trả online)
    else {
        $payLabel = "Chưa thanh toán";
        $payClass = "pay-unpaid";
    }

    /**
     * 6. Logic cho TRẠNG THÁI HỦY HÀNG (Dữ liệu từ bảng cancel_requests)
     */
    $cancelRequest = $order->cancelRequest;
    $refundName = '—';
    $refundStyle = '';

    if ($cancelRequest) {
        $rStatusId = (int) $cancelRequest->status_id; 

        // Tên trạng thái hoàn tiền
        $refundName = match($rStatusId) {
            1 => 'Chờ xử lý',
            2 => 'Đã chấp nhận',
            3 => 'Đã từ chối',
            4 => 'Đã hoàn tiền',
            default => 'Đang xử lý'
        };

        // Style màu sắc badge hoàn tiền (Inline để ưu tiên hiển thị)
        $refundStyle = match($rStatusId) {
            1 => 'background: #fff3cd; color: #856404; border: 1px solid #ffeeba;', // Vàng nhạt
            2 => 'background: #cce5ff; color: #004085; border: 1px solid #b8daff;', // Xanh biển
            3 => 'background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;', // Đỏ nhạt
            4 => 'background: #d4edda; color: #155724; border: 1px solid #c3e6cb;', // Xanh lá
            default => 'background: #e2e3e5; color: #383d41;'
        };
    }

    /**
     * 7. Gom dữ liệu nhật ký (Logs) để hiển thị thời gian từng bước
     */
    $logsByStatus = $order->statusLogs->groupBy('order_status_id');
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

    /* Nút "YÊU CẦU HOÀN HÀNG" - CSS giống btn-complete, chỉ khác màu */
            .btn-return {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 8px 14px;
                min-width: 120px;0px;
                border-radius: 999px;
                border: 1px solid #f59e0b;
                background: #f59e0b;
                color: #fff !important;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                margin-left: 8px;
                margin-left: 8px;
            }

            .btn-return:hover {
                background: #d97706;
                border-color: #d97706;
                color: #fff !important;
            }

            .btn-return:active {
                transform: translateY(0.5px);
            }

            .btn-return.disabled {
                background: #d1d5db;
                border-color: #d1d5db;
                color: #6b7280 !important;
                cursor: not-allowed;
                opacity: 0.6;
                transform: none; /* Không có active effect cho disabled */
            }

            /* Nút "CHI TIẾT HOÀN HÀNG" - Màu vàng */
            .btn-return-detail {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 170px;
                min-width: 170px;
                padding: 8px 16px;
                margin: 0;
                border: 1.5px solid #eab308;
                border-radius: 999px;
                background: #eab308;
                color: #fff !important;
                font-size: 13px;
                font-weight: 600;
                text-align: center;
                cursor: pointer;
                box-sizing: border-box;
                visibility: visible !important;
                opacity: 1 !important;
            }

            .btn-return-detail:hover {
                background: #ca8a04;
                border-color: #ca8a04;
                color: #fff !important;
            }

            .btn-return-detail:active {
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


/* Đảm bảo modal bên trong luôn nổi lên trên cùng */
.cancel-order-modal {
    position: relative;
    z-index: 100000000 !important;
    background: #fff;
    border-radius: 16px;
    width: 100%;
    max-width: 450px;
    overflow: hidden;
}
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
                                   Đã nhận được hàng
                                  </button>
                                </form>
                              @endif
                  

                                {{-- Nút YÊU CẦU HOÀN HÀNG: hiển thị khi đơn đã giao hoặc hoàn thành --}}
                                                                @if (in_array($order->order_status_id, [4, 5]))
                                                                    @php
                                                                        $hasReturnRequest = \App\Models\OrderReturn::where('order_id', $order->id)->exists();
                                                                    @endphp
                                                                    @if (!$hasReturnRequest)
                                                                        <button type="button"
                                                                                onclick="window.location.href='{{ route('orders.return.create', $order->id) }}'"
                                                                                class="btn-return"
                                                                                title="Yêu cầu hoàn hàng">
                                                                            Yêu cầu hoàn hàng
                                                                        </button>
                                                                    @else
                                                                        <span class="btn-return disabled" title="Đã gửi yêu cầu hoàn hàng">
                                                                            Đã gửi yêu cầu hoàn hàng
                                                                        </span>
                                                                    @endif
                                                                @endif

                                                                @if ($order->order_status_id == 7 || \App\Models\OrderReturn::where('order_id', $order->id)->exists())
                                                                    @php
                                                                        $returnRequest = \App\Models\OrderReturn::where('order_id', $order->id)->first();
                                                                    @endphp
                                                                    @if ($returnRequest)
                                                                        <button type="button"
                                                                                onclick="window.location.href='{{ route('orders.return.show', $returnRequest->id) }}'"
                                                                                class="btn-return-detail"
                                                                                title="Xem chi tiết hoàn hàng">
                                                                            Chi tiết hoàn hàng
                                                                        </button>
                                                                    @endif
                                                                @endif

                                                             @if ($order->cancelable)
    {{-- 1. NÚT BẤM THỰC TẾ: Đặt ở đây để người dùng nhìn thấy và click --}}
    <button class="btn-danger-outline" type="button" id="btnOpenCancelModal">
        Hủy đơn hàng
    </button>

    {{-- 2. MODAL ẨN: Chỉ hiện lên sau khi bấm nút trên --}}
    <div id="cancelOrderOverlay" class="cancel-order-overlay">
        <div class="cancel-order-modal shadow-lg">
            <form id="cancel-order-form" method="POST" action="{{ route('orders.cancel', $order->id) }}">
                @csrf
                <h3 class="fw-bold text-danger mb-3">Hủy đơn hàng</h3>
                <p class="text-muted small">Vui lòng cung cấp lý do để chúng tôi hỗ trợ hoàn tiền nhanh nhất.</p>
                
                {{-- Lý do hủy --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Lý do hủy đơn <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="reason" rows="2" required placeholder="Ví dụ: Tôi muốn thay đổi sản phẩm..."></textarea>
                    {{-- ĐÃ XÓA NÚT BẤM SAI VỊ TRÍ Ở ĐÂY --}}
                </div>

                {{-- Phần thông tin hoàn tiền --}}
               @if($order->payment_status_id == 2 && optional($order->paymentMethod)->code !== 'COD')
    <div class="card border-warning bg-warning-subtle mb-3">
        <div class="card-body p-3 text-start">
            <h6 class="card-title fw-bold text-warning-emphasis mb-3 d-flex align-items-center">
                <iconify-icon icon="solar:wallet-money-bold" class="me-2 fs-18"></iconify-icon>
                Thông tin nhận tiền hoàn (VNPay)
            </h6>
            
            {{-- Chọn tài khoản cũ --}}
            @if(auth()->user()->bankAccounts->count() > 0)
                <div class="mb-3">
                    <select name="user_bank_account_id" class="form-select form-select-sm" id="selectBank">
                        <option value="">-- Chọn tài khoản --</option>
                        @foreach(auth()->user()->bankAccounts as $bank)
                            <option value="{{ $bank->id }}" 
                                    data-name="{{ $bank->bank_name }}" 
                                    data-number="{{ $bank->account_number }}" 
                                    data-holder="{{ $bank->account_holder }}">
                                {{ $bank->bank_name }} - {{ $bank->account_number }}
                            </option>
                        @endforeach
                        <option value="new">-- Thêm tài khoản khác --</option>
                    </select>
                </div>
            @endif

            <div id="newBankFields" style="{{ auth()->user()->bankAccounts->count() > 0 ? 'display:none' : '' }}">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="small fw-bold">Tên Ngân hàng <span class="text-danger">*</span></label>
                        <input type="text" name="bank_name" id="bank_name" class="form-control form-control-sm" placeholder="Ví dụ: Vietcombank">
                        <div class="error-msg text-danger small mt-1" id="err_bank_name"></div>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Số tài khoản <span class="text-danger">*</span></label>
                        <input type="text" name="account_number" id="account_number" class="form-control form-control-sm" placeholder="Số tài khoản">
                        <div class="error-msg text-danger small mt-1" id="err_account_number"></div>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Chủ tài khoản <span class="text-danger">*</span></label>
                        <input type="text" name="account_holder" id="account_holder" class="form-control form-control-sm" placeholder="Tên chủ TK">
                        <div class="error-msg text-danger small mt-1" id="err_account_holder"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

                <div class="cancel-order-actions d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-light px-4" id="btnCancelClose">Quay lại</button>
                    {{-- Nút này dùng để SUBMIT form --}}
                    <button type="submit" class="btn btn-danger px-4" id="btnCancelOk">Xác nhận hủy</button>
                </div>
            </form>
        </div>
    </div>
@endif
                                                            </div>
                                                        </div>
                                                                </div>
                                                  

{{-- THẾ TRẬN 1: Đơn hàng đang trong trạng thái chờ Admin duyệt hủy --}}
@if($order->order_status_id != 6 && $order->is_cancel_requested == 1)
    <div class="alert alert-warning shadow-sm border-start border-4 border-warning">
        <h4 class="alert-heading">⚠️ YÊU CẦU HỦY ĐƠN HÀNG</h4>
        <p>Trạng thái hiện tại: <strong>Chờ xử lý</strong></p>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <strong>Lý do bạn cung cấp:</strong>
                <p class="text-muted">{{$order->cancelRequest->reason_user ?? '---' }}</p>
            </div>
            <div class="col-md-6">
                <small class="text-secondary d-block">
                    ⏱ Yêu cầu được gửi lúc: {{ $order->cancelRequest->created_at->format('H:i d/m/Y') }}
                </small>
            </div>
        </div>
    </div>

{{-- THẾ TRẬN 2: Đơn hàng đã chuyển sang trạng thái ĐÃ HỦY (ID = 6) --}}
@elseif($order->order_status_id == 6)
    <div class="alert alert-danger shadow-sm border-start border-4 border-danger">
        <h4 class="alert-heading">🚫 ĐƠN HÀNG ĐÃ HỦY</h4>
        
        {{-- Phân biệt lời chào đầu tiên --}}
        <p class="mb-0">
            @if($order->cancelRequest && $order->cancelRequest->cancel_by == 'user')
                {{-- Nếu khách gửi yêu cầu và đã duyệt --}}
                Yêu cầu hủy đơn hàng của bạn đã được <strong>Quản trị viên phê duyệt</strong>.
            @elseif($order->cancelRequest && $order->cancelRequest->cancel_by == 'admin')
                {{-- Nếu Admin chủ động hủy --}}
                Đơn hàng đã được <strong>Quản trị viên</strong> chủ động hủy bỏ.
            @else
                Đơn hàng này đã được xác nhận hủy trên hệ thống.
            @endif
        </p>

        <hr>
        <div class="mb-2">
            <strong>Lý do hủy:</strong> 
            <span class="text-dark">
                @if($order->cancelRequest && $order->cancelRequest->reason_user)
                    {{ $order->cancelRequest->reason_user }}
                @else
                    {{ $order->note ?? 'Đơn hàng đã được hủy bỏ.' }}
                @endif
            </span>
        </div>
        
        @if($order->cancelRequest && $order->cancelRequest->reason_admin)
            <div class="mt-2 p-2 bg-white bg-opacity-50 rounded border border-danger border-opacity-25">
                <small class="text-danger">
                    <strong>Phản hồi từ Admin:</strong> {{ $order->cancelRequest->reason_admin }}
                </small>
            </div>
        @endif
      </div>
@endif




                        {{-- ======= 2 BOX: ĐƠN HÀNG & THÔNG TIN NGƯỜI NHẬN ======= --}}
               <div class="order-info-grid">
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

                {{-- BỔ SUNG: TRẠNG THÁI HỦY/HOÀN TIỀN --}}
                @if($order->cancelRequest)
                    <div class="sum-row">
                        <span>Trạng thái hủy hàng</span>
                        <span>
                            @php
                                // Lấy ID từ bảng yêu cầu hủy
                                $rStatusId = (int) $order->cancelRequest->status_id; 

                                // Mapping màu sắc
                                $refundClass = match($rStatusId) {
                                    1 => 'badge-warning text-dark', // Chờ xử lý
                                    2 => 'badge-primary',           // Đã chấp nhận
                                    3 => 'badge-danger',            // Đã từ chối
                                    4 => 'badge-success',           // Đã hoàn tiền
                                    default => 'badge-secondary'
                                };
                                
                                // Mapping tên hiển thị
                                $refundName = match($rStatusId) {
                                    1 => 'Chờ xử lý',
                                    2 => 'Đã chấp nhận',
                                    3 => 'Đã từ chối',
                                    4 => 'Đã hoàn tiền',
                                    default => 'Đang xử lý'
                                };
                            @endphp
                            <span class="status-badge {{ $refundClass }}">
                                {{ $refundName }}
                            </span>
                        </span>
                    </div>

                    {{-- Hiển thị ảnh minh chứng nếu có --}}
                    @if($order->cancelRequest->refund_image)
                        <div class="sum-row">
                            <span>Minh chứng hoàn tiền</span>
                            <span>
                                <a href="{{ asset('storage/refunds/' . $order->cancelRequest->refund_image) }}" target="_blank" style="font-size: 0.9em; color: #28a745; text-decoration: underline;">
                                    Xem ảnh
                                </a>
                            </span>
                        </div>
                    @endif
                @endif

                <div class="sum-row">
                    <span>Trạng thái thanh toán</span>
                    <span>
                        <span class="status-badge {{ $payClass }}">
                            {{ $payLabel }}
                        </span>
                    </span>
                </div>

                <div class="sum-row">
                    <span>Phương thức thanh toán</span>
                    <span>{{ $order->paymentMethod?->name ?? ($order->payment?->method?->name ?? '—') }}</span>
                </div>

                <div class="sum-row">
                    <span>Thời gian đặt</span>
                    <span>{{ \Carbon\Carbon::parse($order->created_at)->format('H:i, d/m/Y') }}</span>
                </div>

                <div class="sum-row">
    <span>Thời gian hủy</span>
    <span style="text-align: right;">
        @if($order->cancelRequest && $order->cancelRequest->created_at)
            {{-- Định dạng chuyên nghiệp: Nhỏ, nghiêng và mờ hơn một chút --}}
            <div style="font-size: 0.85em; color: #7f8c8d; font-style: italic; line-height: 1.2;">
                {{ \Carbon\Carbon::parse($order->cancelRequest->created_at)->format('H:i - d/m/Y') }}
            </div>
        @else
            <span class="text-muted" style="font-size: 0.9em;">—</span>
        @endif
    </span>
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
            <h2>Sản phẩm cần đánh giá</h2>
    <div class="review-list">

        {{-- Lặp qua từng chi tiết sản phẩm trong đơn hàng --}}
        @foreach ($order->details as $detail)
            <div class="product-review-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">

                {{-- Hiển thị tên sản phẩm --}}
                <div>
                    <strong>{{ $detail->product->name ?? 'Sản phẩm không rõ' }}</strong>
                    <p class="text-muted mb-0">SKU: {{ $detail->variant_sku }}</p>
                </div>

                {{-- Kiểm tra xem sản phẩm này đã được đánh giá chưa --}}
                @php
                    // Lấy đánh giá cho sản phẩm/đơn hàng cụ thể
                    $existingReview = $detail->product->reviews()->where('order_id', $order->id)->first();
                @endphp

                <div class="review-action">
                    @if ($existingReview)
                        {{-- Nếu đã có đánh giá --}}
                        <span class="text-success me-3">
                            <i class="fa fa-check-circle"></i> Đã đánh giá ({{ $existingReview->rating }} sao)
                        </span>
                    @else
                        {{-- Nếu chưa có đánh giá --}}
                       <a href="{{ route('review.create', ['order_id' => $order->id, 'product_id' => $detail->product->id]) }}"
                           class="btn btn-sm btn-primary">
                           <i class="fa fa-star"></i> Viết đánh giá
                        </a>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
@endif
    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // 1. KHAI BÁO BIẾN CÁC PHẦN TỬ
    const overlay = document.getElementById('cancelOrderOverlay');
    const openBtn = document.getElementById('btnOpenCancelModal');
    const closeBtn = document.getElementById('btnCancelClose');
    const okBtn = document.getElementById('btnCancelOk');
    const cancelForm = document.getElementById('cancel-order-form');
    
    const selectBank = document.getElementById('selectBank');
    const newBankFields = document.getElementById('newBankFields');
    const inputBankName = document.getElementById('bank_name');
    const inputAccNumber = document.getElementById('account_number');
    const inputAccHolder = document.getElementById('account_holder');

    // 2. HÀM HỖ TRỢ HIỂN THỊ/XÓA LỖI
    function showError(input, errorId, message) {
        if (!input) return;
        input.classList.add('is-invalid');
        const errorDiv = document.getElementById(errorId);
        if (errorDiv) errorDiv.innerText = message;
    }

    function clearErrors() {
        document.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
        document.querySelectorAll('.form-control, .form-select').forEach(el => el.classList.remove('is-invalid'));
    }

    // 3. LOGIC ĐIỀN THÔNG TIN NGÂN HÀNG
    function updateBankInputs() {
        if (!selectBank) return;
        const selectedOption = selectBank.options[selectBank.selectedIndex];
        
        if (selectBank.value === 'new') {
            newBankFields.style.display = 'block';
            // Để trống để khách nhập mới
            inputBankName.value = '';
            inputAccNumber.value = '';
            inputAccHolder.value = '';
            inputBankName.readOnly = false;
            inputAccNumber.readOnly = false;
            inputAccHolder.readOnly = false;
        } else if (selectBank.value !== "") {
            newBankFields.style.display = 'none';
            // Lấy data từ attributes của option đã chọn
            inputBankName.value = selectedOption.dataset.name || '';
            inputAccNumber.value = selectedOption.dataset.number || '';
            inputAccHolder.value = selectedOption.dataset.holder || '';
            // Khóa lại để tránh sửa nhầm tài khoản cũ
            inputBankName.readOnly = true;
            inputAccNumber.readOnly = true;
            inputAccHolder.readOnly = true;
        }
    }

    // 4. LOGIC ĐÓNG/MỞ MODAL
    if (openBtn && overlay) {
        openBtn.addEventListener('click', () => {
            overlay.classList.add('is-open');
            clearErrors();
            updateBankInputs(); // Cập nhật lại bank khi mở modal
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => overlay.classList.remove('is-open'));
    }

    window.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('is-open');
    });

    // 5. SỰ KIỆN THAY ĐỔI LỰA CHỌN BANK
    if (selectBank) {
        selectBank.addEventListener('change', () => {
            clearErrors();
            updateBankInputs();
        });
    }

    // 6. LOGIC VALIDATE KHI BẤM NÚT XÁC NHẬN
    if (okBtn && cancelForm) {
        okBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let isValid = true;
            clearErrors();

            // A. Kiểm tra Lý do hủy
            const reason = cancelForm.querySelector('textarea[name="reason"]');
            if (!reason.value.trim()) {
                showError(reason, 'err_reason', 'Vui lòng nhập lý do để chúng tôi xử lý yêu cầu của bạn.');
                isValid = false;
            } else if (reason.value.trim().length < 10) {
                showError(reason, 'err_reason', 'Lý do quá ngắn. Tối thiểu 10 ký tự.');
                isValid = false;
            }

            // B. Kiểm tra Ngân hàng (Nếu có khối selectBank)
            if (selectBank) {
                if (selectBank.value === "") {
                    showError(selectBank, 'err_user_bank_account_id', 'Vui lòng chọn tài khoản nhận tiền hoàn.');
                    isValid = false;
                } else {
                    // Kiểm tra xem các trường bank có dữ liệu không (kể cả chọn cũ hay nhập mới)
                    const fields = [
                        { el: inputBankName, id: 'bank_name', msg: 'Tên ngân hàng không được để trống.' },
                        { el: inputAccNumber, id: 'account_number', msg: 'Số tài khoản không được để trống.' },
                        { el: inputAccHolder, id: 'account_holder', msg: 'Chủ tài khoản không được để trống.' }
                    ];

                    fields.forEach(item => {
                        if (!item.el.value.trim()) {
                            showError(item.el, 'err_' + item.id, item.msg);
                            isValid = false;
                        }
                    });
                }
            }

            // C. Gửi Form nếu tất cả OK
            if (isValid) {
                cancelForm.submit();
            }
        });
    }

    // 7. MODAL ĐÃ NHẬN HÀNG (GIỮ NGUYÊN)
    const completeOpen = document.getElementById('btnOpenCompleteModal');
    const completeOverlay = document.getElementById('completeOrderOverlay');
    const completeClose = document.getElementById('btnCompleteClose');
    const completeOk = document.getElementById('btnCompleteOk');
    const completeForm = document.getElementById('complete-order-form');

    if (completeOpen && completeOverlay && completeOk) {
        completeOpen.addEventListener('click', () => completeOverlay.classList.add('is-open'));
        completeClose.addEventListener('click', () => completeOverlay.classList.remove('is-open'));
        completeOk.addEventListener('click', () => completeForm.submit());
    }
});
</script>
  </div>
@endsection
