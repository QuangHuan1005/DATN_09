@extends('master')

@section('content')
@include('layouts.header')
<div class="container my-4">
  <div class="row">
    <div class="col-md-3">@include('account.partials.navigation')</div>
    <div class="col-md-9">
      <h1 class="h4 mb-3">Chi tiết đơn hàng</h1>

      {{-- 4a. Thông tin chung --}}
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex flex-wrap justify-content-between">
            <div>
              <div class="fw-semibold">Mã đơn: {{ $order->order_code }}</div>
              <div class="text-muted small">
                Ngày đặt: {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
              </div>
            </div>
            <div class="text-end">
              <div>Trạng thái: <span class="badge bg-secondary">{{ $order->status->name ?? '-' }}</span></div>
              <div class="small">Thanh toán: <span class="badge bg-light text-dark">{{ $order->paymentStatus->name ?? '-' }}</span></div>
            </div>
          </div>

          <hr>
          <div class="row small">
            <div class="col-md-6">
              <div class="fw-semibold mb-2">Thông tin người nhận</div>
              <div>Họ tên: {{ $order->name }}</div>
              <div>Điện thoại: {{ $order->phone }}</div>
              <div>Địa chỉ: {{ $order->address }}</div>
              @if(auth()->user()?->email)
              <div>Email: {{ auth()->user()->email }}</div>
              @endif
            </div>
            <div class="col-md-6">
              <div class="fw-semibold mb-2">Thanh toán & vận chuyển</div>
              @php
                $pay = $order->payments->first();
              @endphp
              <div>Phương thức: {{ $pay?->method?->name ?? '—' }}</div>
              <div>Mã thanh toán: {{ $pay?->payment_code ?? '—' }}</div>
              <div>Số tiền thanh toán: {{ number_format($pay?->payment_amount ?? 0,0,',','.') }}₫</div>
              @if($order->voucher)
                <div>Giảm giá (voucher {{ $order->voucher->voucher_code }}): -{{ number_format($order->discount,0,',','.') }}₫</div>
              @endif
            </div>
          </div>
        </div>
      </div>

      {{-- 4b. Danh sách sản phẩm --}}
      <div class="card mb-3">
        <div class="card-header fw-semibold">Sản phẩm trong đơn</div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th>Sản phẩm</th>
                  <th>Thuộc tính</th>
                  <th class="text-end">Đơn giá</th>
                  <th class="text-center">SL</th>
                  <th class="text-end">Thành tiền</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($order->details as $d)
                  @php
                    $p  = $d->variant?->product;
                    $att = [];
                    if($d->variant?->color?->name) $att[] = 'Màu: '.$d->variant->color->name;
                    if($d->variant?->size?->name)  $att[] = 'Size: '.$d->variant->size->name;
                  @endphp
                  <tr>
                    <td>
                      <div class="fw-semibold">{{ $p?->name ?? 'Sản phẩm' }}</div>
                      <div class="text-muted small">Mã biến thể #{{ $d->product_variant_id }}</div>
                    </td>
                    <td class="small">{{ implode(' · ', $att) ?: '—' }}</td>
                    <td class="text-end">{{ number_format($d->price,0,',','.') }}₫</td>
                    <td class="text-center">{{ $d->quantity }}</td>
                    <td class="text-end">{{ number_format($d->price * $d->quantity,0,',','.') }}₫</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- 4c. Tổng tiền --}}
      <div class="card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-end">
            <div style="min-width:320px">
              <div class="d-flex justify-content-between">
                <span>Tạm tính</span>
                <span>{{ number_format($order->subtotal,0,',','.') }}₫</span>
              </div>
              <div class="d-flex justify-content-between">
                <span>Giảm giá</span>
                <span>-{{ number_format($order->discount,0,',','.') }}₫</span>
              </div>
              <hr class="my-2">
              <div class="d-flex justify-content-between fw-semibold fs-5">
                <span>Tổng tiền</span>
                <span>{{ number_format($order->total_amount,0,',','.') }}₫</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- 5. Hủy đơn hàng (nếu đủ điều kiện) --}}
      @if(in_array($order->order_status_id, [1,2]))
        <div class="mb-3">
          <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST"
                onsubmit="return confirm('Bạn chắc chắn muốn hủy đơn này?')">
            @csrf
            <button class="btn btn-outline-danger">
              Hủy đơn hàng
            </button>
            <span class="text-muted small ms-2">
              (Chỉ hủy khi đơn chưa xử lý/giao. Nếu đã thanh toán online, hệ thống đánh dấu hoàn tiền.)
            </span>
          </form>
        </div>
      @endif

      {{-- 6. Lịch sử thay đổi/trạng thái --}}
      <div class="card">
        <div class="card-header fw-semibold">Lịch sử đơn hàng</div>
        <div class="card-body">
          @forelse($order->notifs as $n)
            <div class="d-flex justify-content-between border-bottom py-2">
              <div>
                <div class="fw-semibold">{{ $n->title }}</div>
                <div class="text-muted small">{{ $n->content }}</div>
              </div>
              <div class="text-muted small">{{ \Carbon\Carbon::parse($n->created_at)->format('d/m/Y H:i') }}</div>
            </div>
          @empty
            <div class="text-muted">Chưa có lịch sử.</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
