@extends('admin.master')

@section('content')
<div class="container-xxl">
    
    <h3 class="fw-bold mb-4">🔔 Quản Lý Yêu Cầu Hủy Đơn</h3>

    {{-- Thông báo thành công / lỗi --}}
    @foreach (['success', 'error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Form lọc: keyword bên trái, date + status + nút lọc bên phải (Y hệt trang Đơn hàng) --}}
    <div class="row mb-3 align-items-center">
        {{-- Keyword bên trái --}}
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.order-cancellations.index') }}" class="d-flex gap-2">
                <input type="search" name="search" class="form-control" placeholder="Tìm mã đơn / tên KH"
                        value="{{ request('search') }}" style="max-width: 250px;">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        {{-- Date + Status + Nút Lọc bên phải --}}
        <div class="col-md-6 text-end">
            <form method="GET" action="{{ route('admin.order-cancellations.index') }}" class="d-flex gap-2 justify-content-end">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" style="max-width: 180px;">
                <select name="status" class="form-select w-auto">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Đã chấp nhận</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                </select>
                <button type="submit" class="btn btn-success">Lọc</button>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-3">Mã Đơn Hàng</th>
                            <th>Thời Gian Gửi</th>
                            <th>Khách Hàng</th>
                            <th>Phương Thức thanh toán</th>
                            <th>Lý Do Hủy</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-center">Thao Tác</th>
                        </tr>
                    </thead>
                   <tbody>
            @foreach($cancelRequests as $item)
            <tr>
                <td class="ps-3 fw-bold text-primary">#{{ $item->order->order_code ?? 'N/A' }}</td>
                <td>
                    <div class="small">{{ $item->created_at->format('d/m/Y') }}</div>
                    <div class="text-muted small">{{ $item->created_at->format('H:i') }}</div>
                </td>
                <td>
                    <div class="fw-bold">{{ $item->user->name ?? $item->order->name }}</div>
                    <div class="text-muted small">{{ $item->order->phone }}</div>
                </td>
              <td class="text-center"> {{-- Thêm class text-center ở đây --}}
    @if($item->order->payment_method_id == 1)
        {{-- COD: Màu xanh lá cây - Nổi bật, căn giữa --}}
        <span class="badge bg-success text-white p-2 w-100" style="max-width: 180px;">
            THANH TOÁN COD
        </span>
    @else
        {{-- VNPAY: Màu đỏ - Nổi bật, căn giữa --}}
        <span class="badge bg-danger text-white p-2 w-100" style="max-width: 180px;">
            VNPAY (CẦN HOÀN TIỀN)
        </span>
    @endif
</td>
                <td>
                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $item->reason_user }}">
                        {{ $item->reason_user }}
                    </span>
                </td>
                <td>
                    @php
                        $badgeClass = match($item->status) {
                            'pending'  => 'bg-warning text-dark',
                            'accepted' => 'bg-success',
                            'rejected' => 'bg-danger',
                            'refunded' => 'bg-dark',
                            default    => 'bg-secondary'
                        };
                        $statusName = match($item->status) {
                            'pending'  => 'Chờ xử lý',
                            'accepted' => 'Đã chấp nhận',
                            'rejected' => 'Đã từ chối',
                            'refunded' => 'Đã hoàn tiền',
                            default    => $item->status
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $statusName }}</span>
                </td>
                <td class="text-end pe-3">
                    <a href="{{ route('admin.order-cancellations.show', $item->id) }}" class="btn btn-sm btn-outline-dark">
                        <i class="bx bx-show align-middle"></i> Chi tiết
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
                </table>
            </div>
        </div>

        @if($cancelRequests->hasPages())
        <div class="card-footer bg-white">
            {{ $cancelRequests->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection