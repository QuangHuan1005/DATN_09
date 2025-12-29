@extends('admin.master')

@section('content')
<div class="container-xxl py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Lịch sử Đổi Voucher</h3>
            <p class="text-muted mb-0">Quản lý và theo dõi các lượt đổi điểm thưởng của khách hàng.</p>
        </div>
        <div class="text-end">
            <div class="card border-0 shadow-sm px-3 py-2">
                <span class="text-muted small d-block">Tổng lượt đổi</span>
                <span class="fw-bold text-primary fs-5">{{ number_format($history->total()) }}</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.vouchers.history') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Tìm kiếm</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="keyword" class="form-control bg-light border-start-0" 
                               placeholder="Tên khách, email hoặc mã..." value="{{ request('keyword') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">Trạng thái</label>
                    <select name="status" class="form-select bg-light">
                        <option value="">Tất cả</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Chưa sử dụng</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đã sử dụng</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-uppercase text-muted">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-1"></i> Lọc
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" style="width: 150px;">Ngày đổi</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Khách hàng</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Mã Voucher</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Điểm đã dùng</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Giá trị Voucher</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted text-center">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</div>
                                <div class="text-muted small">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 38px; height: 38px; min-width: 38px;">
                                        <span class="fw-bold small">{{ strtoupper(substr($item->user_name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $item->user_name }}</div>
                                        <div class="text-muted small">{{ $item->user_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded">
                                    <i class="bi bi-ticket-perforated me-1"></i> {{ $item->voucher_code }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-danger fw-bold">
                                    -{{ number_format($item->points_required) }} <small class="fw-normal">CP</small>
                                </span>
                            </td>
                            <td class="text-center fw-bold text-dark">
                                @if($item->discount_type == 'fixed')
                                    {{ number_format($item->discount_value) }}đ
                                @else
                                    {{ $item->discount_value }}%
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->is_used)
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill border border-success-subtle">
                                        <i class="bi bi-check-circle-fill me-1"></i> Đã sử dụng
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill border border-warning-subtle">
                                        <i class="bi bi-clock-history me-1"></i> Chưa sử dụng
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted fs-1"></i>
                                    <p class="text-muted mt-3">Không tìm thấy dữ liệu đổi thưởng nào phù hợp.</p>
                                    <a href="{{ route('admin.vouchers.history') }}" class="btn btn-sm btn-outline-primary">Tải lại danh sách</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($history->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $history->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .avatar-sm { font-size: 0.85rem; }
    .fs-13 { font-size: 13px; }
    .table thead th { border-top: none; }
    .card { transition: all 0.2s; }
    .btn-primary { box-shadow: 0 4px 6px rgba(13, 110, 253, 0.15); }
</style>
@endsection