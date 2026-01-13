@extends('admin.master')
@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container-xxl">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Danh Sách Đơn Hàng</h3>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary d-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" style="border: none; box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;">
                <iconify-icon icon="solar:filter-bold-duotone" class="fs-20"></iconify-icon>
                <span class="fw-bold">Bộ lọc</span>
            </button>
            @if(request()->anyFilled(['payment_status', 'product_id', 'month', 'date', 'status', 'order_status_id', 'keyword', 'start_date', 'end_date']))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-soft-danger d-flex align-items-center shadow-sm">
                    <iconify-icon icon="solar:refresh-broken" class="fs-20"></iconify-icon>
                </a>
            @endif
        </div>
    </div>

    {{-- Thông báo --}}
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : ($msg == 'info' ? 'info' : 'danger') }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Dashboard Filter Badges --}}
    @if(request('payment_status') || request('product_id') || request('month') || request('date') || request('order_status_id') || request('start_date') || request('end_date'))
        <div class="mb-3 d-flex flex-wrap gap-2">
            @if(request('order_status_id'))
                <span class="badge bg-soft-primary text-primary border border-primary px-3 py-2">
                    Trạng thái: {{ collect($statuses)->firstWhere('id', request('order_status_id'))->name ?? 'N/A' }}
                </span>
            @endif
            @if(request('start_date') || request('end_date'))
                <span class="badge bg-soft-dark text-dark border border-dark px-3 py-2">
                    <iconify-icon icon="solar:calendar-date-bold-duotone" class="align-middle me-1"></iconify-icon>
                    Thời gian: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : '...' }} 
                    đến {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : '...' }}
                </span>
            @endif
            @if(request('payment_status'))
                <span class="badge bg-soft-info text-info border border-info px-3 py-2">
                    Thanh toán: {{ request('payment_status') == 2 ? 'Đã thanh toán' : (request('payment_status') == 3 ? 'Đã hoàn tiền' : 'Chưa thanh toán') }}
                </span>
            @endif
            <a href="{{ route('admin.orders.index') }}" class="text-danger small align-self-center ms-2 text-decoration-none fw-bold">
                <iconify-icon icon="solar:refresh-broken" class="align-middle"></iconify-icon> Xóa tất cả lọc
            </a>
        </div>
    @endif

    {{-- Bộ lọc trượt --}}
    <div class="collapse {{ request()->anyFilled(['payment_status', 'start_date', 'end_date', 'status', 'order_status_id', 'keyword']) ? 'show' : '' }}" id="collapseFilter">
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Tìm kiếm</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><iconify-icon icon="solar:magnifer-linear"></iconify-icon></span>
                            <input type="search" name="keyword" class="form-control bg-light border-start-0" placeholder="Mã đơn / Tên khách" value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Từ ngày</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Đến ngày</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold">Trạng thái đơn</label>
                        <select name="order_status_id" class="form-select">
                            <option value="">Tất cả</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ (request('order_status_id') == $status->id || request('status') == $status->id) ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center gap-1">
                            <iconify-icon icon="solar:filter-linear"></iconify-icon> Lọc dữ liệu
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Làm mới</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Tạo</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Tiền Hoàn</th>
                            <th>Phương Thức</th>
                            <th>Thanh Toán</th>
                            <th>Sản Phẩm</th>
                            <th class="text-center">Duyệt</th>
                            <th>Trạng Thái Đơn</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                                $colorClass = $currentStatus->color_class ?? 'border-secondary text-secondary';
                                
                                $paymentColors = [
                                    1 => 'badge border border-primary text-primary',
                                    2 => 'badge border border-success text-success',
                                    3 => 'badge border border-danger text-danger',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                $paymentName = $order->paymentStatus->name ?? 'N/A';

                                $methodColors = [
                                    1 => 'text-dark',
                                    2 => 'text-primary',
                                    3 => 'text-danger',
                                ];
                                $methodColor = $methodColors[$order->payment_method_id] ?? 'text-muted';
                                $methodName = $order->paymentMethod->name ?? 'N/A';

                                $isShippingOrBeyond = in_array($order->order_status_id, [3, 4, 7]);
                                $isFinalized = in_array($order->order_status_id, [5, 6, 7]);

                                // Logic chuẩn bị nội dung Tooltip cho sản phẩm hoàn
                                $returnTooltip = '';
                                if($order->orderReturn && $order->orderReturn->product_details) {
                                    $returnedProducts = json_decode($order->orderReturn->product_details, true);
                                    if($returnedProducts) {
                                        $returnTooltip = "<b>Sản phẩm khách trả:</b><br>";
                                        foreach($returnedProducts as $rp) {
                                            $returnTooltip .= "• " . ($rp['product_name'] ?? 'SP') . " (x" . ($rp['quantity'] ?? 1) . ")<br>";
                                        }
                                        $returnTooltip .= "<i>Lý do: " . ($order->orderReturn->reason ?? 'Không có') . "</i>";
                                    }
                                }
                            @endphp
                            <tr>
                                <td><span class="fw-bold text-dark">{{ $order->order_code }}</span></td>
                                <td class="small">{{ $order->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $order->user_id ?? 0) }}" class="link-primary text-decoration-none fw-medium">
                                        {{ $order->name ?? 'Khách lẻ' }}
                                    </a>
                                </td>
                                <td class="fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                <td class="fw-bold">
                                    @if($order->orderReturn && $order->orderReturn->status == 'completed')
                                        <span class="text-danger">-{{ number_format($order->orderReturn->refund_amount, 0, ',', '.') }}₫</span>
                                    @else
                                        <span class="text-muted">0₫</span>
                                    @endif
                                </td>
                                <td><span class="small fw-medium {{ $methodColor }}">{{ $methodName }}</span></td>
                                <td><span class="{{ $paymentColor }} px-2 py-1 fs-12 fw-bold text-uppercase">{{ $paymentName }}</span></td>
                                <td>
                                    @if($returnTooltip)
                                        <a href="/admin/returns?keyword={{ $order->order_code }}" 
                                           class="badge bg-soft-danger text-danger border border-danger px-2 py-1 text-decoration-none"
                                           data-bs-toggle="tooltip" data-bs-html="true" title="{!! $returnTooltip !!}">
                                            <iconify-icon icon="solar:back-square-bold" class="align-middle me-1"></iconify-icon>
                                            {{ $order->details_sum_quantity ?? 0 }} SP (Hoàn)
                                        </a>
                                    @else
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            <iconify-icon icon="solar:box-bold" class="align-middle me-1 text-secondary"></iconify-icon>
                                            {{ $order->details_sum_quantity ?? 0 }} SP
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($order->cancelRequest && $order->cancelRequest->status_id == 1)
                                        <a href="{{ route('admin.order-cancellations.show', $order->cancelRequest->id) }}" 
                                           class="btn btn-warning btn-sm py-1 px-2">
                                            <iconify-icon icon="solar:bell-bing-broken" class="fs-18 me-1"></iconify-icon> Duyệt
                                        </a>
                                    @elseif($order->cancelRequest)
                                        <span class="text-success">
                                            <iconify-icon icon="solar:document-check-broken" class="fs-18"></iconify-icon>
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="status-form">
                                        @csrf
                                        <input type="hidden" name="admin_reason" class="admin-reason-field">
                                        <select name="order_status_id" class="form-select form-select-sm w-auto {{ $colorClass }}"
                                                onchange="confirmStatusChange(this)"
                                                {{ $isFinalized ? 'disabled' : '' }}>
                                            @foreach($statuses as $status)
                                                @php
                                                    $disabled = false;
                                                    if (in_array($status->id, [5, 7]) && $order->order_status_id != $status->id) {
                                                        continue;
                                                    }
                                                    if ($status->id < $order->order_status_id && $status->id != 6) $disabled = true;
                                                    if ($isShippingOrBeyond && $status->id == 6) $disabled = true;
                                                @endphp
                                                <option value="{{ $status->id }}"
                                                        data-color="{{ $status->color_class }}"
                                                        {{ $order->order_status_id == $status->id ? 'selected' : '' }}
                                                        {{ $disabled ? 'disabled' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-soft-info btn-sm">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5 text-muted">
                                    <iconify-icon icon="solar:document-text-broken" class="fs-48 mb-2 d-block mx-auto opacity-25"></iconify-icon>
                                    Không có đơn hàng nào khớp với bộ lọc.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white border-top">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Khởi tạo Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // 2. Tự động đóng thông báo
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            if(bsAlert) bsAlert.close();
        }, 4000);
    });

    // 3. Khởi tạo màu sắc cho các select trạng thái
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if(selectedOption && selectedOption.dataset.color){
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
        select.dataset.current = select.value;
    });

    // 4. Xử lý xác nhận hủy đơn
    const btnConfirm = document.getElementById('btnConfirmCancel');
    if (btnConfirm) {
        btnConfirm.addEventListener('click', function() {
            const reasonInput = document.getElementById('admin_reason_input');
            const reason = reasonInput.value.trim();
            if (reason.length < 5) {
                alert('Vui lòng nhập lý do hủy chi tiết hơn (tối thiểu 5 ký tự).');
                return;
            }
            if (window.currentSelect) {
                submitStatusForm(window.currentSelect, reason);
                const modal = bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal'));
                if(modal) modal.hide();
            }
        });
    }
});

window.currentSelect = null;

function confirmStatusChange(select) {
    const newValue = select.value;
    const newStatusText = select.selectedOptions[0].text;
    window.currentSelect = select;

    if (newValue == "6") { // ID Hủy
        const modalElement = document.getElementById('cancelReasonModal');
        const modal = new bootstrap.Modal(modalElement);
        document.getElementById('admin_reason_input').value = ''; 
        modal.show();
    } else {
        if (confirm(`Xác nhận đổi trạng thái sang "${newStatusText}"?`)) {
            submitStatusForm(select);
        } else {
            resetSelect(select);
        }
    }
}

function submitStatusForm(select, reason = '') {
    const form = select.form;
    const reasonField = form.querySelector('.admin-reason-field');
    if (reasonField) reasonField.value = reason;
    form.submit();
}

function resetSelect(select) {
    select.value = select.dataset.current;
    const currentOption = select.querySelector(`option[value="${select.value}"]`);
    if (currentOption) select.className = 'form-select form-select-sm w-auto ' + currentOption.dataset.color;
}
</script>

{{-- Modal Lý do hủy --}}
<div class="modal fade" id="cancelReasonModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="fw-medium">Vui lòng nhập lý do hủy đơn hàng này:</p>
                <textarea id="admin_reason_input" class="form-control" rows="3" placeholder="Ví dụ: Sản phẩm hết hàng, Khách không nghe máy..."></textarea>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger px-4" id="btnConfirmCancel">Xác nhận hủy</button>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #e0ebff; color: #0d6efd; }
    .bg-soft-info { background-color: #e0f7ff; color: #0dcaf0; }
    .bg-soft-success { background-color: #e6fffa; color: #198754; }
    .bg-soft-danger { background-color: #fee2e2; color: #ef4444; }
    .bg-soft-dark { background-color: #f1f1f1; color: #333; }
    .fs-20 { font-size: 20px; }
    .fs-12 { font-size: 12px; }
    .badge { font-weight: 600; border-radius: 6px; }
    .tooltip-inner {
        text-align: left !important;
        padding: 10px;
        max-width: 250px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 0.8rem;
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .btn {
        border-radius: 8px;
        font-weight: 600;
    }
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
</style>
@endsection