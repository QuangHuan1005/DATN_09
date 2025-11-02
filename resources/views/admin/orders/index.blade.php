@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Quản lý đơn hàng</h3>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Bộ lọc --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-3 d-flex align-items-center gap-2">
        <select name="status" class="form-select w-auto">
            <option value="">-- Tất cả trạng thái --</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control w-25"
               placeholder="Tìm theo mã đơn hoặc tên KH">

        <button class="btn btn-primary">Lọc</button>
    </form>

    {{-- Bảng đơn hàng --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Mã đơn</th>
                    <th>Tên KH</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái đơn</th>
                     <th>Phương thức thanh toán</th>
                    <th>Trạng thái thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $currentStatus = collect($statuses)->firstWhere('id', $order->order_status_id);
                        $colorClass = $currentStatus ? $currentStatus->color_class : '';
                    @endphp
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ number_format($order->total_amount, 0, ',', '.') }} đ</td>

                        {{-- Trạng thái đơn --}}
                        <td>
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="status-form">
                                @csrf
                                <select name="order_status_id" 
                                        class="form-select form-select-sm w-auto {{ $colorClass }}" 
                                        onchange="changeStatusColor(this); this.form.submit()">
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

                         {{-- Phương thức thanh toán --}}
                        <td>
                            @if($order->paymentMethod)
                                @php
                                    $method = $order->paymentMethod->name;
                                    $type = $order->paymentMethod->type;
                                    $badgeColor = $type === 'online' ? 'info' : 'secondary';
                                    $icon = $type === 'online' ? 'bi-wifi' : 'bi-cash';
                                @endphp
                                <span class="badge bg-{{ $badgeColor }}">
                                    <i class="bi {{ $icon }}"></i> {{ $method }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Chưa chọn</span>
                            @endif
                        </td>

                        {{-- Trạng thái thanh toán --}}
                        <td>
                            @if($order->paymentStatus)
                                @php
                                    $paymentColor = match($order->paymentStatus->id) {
                                        1 => 'bg-warning',
                                        2 => 'bg-success',
                                        3 => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $paymentColor }}">
                                    {{ $order->paymentStatus->name }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Chưa chọn</span>
                            @endif
                        </td>

                        {{-- Hành động --}}
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Không có đơn hàng nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- JS để toast tự ẩn và thay đổi màu select --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tự ẩn alert sau 3s
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            alert.classList.add('hide');
        }, 3000);
    });

    // Set màu ban đầu cho tất cả select
    document.querySelectorAll('select[name="order_status_id"]').forEach(select => {
        const selectedOption = select.selectedOptions[0];
        if (selectedOption && selectedOption.dataset.color) {
            select.className = 'form-select form-select-sm w-auto ' + selectedOption.dataset.color;
        }
    });
});

// Hàm thay đổi màu khi đổi select
function changeStatusColor(select) {
    const colorClass = select.selectedOptions[0].dataset.color || '';
    select.className = 'form-select form-select-sm w-auto ' + colorClass;
}
</script>
@endsection
