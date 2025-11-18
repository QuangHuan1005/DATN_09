<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-3">
    <h3 class="mb-3">Dashboard thống kê</h3>

    
    <form class="row g-2 align-items-end mb-3" method="GET" action="<?php echo e(route('admin.dashboard')); ?>">
        <div class="col-auto">
            <label class="form-label">Từ ngày</label>
            <input type="date" name="from" class="form-control" value="<?php echo e(request('from', optional($from)->format('Y-m-d'))); ?>">
        </div>
        <div class="col-auto">
            <label class="form-label">Đến ngày</label>
            <input type="date" name="to" class="form-control" value="<?php echo e(request('to', optional($to)->format('Y-m-d'))); ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Lọc</button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">Reset</a>
        </div>

        <div class="col-12 mt-2">
            <small class="text-muted">
                Khoảng: <?php echo e($from->format('d/m/Y')); ?> — <?php echo e($to->format('d/m/Y')); ?>

            </small>
        </div>
    </form>

    
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Tổng doanh thu (đã TT)</div>
                    <div class="h4"><?php echo e(number_format($totalRevenue, 0, ',', '.')); ?> ₫</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a class="card shadow-sm text-decoration-none text-reset" href="<?php echo e(route('admin.orders.index')); ?>">
                <div class="card-body">
                    <div class="text-muted">Số đơn đã thanh toán</div>
                    <div class="h4"><?php echo e($totalPaidOrders); ?></div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a class="card shadow-sm text-decoration-none text-reset" href="<?php echo e(route('admin.orders.index')); ?>">
                <div class="card-body">
                    <div class="text-muted">Tổng đơn</div>
                    <div class="h4"><?php echo e($allOrders); ?></div>
                </div>
            </a>
        </div>
    </div>

    
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Doanh thu theo ngày</span>
                </div>
                <div class="card-body">
                    <canvas id="revenueLine"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Tỉ lệ đơn theo trạng thái</div>
                <div class="card-body">
                    <canvas id="orderStatusPie"></canvas>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-3">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">Top sản phẩm bán chạy</div>
                <div class="card-body">
                    <canvas id="topProductsBar"></canvas>
                    <div class="mt-3">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">SL</th>
                                    <th class="text-end">Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($i+1); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.products.edit', $p->product_id)); ?>">
                                            <?php echo e($p->product_name); ?>

                                        </a>
                                    </td>
                                    <td class="text-end"><?php echo e((int)$p->qty_sold); ?></td>
                                    <td class="text-end"><?php echo e(number_format($p->revenue, 0, ',', '.')); ?> ₫</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">Tỉ lệ hoàn hàng theo sản phẩm</div>
                <div class="card-body">
                    <?php if(empty($retLabels)): ?>
                        <div class="text-muted">Không có dữ liệu hoàn hàng</div>
                    <?php else: ?>
                        <canvas id="returnPie"></canvas>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-3">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">Top danh mục bán chạy</div>
                <div class="card-body">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Danh mục</th>
                                <th class="text-end">SL</th>
                                <th class="text-end">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td>
                                    
                                    <a href="<?php echo e(route('admin.categories.edit', $c->category_id)); ?>">
                                        <?php echo e($c->category_name); ?>

                                    </a>
                                </td>
                                <td class="text-end"><?php echo e((int)$c->qty_sold); ?></td>
                                <td class="text-end"><?php echo e(number_format($c->revenue, 0, ',', '.')); ?> ₫</td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">Top khách hàng</div>
                <div class="card-body">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th class="text-end">Đơn</th>
                                <th class="text-end">Chi tiêu</th>
                                <th class="text-end">Đơn TB</th>
                                <th class="text-end">Hủy/Hoàn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.users.edit', $u->user_id)); ?>">
                                        <?php echo e($u->name); ?> <small class="text-muted"><?php echo e($u->email); ?></small>
                                    </a>
                                </td>
                                <td class="text-end"><?php echo e((int)$u->orders_count); ?></td>
                                <td class="text-end"><?php echo e(number_format($u->total_spent, 0, ',', '.')); ?> ₫</td>
                                <td class="text-end"><?php echo e(number_format($u->avg_order_value, 0, ',', '.')); ?> ₫</td>
                                <td class="text-end"><?php echo e((int)$u->cancelled_or_returned); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center text-muted">Không có dữ liệu</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row g-3 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">Sản phẩm tồn kho thấp</div>
                <div class="card-body">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm (Biến thể)</th>
                                <th class="text-end">Tồn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $lowStocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($i+1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.products.edit', $v->product_id)); ?>">
                                        <?php echo e($v->product_name); ?>

                                    </a>
                                    <small class="text-muted">
    <?php if($v->color): ?> • Màu: <?php echo e($v->color); ?> <?php endif; ?>
    <?php if($v->size): ?>  • Size: <?php echo e($v->size); ?> <?php endif; ?>
    • <a href="<?php echo e(route('admin.inventory.index', ['q' => $v->product_code, 'highlight' => $v->variant_id])); ?>">
        (Xem kho)
      </a>
</small>

                                </td>
                                <td class="text-end"><?php echo e((int)$v->quantity); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-center text-muted">Không có dữ liệu</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">Đơn hàng chờ xác nhận (mới nhất)</div>
                <div class="card-body">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách</th>
                                <th class="text-end">Giá trị</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentPending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><a href="<?php echo e(route('admin.orders.show', $o->id)); ?>"><?php echo e($o->order_code); ?></a></td>
                                <td><?php echo e($o->customer); ?></td>
                                <td class="text-end"><?php echo e(number_format($o->total_amount, 0, ',', '.')); ?> ₫</td>
                                <td><?php echo e(\Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-muted">Không có đơn chờ xác nhận</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const money = v => new Intl.NumberFormat('vi-VN').format(v);

// Line: Doanh thu theo ngày
new Chart(document.getElementById('revenueLine'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels, 15, 512) ?>,
        datasets: [{
            label: 'Doanh thu (₫)',
            data: <?php echo json_encode($revenues, 15, 512) ?>,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        interaction: { mode: 'index', intersect: false },
        plugins: {
            tooltip: {
                callbacks: { label: ctx => ' ' + money(ctx.parsed.y) + ' ₫' }
            }
        },
        scales: {
            y: { ticks: { callback: v => money(v) + ' ₫' } }
        }
    }
});

// Pie: Tỉ lệ đơn theo trạng thái
new Chart(document.getElementById('orderStatusPie'), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($statusLabels, 15, 512) ?>,
        datasets: [{ data: <?php echo json_encode($statusValues, 15, 512) ?> }]
    }
});

// Bar: Top sản phẩm (2 trục — doanh thu & SL)
new Chart(document.getElementById('topProductsBar'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($tpLabels, 15, 512) ?>,
        datasets: [
            {
                type: 'bar',
                label: 'Doanh thu (₫)',
                data: <?php echo json_encode($tpRevenue, 15, 512) ?>,
                yAxisID: 'y1'
            },
            {
                type: 'line',
                label: 'Số lượng',
                data: <?php echo json_encode($tpQty, 15, 512) ?>,
                yAxisID: 'y2',
                tension: 0.2
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        scales: {
            y1: {
                position: 'left',
                ticks: { callback: v => money(v) + ' ₫' }
            },
            y2: {
                position: 'right',
                grid: { drawOnChartArea: false }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: ctx => ctx.dataset.label.includes('Doanh thu')
                        ? ' ' + money(ctx.parsed.y) + ' ₫'
                        : ' ' + ctx.parsed.y + ' sp'
                }
            }
        }
    }
});

// Pie: Tỉ lệ hoàn hàng theo sản phẩm (nếu có)
<?php if(!empty($retLabels)): ?>
new Chart(document.getElementById('returnPie'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($retLabels, 15, 512) ?>,
        datasets: [{ data: <?php echo json_encode($retValues, 15, 512) ?> }]
    }
});
<?php endif; ?>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\DATN_09\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>