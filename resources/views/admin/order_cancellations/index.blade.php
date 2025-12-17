@extends('admin.master')

@section('content')
<div class="container-xxl">
    
    <h3 class="fw-bold mb-4">🔔 Yêu Cầu Hủy Đơn Hàng Đang Chờ Xử Lý</h3>

    {{-- Thông báo thành công / lỗi --}}
    @foreach (['success', 'error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Bảng danh sách Yêu cầu Hủy --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Thời Gian Gửi Yêu Cầu</th>
                            <th>Khách Hàng</th>
                            <th>Lý Do Hủy</th>
                            <th>Trạng Thái Yêu Cầu</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cancelRequests as $request)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.orders.show', $request->order_id) }}" class="link-primary fw-bold">
                                        #{{ $request->order->order_code ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>{{ $request->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td>
                                    {{ $request->user->name ?? $request->order->name ?? 'Khách lẻ' }}
                                </td>
                                <td>
                                    {{ Str::limit($request->reason_user, 50) }}
                                </td>
                                
                                {{-- Trạng thái Yêu cầu Hủy --}}
                                <td>
                                    {{-- Giả định $request->status->slug là 'pending' --}}
                                    @php
                                        $badgeClass = match ($request->status->slug ?? 'pending') {
                                            'pending' => 'badge bg-warning text-dark',
                                            'accepted' => 'badge bg-success',
                                            'rejected' => 'badge bg-danger',
                                            default => 'badge bg-secondary',
                                        };
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $request->status->name ?? 'N/A' }}</span>
                                </td>

                                {{-- Thao tác --}}
                                <td>
                                    {{-- Nút Xem chi tiết và Xử lý --}}
                                    <a href="{{ route('admin.order-cancellations.show', $request->id) }}" class="btn btn-soft-primary btn-sm" title="Xem & Xử lý">
                                        <iconify-icon icon="solar:pen-new-square-broken" class="fs-18"></iconify-icon>
                                        Xử lý
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">🎉 Không có yêu cầu hủy nào đang chờ xử lý!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $cancelRequests->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Script để ẩn alert --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => alert.classList.add('d-none'), 3000);
    });
});
</script>
@endsection