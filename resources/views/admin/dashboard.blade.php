@extends('admin.master')
@section('title', 'Dashboard Thống Kê Chi Tiết')

@section('content')

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="fas fa-chart-line me-2"></i>Dashboard Thống Kê</h3>
        <span class="badge bg-light text-dark shadow-sm p-2">
            Hệ thống cập nhật: {{ now()->format('H:i d/m/Y') }}
        </span>
    </div>

    {{-- Bộ lọc thời gian --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form id="filterForm" class="row g-3 align-items-end" method="GET" action="{{ route('admin.dashboard') }}">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase">Từ ngày</label>
                    <input type="date" name="from" id="fromDate" class="form-control" value="{{ request('from', optional($from)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase">Đến ngày</label>
                    <input type="date" name="to" id="toDate" class="form-control" value="{{ request('to', optional($to)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-filter me-1"></i> Lọc dữ liệu</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4">Làm mới</a>
                </div>
                <div class="col-12">
                    <div class="text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> Chu kỳ báo cáo: 
                        <span class="text-primary fw-bold">{{ $from->format('d/m/Y') }}</span> 
                        <i class="fas fa-long-arrow-alt-right mx-1"></i> 
                        <span class="text-primary fw-bold">{{ $to->format('d/m/Y') }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

   {{-- KPI Cards - DOANH THU --}}
<div class="row g-3 mb-3">
    {{-- Click xem Đơn hoàn thành --}}
    <div class="col-md-4">
        <a href="{{ route('admin.orders.index', ['order_status_id' => 5]) }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-4 border-primary h-100 btn-reveal">
                <div class="card-body">
                    <div class="text-uppercase small fw-bold text-muted mb-1">Doanh thu gộp (Hóa đơn)</div>
                    <div class="h3 mb-0 fw-bold text-primary">{{ number_format($totalRevenue, 0, ',', '.') }} ₫</div>
                    <small class="text-muted">Tổng đơn Hoàn thành <i class="bi bi-arrow-right-short"></i></small>
                </div>
            </div>
        </a>
    </div>

    {{-- Click xem Đơn đã hoàn tiền --}}
    <div class="col-md-4">
        <a href="{{ route('admin.orders.index', ['order_status_id' => 7]) }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-4 border-danger h-100 btn-reveal">
                <div class="card-body">
                    <div class="text-uppercase small fw-bold text-muted mb-1">Tổng tiền hoàn trả</div>
                    <div class="h3 mb-0 fw-bold text-danger">{{ number_format($totalRefund ?? 0, 0, ',', '.') }} ₫</div>
                    <small class="text-muted">Khấu trừ đơn Hoàn hàng <i class="bi bi-arrow-right-short"></i></small>
                </div>
            </div>
        </a>
    </div>

    {{-- Thẻ này thường xem tổng thể nên để link về trang index không lọc hoặc lọc đơn "Thực thu" --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
            <div class="card-body">
                <div class="text-uppercase small fw-bold text-muted mb-1">Doanh thu thực nhận</div>
                <div class="h3 mb-0 fw-bold text-success">{{ number_format($netRevenue ?? $totalRevenue, 0, ',', '.') }} ₫</div>
                <small class="text-muted">Thực thu sau khi trừ hoàn</small>
            </div>
        </div>
    </div>
</div>

{{-- KPI Cards - SỐ LƯỢNG ĐƠN HÀNG --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.orders.index', ['order_status_id' => 5]) }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-4 h-100" style="border-left-color: #ff6b00 !important;">
                <div class="card-body">
                    <div class="text-uppercase small fw-bold text-muted mb-1">Đơn hàng hoàn thành</div>
                    <div class="h3 mb-0 fw-bold" style="color: #ff6b00;">{{ $totalPaidOrders }}</div>
                    <small class="text-muted">Đơn đã nhận hàng & thanh toán</small>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
            <div class="card shadow-sm border-0 border-start border-4 border-info h-100">
                <div class="card-body">
                    <div class="text-uppercase small fw-bold text-muted mb-1">Tổng lượng giao dịch</div>
                    <div class="h3 mb-0 fw-bold text-info">{{ $allOrders }}</div>
                    <small class="text-muted">Tất cả trạng thái đơn hàng</small>
                </div>
            </div>
        </a>
    </div> 
</div>

    {{-- BIỂU ĐỒ DOANH THU THÁNG --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i>Tăng trưởng doanh thu theo tháng</span>
                        <div class="d-flex align-items-center">
                            <label class="me-2 small fw-bold text-muted text-uppercase">Năm báo cáo:</label>
                            <form action="{{ route('admin.dashboard') }}" method="GET" id="yearFilterForm">
                                <input type="hidden" name="from" value="{{ request('from') }}">
                                <input type="hidden" name="to" value="{{ request('to') }}">
                                <select name="year" class="form-select form-select-sm fw-bold border-primary" onchange="this.form.submit()" style="width: 100px;">
                                    @for ($i = date('Y'); $i >= 2020; $i--)
                                        <option value="{{ $i }}" {{ (request('year', $year ?? date('Y')) == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="revenueMonthly"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Doanh thu ngày & Trạng thái --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between">
                    <span><i class="fas fa-chart-area me-2 text-info"></i>Biến động doanh thu theo ngày</span>
                    <small class="text-muted italic">Click vào điểm nút để xem đơn hàng ngày đó</small>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="revenueLine"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3">Tỷ lệ đơn theo trạng thái</div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div style="width: 100%; max-width: 250px;">
                        <canvas id="orderStatusPie"></canvas>
                    </div>
                    <div id="statusLegend" class="mt-3 w-100"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Sản phẩm & Hoàn hàng --}}
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold py-3">Top 10 sản phẩm hiệu quả nhất</div>
                <div class="card-body">
                    <canvas id="topProductsBar" style="max-height: 300px;"></canvas>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover align-middle border">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $i => $p)
                                <tr>
                                    <td><span class="badge bg-secondary rounded-circle">{{ $i+1 }}</span></td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $p->product_id) }}" class="text-decoration-none fw-bold text-dark">
                                            {{ $p->product_name }}
                                        </a>
                                    </td>
                                    <td class="text-center"><span class="fw-bold">{{ (int)$p->qty_sold }}</span></td>
                                    <td class="text-end text-primary fw-bold">{{ number_format($p->revenue, 0, ',', '.') }} ₫</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center p-4 text-muted">Chưa có dữ liệu giao dịch</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3 text-danger">Tỉ lệ hoàn hàng theo sản phẩm</div>
                <div class="card-body text-center">
                    @if(empty($retLabels))
                        <div class="py-5">
                            <i class="fas fa-check-circle fa-4x text-success mb-3 opacity-50"></i>
                            <p class="text-muted">Tuyệt vời! Không có dữ liệu hoàn hàng.</p>
                        </div>
                    @else
                        <canvas id="returnPie"></canvas>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Khách hàng & Danh mục --}}
    <div class="row g-3 mb-5">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3 text-uppercase small">Danh mục đóng góp doanh thu</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr class="text-muted small">
                                <th>Danh mục</th>
                                <th class="text-end">Số lượng</th>
                                <th class="text-end">Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCategories as $c)
                            <tr>
                                <td class="fw-bold">{{ $c->category_name }}</td>
                                <td class="text-end">{{ $c->qty_sold }}</td>
                                <td class="text-end fw-bold text-success">{{ number_format($c->revenue, 0, ',', '.') }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3 text-uppercase small">Khách hàng VIP</div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr class="text-muted small">
                                <th>Khách hàng</th>
                                <th class="text-end">Số đơn</th>
                                <th class="text-end">Tổng chi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCustomers as $u)
                            <tr>
                                <td class="fw-bold">{{ $u->name }}</td>
                                <td class="text-end">{{ $u->orders_count }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($u->total_spent, 0, ',', '.') }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Thư viện hỗ trợ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const money = v => new Intl.NumberFormat('vi-VN').format(v) + ' ₫';

document.addEventListener('DOMContentLoaded', function() {
    const COMPLETED_STATUS_ID = 5;

    // --- 0. BỘ LỌC NGÀY ---
    const fromInput = document.getElementById('fromDate');
    const toInput = document.getElementById('toDate');
    const filterForm = document.getElementById('filterForm');

    function validateDates() {
        if (fromInput.value && toInput.value) {
            const date1 = new Date(fromInput.value);
            const date2 = new Date(toInput.value);
            if (date1 > date2) {
                const temp = fromInput.value;
                fromInput.value = toInput.value;
                toInput.value = temp;
                Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true,
                }).fire({
                    icon: 'warning', title: 'Ngày bắt đầu > Ngày kết thúc', text: 'Hệ thống đã tự động đảo lại ngày cho hợp lệ.'
                });
            }
        }
    }

    fromInput.addEventListener('change', validateDates);
    toInput.addEventListener('change', validateDates);

    filterForm.addEventListener('submit', function() {
        Swal.fire({
            title: 'Đang xử lý dữ liệu...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }
        });
    });

    // --- 1. BIỂU ĐỒ THÁNG ---
    new Chart(document.getElementById('revenueMonthly'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($monthlyRevenues ?? []) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1, borderRadius: 4
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            onClick: (e, els) => {
                if (els.length > 0) {
                    const month = els[0].index + 1;
                    const year = {{ request('year', $year ?? date('Y')) }};
                    window.location.href = `{{ route('admin.orders.index') }}?month=${month}&year=${year}&order_status_id=${COMPLETED_STATUS_ID}`;
                }
            },
            plugins: { tooltip: { callbacks: { label: ctx => ' ' + money(ctx.parsed.y) } } },
            scales: { y: { ticks: { callback: v => money(v) } } }
        }
    });

    // --- 2. BIỂU ĐỒ NGÀY ---
    new Chart(document.getElementById('revenueLine'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels ?? []) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($revenues ?? []) !!},
                borderColor: '#0dcaf0', backgroundColor: 'rgba(13, 202, 240, 0.1)',
                fill: true, tension: 0.4, pointRadius: 4, pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            onClick: (e, els) => {
                if (els.length > 0) {
                    const idx = els[0].index;
                    const date = {!! json_encode($labels ?? []) !!}[idx];
                    window.location.href = `{{ route('admin.orders.index') }}?date=${date}&order_status_id=${COMPLETED_STATUS_ID}`;
                }
            },
            plugins: { tooltip: { callbacks: { label: ctx => ' ' + money(ctx.parsed.y) } } },
            scales: { y: { ticks: { callback: v => money(v) } } }
        }
    });

    // --- 3. BIỂU ĐỒ TRẠNG THÁI ---
    const statusMapIds = [1, 2, 3, 4, 5, 6, 7];
    new Chart(document.getElementById('orderStatusPie'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($statusLabels ?? []) !!},
            datasets: [{
                data: {!! json_encode($statusValues ?? []) !!},
                backgroundColor: ['#ffc107', '#0d6efd', '#0dcaf0', '#198754', '#20c997', '#dc3545', '#6c757d']
            }]
        },
        options: {
            onClick: (e, els) => {
                if (els.length > 0) {
                    const idx = els[0].index;
                    const sid = statusMapIds[idx];
                    window.location.href = `{{ route('admin.orders.index') }}?order_status_id=${sid}`;
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const perc = ((ctx.raw / total) * 100).toFixed(1);
                            return ` ${ctx.label}: ${ctx.raw} đơn (${perc}%)`;
                        }
                    }
                }
            }
        }
    });

    // --- 4. TOP SẢN PHẨM ---
    const topProductIds = {!! json_encode($topProducts->pluck('product_id') ?? []) !!};
    new Chart(document.getElementById('topProductsBar'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($tpLabels ?? []) !!},
            datasets: [
                {
                    label: 'Doanh thu',
                    data: {!! json_encode($tpRevenue ?? []) !!},
                    backgroundColor: 'rgba(13, 110, 253, 0.7)', yAxisID: 'y'
                },
                {
                    label: 'Số lượng',
                    data: {!! json_encode($tpQty ?? []) !!},
                    borderColor: '#dc3545', type: 'line', yAxisID: 'y1'
                }
            ]
        },
        options: {
            onClick: (e, els) => {
                if (els.length > 0) {
                    const idx = els[0].index;
                    const pid = topProductIds[idx];
                    window.location.href = `{{ route('admin.orders.index') }}?product_id=${pid}&order_status_id=${COMPLETED_STATUS_ID}`;
                }
            },
            scales: {
                y: { position: 'left', ticks: { callback: v => money(v) } },
                y1: { position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });

    // --- 5. HOÀN HÀNG ---
    @if(!empty($retLabels))
    new Chart(document.getElementById('returnPie'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($retLabels) !!},
            datasets: [{
                data: {!! json_encode($retValues) !!},
                backgroundColor: ['#dc3545', '#fd7e14', '#6f42c1', '#20c997']
            }]
        },
        options: {
            plugins: { tooltip: { callbacks: { label: ctx => ` ${ctx.label}: hoàn ${ctx.raw} món` } } }
        }
    });
    @endif
});
</script>

<style>
    .card { border-radius: 12px; border: none; transition: all 0.3s ease; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .table thead th { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .italic { font-style: italic; }
    canvas { cursor: pointer; }
    .swal2-popup { font-size: 0.9rem !important; }
</style>
@endsection