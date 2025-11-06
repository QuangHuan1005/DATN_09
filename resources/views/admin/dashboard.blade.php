@extends('admin.master')
@section('title', 'Dashboard')

@section('content')

<div class="container-fluid py-3">
    <h3 class="mb-3">Dashboard thống kê</h3>

    {{-- Bộ lọc thời gian --}}
    <form class="row g-2 align-items-end mb-3" method="GET" action="{{ route('admin.dashboard') }}">
        <div class="col-auto">
            <label class="form-label">Từ ngày</label>
            <input type="date" name="from" class="form-control" value="{{ request('from', optional($from)->format('Y-m-d')) }}">
        </div>
        <div class="col-auto">
            <label class="form-label">Đến ngày</label>
            <input type="date" name="to" class="form-control" value="{{ request('to', optional($to)->format('Y-m-d')) }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Lọc</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Reset</a>
        </div>

        <div class="col-12 mt-2">
            <small class="text-muted">
                Khoảng: {{ $from->format('d/m/Y') }} — {{ $to->format('d/m/Y') }}
            </small>
        </div>
    </form>

    {{-- KPI nhanh --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Tổng doanh thu (đã TT)</div>
                    <div class="h4">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a class="card shadow-sm text-decoration-none text-reset" href="{{ route('admin.orders.index') }}">
                <div class="card-body">
                    <div class="text-muted">Số đơn đã thanh toán</div>
                    <div class="h4">{{ $totalPaidOrders }}</div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a class="card shadow-sm text-decoration-none text-reset" href="{{ route('admin.orders.index') }}">
                <div class="card-body">
                    <div class="text-muted">Tổng đơn</div>
                    <div class="h4">{{ $allOrders }}</div>
                </div>
            </a>
        </div>
    </div>

    {{-- Hàng 1: Doanh thu theo ngày + Tỉ lệ trạng thái --}}
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

    {{-- Hàng 2: Top sản phẩm (doanh thu & SL) + Pie tỉ lệ hoàn hàng --}}
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
                                @forelse($topProducts as $i => $p)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $p->product_id) }}">
                                            {{ $p->product_name }}
                                        </a>
                                    </td>
                                    <td class="text-end">{{ (int)$p->qty_sold }}</td>
                                    <td class="text-end">{{ number_format($p->revenue, 0, ',', '.') }} ₫</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>
                                @endforelse
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
                    @if(empty($retLabels))
                        <div class="text-muted">Không có dữ liệu hoàn hàng</div>
                    @else
                        <canvas id="returnPie"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Hàng 3: Top danh mục + Top khách hàng --}}
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
                            @forelse($topCategories as $i => $c)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    {{-- Không có route admin categories show? dùng edit --}}
                                    <a href="{{ route('admin.categories.edit', $c->category_id) }}">
                                        {{ $c->category_name }}
                                    </a>
                                </td>
                                <td class="text-end">{{ (int)$c->qty_sold }}</td>
                                <td class="text-end">{{ number_format($c->revenue, 0, ',', '.') }} ₫</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Không có dữ liệu</td></tr>
                            @endforelse
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
                            @forelse($topCustomers as $i => $u)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $u->user_id) }}">
                                        {{ $u->name }} <small class="text-muted">{{ $u->email }}</small>
                                    </a>
                                </td>
                                <td class="text-end">{{ (int)$u->orders_count }}</td>
                                <td class="text-end">{{ number_format($u->total_spent, 0, ',', '.') }} ₫</td>
                                <td class="text-end">{{ number_format($u->avg_order_value, 0, ',', '.') }} ₫</td>
                                <td class="text-end">{{ (int)$u->cancelled_or_returned }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">Không có dữ liệu</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Hàng 4: Tồn kho + Đơn chờ xác nhận --}}
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
                            @forelse($lowStocks as $i => $v)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $v->product_id) }}">
                                        {{ $v->product_name }}
                                    </a>
                                    <small class="text-muted">
    @if($v->color) • Màu: {{ $v->color }} @endif
    @if($v->size)  • Size: {{ $v->size }} @endif
    • <a href="{{ route('admin.inventory.index', ['q' => $v->product_code, 'highlight' => $v->variant_id]) }}">
        (Xem kho)
      </a>
</small>

                                </td>
                                <td class="text-end">{{ (int)$v->quantity }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted">Không có dữ liệu</td></tr>
                            @endforelse
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
                            @forelse($recentPending as $o)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $o->id) }}">{{ $o->order_code }}</a></td>
                                <td>{{ $o->customer }}</td>
                                <td class="text-end">{{ number_format($o->total_amount, 0, ',', '.') }} ₫</td>
                                <td>{{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">Không có đơn chờ xác nhận</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const money = v => new Intl.NumberFormat('vi-VN').format(v);

// Line: Doanh thu theo ngày
new Chart(document.getElementById('revenueLine'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Doanh thu (₫)',
            data: @json($revenues),
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
        labels: @json($statusLabels),
        datasets: [{ data: @json($statusValues) }]
    }
});

// Bar: Top sản phẩm (2 trục — doanh thu & SL)
new Chart(document.getElementById('topProductsBar'), {
    type: 'bar',
    data: {
        labels: @json($tpLabels),
        datasets: [
            {
                type: 'bar',
                label: 'Doanh thu (₫)',
                data: @json($tpRevenue),
                yAxisID: 'y1'
            },
            {
                type: 'line',
                label: 'Số lượng',
                data: @json($tpQty),
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
@if(!empty($retLabels))
new Chart(document.getElementById('returnPie'), {
    type: 'doughnut',
    data: {
        labels: @json($retLabels),
        datasets: [{ data: @json($retValues) }]
    }
});
@endif
</script>
@endsection