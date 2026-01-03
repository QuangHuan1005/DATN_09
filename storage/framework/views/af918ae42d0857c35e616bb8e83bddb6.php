<?php $__env->startSection('content'); ?>

<body class="wp-singular page-template-fullwidth woocommerce-account woocommerce-page woocommerce-orders ltr" data-elementor-device-mode="laptop">
  <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

  <div class="site-wrapper">
    <div class="kitify-site-wrapper elementor-459kitify">
      <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <div id="site-content" class="site-content-wrapper">
        <div class="container py-4">
          <div class="grid-x">
            <div class="cell small-12">
              <div class="site-content">
                
                <div class="page-header-content mb-4">
                  <nav class="woocommerce-breadcrumb">
                    <a href="<?php echo e(url('/')); ?>">Home</a><span class="delimiter">/</span>
                    <a href="<?php echo e(route('account.dashboard')); ?>">My account</a><span class="delimiter">/</span>Orders
                  </nav>
                  <h1 class="page-title" style="font-size: 28px; font-weight: 700;">Đơn hàng của tôi</h1>
                </div>

                <article class="hentry">
                  <div class="entry-content">
                    <style>
                      body.woocommerce-account.woocommerce-page #site-content.site-content-wrapper{ padding-top: 10px !important; }
                      .woocommerce-account .woocommerce{ display: flex; gap: 30px; margin-top: 10px; }
                      .woocommerce-MyAccount-navigation{ flex: 0 0 250px; background: #fff; border-radius: 12px; }
                      .woocommerce-MyAccount-content{ flex: 1; background: #fff; border-radius: 12px; }
                      
                      /* Table Layout */
                      .account-orders-table{ width:100%; border-collapse: separate; border-spacing: 0; border: 1px solid #f0f2f5; border-radius: 12px; overflow: hidden; }
                      .account-orders-table thead th{ background:#f8fafc; font-weight:600; padding:16px; text-align: left; font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
                      .account-orders-table tbody td{ padding:16px; vertical-align:middle; border-top:1px solid #f1f5f9; font-size: 14px; }
                      
                      /* Badges */
                      .badge{ display:inline-flex; align-items:center; gap:.4rem; padding:.4rem .8rem; border-radius:8px; font-size:.75rem; font-weight:700 }
                      .badge::before{content:""; width:6px; height:6px; border-radius:50%; background:currentColor; opacity:.85}
                      .badge-processing{background:#eaf3ff;color:#1d4ed8}
                      .badge-shipping{background:#e9fdf4;color:#047857}
                      .badge-completed{background:#eafaf0;color:#166534}
                      .badge-cancelled{background:#fff1f1;color:#b91c1c}
                      .badge-on-hold{background:#fff6ea;color:#9a3412}
                      .badge-refunded{background:#f3efff;color:#6d28d9}
                      
                      .method-pill{ display:inline-block; padding:.2rem .6rem; border-radius:6px; font-size:.7rem; background:#f1f5f9; color:#475569; font-weight:600; border: 1px solid #e2e8f0; }
                      
                      /* Toolbar */
                      .orders-header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px; flex-wrap: wrap; }
                      .orders-search-box { position: relative; flex: 1; max-width: 400px; }
                      .orders-search-box input { width: 100%; padding: 10px 15px 10px 40px !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important; font-size: 14px; }
                      .orders-search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
                      .orders-select { padding: 10px 35px 10px 15px !important; border-radius: 10px !important; border: 1px solid #e2e8f0 !important; background-color: #fff !important; font-size: 14px; min-width: 200px; }

                      /* Button Repay */
                      .btn-repay { background: #2563eb; color: #fff !important; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s; margin-top: 8px; text-decoration: none; }
                      .btn-repay:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
                      .expired-label { font-size: 11px; color: #94a3b8; font-style: italic; margin-top: 5px; display: block; }

                      /* Countdown Timer CSS */
                      .repay-timer { font-size: 11px; color: #ef4444; font-weight: 700; margin-top: 4px; display: flex; align-items: center; gap: 3px; }
                    </style>

                    <div class="woocommerce">
                      <?php echo $__env->make('account.partials.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                      <div class="woocommerce-MyAccount-content">
                        
                        <div class="woocommerce-notices-wrapper">
                          <?php if(session('error')): ?> <div class="woocommerce-error" style="background: #fef2f2; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px;"><?php echo e(session('error')); ?></div> <?php endif; ?>
                          <?php if(session('success')): ?> <div class="woocommerce-message" style="background: #ecfdf5; color: #059669; padding: 15px; border-radius: 8px; margin-bottom: 20px;"><?php echo e(session('success')); ?></div> <?php endif; ?>
                        </div>

                        
                        <div class="orders-header-bar">
                          <div class="orders-search-box">
                            <i class="iconify" data-icon="solar:magnifer-linear"></i>
                            <form method="GET" action="<?php echo e(route('orders.index')); ?>">
                                <input type="text" name="keyword" placeholder="Tìm theo mã đơn hàng..." value="<?php echo e(request('keyword')); ?>">
                            </form>
                          </div>
                          
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
                          <div class="text-center py-5" style="background: #f8fafc; border-radius: 12px; border: 2px dashed #e2e8f0;">
                            <iconify-icon icon="solar:box-minimalistic-linear" style="font-size: 64px; color: #94a3b8;"></iconify-icon>
                            <p class="text-muted mt-3">Không tìm thấy đơn hàng nào phù hợp.</p>
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-sm rounded-pill px-4">Mua sắm ngay</a>
                          </div>
                        <?php else: ?>
                          <table class="account-orders-table">
                            <thead>
                              <tr>
                                <th>Mã đơn</th>
                                <th>Ngày mua</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th>Phương thức</th>
                                <th>Tổng cộng</th>
                                <th class="text-center">Hành động</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                  $orderCls = match((int)$order->order_status_id){
                                      1 => 'badge-on-hold', 2 => 'badge-processing', 3 => 'badge-shipping',
                                      4, 5 => 'badge-completed', 6 => 'badge-cancelled', 7 => 'badge-refunded',
                                      default => 'badge-default'
                                  };
                                  $pStatusId = (int)$order->payment_status_id;
                                  $payCls = ($pStatusId === 2) ? 'badge-completed' : (($pStatusId === 3) ? 'badge-refunded' : 'badge-on-hold');
                                  $payLabel = $order->paymentStatus->name ?? ($pStatusId === 2 ? 'Đã thanh toán' : 'Chưa thanh toán');

                                  // Logic đếm ngược: 30 phút từ lúc tạo đơn
                                  $remainingSeconds = 0;
                                  if ($order->payment_method_id == 2 && $pStatusId != 2 && $order->order_status_id == 1) {
                                      $expiryTime = $order->created_at->addMinutes(30);
                                      $remainingSeconds = now()->diffInSeconds($expiryTime, false);
                                  }
                                ?>
                                <tr>
                                  <td class="fw-bold">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" style="color: #2563eb;">#<?php echo e($order->order_code); ?></a>
                                  </td>
                                  <td>
                                    <div class="text-dark"><?php echo e($order->created_at->format('d/m/Y')); ?></div>
                                    <div class="text-muted small"><?php echo e($order->created_at->format('H:i')); ?></div>
                                  </td>
                                  <td><span class="badge <?php echo e($orderCls); ?>"><?php echo e($order->status->name ?? '—'); ?></span></td>
                                  <td>
                                    <span class="badge <?php echo e($payCls); ?>"><?php echo e($payLabel); ?></span>
                                    
                                    
                                    <?php if($remainingSeconds > 0): ?>
                                      <a href="<?php echo e(route('orders.repay', $order->order_code)); ?>" class="btn-repay">
                                        <iconify-icon icon="solar:card-send-bold"></iconify-icon> Thanh toán ngay
                                      </a>
                                      <div class="repay-timer" data-seconds="<?php echo e($remainingSeconds); ?>">
                                        <iconify-icon icon="solar:history-linear"></iconify-icon>
                                        <span class="timer-text">--:--</span>
                                      </div>
                                    <?php elseif($order->order_status_id == 6 && $order->payment_method_id == 2 && $pStatusId != 2): ?>
                                      <span class="expired-label">Hết hạn thanh toán</span>
                                    <?php endif; ?>
                                  </td>
                                  <td><span class="method-pill"><?php echo e($order->paymentMethod->name ?? '—'); ?></span></td>
                                  <td class="fw-bold text-dark"><?php echo e(number_format($order->total_amount)); ?>₫</td>
                                  <td class="text-center">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn-view-order">
                                      <iconify-icon icon="solar:eye-broken" style="font-size:22px; color:#64748b"></iconify-icon>
                                    </a>
                                  </td>
                                </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                          
                          <div class="d-flex justify-content-center mt-4">
                            <?php echo e($orders->links()); ?>

                          </div>
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

  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('.repay-timer');
        
        timers.forEach(timer => {
            let secondsLeft = parseInt(timer.getAttribute('data-seconds'));
            const display = timer.querySelector('.timer-text');

            function updateDisplay() {
                if (secondsLeft <= 0) {
                    display.innerText = "Hết hạn";
                    timer.style.color = "#94a3b8";
                    // Tùy chọn: Tự động load lại trang khi hết hạn để cập nhật trạng thái "Hủy"
                    // location.reload(); 
                    return;
                }

                const minutes = Math.floor(secondsLeft / 60);
                const seconds = secondsLeft % 60;
                display.innerText = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                
                secondsLeft--;
                setTimeout(updateDisplay, 1000);
            }

            updateDisplay();
        });
    });
  </script>
</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/orders/index.blade.php ENDPATH**/ ?>