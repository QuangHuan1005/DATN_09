@extends('admin.master')

@section('content')
<div class="container-xxl">
    
    <h3 class="fw-bold mb-4">Danh Sách Đơn Hàng</h3>

    {{-- Thông báo thành công / lỗi --}}
    @foreach (['success', 'error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Form lọc --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
                <input type="search" name="keyword" class="form-control" placeholder="Tìm mã đơn / tên KH"
                        value="{{ request('keyword') }}" style="max-width: 250px;">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        <div class="col-md-6 text-end">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2 justify-content-end">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="max-width: 180px;">
                <select name="status" class="form-select w-auto">
                    <option value="">Tất cả trạng thái</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success">Lọc</button>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Ngày Tạo</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Phương Thức</th> {{-- Cột thêm mới --}}
                            <th>Thanh Toán</th>   {{-- Trạng thái thanh toán --}}
                            <th>Sản Phẩm</th>
                            <th class="text-center">Hủy Yêu Cầu</th>
                            <th>Trạng Thái Đơn</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                // Logic màu trạng thái đơn hàng
                                $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                                $colorClass = $currentStatus->color_class ?? 'border-secondary text-secondary';
                                
                                // Logic màu trạng thái thanh toán
                                $paymentColors = [
                                    1 => 'badge border border-primary text-primary',
                                    2 => 'badge border border-warning text-warning',
                                    3 => 'badge border border-success text-success',
                                    4 => 'badge border border-danger text-danger',
                                    5 => 'badge border border-secondary text-secondary',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                $paymentName = $order->paymentStatus->name ?? 'Không xác định';

                                // Logic hiển thị phương thức thanh toán
                                $methodColors = [
                                    1 => 'text-dark',      // COD
                                    2 => 'text-primary',   // VNPAY
                                    3 => 'text-danger',    // MOMO
                                ];
                                $methodColor = $methodColors[$order->payment_method_id] ?? 'text-muted';
                                $methodName = $order->paymentMethod->name ?? 'N/A';
                            @endphp
                            <tr>
                                <td><span class="fw-bold">{{ $order->order_code }}</span></td>
                                <td>{{ $order->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $order->user_id ?? 0) }}" class="link-primary">
                                        {{ $order->name ?? 'Khách lẻ' }}
                                    </a>
                                </td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                
                                {{-- Phương thức thanh toán --}}
                                <td>
                                    <span class="fw-medium {{ $methodColor }}">
                                        {{ $methodName }}
                                    </span>
                                </td>

                                {{-- Trạng thái thanh toán --}}
                                <td>
                                    <span class="{{ $paymentColor }} px-2 py-1 fs-13">{{ $paymentName }}</span>
                                </td>

                                <td>
    <span class="badge bg-light text-dark border px-2 py-1">
        <iconify-icon icon="solar:box-bold" class="align-middle me-1 text-secondary"></iconify-icon>
        {{ $order->details_sum_quantity ?? 0 }} SP
    </span>
</td>
                                {{-- Cột Cảnh báo Hủy --}}
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

                                {{-- Cập nhật trạng thái đơn hàng --}}
                                <td>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="status-form">
                                        @csrf
                                        <input type="hidden" name="admin_reason" class="admin-reason-field">
                                        <select name="order_status_id" class="form-select form-select-sm w-auto {{ $colorClass }}"
                                                onchange="confirmStatusChange(this)">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                        data-color="{{ $status->color_class }}"
                                                        {{ $order->order_status_id == $status->id ? 'selected' : '' }}
                                                        {{ in_array($status->id, [5,7]) ? 'disabled' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                {{-- Thao tác --}}
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-soft-info btn-sm">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Không có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Script xử lý logic Modal và Confirm --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ẩn alert sau 3s
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => alert.classList.add('d-none'), 3000);
    });

    // Khởi tạo màu sắc ban đầu cho select
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if(selectedOption && selectedOption.dataset.color){
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
        select.dataset.current = select.value;
    });

    // Xác nhận hủy đơn trong Modal
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

    // Nút đóng Modal
    const btnClose = document.getElementById('btnCancelModal');
    if (btnClose) {
        btnClose.addEventListener('click', function() {
            if (window.currentSelect) resetSelect(window.currentSelect);
            const modal = bootstrap.Modal.getInstance(document.getElementById('cancelReasonModal'));
            if(modal) modal.hide();
        });
    }
});

window.currentSelect = null;

function confirmStatusChange(select) {
    const newValue = select.value;
    const newStatusText = select.selectedOptions[0].text;
    window.currentSelect = select;

    if (newValue == "6") { // ID Trạng thái Hủy
        const modalElement = document.getElementById('cancelReasonModal');
        const modal = new bootstrap.Modal(modalElement);
        document.getElementById('admin_reason_input').value = ''; 
        modal.show();
    } else {
        if (confirm(`Bạn có chắc muốn đổi trạng thái sang "${newStatusText}"?`)) {
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

{{-- Modal Lý Do Hủy --}}
<div class="modal fade" id="cancelReasonModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Vui lòng nhập lý do hủy đơn hàng này:</p>
                <textarea id="admin_reason_input" class="form-control" rows="3" placeholder="Sản phẩm hết hàng, không liên lạc được khách..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnCancelModal">Đóng</button>
                <button type="button" class="btn btn-danger" id="btnConfirmCancel">Xác nhận hủy</button>
            </div>
        </div>
    </div>
</div>
@endsection