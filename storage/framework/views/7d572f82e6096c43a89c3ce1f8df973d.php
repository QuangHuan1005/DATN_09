<?php $__env->startSection('content'); ?>

<body
  class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit"
  data-elementor-device-mode="laptop">

  <style>
    /* ====== cosmetic nâng cấp nhé ====== */
    .order-header{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;border:1px solid #e5e7eb;border-radius:12px;background:#fff}
    .order-header .meta{display:flex;flex-wrap:wrap;gap:12px;color:#6b7280;font-size:.92rem}
    .tag{display:inline-flex;align-items:center;gap:.35rem;padding:.28rem .55rem;border-radius:999px;font-weight:600;font-size:.78rem}
    .tag-primary{background:#eef2ff;color:#3730a3}
    .tag-green{background:#ecfdf5;color:#047857}
    .tag-amber{background:#fff7ed;color:#9a3412}
    .tag-red{background:#fef2f2;color:#b91c1c}
    .tag-gray{background:#f3f4f6;color:#374151}

    /* progress trạng thái */
    .order-progress{display:flex;align-items:center;gap:10px;margin:10px 0 0}
    .order-progress .step{display:flex;align-items:center;gap:8px}
    .order-progress .dot{width:10px;height:10px;border-radius:50%;background:#e5e7eb}
    .order-progress .dot.active{background:#111827}
    .order-progress .bar{height:2px;width:46px;background:#e5e7eb}
    .order-progress .bar.active{background:#111827}

    /* bảng sản phẩm */
    .order_details tbody tr:hover{background:#fafafa}
    .product-name .thumb{width:64px;height:64px;border-radius:8px;object-fit:cover;border:1px solid #eee}
    .product-name .meta{color:#6b7280;font-size:.85rem}

    /* sidebar card */
    .card{border:1px solid #e5e7eb;border-radius:12px;background:#fff}
    .card .card-hd{padding:12px 14px;border-bottom:1px solid #e5e7eb;font-weight:600}
    .card .card-bd{padding:14px}
    .sum-row{display:flex;justify-content:space-between;margin:.25rem 0}
    .sum-row.total{font-weight:700;border-top:1px dashed #e5e7eb;padding-top:.5rem}

    /* invoice / tool buttons */
    .order-tools{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
    .btn-lite{display:inline-flex;align-items:center;gap:6px;padding:8px 12px;border:1px solid #e5e7eb;border-radius:8px;background:#fff;text-decoration:none}
    .btn-danger-outline{border:1px solid #ef4444;color:#b91c1c;background:#fff;padding:9px 12px;border-radius:8px}
    .btn-danger-outline:hover{background:#fef2f2}

    /* mobile spacing */
    @media (max-width: 768px){
      .order-header{padding:12px}
    }
    /* ===== 2 cột: trái = chi tiết sản phẩm, phải = tổng + người nhận ===== */
    .order-two-cols{display:grid;grid-template-columns:1fr;gap:20px;margin-top:18px}
    @media(min-width: 992px){ /* laptop trở lên */
        .order-two-cols{grid-template-columns:minmax(0,1fr) 360px;align-items:start}
    }
    /* sidebar dính nhẹ khi cuộn (tuỳ thích) */
    .order-sidebar{position:sticky;top:90px}
    /* ===== OVERRIDES: đặt ở CUỐI <style> ===== */

    /* Gom badge + các nút trên 1 hàng, căn phải gọn gàng */
    .order-header > div:last-child{
      display:flex;              /* từ block -> flex để xếp ngang */
      align-items:center;
      justify-content:flex-end;
      gap:8px;
      flex-wrap:wrap;            /* nếu hẹp màn hình thì tự xuống dòng */
      text-align:right;
    }
    .order-header > div:last-child .order-tools{
      margin-top:0;              /* bỏ khoảng cách thừa */
    }
    .order-header .tag{
      margin:0 2px 0 0;          /* chút khoảng cách với nút */
    }

    /* Nút hành động: luôn nền trắng, viền xám; hover xám rất nhẹ */
    .btn-lite{
      background:#fff !important;
      color:#111827 !important;
      border:1px solid #e5e7eb !important;
      cursor:pointer;
    }
    .btn-lite:hover{
      background:#f9fafb !important;
      border-color:#d1d5db !important;
      color:#111827 !important;
    }
    .btn-lite:focus-visible{
      outline:2px solid #11182722;
      outline-offset:2px;
    }
    .btn-lite:active{
      transform:translateY(0.5px);
    }

    /* Mobile: đưa badge + nút căn trái để đỡ chật */
    @media (max-width: 768px){
      .order-header > div:last-child{
        justify-content:flex-start;
        text-align:left;
      }
    }
    .btn-danger-outline:hover {
      background: #fef2f2 !important;
      color: #b91c1c !important;
      border-color: #ef4444 !important;
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

                        
                      <?php
                        $statusId = (int)$order->order_status_id;
                        $statusName = $order->status?->name ?? '—';
                        $tagClass = match($statusId){
                          1 => 'tag-amber',    // Chờ xác nhận
                          2 => 'tag-primary',  // Đã xác nhận
                          3 => 'tag-amber',    // Đang giao
                          4 => 'tag-green',    // Đã giao
                          5 => 'tag-green',    // Hoàn thành
                          6 => 'tag-red',      // Hủy
                          7 => 'tag-gray',     // Hoàn hàng
                          default => 'tag-gray'
                        };

                        // pipeline 5 mốc (thêm mốc "Đã giao")
                        $steps = [
                          1 => 'Chờ xác nhận',
                          2 => 'Đã xác nhận',
                          3 => 'Đang giao',
                          4 => 'Đã giao',
                          5 => 'Hoàn thành'
                        ];

                        // map statusId vào mức hoàn thành thanh tiến trình (5 mốc)
                        // ⚙️ chỉnh lại: nếu đơn bị hủy (6) thì chỉ dừng ở "Chờ xác nhận" (1)
                        $activeStep = match(true){
                          $statusId === 6 => 1,          // Hủy -> chỉ hiển thị bước 1
                          $statusId === 1 => 1,
                          $statusId === 2 => 2,
                          $statusId === 3 => 3,
                          $statusId === 4 => 4,
                          $statusId >= 5 => 5,
                          default => 1
                        };
                      ?>


                        <div class="order-header">
                          <div>
                            <div style="font-weight:700;font-size:1.05rem">Đơn hàng #<?php echo e($order->order_code); ?></div>
                            <div class="meta">
                              <span>Đặt lúc <?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></span>
                              <span>•</span>
                              <span>Tổng: <strong>₫<?php echo e(number_format($calc_total)); ?></strong></span>
                            </div>

                            
                            <div class="order-progress" aria-label="Tiến trình đơn hàng">
                              <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="step">
                                  <span class="dot <?php echo e($i <= $activeStep ? 'active':''); ?>"></span>
                                  <span style="font-size:.83rem;color:#374151"><?php echo e($label); ?></span>
                                </div>
                                <?php if($i < count($steps)): ?>
                                  <span class="bar <?php echo e($i < $activeStep ? 'active':''); ?>"></span>
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
                                <form method="POST" action="<?php echo e(route('orders.complete', $order->id)); ?>">
                                  <?php echo csrf_field(); ?>
                                  <button class="btn-lite" type="submit" title="Xác nhận đã nhận hàng">Hoàn thành</button>
                                </form>
                              <?php endif; ?>

                              <?php if($order->cancelable): ?>
                                <form method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn?')">
                                  <?php echo csrf_field(); ?>
                                  <input type="hidden" name="reason" value="Khách yêu cầu hủy">
                                  <button class="btn-danger-outline" type="submit">Hủy đơn</button>
                                </form>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>

                        
                        <div class="order-two-cols">
                        
                        <div>
                            <section class="woocommerce-order-details card">
                            <div class="card-hd">Chi tiết sản phẩm</div>
                            <div class="card-bd" style="padding:0">
                                <table class="woocommerce-table woocommerce-table--order-details shop_table order_details" style="margin:0">
                                <thead>
                                    <tr>
                                    <th class="product-name">Sản phẩm</th>
                                    <th class="product-quantity">SL</th>
                                    <th class="product-total">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="order_item">
                                    <td class="product-name">
                                        <div style="display:flex;gap:12px;align-items:center">
                                        <?php if($it->image): ?>
                                            <img class="thumb" src="<?php echo e(asset($it->image)); ?>" alt="">
                                        <?php endif; ?>
                                        <div>
                                            <strong><?php echo e($it->product_name); ?></strong>
                                            <div class="meta">
                                            <?php if($it->variant_text): ?> <?php echo e($it->variant_text); ?> · <?php endif; ?>
                                            Đơn giá: ₫<?php echo e(number_format($it->unit_price)); ?>

                                            <?php if($it->eta): ?> · Dự kiến: <?php echo e(\Carbon\Carbon::parse($it->eta)->format('d/m')); ?> <?php endif; ?>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="product-quantity"><?php echo e($it->qty); ?></td>
                                    <td class="product-total">
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

                            <?php if($order->order_status_id == 5): ?>
                            <div class="woocommerce-message" style="margin-top:14px">
                                Đơn hàng đã hoàn thành.
                                <a class="button" href="#">Viết đánh giá</a>
                            </div>
                            <?php endif; ?>
                        </div>

                        
                        <aside class="order-sidebar">
                            <div class="card" style="margin-bottom:16px">
                            <div class="card-hd">Tổng kết thanh toán</div>
                            <div class="card-bd">
                                <div class="sum-row"><span>Tạm tính</span><span>₫<?php echo e(number_format($calc_subtotal)); ?></span></div>
                                <div class="sum-row"><span>Giảm giá</span><span>-₫<?php echo e(number_format($calc_discount)); ?></span></div>
                                <?php if($order->voucher): ?>
                                <div class="sum-row" style="color:#6b7280"><span>Voucher</span><span><?php echo e($order->voucher->voucher_code); ?></span></div>
                                <?php endif; ?>
                                <div class="sum-row"><span>Phương thức</span><span><?php echo e($order->payment?->method?->name ?? '—'); ?></span></div>
                                <div class="sum-row"><span>TT thanh toán</span><span><?php echo e($order->paymentStatus?->name); ?></span></div>
                                <div class="sum-row total"><span>Tổng thanh toán</span><span>₫<?php echo e(number_format($calc_total)); ?></span></div>
                            </div>
                            </div>

                            <div class="card" style="margin-bottom:16px">
                            <div class="card-hd">Thông tin người nhận</div>
                            <div class="card-bd">
                                <address style="margin:0">
                                <strong><?php echo e($order->name); ?></strong><br>
                                <?php echo e($order->address); ?><br>
                                <?php echo e($order->phone); ?><br>
                                <?php if($order->user?->email): ?>
                                    <a href="mailto:<?php echo e($order->user->email); ?>"><?php echo e($order->user->email); ?></a>
                                <?php endif; ?>
                                </address>
                                <?php if($order->note): ?>
                                <div style="margin-top:8px;color:#6b7280">Ghi chú: <?php echo e($order->note); ?></div>
                                <?php endif; ?>
                            </div>
                            </div>

                            <?php if($order->cancelable): ?>
                            <div class="card">
                                <div class="card-hd">Hủy đơn hàng</div>
                                <div class="card-bd">
                                <form method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>" onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn?')">
                                    <?php echo csrf_field(); ?>
                                    <input id="reason" name="reason" class="input-text" placeholder="Ví dụ: đặt nhầm, đổi địa chỉ..." style="width:100%;margin-bottom:8px">
                                    <button class="button alt" type="submit" style="width:100%">Hủy đơn</button>
                                    <p class="woocommerce-info" style="margin-top:8px">
                                    Nếu đã thanh toán online, hệ thống chuyển trạng thái <b>Hoàn tiền</b>.
                                    </p>
                                </form>
                                </div>
                            </div>
                            <?php elseif($order->order_status_id == 6): ?>
                            <div class="woocommerce-info">Đơn đã hủy.</div>
                            <?php endif; ?>
                        </aside>
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
    <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/orders/show.blade.php ENDPATH**/ ?>