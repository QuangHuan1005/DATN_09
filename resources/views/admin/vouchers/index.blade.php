@extends('admin.master')

@section('content')
<style>
    /* Tinh chỉnh để chữ to và rõ nét hơn */
    .container-xxl { font-size: 15px !important; }
    .table thead th { 
        font-size: 14px !important; 
        font-weight: 700 !important; 
        text-transform: uppercase; 
        color: #334155 !important;
        padding: 18px 12px !important;
    }
    .table tbody td { 
        padding: 18px 12px !important; 
        vertical-align: middle !important;
        font-size: 15px !important;
    }
    .fw-bold.text-primary { font-size: 16px !important; }
    .badge { font-size: 13px !important; padding: 6px 12px !important; }
    .form-control { font-size: 15px !important; padding: 10px 15px !important; }
    .btn-primary { font-size: 15px !important; font-weight: 600 !important; }
</style>

<div class="container-xxl py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Quản lý hệ thống Voucher</h3>
        <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success px-4">
            <i class="bi bi-plus-circle me-2"></i> Thêm Voucher Mới
        </a>
    </div>

    {{-- Alert Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tìm kiếm --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.vouchers.index') }}">
                <div class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="search" name="keyword" class="form-control bg-light border-start-0" 
                                    placeholder="Tìm kiếm theo mã voucher hoặc mô tả..." value="{{ request('keyword') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 py-2">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Bảng danh sách voucher --}}
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Mã voucher</th>
                            <th class="text-center">Giá trị</th> 
                            <th class="text-center">Giảm tối đa</th> 
                            <th class="text-center">Đơn tối thiểu</th> 
                            <th class="text-center">Điểm đổi</th> 
                            <th class="text-center">SL còn/Tổng</th> 
                            <th class="text-center">Thời gian</th> 
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Sản phẩm</th> 
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($vouchers as $key => $item)
                            <tr>
                                <td class="text-center text-muted">{{ $vouchers->firstItem() + $key }}</td>
                                <td class="fw-bold text-primary">{{ $item->voucher_code }}</td>

                                <td class="text-center">
                                    @if ($item->discount_type === 'fixed')
                                        <span class="fw-bold text-dark">{{ number_format($item->discount_value) }}đ</span>
                                        <br><small class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Cố định</small>
                                    @else
                                        <span class="fw-bold text-dark">{{ $item->discount_value }}%</span>
                                        <br><small class="badge bg-info-subtle text-info border border-info-subtle">Phần trăm</small>
                                    @endif
                                </td>
                                
                                <td class="text-center text-danger fw-medium">
                                    {{ $item->discount_type === 'percent' && $item->sale_price ? number_format($item->sale_price) . 'đ' : '—' }}
                                </td>

                                <td class="text-center">
                                    {{ number_format($item->min_order_value) }}đ
                                </td>

                                <td class="text-center">
                                    @if($item->points_required > 0)
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-coin me-1"></i>{{ number_format($item->points_required) }} CP
                                        </span>
                                    @else
                                        <span class="text-muted small">Công khai</span>
                                    @endif
                                </td>
                                
                                <td class="text-center fw-medium">
                                    <span class="text-success">{{ $item->quantity - $item->total_used }}</span> / <span class="text-muted">{{ $item->quantity }}</span>
                                </td>

                                <td class="text-center small">
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }}</div>
                                    <div class="text-muted">{{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}</div>
                                </td>

                                <td class="text-center">
                                    @switch($item->display_status)
                                        @case('expired')
                                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2">Hết hạn</span>
                                            @break
                                        @case('out_of_stock')
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2">Hết mã</span>
                                            @break
                                        @default
                                            <span class="badge bg-success-subtle text-success px-3 py-2 border border-success-subtle">Hoạt động</span>
                                    @endswitch
                                </td>
                                
                                <td class="text-center">
                                    @if ($item->products->count() > 0)
                                        <span class="badge bg-info text-white cursor-pointer" 
                                              data-bs-toggle="tooltip" title="{{ $item->products->pluck('name')->implode(', ') }}">
                                            {{ $item->products->count() }} SP <i class="bi bi-tag-fill ms-1"></i>
                                        </span>
                                    @else
                                        <span class="text-muted small">Tất cả</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.vouchers.edit', $item->id) }}"
                                            class="btn btn-soft-warning p-2" title="Sửa voucher">
                                             <iconify-icon icon="solar:pen-new-square-broken" class="fs-4"></iconify-icon>
                                        </a>

                                        <form action="{{ route('admin.vouchers.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger p-2" 
                                                    onclick="return confirm('Xóa voucher {{ $item->voucher_code }}?')">
                                                 <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="fs-4"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="bi bi-ticket-perforated text-muted display-1"></i>
                                    <p class="mt-3 fs-5 text-muted">Không tìm thấy mã voucher nào.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white py-3 border-top">
            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-medium text-muted">Tổng cộng: {{ $vouchers->total() }} voucher</span>
                <div>{{ $vouchers->withQueryString()->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tự ẩn alert sau 4 giây
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 4000);

        // Kích hoạt Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection