@extends('master')

@section('content')
@include('layouts.header')

<div class="container my-4">
  <div class="row">
    <div class="col-md-3">@include('account.partials.navigation')</div>
    <div class="col-md-9">
      <h1 class="h4 mb-3">Thông tin tài khoản</h1>

      <div class="card">
        <div class="card-body">
          <p><strong>Họ tên:</strong> {{ auth()->user()->name }}</p>
          <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
          @if(auth()->user()->phone)<p><strong>SĐT:</strong> {{ auth()->user()->phone }}</p>@endif
          @if(auth()->user()->address)<p><strong>Địa chỉ:</strong> {{ auth()->user()->address }}</p>@endif

          <a href="{{ route('account.dashboard') }}" class="btn btn-outline-secondary mt-3">← Về bảng điều khiển</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
