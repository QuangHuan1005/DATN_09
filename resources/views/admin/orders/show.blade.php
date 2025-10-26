@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
    <h3>Chi tiết đơn hàng: {{ $order->order_code }}</h3>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row mt-3">
        {{-- Thông tin khách hàng --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Thông tin khách hàng</div>
                <div class="card-body">
                    <p><strong>Tên:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user?->email ?? 'Không có' }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                </div>
            </div>
        </div>

        {{-- Thông tin đơn hàng --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Thông tin đơn hàng</div>
                <div class="card-body">
                    <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                    <p><strong>Trạng thái:</strong>
                        @if($order->status)
                            <span class="badge bg-{{ $order->status->color }}">
                                {{ $order->status->name }}
                            </span>
                        @else
                            <span class="text-muted">Chưa có</span>
                        @endif
                    </p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment?->method?->name ?? 'Chưa chọn' }}</p>
                    <p><strong>Tổng tiền:</strong> {{ number_format($order->calc_total,0,',','.') }} đ</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="card mb-3">
        <div class="card-header">Chi tiết sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered align-middle text-center">
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
                    @foreach($lines as $line)
                        <tr>
                            <td>
                                @if($line->image)
                                    <img src="{{ asset('storage/'.$line->image) }}" alt="image" style="width:60px;">
                                @else
                                    <span>Không có</span>
                                @endif
                            </td>
                            <td>{{ $line->product_name }}</td>
                            <td>{{ $line->variant_text ?? '-' }}</td>
                            <td>{{ number_format($line->unit_price,0,',','.') }} đ</td>
                            <td>{{ $line->qty }}</td>
                            <td>{{ number_format($line->line_total,0,',','.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tổng tiền --}}
    <div class="card mb-3">
        <div class="card-body text-end">
            <p><strong>Tạm tính:</strong> {{ number_format($calc_subtotal,0,',','.') }} đ</p>
            <p><strong>Giảm giá:</strong> {{ number_format($calc_discount,0,',','.') }} đ</p>
            <p><strong>Tổng cộng:</strong> {{ number_format($calc_total,0,',','.') }} đ</p>
        </div>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách đơn hàng</a>
</div>
@endsection
