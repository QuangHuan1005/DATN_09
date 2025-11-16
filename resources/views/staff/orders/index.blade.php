@extends('admin.master')

@section('content')
<div class="container-xxl">

    {{-- Thông báo thành công / lỗi --}}
    @foreach (['success', 'error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Tìm kiếm + lọc trạng thái --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('staff.orders.index') }}" class="d-flex">
                <input type="search" name="keyword" class="form-control me-2" placeholder="Tìm mã đơn / tên KH"
                    value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <div class="dropdown">
                <a href="#" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    {{ match (request('status')) {
                        '1' => 'Chờ xác nhận',
                        '2' => 'Xác nhận',
                        '3' => 'Đang giao hàng',
                        '4' => 'Đã giao hàng',
                        '5' => 'Hoàn thành',
                        '6' => 'Hủy',
                        '7' => 'Hoàn hàng',
                        default => 'Tất cả trạng thái',
                    } }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('staff.orders.index') }}" class="dropdown-item">Tất cả trạng thái</a>
                    @foreach($statuses as $status)
                        <a href="{{ route('staff.orders.index', ['status' => $status->id]) }}" class="dropdown-item">
                            {{ $status->name }}
                        </a>
                    @endforeach
                </div>
            </div>
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
                                    <a href="{{ route('staff.users.show', $order->user_id ?? 0) }}" class="link-primary">
                                        {{ $order->name ?? 'Khách lẻ' }}
                                    </a>
                                </td>
                                <td>{{ number_format($order->total_amount,0,',','.') }}₫</td>
                                <td>
                                    <span class="badge {{ $paymentColor }} px-2 py-1 fs-13">{{ $paymentName }}</span>
                                </td>
                                <td>{{ $order->details_sum_quantity ?? 0 }} sản phẩm</td>

                                {{-- Cập nhật trạng thái --}}
                                <td>
                                    <form action="{{ route('staff.orders.status', $order->id) }}" method="POST" class="status-form">
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
                                    <a href="{{ route('staff.orders.show', $order->id) }}" class="btn btn-soft-info btn-sm" title="Xem chi tiết">
                                        <iconify-icon icon="solar:eye-broken" class="fs-18"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Không có đơn hàng nào.</td>
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
    });

    function changeStatusColor(select){
        const color = select.selectedOptions[0].dataset.color || '';
        select.className = 'form-select form-select-sm w-auto ' + color;
    }

     function confirmStatusChange(select) {
        const newStatusText = select.selectedOptions[0].text;
        const form = select.form;

        if(confirm(`Bạn có chắc chắn muốn đổi trạng thái sang "${newStatusText}" không?`)) {
            // Nếu đồng ý, đổi màu và submit
            const color = select.selectedOptions[0].dataset.color || '';
            select.className = 'form-select form-select-sm w-auto ' + color;
            select.dataset.current = select.value; // cập nhật giá trị hiện tại
            form.submit();
        } else {
            // Nếu cancel, trả về trạng thái cũ
            select.value = select.dataset.current;
        }
    }
</script>
@endsection
