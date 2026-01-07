<?php $__env->startSection('content'); ?>
<?php
    /**
     * 1. Lấy thông tin cơ bản
     */
    $currentStatusId = (int)$order->order_status_id;
    $cancelRequest = $order->cancelRequest;
    $pStatusId = (int)$order->payment_status_id;
    $pMethodId = (int)$order->payment_method_id; 

    /**
     * 2. Xử lý nhật ký (Logs) để lấy thời gian tự động
     */
    $logsByStatus = $order->statusLogs->groupBy('order_status_id');

    // Hàm Closure để lấy thời gian từ Log theo ID trạng thái
    $getStatusTime = function($statusId) use ($logsByStatus) {
        $log = $logsByStatus->get($statusId)?->first();
        return $log ? \Carbon\Carbon::parse($log->created_at)->format('H:i d/m/Y') : null;
    };

    /**
     * 3. Cấu hình mốc tiến trình (Progress Bar)
     */
    if ($currentStatusId === 6) {
        // TRƯỜNG HỢP: ĐƠN HÀNG BỊ HỦY
        $rStatusId = $cancelRequest ? (int)$cancelRequest->status_id : 0;

        if ($pMethodId === 1) {
            $stepMeta = [
                1 => ['label' => 'Đã đặt hàng', 'desc' => $getStatusTime(1) ?? 'Chờ xử lý' ],
                2 => ['label' => 'Yêu cầu hủy', 'desc' => $getStatusTime(6) ?? 'Khách gửi yêu cầu'],
                3 => ['label' => 'Xác nhận hủy', 'desc' => ($rStatusId >= 2) ? ($getStatusTime(6) ?? 'Cửa hàng đồng ý') : 'Đang xử lý'],
                4 => ['label' => 'Kết thúc',     'desc' => ($rStatusId == 2) ? 'Giao dịch đã hủy' : '—'],
            ];
            $activeStep = ($rStatusId === 2) ? 4 : 2;
        } else {
            $stepMeta = [
                1 => ['label' => 'Đã đặt hàng', 'desc' => $getStatusTime(1) ?? 'Chờ xử lý'],
                2 => ['label' => 'Yêu cầu hủy', 'desc' => $getStatusTime(6) ?? 'Gửi yêu cầu'],
                3 => ['label' => 'Xác nhận hủy', 'desc' => ($rStatusId >= 2) ? 'Cửa hàng đồng ý' : 'Đang chờ'],
                4 => ['label' => 'Hoàn tiền',    'desc' => ($rStatusId == 4) ? ($getStatusTime(6) ?? 'Đã hoàn tiền') : 'Đang xử lý'],
                5 => ['label' => 'Kết thúc',     'desc' => ($cancelRequest && $cancelRequest->is_customer_confirmed) ? 'Hoàn tất' : '—'],
            ];
            $activeStep = match (true) {
                ($cancelRequest && $cancelRequest->is_customer_confirmed) => 5,
                ($rStatusId === 4) => 4,
                ($rStatusId === 2) => 3,
                default => 2,
            };
        }
    } else {
        // TRƯỜNG HỢP: ĐƠN HÀNG BÌNH THƯỜNG
        $stepMeta = [
            1 => ['label' => 'Chờ xác nhận',  'desc' => $getStatusTime(1) ?? 'Đặt hàng thành công'],
            2 => ['label' => 'Đã xác nhận',   'desc' => $getStatusTime(2) ?? 'Chờ lấy hàng'],
            3 => ['label' => 'Đang giao hàng', 'desc' => $getStatusTime(3) ?? 'Đang vận chuyển'],
            4 => ['label' => 'Đã giao hàng',   'desc' => $getStatusTime(4) ?? 'Giao thành công'],
            5 => ['label' => 'Hoàn thành',    'desc' => $getStatusTime(5) ?? 'Khách đã nhận'],
        ];

        $activeStep = match (true) {
            $currentStatusId >= 5 => 5,
            default => $currentStatusId,
        };
    }

    /**
     * 4. Badge & Style (Giữ nguyên logic của bạn)
     */
    $statusName = $order->status?->name ?? '—';
    $tagClass = match($currentStatusId) {
        1 => 'tag-amber', 2 => 'tag-primary', 3 => 'tag-amber',
        4 => 'tag-green', 5 => 'tag-green',   6 => 'tag-red',
        7 => 'tag-gray',  default => 'tag-gray',
    };

    $statusClass = match($currentStatusId) {
        1 => 'status-pending', 2 => 'status-confirmed', 3 => 'status-shipping',
        4 => 'status-delivered', 5 => 'status-done',    6 => 'status-cancel',
        default => 'status-pending',
    };

    /**
     * 5. Logic Thanh toán
     */
    $isPaid = ($pMethodId !== 1 && in_array($pStatusId, [2, 3])) || ($pMethodId == 1 && $currentStatusId == 5);
    $payLabel = $isPaid ? "Đã thanh toán" : "Chưa thanh toán";
    $payClass = $isPaid ? "pay-paid" : "pay-unpaid";

    /**
     * 6. Logic Hủy & Hoàn tiền
     */
    $refundName = '—';
    if ($cancelRequest) {
        $rStatusId = (int) $cancelRequest->status_id; 
        $refundName = match($rStatusId) {
            1 => 'Chờ xử lý hủy', 2 => 'Đã chấp nhận hủy',
            3 => 'Từ chối hủy',  4 => 'Đã hoàn tiền',
            default => 'Đang xử lý'
        };
    }

    $refundProofImage = $cancelRequest->refund_image ?? null;
    $isCustomerConfirmedRefund = $cancelRequest->is_customer_confirmed ?? false;
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
                min-width: 120px;
                0px;
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
                transform: none;
                /* Không có active effect cho disabled */
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
                                            <a href="<?php echo e(route('orders.index')); ?>">My account</a><span
                                                class="delimiter">/</span>
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
                                                        <?php if(session('error')): ?>
                                                            <div class="woocommerce-error"><?php echo e(session('error')); ?></div>
                                                        <?php endif; ?>
                                                        <?php if(session('success')): ?>
                                                            <div class="woocommerce-message"><?php echo e(session('success')); ?></div>
                                                        <?php endif; ?>
                                                    </div>

                                                    

                                                    <div class="order-header">
                                                        <div>
                                                            <div style="font-weight:700;font-size:1.05rem">Đơn hàng
                                                                #<?php echo e($order->order_code); ?></div>
                                                            <div class="meta">
                                                                <span>Đặt lúc
                                                                    <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></span>
                                                                <span>•</span>
                                                                <span>Tổng:
                                                                    <strong>₫<?php echo e(number_format($calc_total)); ?></strong></span>
                                                            </div>

                                                            
                                                            <div class="order-progress" aria-label="Tiến trình đơn hàng">
                                                                <?php $__currentLoopData = $stepMeta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sid => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php
                                                                        // Bước này đã được đi qua chưa?
                                                                        $isReached = $activeStep >= $sid;

                                                                        // Lấy log đầu tiên của trạng thái này (thời điểm chuyển sang trạng thái)
                                                                        $logsForStep = $logsByStatus->get($sid);
                                                                        $firstLog = $logsForStep
                                                                            ? $logsForStep->first()
                                                                            : null;
                                                                    ?>

                                                                    <div class="step">
                                                                        <span
                                                                            class="dot <?php echo e($isReached ? 'active' : ''); ?>"></span>

                                                                        <div
                                                                            style="display:flex;flex-direction:column;align-items:flex-start">
                                                                            
                                                                            <span
                                                                                style="font-size:.83rem;color:#374151"><?php echo e($meta['label']); ?></span>
                                                                            <span
                                                                                style="font-size:.78rem;color:#6b7280"><?php echo e($meta['desc']); ?></span>

                                                                            
                                                                            <?php if($firstLog): ?>
                                                                                <span
                                                                                    style="font-size:.75rem;color:#9ca3af">
                                                                                    <?php echo e($firstLog->actor_label); ?>

                                                                                    •
                                                                                    <?php echo e($firstLog->created_at->format('H:i d/m/Y')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>

                                                                    <?php if($sid < count($stepMeta)): ?>
                                                                        <span
                                                                            class="bar <?php echo e($sid < $activeStep ? 'active' : ''); ?>"></span>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>

                                                        </div>


                           <div style="text-align:right">
                            <span class="tag <?php echo e($tagClass); ?>"><?php echo e($statusName); ?></span>
                            <div class="order-tools">
                              
<?php if(in_array($order->order_status_id, [1, 2])): ?>
    <form id="cancel-order-form" method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>">
        <?php echo csrf_field(); ?>
        <button 
            class="btn-danger-outline" 
            type="button" 
            id="btnOpenCancelModal"
            style="cursor:pointer; border-radius: 999px; padding: 8px 16px; font-weight: 600;"
        >
            <i class="fa fa-times-circle"></i> Hủy đơn hàng
        </button>
        
        
        <div class="cancel-order-overlay" id="cancelOrderOverlay">
            <div class="cancel-order-modal" style="text-align: left; max-width: 500px;">
                <h3 style="text-align: center">Yêu cầu hủy đơn hàng</h3>
                <p style="text-align: center">Vui lòng cho biết lý do bạn muốn hủy đơn này.</p>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; display: block; margin-bottom: 5px;">Lý do hủy <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="3" placeholder="Ví dụ: Tôi muốn đổi địa chỉ, đổi sản phẩm khác..." style="width: 100%; border-radius: 8px; border: 1px solid #ddd; padding: 10px;"></textarea>
                    <div id="err_reason" class="error-msg text-danger" style="display:none; font-size: 12px; margin-top: 5px;"></div>
                </div>

                
                <?php if($pMethodId !== 1 && in_array($pStatusId, [2, 3])): ?>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600; display: block; margin-bottom: 5px;">Tài khoản nhận lại tiền <span class="text-danger">*</span></label>
                        <select name="user_bank_account_id" id="selectBank" class="form-select" style="width: 100%; padding: 8px; border-radius: 8px; border: 1px solid #ddd;">
                            <option value="">-- Chọn tài khoản của bạn --</option>
                            <?php $__currentLoopData = Auth::user()->bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($bank->id); ?>" 
                                    data-name="<?php echo e($bank->bank_name); ?>" 
                                    data-number="<?php echo e($bank->account_number); ?>" 
                                    data-holder="<?php echo e($bank->account_holder); ?>">
                                    <?php echo e($bank->bank_name); ?> - <?php echo e($bank->account_number); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <option value="new">+ Thêm tài khoản mới</option>
                        </select>
                        <div id="err_user_bank_account_id" class="error-msg text-danger" style="display:none; font-size: 12px; margin-top: 5px;"></div>
                    </div>

                    <div id="newBankFields" style="display: none; background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #eee;">
                        <div style="margin-bottom: 10px;">
                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Tên ngân hàng (ví dụ: VCB, MB...)" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ddd;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <input type="text" name="account_number" id="account_number" class="form-control" placeholder="Số tài khoản" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ddd;">
                        </div>
                        <div>
                            <input type="text" name="account_holder" id="account_holder" class="form-control" placeholder="Tên chủ tài khoản (viết hoa không dấu)" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ddd;">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="cancel-order-actions" style="margin-top: 20px;">
                    <button type="button" class="btn-cancel-close" id="btnCancelClose">Để tôi xem lại</button>
                    <button type="button" class="btn-cancel-ok" id="btnCancelOk">Xác nhận hủy</button>
                </div>
            </div>
        </div>
    </form>
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
                                                                        $hasReturnRequest = \App\Models\OrderReturn::where(
                                                                            'order_id',
                                                                            $order->id,
                                                                        )->exists();
                                                                    ?>
                                                                    <?php if(!$hasReturnRequest): ?>
                                                                        <button type="button"
                                                                            onclick="window.location.href='<?php echo e(route('orders.return.create', $order->id)); ?>'"
                                                                            class="btn-return" title="Yêu cầu hoàn hàng">
                                                                            Yêu cầu hoàn hàng
                                                                        </button>
                                                                    <?php else: ?>
                                                                        <span class="btn-return disabled"
                                                                            title="Đã gửi yêu cầu hoàn hàng">
                                                                            Đã gửi yêu cầu hoàn hàng
                                                                        </span>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if($order->order_status_id == 7 || \App\Models\OrderReturn::where('order_id', $order->id)->exists()): ?>
                                                                    <?php
                                                                        $returnRequest = \App\Models\OrderReturn::where(
                                                                            'order_id',
                                                                            $order->id,
                                                                        )->first();
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
                                                                                        <span
                                                                                            class="status-badge <?php echo e($statusClass); ?>">
                                                                                            <?php echo e($order->status?->name ?? '—'); ?>

                                                                                        </span>
                                                                                    </span>
                                                                                </div>

                                                                                
                                                                                <?php if($order->cancelRequest): ?>
                                                                                    <div class="sum-row">
                                                                                        <span>Trạng thái hủy hàng</span>
                                                                                        <span>
                                                                                            <?php
                                                                                                $rStatusId =
                                                                                                    (int) $order
                                                                                                        ->cancelRequest
                                                                                                        ->status_id;
                                                                                                $refundClass = match (
                                                                                                    $rStatusId
                                                                                                ) {
                                                                                                    1
                                                                                                        => 'badge-warning text-dark',
                                                                                                    2
                                                                                                        => 'badge-primary',
                                                                                                    3 => 'badge-danger',
                                                                                                    4
                                                                                                        => 'badge-success',
                                                                                                    default
                                                                                                        => 'badge-secondary',
                                                                                                };
                                                                                                $refundName = match (
                                                                                                    $rStatusId
                                                                                                ) {
                                                                                                    1 => 'Chờ xử lý',
                                                                                                    2 => 'Đã chấp nhận',
                                                                                                    3 => 'Đã từ chối',
                                                                                                    4 => 'Đã hoàn tiền',
                                                                                                    default
                                                                                                        => 'Đang xử lý',
                                                                                                };
                                                                                            ?>
                                                                                            <span
                                                                                                class="status-badge <?php echo e($refundClass); ?>">
                                                                                                <?php echo e($refundName); ?>

                                                                                            </span>
                                                                                        </span>
                                                                                    </div>

                                                                                    
                                                                                    <?php if($order->cancelRequest->refund_image): ?>
                                                                                        <div class="sum-row"
                                                                                            style="flex-direction: column; align-items: stretch; gap: 10px; background: #f0fdf4; border: 1px solid #bcf0da; padding: 12px; border-radius: 8px; margin-top: 10px;">
                                                                                            <div
                                                                                                style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                                                                                <span
                                                                                                    style="font-weight: 600; color: #065f46; font-size: 0.9rem;">
                                                                                                    <i
                                                                                                        class="fas fa-file-invoice-dollar me-1"></i>
                                                                                                    Minh chứng hoàn tiền
                                                                                                </span>
                                                                                                <a href="<?php echo e(asset('storage/refunds/' . $order->cancelRequest->refund_image)); ?>"
                                                                                                    target="_blank"
                                                                                                    class="text-success"
                                                                                                    style="text-decoration: underline; font-size: 0.85rem; font-weight: 600;">
                                                                                                    <i
                                                                                                        class="fas fa-external-link-alt me-1"></i>
                                                                                                    Xem ảnh
                                                                                                </a>
                                                                                            </div>

                                                                                            <div id="refund-action-area"
                                                                                                style="text-align: right;">
                                                                                                <?php
                                                                                                    $isConfirmed =
                                                                                                        (bool) $order
                                                                                                            ->cancelRequest
                                                                                                            ->is_customer_confirmed;
                                                                                                ?>

                                                                                                <?php if($rStatusId === 4 && !$isConfirmed): ?>
                                                                                                    <button type="button"
                                                                                                        id="btnOpenConfirmMoney"
                                                                                                        class="btn-complete"
                                                                                                        style="padding: 6px 12px; font-size: 12px; background: #059669; color: white; border: none; border-radius: 4px;">
                                                                                                        Xác nhận nhận tiền
                                                                                                    </button>
                                                                                                <?php elseif($isConfirmed): ?>
                                                                                                    <span
                                                                                                        class="badge bg-success"
                                                                                                        style="padding: 6px 12px; border-radius: 999px; font-size: 11px;">
                                                                                                        <i
                                                                                                            class="fas fa-check-circle"></i>
                                                                                                        Bạn đã xác nhận
                                                                                                    </span>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>

                                                                                <hr class="my-3">

                                                                                
                                                                                <div class="sum-row">
                                                                                    <span>Trạng thái thanh toán</span>
                                                                                    <span>
                                                                                        <span
                                                                                            class="status-badge <?php echo e($payClass); ?>">
                                                                                            <?php echo e($payLabel); ?>

                                                                                        </span>
                                                                                    </span>
                                                                                </div>

                                                                                <div class="sum-row">
                                                                                    <span>Phương thức thanh toán</span>
                                                                                    <span><?php echo e($order->paymentMethod?->name ?? '—'); ?></span>
                                                                                </div>

                                                                                <div class="sum-row">
                                                                                    <span>Thời gian đặt</span>
                                                                                    <span><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('H:i, d/m/Y')); ?></span>
                                                                                </div>

                                                                                <div class="sum-row">
                                                                                    <span>Thời gian hủy</span>
                                                                                    <span style="text-align: right;">
                                                                                        <?php if($order->cancelRequest && $order->cancelRequest->status_id != 3): ?>
                                                                                            <div
                                                                                                style="font-size: 0.85em; color: #7f8c8d; font-style: italic;">
                                                                                                <?php echo e(\Carbon\Carbon::parse($order->cancelRequest->created_at)->format('H:i - d/m/Y')); ?>

                                                                                            </div>
                                                                                        <?php else: ?>
                                                                                            <span
                                                                                                class="text-muted">—</span>
                                                                                        <?php endif; ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        
                                                                        
<div class="card">
    <div class="card-hd" style="text-align: left; font-weight: 700;">Thông tin người nhận</div>
    <div class="card-bd pt-2" style="text-align: left !important;">
        <p class="mb-1" style="text-align: left; margin-left: 0; color: #000;">
            <strong style="font-weight: 700;">Họ tên:</strong>
            <span><?php echo e($order->name); ?></span>
        </p>

        <p class="mb-1" style="text-align: left; margin-left: 0; color: #000;">
            <strong style="font-weight: 700;">Điện thoại:</strong>
            <span><?php echo e($order->phone); ?></span>
        </p>

        <p class="mb-1" style="text-align: left; margin-left: 0; color: #000;">
            <strong style="font-weight: 700;">Địa chỉ:</strong>
            <span><?php echo e($order->address); ?></span>
        </p>

        <?php if($order->user?->email): ?>
            <p class="mb-1" style="text-align: left; margin-left: 0; color: #000;">
                <strong style="font-weight: 700;">Email:</strong>
                <a href="mailto:<?php echo e($order->user->email); ?>" style="color: inherit; text-decoration: underline;">
                    <?php echo e($order->user->email); ?>

                </a>
            </p>
        <?php endif; ?>

        <?php if($order->note): ?>
            <p class="mt-2" style="text-align: left; margin-left: 0; color: #000;">
                <strong style="font-weight: 700;">Ghi chú:</strong>
                <span><?php echo e($order->note); ?></span>
            </p>
        <?php endif; ?>
    </div>
</div>
                                                                    </div>
                                                                </div>

                                                                
                                                                <div class="complete-order-overlay"
                                                                    id="confirmMoneyOverlay"
                                                                    style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                                                                    <div class="cancel-order-modal"
                                                                        style="background: white; padding: 24px; border-radius: 12px; max-width: 400px; width: 90%; text-align: center;">
                                                                        <div
                                                                            style="color: #059669; font-size: 2.5rem; margin-bottom: 15px;">
                                                                            <i class="fas fa-hand-holding-usd"></i>
                                                                        </div>
                                                                        <h3
                                                                            style="color: #059669; font-size: 1.2rem; font-weight: 700;">
                                                                            Xác nhận nhận tiền</h3>
                                                                        <p
                                                                            style="font-size: 14px; color: #4b5563; margin-bottom: 20px;">
                                                                            Bạn xác nhận đã nhận đủ số tiền hoàn lại thông
                                                                            qua tài khoản ngân hàng?
                                                                        </p>
                                                                        <div class="cancel-order-actions"
                                                                            style="display: flex; gap: 10px; justify-content: center;">
                                                                            <button type="button"
                                                                                class="btn-cancel-close"
                                                                                id="btnConfirmMoneyClose"
                                                                                style="padding: 8px 16px; border: 1px solid #ddd; border-radius: 6px;">Kiểm
                                                                                tra lại</button>
                                                                            <button type="button" class="btn-cancel-ok"
                                                                                id="btnConfirmMoneyOk"
                                                                                style="padding: 8px 16px; background: #059669; color: white; border: none; border-radius: 6px; font-weight: 600;">Đã
                                                                                nhận được</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                
                                                                <section class="woocommerce-order-details card"
                                                                    style="margin-top:18px">
                                                                    <div class="card-hd">Chi tiết đơn hàng</div>
                                                                    <div class="card-bd" style="padding:0">
                                                                        <table
                                                                            class="woocommerce-table woocommerce-table--order-details shop_table order_details"
                                                                            style="margin:0">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="width:60px">STT</th>
                                                                                    <th class="product-name">Sản phẩm</th>
                                                                                    <th class="product-quantity"
                                                                                        style="width:90px">SL</th>
                                                                                    <th class="product-total"
                                                                                        style="width:150px">Thành tiền</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <tr class="order_item">
                                                                                        <td style="text-align:center">
                                                                                            <?php echo e($loop->iteration); ?></td>
                                                                                        <td class="product-name">
                                                                                            <div
                                                                                                style="display:flex; gap:12px; align-items:center">
                                                                                                


                                                                                                <strong><?php echo e($it->product_name); ?></strong>
                                                                                                <div class="meta">
                                                                                                    <?php if($it->variant_text): ?>
                                                                                                        <?php echo e($it->variant_text); ?>

                                                                                                        ·
                                                                                                    <?php endif; ?>
                                                                                                    Đơn giá:
                                                                                                    ₫<?php echo e(number_format($it->unit_price)); ?>

                                                                                                    <?php if($it->eta): ?>
                                                                                                        · Dự kiến:
                                                                                                        <?php echo e(\Carbon\Carbon::parse($it->eta)->format('d/m')); ?>

                                                                                                    <?php endif; ?>
                                                                                                </div>
                                                                                            </div>
                                                                    </div>
                                                                    </td>
                                                                    <td class="product-quantity"
                                                                        style="text-align:center"><?php echo e($it->qty); ?></td>
                                                                    <td class="product-total" style="text-align:right">
                                                                        <span class="woocommerce-Price-amount amount">
                                                                            <span
                                                                                class="woocommerce-Price-currencySymbol">₫</span><?php echo e(number_format($it->line_total)); ?>

                                                                        </span>
                                                                    </td>
                                                                    </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tbody>
                                                                    </table>
                                                            </div>
                                                            </section>

<div class="order-bottom container-fluid mt-4">
    <div class="row">
        
        
        <div class="col-md-7 col-12 order-bottom-left">
            <?php if($order->order_status_id == 5): ?>
                <h2 class="h5 mb-4 font-weight-bold">Sản phẩm cần đánh giá</h2>
                <div class="review-list">
                    <?php
                        /** * 1. Lọc sản phẩm duy nhất dựa trên ID sản phẩm gốc (product->id)
                         * Vì bảng của bạn dùng product_variant_id, ta phải trỏ qua quan hệ product
                         */
                        $uniqueDetails = $order->details->unique(function($item) {
                            return $item->product->id;
                        });
                    ?>

                    <?php $__currentLoopData = $uniqueDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-review-item d-flex justify-content-between align-items-center mb-3 p-3 border rounded bg-white shadow-sm">
                            <div class="product-info">
                                <strong class="d-block text-dark"><?php echo e($detail->product->name ?? 'Sản phẩm không rõ'); ?></strong>
                                <small class="text-muted">Đơn hàng #<?php echo e($order->order_code); ?></small>
                            </div>

                            <?php
                                /** * 2. Kiểm tra tồn tại đánh giá: 
                                 * Phải tìm theo product_id (ID sản phẩm gốc) thay vì biến thể
                                 */
                                $existingReview = \App\Models\Review::where('order_id', $order->id)
                                    ->where('product_id', $detail->product->id)
                                    ->first();
                            ?>

                            <div class="review-action">
                                <?php if($existingReview): ?>
                                    
                                    <span class="badge badge-success p-2" style="border-radius: 20px; background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;">
                                        <i class="fa fa-check-circle"></i> Đã hoàn thành đánh giá
                                    </span>
                                <?php else: ?>
                                    
                                    <a href="<?php echo e(route('review.create', ['order_id' => $order->id, 'product_id' => $detail->product->id])); ?>"
                                       class="btn btn-sm btn-primary px-4" 
                                       style="border-radius: 999px; font-weight: 600; background-color: #3b82f6; border: none; color: white !important;">
                                       <i class="fa fa-star me-1" style="color: #fbbf24;"></i> Viết đánh giá
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="col-md-5 col-12">
            <div class="order-total-card card shadow-sm border-0">
                <div class="card-header bg-white font-weight-bold border-bottom-0 pt-3">
                    Tổng thanh toán
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính</span>
                        <span>₫<?php echo e(number_format($calc_subtotal)); ?>₫</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Phí vận chuyển</span>
                        <span>+ ₫<?php echo e(number_format($calc_shipping_fee ?? 0)); ?>₫</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span>Giảm giá</span>
                        <span>-<?php echo e(number_format($calc_discount ?? 0)); ?> ₫</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Voucher</span>
                        <span class="text-primary"><?php echo e($order->voucher->voucher_code ?? '_'); ?></span>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top font-weight-bold">
                        <span class="h6 font-weight-bold">Tổng thanh toán</span>
                        <span class="h5 text-danger font-weight-bold">₫<?php echo e(number_format($calc_total)); ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
                                                        
                                                        
<?php if($currentStatusId === 4): ?>
<div class="cancel-order-overlay" id="completeOrderOverlay">
    <div class="cancel-order-modal">
        <div style="color: #16a34a; font-size: 3rem; margin-bottom: 15px;">
            <i class="fa fa-check-circle"></i>
        </div>
        <h3>Xác nhận nhận hàng</h3>
        <p>Bạn xác nhận đã nhận được đầy đủ sản phẩm và hài lòng với đơn hàng này?</p>
        <div class="cancel-order-actions" style="justify-content: center;">
            <button type="button" class="btn-cancel-close" id="btnCompleteClose">Đóng</button>
            <button type="button" class="btn-cancel-ok" id="confirmCompleteBtn" style="background: #16a34a; border-color: #16a34a;">Xác nhận</button>
        </div>
    </div>
</div>
<?php endif; ?>
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
        // ==========================================
        // 1. XỬ LÝ MODAL HỦY ĐƠN HÀNG (GIỮ NGUYÊN)
        // ==========================================
        const cancelOverlay = document.getElementById('cancelOrderOverlay');
        const btnOpenCancel = document.getElementById('btnOpenCancelModal');
        const btnCloseCancel = document.getElementById('btnCancelClose');
        const btnOkCancel = document.getElementById('btnCancelOk');
        const cancelForm = document.getElementById('cancel-order-form');

        const selectBank = document.getElementById('selectBank');
        const newBankFields = document.getElementById('newBankFields');
        const inputBankName = document.getElementById('bank_name');
        const inputAccNumber = document.getElementById('account_number');
        const inputAccHolder = document.getElementById('account_holder');

        function showError(input, errorId, message) {
            if (!input) return;
            input.classList.add('is-invalid');
            const errorDiv = document.getElementById(errorId);
            if (errorDiv) {
                errorDiv.innerText = message;
                errorDiv.style.display = 'block';
            }
        }

        function clearErrors() {
            document.querySelectorAll('.error-msg').forEach(el => {
                el.innerText = '';
                el.style.display = 'none';
            });
            document.querySelectorAll('.form-control, .form-select, .is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
        }

        function updateBankInputs() {
            if (!selectBank || !newBankFields) return;
            const selectedOption = selectBank.options[selectBank.selectedIndex];

            if (selectBank.value === 'new') {
                newBankFields.style.display = 'block';
                if (inputBankName) {
                    inputBankName.value = '';
                    inputAccNumber.value = '';
                    inputAccHolder.value = '';
                    inputBankName.readOnly = false;
                    inputAccNumber.readOnly = false;
                    inputAccHolder.readOnly = false;
                }
            } else if (selectBank.value !== "") {
                newBankFields.style.display = 'none';
                if (inputBankName) {
                    inputBankName.value = selectedOption.dataset.name || '';
                    inputAccNumber.value = selectedOption.dataset.number || '';
                    inputAccHolder.value = selectedOption.dataset.holder || '';
                    inputBankName.readOnly = true;
                    inputAccNumber.readOnly = true;
                    inputAccHolder.readOnly = true;
                }
            } else {
                newBankFields.style.display = 'none';
            }
        }

        if (btnOpenCancel) {
            btnOpenCancel.addEventListener('click', () => {
                cancelOverlay.style.display = 'flex';
                clearErrors();
                updateBankInputs();
            });
        }
        if (btnCloseCancel) {
            btnCloseCancel.addEventListener('click', () => cancelOverlay.style.display = 'none');
        }

        if (selectBank) {
            selectBank.addEventListener('change', () => {
                clearErrors();
                updateBankInputs();
            });
        }

        if (btnOkCancel && cancelForm) {
            btnOkCancel.addEventListener('click', function(e) {
                e.preventDefault();
                let isValid = true;
                clearErrors();

                const reason = cancelForm.querySelector('textarea[name="reason"]');
                if (reason && !reason.value.trim()) {
                    showError(reason, 'err_reason', 'Vui lòng nhập lý do hủy đơn.');
                    isValid = false;
                } else if (reason && reason.value.trim().length < 10) {
                    showError(reason, 'err_reason', 'Lý do quá ngắn (tối thiểu 10 ký tự).');
                    isValid = false;
                }

                if (selectBank && selectBank.value === "") {
                    showError(selectBank, 'err_user_bank_account_id',
                        'Vui lòng chọn tài khoản nhận tiền hoàn.');
                    isValid = false;
                }

                if (isValid) cancelForm.submit();
            });
        }

       // ==========================================
// 2. XỬ LÝ MODAL ĐÃ NHẬN HÀNG (DÙNG CUSTOM OVERLAY)
// ==========================================
const completeOverlay = document.getElementById('completeOrderOverlay');
const btnOpenComplete = document.getElementById('btnOpenCompleteModal');
const btnCloseComplete = document.getElementById('btnCompleteClose');
const btnConfirmComplete = document.getElementById('confirmCompleteBtn');
const completeForm = document.getElementById('complete-order-form');

if (btnOpenComplete && completeOverlay) {
    btnOpenComplete.addEventListener('click', function(e) {
        e.preventDefault();
        completeOverlay.style.display = 'flex'; // Hiện modal
    });
}

if (btnCloseComplete) {
    btnCloseComplete.addEventListener('click', function() {
        completeOverlay.style.display = 'none'; // Đóng modal
    });
}

if (btnConfirmComplete && completeForm) {
    btnConfirmComplete.addEventListener('click', function() {
        btnConfirmComplete.disabled = true;
        btnConfirmComplete.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
        completeForm.submit();
    });
}

// Bổ sung: Click ra ngoài vùng modal để đóng
window.addEventListener('click', function(e) {
    if (e.target === completeOverlay) {
        completeOverlay.style.display = 'none';
    }
});
        // ==========================================
        // 3. XỬ LÝ MODAL XÁC NHẬN NHẬN TIỀN (GIỮ NGUYÊN)
        // ==========================================
        const moneyOverlay = document.getElementById('confirmMoneyOverlay');
        const btnOpenMoney = document.getElementById('btnOpenConfirmMoney');
        const btnCloseMoney = document.getElementById('btnConfirmMoneyClose');
        const btnOkMoney = document.getElementById('btnConfirmMoneyOk');

        if (btnOpenMoney) {
            btnOpenMoney.addEventListener('click', function(e) {
                e.preventDefault();
                if (moneyOverlay) moneyOverlay.style.display = 'flex';
            });
        }

        if (btnCloseMoney) {
            btnCloseMoney.addEventListener('click', function() {
                moneyOverlay.style.display = 'none';
            });
        }

        if (btnOkMoney) {
            btnOkMoney.addEventListener('click', function() {
                const btn = this;
                btn.disabled = true;
                btn.innerText = 'Đang xử lý...';

                fetch("<?php echo e(route('orders.cancel.confirm_received', $order->id)); ?>", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            moneyOverlay.style.display = 'none';
                            const actionArea = document.getElementById('refund-action-area');
                            if (actionArea) {
                                actionArea.innerHTML = `
                <span class="badge" style="background: #d1fae5; color: #065f46; padding: 6px 12px; border-radius: 999px; font-size: 12px; border: 1px solid #059669;">
                    <i class="fas fa-check-circle me-1"></i> Bạn đã xác nhận nhận tiền
                </span>
            `;
                            }
                            const dots = document.querySelectorAll('.order-progress .dot');
                            const bars = document.querySelectorAll('.order-progress .bar');
                            dots.forEach((dot, index) => {
                                if (index < 5) dot.classList.add('active');
                            });
                            bars.forEach((bar, index) => {
                                if (index < 4) bar.classList.add('active');
                            });
                        } else {
                            alert(data.message || 'Có lỗi xảy ra!');
                            btn.disabled = false;
                            btn.innerText = 'Đã nhận được';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Lỗi kết nối hệ thống!');
                        btn.disabled = false;
                        btn.innerText = 'Đã nhận được';
                    });
            });
        }

        // ==========================================
        // ĐÓNG MODAL KHI CLICK RA NGOÀI VÙNG XÁM (GIỮ NGUYÊN)
        // ==========================================
        window.addEventListener('click', (e) => {
            if (e.target === cancelOverlay) cancelOverlay.style.display = 'none';
            if (e.target === moneyOverlay) moneyOverlay.style.display = 'none';
        });
    });
</script>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/orders/show.blade.php ENDPATH**/ ?>