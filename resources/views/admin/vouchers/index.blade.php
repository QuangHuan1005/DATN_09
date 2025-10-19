@extends('layouts.admin.app')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Quản lý Voucher</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('admin.vouchers.create') }}" class="btn btn-primary">+ Thêm voucher</a>
        </div>

        <div class="table-responsive ">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th>#</th>
                        <th>Mã voucher</th>
                        <th>Loại giảm giá</th>
                        <th>Giá trị giảm</th>
                        <th>Giá sau giảm tối thiểu</th>
                        <th>Điều kiện (đơn tối thiểu)</th>
                        <th>Số lượng</th>
                        <th>Đã dùng</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vouchers as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->voucher_code }}</td>
                            <td>
                                {{ $item->discount_type == 'fixed' ? 'Giảm cố định' : 'Giảm %' }}
                            </td>
                            <td>
                                {{ $item->discount_type == 'fixed' ? number_format($item->discount_value) . 'đ' : $item->discount_value . '%' }}
                            </td>
                              <td>
                                {{ $item->sale_price ? number_format($item->sale_price, 0, ',', '.') . ' đ' : '—' }}
                            </td>
                            <td>{{ number_format($item->min_order_value) }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->total_used }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Ngừng</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.vouchers.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>

                                <form action="{{ route('admin.vouchers.destroy', $item->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa voucher này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">Chưa có voucher nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $vouchers->links() }}
        </div>
    </div>
@endsection
