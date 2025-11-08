@extends('admin.master')

@section('title', 'Staff Dashboard')

@section('menu')
    @include('staff.layouts.menu-nav')
@endsection

@section('content')
<div class="container">
    <h1>Chào mừng nhân viên!</h1>
    <p>Đây là trang dashboard dành riêng cho Staff.</p>
</div>
@endsection
