@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <!-- Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Admin Dashboard</h1>
        </div>
    </div>

    <!-- Navigation Cards -->
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-palette fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Biến thể sản phẩm</h5>
                    <p class="card-text">Quản lý kích thước và màu sắc</p>
                    <a href="{{ route('admin.products.variants') }}" class="btn btn-success btn-lg">Quản lý biến thể</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <h3>Thao tác nhanh</h3>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('admin.products.variants') }}" class="btn btn-outline-success">
                    <i class="fas fa-plus"></i> Thêm biến thể sản phẩm
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
