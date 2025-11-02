@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Chi tiết đơn hàng: {{ $order->order_code }}</h3>

    {{-- THÔNG BÁO --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        {{-- THÔNG TIN TÀI KHOẢN --}}
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light fw-bold">Thông tin tài khoản</div>
                <div class="card-body">
                    @if($order->user)
                        <p><strong>Tên tài khoản:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->user->phone ?? 'Không có' }}</p>
                        <p><strong>Ngày đăng ký:</strong> {{ $order->user->created_at->format('d/m/Y') }}</p>
                    @else
                        <p class="text-muted">Đơn hàng được tạo bởi khách vãng lai (không có tài khoản).</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- THÔNG TIN KHÁCH HÀNG / NGƯỜI NHẬN --}}
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light fw-bold">Thông tin khách hàng / giao hàng</div>
                <div class="card-body">
                    <p><strong>Tên người nhận:</strong> {{ $order->name }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
                    <p><strong>Email liên hệ:</strong> {{ $order->email ?? ($order->user?->email ?? 'Không có') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- THÔNG TIN ĐƠN HÀNG --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light fw-bold">Thông tin đơn hàng</div>
        <div class="card-body row">
            <div class="col-md-6">
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</p>
                <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Trạng thái đơn hàng:</strong> {{ $order->status ? $order->status->name : 'Chưa xác định' }}</p>

            </div>

            <div class="col-md-6">
                <p><strong>Trạng thái thanh toán:</strong> 
                    {{ $order->paymentStatus->name ?? 'Chưa xác định' }}
                </p>

                <p><strong>Phương thức thanh toán:</strong> 
                    {{ $order->paymentMethod->name ?? 'Chưa chọn' }}
                </p>

                @if($order->voucher)
                    <p><strong>Mã giảm giá:</strong> {{ $order->voucher->voucher_code }}</p>
                    <ul class="list-unstyled ms-2 text-muted">
                        <li>Giảm: <strong>{{ number_format($order->voucher->sale_price, 0, ',', '.') }} đ</strong></li>
                        <li>Đơn tối thiểu: <strong>{{ number_format($order->voucher->min_order_value, 0, ',', '.') }} đ</strong></li>
                        <li>Mô tả: {{ $order->voucher->description ?? 'Không có' }}</li>
                    </ul>
                @else
                    <p><strong>Mã giảm giá:</strong> Không sử dụng</p>
                @endif
            </div>
        </div>
    </div>

    {{-- CHI TIẾT SẢN PHẨM --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light fw-bold">Chi tiết sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Biến thể</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lines as $line)
                        <tr>
                            <td>
                                @if($line->image)
                                    <img src="{{ asset('storage/' . $line->image) }}" width="60" alt="image">
                                @else
                                    <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td>{{ $line->product_name }}</td>
                            <td>{{ $line->variant_text ?? '-' }}</td>
                            <td>{{ number_format($line->unit_price, 0, ',', '.') }} đ</td>
                            <td>{{ $line->qty }}</td>
                            <td>{{ number_format($line->line_total, 0, ',', '.') }} đ</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted">Không có sản phẩm nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TỔNG TIỀN --}}
    <div class="card shadow-sm">
        <div class="card-body text-end">
            <p><strong>Tạm tính:</strong> {{ number_format($calc_subtotal, 0, ',', '.') }} đ</p>
            <p><strong>Giảm giá:</strong> -{{ number_format($calc_discount, 0, ',', '.') }} đ</p>
            <hr>
            <h5><strong>Tổng cộng:</strong> {{ number_format($calc_total, 0, ',', '.') }} đ</h5>
        </div>
    </div>

    {{-- HÀNH ĐỘNG --}}
    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>

        <div>
            @if(in_array($order->order_status, ['pending', 'confirmed']))
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        Hủy đơn hàng
                    </button>
                </form>
            @endif

            {{-- Chỉ admin mới có thể cập nhật trạng thái --}}
            @if(auth()->user()?->isAdmin())
                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    <select name="status" class="form-select d-inline w-auto">
                        <option value="pending" {{ $order->order_status=='pending'?'selected':'' }}>Chờ xác nhận</option>
                        <option value="confirmed" {{ $order->order_status=='confirmed'?'selected':'' }}>Đã xác nhận</option>
                        <option value="shipping" {{ $order->order_status=='shipping'?'selected':'' }}>Đang giao</option>
                        <option value="delivered" {{ $order->order_status=='delivered'?'selected':'' }}>Đã giao</option>
                        <option value="cancelled" {{ $order->order_status=='cancelled'?'selected':'' }}>Đã hủy</option>
                    </select>
                    <button class="btn btn-primary ms-1">Cập nhật</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
