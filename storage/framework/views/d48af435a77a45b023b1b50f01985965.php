<?php $__env->startSection('content'); ?>

<body
  class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-orders woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
  data-elementor-device-mode="laptop">
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
                    <a href="<?php echo e(route('orders.index')); ?>">My account</a><span class="delimiter">/</span>Orders
                  </nav>
                  <h1 class="page-title">My account</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">

                    <?php
                    // map trạng thái ĐƠN HÀNG -> class badge
                    $orderBadgeClass = function($sid) {
                        return match((int)$sid){
                            1 => 'badge-on-hold',     // Chờ xác nhận
                            2 => 'badge-processing',  // Xác nhận
                            3 => 'badge-shipping',    // Đang giao
                            4,5 => 'badge-completed', // Đã giao / Hoàn thành
                            6 => 'badge-cancelled',   // Hủy
                            7 => 'badge-refunded',    // Hoàn hàng
                            default => 'badge-default'
                        };
                    };
                    // map trạng thái THANH TOÁN -> class badge
                    $payBadgeClass = function($pid) {
                        return match((int)$pid){
                            1 => 'badge-on-hold',     // Chưa thanh toán
                            2 => 'badge-completed',   // Đã thanh toán
                            3 => 'badge-refunded',    // Hoàn tiền
                            default => 'badge-default'
                        };
                    };
                    // fallback label nếu chưa eager-load quan hệ
                    $paymentStatusMap = [1=>'Chưa thanh toán', 2=>'Đã thanh toán', 3=>'Hoàn tiền'];
                    $paymentMethodMap = [1=>'Thanh toán khi nhận hàng', 2=>'VNPAY', 3=>'MoMo'];
                    ?>

                   <style>
                    /* ==== 1. GIẢM KHOẢNG TRẮNG TỪ HEADER XUỐNG ==== */
                    body.woocommerce-account.woocommerce-page #site-content.site-content-wrapper{
                      padding-top: 0px !important;   /* thay vì 40–80px của theme */
                      margin-top: 0 !important;
                    }

                    body.woocommerce-account.woocommerce-page .site-content{
                      padding-top: 0 !important;
                      margin-top: 0 !important;
                    }

                    body.woocommerce-account.woocommerce-page .page-header-content{
                      padding-top: 0px !important;
                      padding-bottom: 8px !important;
                      margin-top: 0 !important;
                      margin-bottom: 0px !important;  /* sát xuống danh sách hơn */
                    }

                    body.woocommerce-account.woocommerce-page .page-header-content .page-title{
                      margin-top: 4px !important;
                      margin-bottom: 0 !important;
                    }

                    /* ==== 2. GIẢM KHOẢNG TRẮNG GIỮA TIÊU ĐỀ & DANH SÁCH ==== */
                    body.woocommerce-account.woocommerce-page .entry-content > .woocommerce{
                      margin-top: 0 !important;
                    }

                    /* ==== 3. LAYOUT NAV + CONTENT (không liên quan khoảng trắng trên nhưng cho chuẩn) ==== */
                    @media (min-width: 992px){
                      .woocommerce-account .entry-content > .woocommerce{
                        max-width: none;
                      }

                      .woocommerce-account .woocommerce{
                        display: flex;
                        align-items: flex-start;
                        gap: 32px;
                      }

                      .woocommerce-account .woocommerce-MyAccount-navigation{
                        flex: 0 0 230px;
                      }

                      .woocommerce-account .woocommerce-MyAccount-content{
                        flex: 1;
                        margin: 0;
                        max-width: none;
                      }
                    }

                    /* ========= POLISH: Filter select ========= */
                    .orders-filter-select-wrap{ display:flex; justify-content:flex-end; margin:0 0 12px; }
                    .orders-select{
                        appearance:none; -webkit-appearance:none; -moz-appearance:none;
                        padding:10px 38px 10px 14px; border:1px solid #e5e7eb; border-radius:999px;
                        background:#fff url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6 8l4 4 4-4" stroke="%236b7280" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>') no-repeat right 12px center/16px;
                        font-size:.95rem; color:#111827; cursor:pointer;
                        box-shadow:0 1px 0 rgba(17,24,39,.04);
                    }
                    .orders-select:focus{ outline:none; border-color:#111827; box-shadow:0 0 0 3px rgba(17,24,39,.06); }

                    /* ========= POLISH: Table as clean card ========= */
                    .account-orders-table{ border:1px solid #eceff3; border-radius:12px; overflow:hidden; background:#fff; width:100%; }
                    .account-orders-table thead th{ background:#fafafa; font-weight:600; letter-spacing:.2px; padding:14px 16px; }
                    .account-orders-table tbody td,
                    .account-orders-table tbody th{ padding:14px 16px; vertical-align:middle; border-top:1px solid #f2f4f6; }
                    .account-orders-table tbody tr{ transition:background .15s ease, transform .05s ease; }
                    .account-orders-table tbody tr:hover{ background:#fcfcfd; }

                    /* ========= POLISH: Badges ========= */
                    .badge{ display:inline-flex; align-items:center; gap:.4rem; padding:.25rem .6rem; border-radius:999px; font-size:.78rem; font-weight:700 }
                    .badge::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor; opacity:.85}
                    .badge-processing{background:#eaf3ff;color:#1d4ed8}
                    .badge-shipping{background:#e9fdf4;color:#047857}
                    .badge-completed{background:#eafaf0;color:#166534}
                    .badge-cancelled{background:#fff1f1;color:#b91c1c}
                    .badge-on-hold{background:#fff6ea;color:#9a3412}
                    .badge-refunded{background:#f3efff;color:#6d28d9}
                    .badge-default{background:#f3f4f6;color:#374151}

                    /* ========= POLISH: Method pill ========= */
                    .method-pill{ display:inline-block; margin-left:8px; padding:.12rem .5rem; border-radius:999px; font-size:.72rem; background:#f3f4f6; color:#374151; font-weight:600 }

                    /* ========= POLISH: Order code / amount ========= */
                    .woocommerce-orders-table__cell-order-number a{ font-weight:700; text-decoration:none; }
                    .woocommerce-orders-table__cell-order-number a:hover{ text-decoration:underline; }
                    .woocommerce-orders-table__cell-order-total .amount{ font-weight:700; }

                    /* ========= POLISH: Action button ========= */
                    .woocommerce-orders-table__cell-order-actions .button.view{
                      display:inline-flex; align-items:center; gap:6px;
                      padding:8px 12px; border-radius:8px; border:1px solid #e5e7eb;
                      text-decoration:none; font-weight:600;
                    }
                    .woocommerce-orders-table__cell-order-actions .button.view:hover{
                      border-color:#111827; box-shadow:0 1px 0 rgba(17,24,39,.06);
                    }

                    /* ========= POLISH: Pagination ========= */
                    nav[role="navigation"] { display:flex; justify-content:center; margin-top:12px }
                    </style>


                    <div class="woocommerce">
                      <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                      <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper">
                          <?php if(session('error')): ?> <div class="woocommerce-error"><?php echo e(session('error')); ?></div> <?php endif; ?>
                          <?php if(session('success')): ?> <div class="woocommerce-message"><?php echo e(session('success')); ?></div> <?php endif; ?>
                        </div>

                        
                        <div class="orders-filter-select-wrap">
                          <form id="order-filter-form" method="GET" action="<?php echo e(route('orders.index')); ?>">
                            <select name="status_id" class="orders-select" onchange="this.form.submit()">
                              <option value="0" <?php echo e((int)$statusId === 0 ? 'selected' : ''); ?>>
                                Tất cả (<?php echo e($orders->total()); ?>)
                              </option>
                              <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st->id); ?>" <?php echo e((int)$statusId === (int)$st->id ? 'selected' : ''); ?>>
                                  <?php echo e($st->name); ?> (<?php echo e($counts[$st->id] ?? 0); ?>)
                                </option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </form>
                        </div>

                        
                        <?php if($orders->isEmpty()): ?>
                          <div class="woocommerce-info">
                            <?php if($statusId>0): ?>
                              Không có đơn ở trạng thái này.
                              <a class="woocommerce-Button wc-forward button" href="<?php echo e(route('orders.index')); ?>">Xem tất cả</a>
                            <?php else: ?>
                              Chưa có đơn hàng nào.
                              <a class="woocommerce-Button wc-forward button" href="<?php echo e(route('products.index')); ?>">Xem sản phẩm</a>
                            <?php endif; ?>
                          </div>
                        <?php else: ?>
                          <table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
                            <thead>
                              <tr>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number"><span class="nobr">Mã đơn hàng</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date"><span class="nobr">Ngày mua</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-status"><span class="nobr">Trạng thái đơn</span></th>
                                <th class="woocommerce-orders-table__header"><span class="nobr">Thanh toán</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-total"><span class="nobr">Tổng</span></th>
                                <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions"><span class="nobr">Hành động</span></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                  $itemsCount = optional($order->details)->sum('quantity') ?? 0;

                                  // order status
                                  $orderCls   = $orderBadgeClass($order->order_status_id);
                                  $orderLabel = $order->status?->name ?? '—';

                                  // payment status + method (fallback nếu chưa eager-load)
                                  $pStatusId  = (int)($order->payment_status_id ?? 0);
                                  $payCls     = $payBadgeClass($pStatusId);
                                  $payLabel   = $order->paymentStatus->name ?? ($paymentStatusMap[$pStatusId] ?? '—');

                                  $pmId       = (int)($order->payment_method_id ?? 0);
                                  $pmLabel    = $order->paymentMethod->name ?? ($paymentMethodMap[$pmId] ?? 'Không xác định');
                                ?>
                                <tr class="woocommerce-orders-table__row order">
                                  <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order" scope="row">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" aria-label="View order <?php echo e($order->order_code); ?>">
                                      #<?php echo e($order->order_code); ?>

                                    </a>
                                  </th>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date">
                                    <time datetime="<?php echo e(\Carbon\Carbon::parse($order->created_at)->toAtomString()); ?>">
                                      <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?>

                                    </time>
                                  </td>

                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-status" data-title="Order Status">
                                    <span class="badge <?php echo e($orderCls); ?>"><?php echo e($orderLabel); ?></span>
                                  </td>

                                  <td class="woocommerce-orders-table__cell" data-title="Payment">
                                    <span class="badge <?php echo e($payCls); ?>"><?php echo e($payLabel); ?></span>
                                    <span class="method-pill"><?php echo e($pmLabel); ?></span>
                                  </td>

                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-total" data-title="Total">
                                    <span class="woocommerce-Price-amount amount">
                                      <span class="woocommerce-Price-currencySymbol">₫</span><?php echo e(number_format($order->total_amount)); ?>

                                    </span>
                                    <?php if($itemsCount): ?> cho <?php echo e($itemsCount); ?> sản phẩm <?php endif; ?>
                                  </td>
                                  <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Actions">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="woocommerce-button button view" aria-label="View order <?php echo e($order->order_code); ?>">Xem</a>
                                  </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>

                          <div class="mt-3">
                            <?php echo e($orders->links()); ?>

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
    <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/orders/index.blade.php ENDPATH**/ ?>