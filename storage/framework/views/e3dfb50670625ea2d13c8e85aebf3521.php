<?php $__env->startSection('content'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Trạng thái hiện tại của đơn
    $currentStatus = (int) $order->order_status_id;

    // Thông tin cho từng bước trên thanh trạng thái
    $stepMeta = [
        1 => ['label' => 'Chờ xác nhận',    'desc' => 'Đặt hàng thành công'],
        2 => ['label' => 'Đã xác nhận',     'desc' => 'Cửa hàng đã xác nhận'],
        3 => ['label' => 'Đang giao hàng', 'desc' => 'Đơn đang được giao'],
        4 => ['label' => 'Đã giao hàng',    'desc' => 'Hàng đã tới địa chỉ nhận'],
        5 => ['label' => 'Hoàn thành',      'desc' => 'Khách xác nhận đã nhận'],
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
        $statusId === 6 => 1,          // Hủy -> chỉ coi như ở bước 1
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
    .order-info-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 16px;
      margin-top: 18px;
    }

    @media (min-width: 768px) {
      .order-info-grid {
        grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
      }
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
                                    Hoàn thành
                                  </button>
                                </form>
                              <?php endif; ?>

                              <?php if($order->cancelable): ?>
                                
                                <form id="cancel-order-form" method="POST" action="<?php echo e(route('orders.cancel', $order->id)); ?>">
                                  <?php echo csrf_field(); ?>
                                  <input type="hidden" name="reason" value="Khách yêu cầu hủy">
                                  <button class="btn-danger-outline" type="button" id="btnOpenCancelModal">Hủy đơn</button>
                                </form>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>

                        
                        <div class="order-info-grid">
                          
                          <div class="card">
                            <div class="card-hd">Đơn hàng</div>
                            <div class="card-bd">
                              <div class="sum-row">
                                <span>Mã đơn</span>
                                <span>#<?php echo e($order->order_code); ?></span>
                              </div>
                              <div class="sum-row">
                                <span>Trạng thái đơn</span>
                                <span><?php echo e($statusName); ?></span>
                              </div>
                              <div class="sum-row">
                                <span>Trạng thái thanh toán</span>
                                <span><?php echo e($order->paymentStatus?->name); ?></span>
                              </div>
                              <div class="sum-row">
                                <span>Phương thức thanh toán</span>
                                <span><?php echo e($order->payment?->method?->name ?? '—'); ?></span>
                              </div>
                              <div class="sum-row">
                                <span>Thời gian đặt</span>
                                <span><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')); ?></span>
                              </div>
                            </div>
                          </div>

                          
                          <div class="card">
                            <div class="card-hd">Thông tin người nhận</div>
                            <div class="card-bd">
                              <address style="margin:0">
                                <strong><?php echo e($order->name); ?></strong><br>
                                <?php echo e($order->phone); ?><br>
                                <?php echo e($order->address); ?><br>
                                <?php if($order->user?->email): ?>
                                  <a href="mailto:<?php echo e($order->user->email); ?>"><?php echo e($order->user->email); ?></a>
                                <?php endif; ?>
                              </address>
                              <?php if($order->note): ?>
                                <div style="margin-top:8px;color:#6b7280">Ghi chú: <?php echo e($order->note); ?></div>
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
                              <div class="woocommerce-message" style="margin-top:14px">
                                Đơn hàng đã hoàn thành.
                                <a class="button" href="#">Viết đánh giá</a>
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
                              <?php if($calc_shipping_fee > 0): ?>
                                <div class="sum-row">
                                  <span>Phí vận chuyển</span>
                                  <span>₫<?php echo e(number_format($calc_shipping_fee)); ?></span>
                                </div>
                              <?php endif; ?>
                              <?php if($calc_discount > 0): ?>
                                <div class="sum-row">
                                  <span>Giảm giá</span>
                                  <span>-₫<?php echo e(number_format($calc_discount)); ?></span>
                                </div>
                              <?php endif; ?>
                              <?php if($order->voucher): ?>
                                <div class="sum-row" style="color:#6b7280">
                                  <span>Voucher</span>
                                  <span><?php echo e($order->voucher->voucher_code); ?></span>
                                </div>
                              <?php endif; ?>
                              <div class="sum-row">
                                <span>TT thanh toán</span>
                                <span><?php echo e($order->paymentStatus?->name); ?></span>
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
                            <h3>Hủy đơn hàng</h3>
                            <p>Bạn chắc chắn muốn hủy đơn này?</p>
                            <div class="cancel-order-actions">
                              <button type="button" class="btn-cancel-close" id="btnCancelClose">Không</button>
                              <button type="button" class="btn-cancel-ok" id="btnCancelOk">Đồng ý</button>
                            </div>
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
      document.addEventListener('DOMContentLoaded', function () {
        // ===== HỦY ĐƠN =====
        const openBtn  = document.getElementById('btnOpenCancelModal');
        const overlay  = document.getElementById('cancelOrderOverlay');
        const closeBtn = document.getElementById('btnCancelClose');
        const okBtn    = document.getElementById('btnCancelOk');
        const form     = document.getElementById('cancel-order-form');

        if (openBtn && overlay && closeBtn && okBtn && form) {
          openBtn.addEventListener('click', function () {
            overlay.classList.add('is-open');
          });

          closeBtn.addEventListener('click', function () {
            overlay.classList.remove('is-open');
          });

          overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
              overlay.classList.remove('is-open');
            }
          });

          okBtn.addEventListener('click', function () {
            form.submit();
          });
        }

        // ===== ĐÃ NHẬN HÀNG (HOÀN THÀNH) =====
        const completeOpen   = document.getElementById('btnOpenCompleteModal');
        const completeOverlay= document.getElementById('completeOrderOverlay');
        const completeClose  = document.getElementById('btnCompleteClose');
        const completeOk     = document.getElementById('btnCompleteOk');
        const completeForm   = document.getElementById('complete-order-form');

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
            // tại đây user đã xác nhận "Bạn đã nhận hàng..."
            completeForm.submit();
          });
        }
      });
    </script>

    <?php echo $__env->make('layouts.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN09\resources\views/orders/show.blade.php ENDPATH**/ ?>