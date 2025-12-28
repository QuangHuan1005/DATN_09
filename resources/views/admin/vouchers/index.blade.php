@extends('admin.master')

@section('content')
<div class="container-xxl">
    <h3 class="mb-3">Quản lý Voucher</h3>

    {{-- Alert Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tìm kiếm + Thêm mới --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <form method="GET" action="{{ route('admin.vouchers.index') }}" class="d-flex">
                <input type="search" name="keyword" class="form-control me-2"
                        placeholder="Tìm mã voucher..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>

        <div class="col-md-6 text-end">
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-success">
                <i class="bi bi-plus-square"></i> Thêm voucher
            </a>
        </div>
    </div>

    {{-- Bảng danh sách voucher đã Tối ưu --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0 align-middle">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Mã voucher</th>
                            <th class="text-center" style="width: 15%;">Giá trị</th> 
                            <th class="text-center">Giảm tối đa</th> 
                            <th class="text-center">Đơn tối thiểu</th> 
                            <th class="text-center">SL còn/Tổng</th> 
                            <th class="text-center" style="width: 10%;">Bắt đầu</th> 
                            <th class="text-center" style="width: 10%;">Kết thúc</th> 
                            <th class="text-center">TT</th>
                            <th class="text-center">SP áp dụng</th> 
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($vouchers as $key => $item)
                            <tr>
                                <td class="text-center">{{ $vouchers->firstItem() + $key }}</td>
                                <td class="text-center fw-bold">{{ $item->voucher_code }}</td>

                                {{-- Cột Giá trị --}}
                                <td class="text-center">
                                    @if ($item->discount_type === 'fixed')
                                        {{ number_format($item->discount_value) }}đ 
                                        <span class="badge text-bg-secondary">Cố định</span>
                                    @else
                                        {{ $item->discount_value }}% 
                                        <span class="badge text-bg-secondary">Phần trăm</span>
                                    @endif
                                </td>
                                
                                {{-- Cột Giảm tối đa --}}
                                <td class="text-center">
                                    @if ($item->discount_type === 'fixed')
                                        <span class="text-muted">—</span> 
                                    @else
                                        {{ $item->sale_price ? number_format($item->sale_price) . 'đ' : '—' }}
                                    @endif
                                </td>

                                {{-- Cột Đơn tối thiểu --}}
                                <td class="text-center">
                                    {{ number_format($item->min_order_value) }}đ
                                </td>
                                
                                {{-- Cột SL còn / Tổng --}}
                                <td class="text-center fw-medium">
                                    {{ $item->quantity - $item->total_used }} / {{ $item->quantity }}
                                </td>

                                {{-- Ngày bắt đầu/Kết thúc --}}
                                <td class="text-center">{{ \Carbon\Carbon::parse($item->start_date)->format('d-m H:i') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($item->end_date)->format('d-m H:i') }}</td>

                                {{-- Trạng thái (TT) --}}
                               <td class="text-center">
    @switch($item->display_status)
        @case('stopped')
            <span class="badge bg-danger-subtle text-danger px-2 py-1 border border-danger-subtle">
                <i class="bi bi-pause-circle-fill me-1"></i> Dừng
            </span>
            @break

        @case('expired')
            <span class="badge bg-secondary-subtle text-secondary px-2 py-1 border border-secondary-subtle">
                <i class="bi bi-calendar-x-fill me-1"></i> Hết hạn
            </span>
            @break

        @case('out_of_stock')
            <span class="badge bg-warning-subtle text-warning px-2 py-1 border border-warning-subtle">
                <i class="bi bi-exclamation-octagon-fill me-1"></i> Hết mã
            </span>
            @break

        @case('upcoming')
            <span class="badge bg-info-subtle text-info px-2 py-1 border border-info-subtle">
                <i class="bi bi-clock-history me-1"></i> Sắp chạy
            </span>
            @break

        @default
            <span class="badge bg-success-subtle text-success px-2 py-1 border border-success-subtle">
                <i class="bi bi-check-circle-fill me-1"></i> Hoạt động
            </span>
    @endswitch
</td>
                                
                                {{-- Sản phẩm áp dụng --}}
                                <td class="text-center">
                                    @if ($item->products->count() > 0)
                                        <span class="badge text-bg-info" 
                                              data-bs-toggle="tooltip" 
                                              data-bs-placement="top" 
                                              title="{{ $item->products->pluck('name')->implode(', ') }}">
                                            {{ $item->products->count() }} SP <i class="bi bi-tag-fill"></i>
                                        </span>
                                    @else
                                        <span class="text-muted">Tất cả</span>
                                    @endif
                                </td>

                                {{-- Thao tác (ICON + CSS TỐI ƯU) --}}
                                <td class="text-center text-nowrap">
                                    
                                    {{-- Sửa --}}
                                    <a href="{{ route('admin.vouchers.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm px-1 py-0 me-1" title="Sửa voucher">
                                         <iconify-icon icon="solar:pen-new-square-broken" class="fs-18"></iconify-icon>
                                    </a>

                                    {{-- Xóa --}}
                                    <form action="{{ route('admin.vouchers.destroy', $item->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc muốn xóa voucher {{ $item->voucher_code }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-1 py-0" title="Xóa voucher">
                                             <iconify-icon icon="solar:trash-bin-minimalistic-broken" class="fs-18"></iconify-icon>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    Không có voucher nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Phân trang --}}
        <div class="card-footer">
            {{ $vouchers->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tự ẩn alert sau 3 giây
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.classList.add('d-none');
            }, 3000);
        });

        // Kích hoạt Tooltips cho cột Sản phẩm áp dụng và các nút icon (Bootstrap)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], [title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection