@extends('master')

@section('content')
@include('layouts.header')
<div class="container my-4">
  <div class="row">
    <div class="col-md-3">@include('account.partials.navigation')</div>
    <div class="col-md-9">
      <h1 class="h4 mb-3">Đơn hàng của tôi</h1>

      @forelse ($orders as $o)
        <div class="card mb-3">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-semibold">Mã đơn: {{ $o->order_code }}</div>
              <div class="text-muted small">
                Ngày đặt: {{ \Carbon\Carbon::parse($o->created_at)->format('d/m/Y H:i') }} ·
                Trạng thái: <span class="badge bg-secondary">{{ $o->status->name ?? '-' }}</span> ·
                Thanh toán: <span class="badge bg-light text-dark">{{ $o->paymentStatus->name ?? '-' }}</span>
              </div>
              <div class="small mt-1">Tổng tiền: <strong>{{ number_format($o->total_amount,0,',','.') }}₫</strong></div>
            </div>
            <a class="btn btn-outline-dark" href="{{ route('account.orders.show', $o->id) }}">Xem chi tiết</a>
          </div>
        </div>
      @empty
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
      @endforelse

      {{ $orders->links() }}
    </div>
  </div>
</div>
@endsection
