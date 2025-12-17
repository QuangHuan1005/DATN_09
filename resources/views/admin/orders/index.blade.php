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

    {{-- Form lọc: keyword bên trái, date + status + nút lọc bên phải --}}
    <div class="row mb-3 align-items-center">
        {{-- Keyword --}}
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
                <input type="search" name="keyword" class="form-control" placeholder="Tìm mã đơn / tên KH"
                        value="{{ request('keyword') }}" style="max-width: 250px;">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        {{-- Date + Status + Nút Lọc --}}
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

    {{-- Bảng danh sách đơn hàng --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Ngày Tạo</th>
                            <th>Khách Hàng</th>
                            <th>Tổng Tiền</th>
                            <th>Thanh Toán</th>
                            <th>Sản Phẩm</th>
                            <th class="text-center">Hủy Yêu Cầu</th>  {{-- <--- CỘT MỚI --}}
                            <th>Trạng Thái</th>
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
                                    2 => 'badge border border-warning text-warning',
                                    3 => 'badge border border-success text-success',
                                    4 => 'badge border border-danger text-danger',
                                    5 => 'badge border border-secondary text-secondary',
                                ];
                                $paymentColor = $paymentColors[$order->payment_status_id] ?? 'bg-light text-dark';
                                $paymentName = $order->paymentStatus->name ?? 'Không xác định';
                            @endphp
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $order->user_id ?? 0) }}" class="link-primary">
                                        {{ $order->name ?? 'Khách lẻ' }}
                                    </a>
                                </td>
                                <td>{{ number_format($order->total_amount,0,',','.') }}₫</td>
                                <td>
                                    <span class="badge {{ $paymentColor }} px-2 py-1 fs-13">{{ $paymentName }}</span>
                                </td>
                                <td>{{ $order->details_sum_quantity ?? 0 }} sản phẩm</td>
                                
                                {{-- CỘT CẢNH BÁO YÊU CẦU HỦY (Liên kết đến trang xử lý) --}}
                                <td class="text-center">
                                    @if($order->cancelRequest && $order->cancelRequest->status_id == 1)
                                        {{-- Yêu cầu đang chờ xử lý (status_id = 1) --}}
                                        <a href="{{ route('admin.order-cancellations.show', $order->cancelRequest->id) }}" 
                                           class="btn btn-warning btn-sm py-1 px-2" 
                                           title="Có yêu cầu hủy đang chờ duyệt!">
                                            <iconify-icon icon="solar:bell-bing-broken" class="fs-18 me-1"></iconify-icon> Duyệt
                                        </a>
                                    @elseif($order->cancelRequest)
                                        {{-- Yêu cầu đã tồn tại nhưng đã được xử lý (accepted/rejected) --}}
                                        <span class="text-success" title="Đã xử lý">
                                            <iconify-icon icon="solar:document-check-broken" class="fs-18"></iconify-icon>
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Cập nhật trạng thái --}}
                                <td>
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="status-form">
                                        @csrf
                                        <select name="order_status_id" class="form-select form-select-sm w-auto {{ $colorClass }}"
                                                onchange="confirmStatusChange(this)">
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                        data-color="{{ $status->color_class }}"
                                                        {{ $order->order_status_id == $status->id ? 'selected' : '' }}
                                                        {{ in_array($status->id, [5,6,7]) ? 'disabled' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>

                                {{-- Thao tác --}}
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Không có đơn hàng nào.</td> {{-- Cập nhật colspan thành 9 --}}
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

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ẩn alert sau 3s
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => alert.classList.add('d-none'), 3000);
    });

    // Set màu select trạng thái khi load
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if(selectedOption && selectedOption.dataset.color){
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
    });
    
    // Lưu trạng thái hiện tại (giá trị ban đầu) của select để reset nếu user cancel
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        select.dataset.current = select.value;
    });
});

function confirmStatusChange(select){
    const newStatusText = select.selectedOptions[0].text;
    const form = select.form;

    if(confirm(`Bạn có chắc chắn muốn đổi trạng thái sang "${newStatusText}" không?`)) {
        // Cập nhật màu và gửi form
        const color = select.selectedOptions[0].dataset.color || '';
        select.className = 'form-select form-select-sm w-auto ' + color;
        
        // Lưu lại giá trị mới (sau khi đã confirm)
        select.dataset.current = select.value; 
        
        form.submit();
    } else {
        // Đặt lại giá trị ban đầu nếu user hủy
        select.value = select.dataset.current;
        
        // Cập nhật lại màu về trạng thái cũ
        const currentOption = select.querySelector(`option[value="${select.value}"]`);
        const currentColor = currentOption ? currentOption.dataset.color : '';
        select.className = 'form-select form-select-sm w-auto ' + currentColor;
    }
}
</script>
@endsection