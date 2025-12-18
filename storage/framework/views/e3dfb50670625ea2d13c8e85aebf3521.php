<?php $__env->startSection('content'); ?>
<?php

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
?>



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

  </style>

  <div class="site-wrapper">
    <div class="kitify-site-wrapper elementor-459kitify">
      <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <div id="site-content" class="site-content-wrapper">
        <div class="container">
          <div class="grid-x">
            <div class="cell small-12">
              <div class="site-content">
                <div class="page-header-content">
                  <nav class="woocommerce-breadcrumb">
                    <a href="<?php echo e(url('/')); ?>">Home</a><span class="delimiter">/</span>
                    <a href="<?php echo e(route('orders.index')); ?>">My account</a><span class="delimiter">/</span>
                    Order #<?php echo e($order->order_code); ?>

                  </nav>
                  <h1 class="page-title">My account</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">
                    <div class="woocommerce">
                      <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                      <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper">
                          <?php if(session('error')): ?> <div class="woocommerce-error"><?php echo e(session('error')); ?></div> <?php endif; ?>
                          <?php if(session('success')): ?> <div class="woocommerce-message"><?php echo e(session('success')); ?></div> <?php endif; ?>
                        </div>

                                   

                        <div class="order-header">
                          <div>
                            <div style="font-weight:700;font-size:1.05rem">Đơn hàng #<?php echo e($order->order_code); ?></div>
                            <div class="meta">
                              <span>Đặt lúc <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></span>
                              <span>•</span>
                              <span>Tổng: <strong>₫<?php echo e(number_format($calc_total)); ?></strong></span>
                            </div>

                            
                            <div class="order-progress" aria-label="Tiến trình đơn hàng">
                              <?php $__currentLoopData = $stepMeta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sid => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Bước này đã được đi qua chưa?
                                    $isReached   = $activeStep >= $sid;

                                    // Lấy log đầu tiên của trạng thái này (thời điểm chuyển sang trạng thái)
                                    $logsForStep = $logsByStatus->get($sid);
                                    $firstLog    = $logsForStep ? $logsForStep->first() : null;
                                ?>

                                <div class="step">
                                  <span class="dot <?php echo e($isReached ? 'active' : ''); ?>"></span>

                                  <div style="display:flex;flex-direction:column;align-items:flex-start">
                                    
                                    <span style="font-size:.83rem;color:#374151"><?php echo e($meta['label']); ?></span>
                                    <span style="font-size:.78rem;color:#6b7280"><?php echo e($meta['desc']); ?></span>

                                    
                                    <?php if($firstLog): ?>
                                      <span style="font-size:.75rem;color:#9ca3af">
                                        <?php echo e($firstLog->actor_label); ?>

                                        • <?php echo e($firstLog->created_at->format('H:i d/m/Y')); ?>

                                      </span>
                                    <?php endif; ?>
                                  </div>
                                </div>

                                <?php if($sid < count($stepMeta)): ?>
                                  <span class="bar <?php echo e($sid < $activeStep ? 'active' : ''); ?>"></span>
                                <?php endif; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                          </div>

                          <div style="text-align:right">
                            <span class="tag <?php echo e($tagClass); ?>"><?php echo e($statusName); ?></span>
                            <div class="order-tools">
                              <?php if($order->invoice): ?>
                                <a href="#" class="btn-lite">In hoá đơn: <?php echo e($order->invoice->invoice_code); ?></a>
                              <?php endif; ?>

                              
                              <?php if($order->order_status_id == 4): ?>
                                <form id="complete-order-form" method="POST" action="<?php echo e(route('orders.complete', $order->id)); ?>">
                                  <?php echo csrf_field(); ?>
                                  <button
                                    class="btn-complete"
                                    type="button"
                                    id="btnOpenCompleteModal"
                                    title="Xác nhận đã nhận hàng"
                                  >
                                   Đã nhận được hàng
                                  </button>
                                </form>
                              <?php endif; ?>
                  

                                
                                                                <?php if(in_array($order->order_status_id, [4, 5])): ?>
                                                                    <?php
                                                                        $hasReturnRequest = \App\Models\OrderReturn::where('order_id', $order->id)->exists();
                                                                    ?>
                                                                    <?php if(!$hasReturnRequest): ?>
                                                                        <button type="button"
                                                                                onclick="window.location.href='<?php echo e(route('orders.return.create', $order->id)); ?>'"
                                                                                class="btn-return"
                                                                                title="Yêu cầu hoàn hàng">
                                                                            Yêu cầu hoàn hàng
                                                                        </button>
                                                                    <?php else: ?>
                                                                        <span class="btn-return disabled" title="Đã gửi yêu cầu hoàn hàng">
                                                                            Đã gửi yêu cầu hoàn hàng
                                                                        </span>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if($order->order_status_id == 7 || \App\Models\OrderReturn::where('order_id', $order->id)->exists()): ?>
                                                                    <?php
                                                                        $returnRequest = \App\Models\OrderReturn::where('order_id', $order->id)->first();
                                                                    ?>
                                                                    <?php if($returnRequest): ?>
                                                                        <button type="button"
                                                                                onclick="window.location.href='<?php echo e(route('orders.return.show', $returnRequest->id)); ?>'"
                                                                                class="btn-return-detail"
                                                                                title="Xem chi tiết hoàn hàng">
                                                                            Chi tiết hoàn hàng
                                                                        </button>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if($order->cancelable): ?>
                                                                    
                                                                    <form id="cancel-order-form" method="POST"
                                                                        action="<?php echo e(route('orders.cancel', $order->id)); ?>">
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="reason"
                                                                            value="Khách yêu cầu hủy">
                                                                        <button class="btn-danger-outline" type="button"
                                                                            id="btnOpenCancelModal">Hủy đơn hàng</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                      <?php if($order->cancelRequest): ?>
    
    <?php
        $request = $order->cancelRequest;
        $statusId = $request->status; // 1: pending, 2: accepted, 3: rejected
        
        $statusText = '';
        $alertClass = '';
        
        switch ($statusId) {
            case 1:
                $statusText = 'ĐANG CHỜ XEM XÉT';
                $alertClass = 'alert-warning';
                break;
            case 2:
                $statusText = 'ĐÃ CHẤP NHẬN HỦY';
                $alertClass = 'alert-success';
                break;
            case 3:
                $statusText = 'ĐÃ BỊ TỪ CHỐI';
                $alertClass = 'alert-danger';
                break;
            default:
                $statusText = 'KHÔNG XÁC ĐỊNH';
                $alertClass = 'alert-secondary';
                break;
        }
    ?>

    <div class="alert <?php echo e($alertClass); ?>" role="alert">
        <h4 class="alert-heading">⚠️ YÊU CẦU HỦY ĐƠN HÀNG</h4>
        <p>
            Trạng thái hiện tại của yêu cầu hủy của bạn là: 
            <span class="font-weight-bold"><?php echo e($statusText); ?></span>.
        </p>
        
        <hr>
        
        <div class="row">
            
            <div class="col-md-6 mb-2">
                <strong>Lý do bạn cung cấp:</strong>
                <p class="mb-0 text-muted"><?php echo e($request->reason_user); ?></p>
            </div>
            
            
            <?php if($request->reason_admin): ?>
                <div class="col-md-6 mb-2">
                    <strong>Phản hồi từ Admin:</strong>
                    <p class="mb-0 font-weight-bold text-dark"><?php echo e($request->reason_admin); ?></p>
                </div>
            <?php endif; ?>
            
            
            <div class="col-md-12">
                <small class="text-secondary">Yêu cầu được gửi lúc: <?php echo e($request->created_at->format('H:i d/m/Y')); ?></small>
            </div>
        </div>
    </div>
    <br>
<?php endif; ?>              




                        
                          <div class="order-info-grid">

    
   <div class="order-info-flex">

    
    <div class="card">
        <div class="card-hd">Đơn hàng</div>
        <div class="card-bd">

            <div class="sum-row">
                <span>Mã đơn</span>
                <span>#<?php echo e($order->order_code); ?></span>
            </div>

            <div class="sum-row">
                <span>Trạng thái đơn</span>
                <span>
                    <span class="status-badge <?php echo e($statusClass); ?>">
                        <?php echo e($order->status?->name ?? '—'); ?>

                    </span>
                </span>
            </div>

            <div class="sum-row">
                <span>Trạng thái thanh toán</span>
                <span>
                    <span class="status-badge <?php echo e($payClass); ?>">
                        <?php echo e($order->paymentStatus?->name ?? '—'); ?>

                    </span>
                </span>
            </div>

            <div class="sum-row">
                <span>Phương thức thanh toán</span>
                <span><?php echo e($order->paymentMethod?->name ?? '—'); ?></span>
            </div>

            <div class="sum-row">
                <span>Thời gian đặt</span>
                <span><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></span>
            </div>

        </div>
    </div>


    
    <div class="card">
        <div class="card-hd">Thông tin người nhận</div>

        <div class="card-bd pt-2">

            <p class="mb-1"><strong>Họ tên:</strong> <?php echo e($order->name); ?></p>
            <p class="mb-1"><strong>Điện thoại:</strong> <?php echo e($order->phone); ?></p>
            <p class="mb-1"><strong>Địa chỉ:</strong> <?php echo e($order->address); ?></p>

            <?php if($order->user?->email): ?>
                <p class="mb-1">
                    <strong>Email:</strong>
                    <a href="mailto:<?php echo e($order->user->email); ?>"><?php echo e($order->user->email); ?></a>
                </p>
            <?php endif; ?>

            <?php if($order->note): ?>
                <p class="mt-2 text-muted"><strong>Ghi chú:</strong> <?php echo e($order->note); ?></p>
            <?php endif; ?>

        </div>
    </div>

</div>


                        
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
                                <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr class="order_item">
                                    <td style="text-align:center"><?php echo e($loop->iteration); ?></td>
                                    <td class="product-name">
                                      <div style="display:flex; gap:12px; align-items:center">



                                          <strong><?php echo e($it->product_name); ?></strong>
                                          <div class="meta">
                                            <?php if($it->variant_text): ?> <?php echo e($it->variant_text); ?> · <?php endif; ?>
                                            Đơn giá: ₫<?php echo e(number_format($it->unit_price)); ?>

                                            <?php if($it->eta): ?>
                                              · Dự kiến: <?php echo e(\Carbon\Carbon::parse($it->eta)->format('d/m')); ?>

                                            <?php endif; ?>
                                          </div>
                                        </div>
                                      </div>
                                    </td>
                                    <td class="product-quantity" style="text-align:center"><?php echo e($it->qty); ?></td>
                                    <td class="product-total" style="text-align:right">
                                      <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">₫</span><?php echo e(number_format($it->line_total)); ?>

                                      </span>
                                    </td>
                                  </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                            </table>
                          </div>
                        </section>

                    
<div class="order-bottom">

    
    <div class="order-bottom-left">
        <?php if($order->order_status_id == 5): ?>
            <h2>Sản phẩm cần đánh giá</h2>
    <div class="review-list">

        
        <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-review-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded">

                
                <div>
                    <strong><?php echo e($detail->product->name ?? 'Sản phẩm không rõ'); ?></strong>
                    <p class="text-muted mb-0">SKU: <?php echo e($detail->variant_sku); ?></p>
                </div>

                
                <?php
                    // Lấy đánh giá cho sản phẩm/đơn hàng cụ thể
                    $existingReview = $detail->product->reviews()->where('order_id', $order->id)->first();
                ?>

                <div class="review-action">
                    <?php if($existingReview): ?>
                        
                        <span class="text-success me-3">
                            <i class="fa fa-check-circle"></i> Đã đánh giá (<?php echo e($existingReview->rating); ?> sao)
                        </span>
                    <?php else: ?>
                        
                       <a href="<?php echo e(route('review.create', ['order_id' => $order->id, 'product_id' => $detail->product->id])); ?>"
                           class="btn btn-sm btn-primary">
                           <i class="fa fa-star"></i> Viết đánh giá
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
<?php endif; ?>
    </div>

    
    <div class="order-total-card card">

        <div class="card-hd">Tổng thanh toán</div>

        <div class="card-bd">

            <div class="sum-row">
                <span>Tạm tính</span>
                <span>₫<?php echo e(number_format($calc_subtotal)); ?></span>
            </div>

            <div class="sum-row">
                <span>Phí vận chuyển</span>
                <span>₫<?php echo e(number_format($calc_shipping_fee ?? 0)); ?></span>
            </div>

            <div class="sum-row">
                <span>Giảm giá</span>
                <span>-₫<?php echo e(number_format($calc_discount ?? 0)); ?></span>
            </div>

            <div class="sum-row">
                <span>Voucher</span>
                <span><?php echo e($order->voucher->voucher_code ?? 'Không có'); ?></span>
            </div>

            <div class="sum-row">
                <span>Trạng thái thanh toán</span>
                <span><?php echo e($order->paymentStatus?->name ?? 'Chưa xác định'); ?></span>
            </div>

            <div class="sum-row total">
                <span>Tổng thanh toán</span>
                <span>₫<?php echo e(number_format($calc_total)); ?></span>
            </div>

        </div>
    </div>

</div>
             
                                                   <div class="cancel-order-overlay" id="cancelOrderOverlay">
    <div class="cancel-order-modal">
        
        <form id="cancelOrderForm" method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>">
            <?php echo csrf_field(); ?>

            <h3>Hủy đơn hàng</h3>
            <p>Bạn chắc chắn muốn hủy đơn này? Vui lòng cung cấp lý do dưới đây:</p>

            
            <div class="mb-3">
                <label for="cancelReason" class="form-label visually-hidden">Lý do hủy</label>
                <textarea class="form-control" id="cancelReason" name="reason" rows="3" required
                          placeholder="Nhập lý do hủy đơn hàng (Ví dụ: Đặt trùng đơn, thay đổi ý định...)"></textarea>
            </div>

            <div class="cancel-order-actions">
                
                <button type="button" class="btn-cancel-close" id="btnCancelClose">Không</button>

                
                <button type="submit" class="btn-cancel-ok" id="btnCancelOk">Đồng ý</button>
            </div>
        </form>
        
    </div>
</div>



                        
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

      <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
      <div class="nova-overlay-global"></div>
    </div><!-- .kitify-site-wrapper -->

    
   
 <script>
        document.addEventListener('DOMContentLoaded', function() {
                    // ===== HỦY ĐƠN =====
                    const openBtn = document.getElementById('btnOpenCancelModal');
                    const overlay = document.getElementById('cancelOrderOverlay');
                    const closeBtn = document.getElementById('btnCancelClose');
                    const okBtn = document.getElementById('btnCancelOk');
                    const form = document.getElementById('cancel-order-form');

                    if (openBtn && overlay && closeBtn && okBtn && form) {
                        openBtn.addEventListener('click', function() {
                            overlay.classList.add('is-open');
                        });

                        closeBtn.addEventListener('click', function() {
                            overlay.classList.remove('is-open');
                        });

                        overlay.addEventListener('click', function(e) {
                            if (e.target === overlay) {
                                overlay.classList.remove('is-open');
                            }
                        });

                        okBtn.addEventListener('click', function() {
                            form.submit();
                        });
                    }

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/orders/show.blade.php ENDPATH**/ ?>