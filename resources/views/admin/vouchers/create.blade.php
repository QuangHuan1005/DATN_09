@extends('layouts.admin.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Thêm Voucher mới</h3>

    {{-- Hiển thị lỗi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.vouchers.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Mã voucher</label>
                <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Loại giảm giá</label>
                <select name="discount_type" class="form-select" id="discount_type">
                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo %</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Số lượng</label>
                <input type="number" name="quantity" value="{{ old('quantity', 1) }}" class="form-control" min="1">
            </div>
            <div class="col-md-6">
                <label class="form-label">Giới hạn mỗi người</label>
                <input type="number" name="user_limit" value="{{ old('user_limit', 1) }}" class="form-control" min="1">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">
                    Giá trị giảm (<span id="discount-label">{{ old('discount_type') == 'percent' ? '%' : 'VNĐ' }}</span>)
                </label>
                <input type="number" name="discount_value" value="{{ old('discount_value') }}" class="form-control" min="0" step="1">
                @error('discount_value')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" value="{{ old('min_order_value', 0) }}" class="form-control" step="1000" min="0">
            </div>

            <div class="col-md-4">
                <label class="form-label">Giá sau giảm tối thiểu (sale_price)</label>
                <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" class="form-control" step="1000" min="0">
                <small class="text-muted">Đảm bảo giá sau giảm không thấp hơn mức này</small>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Ngày bắt đầu</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Ngày kết thúc</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control">
            </div>
            <div class="">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ngừng</option>
                </select>
            </div>
            <div class="">
                <label class="form-label">Mô tả</label>
                <textarea name="description" rows="1" class="form-control">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Lưu voucher</button>
        </div>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('discount_type');
    const label = document.getElementById('discount-label');

    typeSelect.addEventListener('change', function () {
        label.textContent = this.value === 'fixed' ? 'VNĐ' : '%';
    });
});
</script>
