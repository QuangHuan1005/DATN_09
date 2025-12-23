<?php $__env->startSection('content'); ?>

<body class="wp-singular page-template-fullwidth woocommerce-account woocommerce-page woocommerce-orders ltr" data-elementor-device-mode="laptop">
  <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

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
                  <h1 class="page-title">Đơn hàng của tôi</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">

                    <style>
                      /* Clean CSS */
                      body.woocommerce-account.woocommerce-page #site-content.site-content-wrapper{ padding-top: 0px !important; }
                      .woocommerce-account .woocommerce{ display: flex; align-items: flex-start; gap: 32px; margin-top: 20px; }
                      .woocommerce-MyAccount-navigation{ flex: 0 0 230px; }
                      .woocommerce-MyAccount-content{ flex: 1; }
                      .account-orders-table{ border:1px solid #eceff3; border-radius:12px; overflow:hidden; background:#fff; width:100%; border-collapse: collapse; }
                      .account-orders-table thead th{ background:#fafafa; font-weight:600; padding:14px 16px; text-align: left; }
                      .account-orders-table tbody td{ padding:14px 16px; vertical-align:middle; border-top:1px solid #f2f4f6; }
                      .badge{ display:inline-flex; align-items:center; gap:.4rem; padding:.25rem .6rem; border-radius:999px; font-size:.78rem; font-weight:700 }
                      .badge::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor; opacity:.85}
                      .badge-processing{background:#eaf3ff;color:#1d4ed8}
                      .badge-shipping{background:#e9fdf4;color:#047857}
                      .badge-completed{background:#eafaf0;color:#166534}
                      .badge-cancelled{background:#fff1f1;color:#b91c1c}
                      .badge-on-hold{background:#fff6ea;color:#9a3412}
                      .badge-refunded{background:#f3efff;color:#6d28d9}
                      .method-pill{ display:inline-block; padding:.12rem .5rem; border-radius:999px; font-size:.72rem; background:#f3f4f6; color:#374151; font-weight:600 }
                      .orders-filter-select-wrap{ display:flex; justify-content:flex-end; margin-bottom:15px; }
                      .orders-select{ padding:8px 30px 8px 15px; border-radius:20px; border:1px solid #ddd; appearance:none; background:#fff url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M6 8l4 4 4-4" stroke="%236b7280" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>') no-repeat right 12px center/16px; }
                    </style>

                    <div class="woocommerce">
                      <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                      <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper">
                          <?php if(session('error')): ?> <div class="woocommerce-error" style="color:red"><?php echo e(session('error')); ?></div> <?php endif; ?>
                          <?php if(session('success')): ?> <div class="woocommerce-message" style="color:green"><?php echo e(session('success')); ?></div> <?php endif; ?>
                        </div>

                        <div class="orders-filter-select-wrap">
                          <form method="GET" action="<?php echo e(route('orders.index')); ?>">
                            <select name="status_id" class="orders-select" onchange="this.form.submit()">
                              <option value="0" <?php echo e((int)$statusId === 0 ? 'selected' : ''); ?>>Tất cả đơn hàng</option>
                              <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($st->id); ?>" <?php echo e((int)$statusId === (int)$st->id ? 'selected' : ''); ?>><?php echo e($st->name); ?> (<?php echo e($counts[$st->id] ?? 0); ?>)</option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </form>
                        </div>

                        <?php if($orders->isEmpty()): ?>
                          <div class="woocommerce-info">Không có đơn hàng nào.</div>
                        <?php else: ?>
                          <table class="account-orders-table">
                            <thead>
                              <tr>
                                <th>Mã đơn</th>
                                <th>Ngày mua</th>
                                <th>Trạng thái đơn</th>
                                <th>Thanh toán</th>
                                <th>Phương thức</th>
                                <th>Tổng</th>
                                <th>Hành động</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                  // Logic Trạng thái đơn
                                  $orderCls = match((int)$order->order_status_id){
                                      1 => 'badge-on-hold', 2 => 'badge-processing', 3 => 'badge-shipping',
                                      4, 5 => 'badge-completed', 6 => 'badge-cancelled', 7 => 'badge-refunded',
                                      default => 'badge-default'
                                  };
                                  
                                  // Logic Thanh toán - Lấy chuẩn ID từ Database
                                  $pStatusId = (int)$order->payment_status_id;
                                  $payCls = ($pStatusId === 2) ? 'badge-completed' : (($pStatusId === 3) ? 'badge-refunded' : 'badge-on-hold');
                                  $payLabel = $order->paymentStatus->name ?? ($pStatusId === 2 ? 'Đã thanh toán' : 'Chưa thanh toán');
                                ?>
                                <tr>
                                  <td><a href="<?php echo e(route('orders.show', $order->id)); ?>">#<?php echo e($order->order_code); ?></a></td>
                                  <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                                  <td><span class="badge <?php echo e($orderCls); ?>"><?php echo e($order->status->name ?? '—'); ?></span></td>
                                  <td><span class="badge <?php echo e($payCls); ?>"><?php echo e($payLabel); ?></span></td>
                                  <td><span class="method-pill"><?php echo e($order->paymentMethod->name ?? '—'); ?></span></td>
                                  <td><?php echo e(number_format($order->total_amount)); ?>₫</td>
                                  <td>
                                    <div style="display:flex; gap:8px">
                                      <a href="<?php echo e(route('orders.show', $order->id)); ?>" title="Xem"><iconify-icon icon="solar:eye-broken" style="font-size:20px; color:#3b82f6"></iconify-icon></a>
                                    </div>
                                  </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                          <div style="margin-top:20px"><?php echo e($orders->links()); ?></div>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/orders/index.blade.php ENDPATH**/ ?>