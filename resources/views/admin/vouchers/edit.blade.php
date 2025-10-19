@extends('layouts.admin.app')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Chỉnh sửa Voucher</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Mã voucher</label>
                    <input type="text" name="voucher_code" value="{{ old('voucher_code', $voucher->voucher_code) }}"
                        class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Loại giảm giá</label>
                    <select name="discount_type" id="discount_type" class="form-select">
                        <option value="fixed"
                            {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>Giảm cố định
                            (VNĐ)</option>
                        <option value="percent"
                            {{ old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : '' }}>Giảm theo %
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="quantity" value="{{ old('quantity', $voucher->quantity) }}"
                        class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Giới hạn mỗi người</label>
                    <input type="number" name="user_limit" value="{{ old('user_limit', $voucher->user_limit) }}"
                        class="form-control">
                </div>
               
            </div>

            <div class="row mb-3">
                 <div class="col-md-4">
                    <label class="form-label">
                        Giá trị giảm (<span
                            id="discount_label">{{ $voucher->discount_type == 'fixed' ? 'VNĐ' : '%' }}</span>)
                    </label>
                    <input type="number" name="discount_value" id="discount_value"
                        value="{{ old('discount_value', $voucher->discount_value) }}" class="form-control" step="1"
                        min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Giá trị đơn hàng tối thiểu</label>
                    <input type="number" name="min_order_value"
                        value="{{ old('min_order_value', $voucher->min_order_value) }}" class="form-control" step="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Giá sau giảm tối thiểu (sale_price)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $voucher->sale_price) }}"
                        class="form-control" step="1000" min="0">
                    <small class="text-muted">Đảm bảo giá sau giảm không thấp hơn mức này</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', substr($voucher->start_date, 0, 10)) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" value="{{ old('end_date', substr($voucher->end_date, 0, 10)) }}"
                        class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="1" {{ old('status', $voucher->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status', $voucher->status) == 0 ? 'selected' : '' }}>Ngừng</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $voucher->description) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">Cập nhật voucher</button>
            </div>
        </form>
    </div>

    <script>
        // Cập nhật nhãn đơn vị giảm giá
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('discount_type');
            const label = document.getElementById('discount_label');
            typeSelect.addEventListener('change', function() {
                label.textContent = this.value === 'fixed' ? 'VNĐ' : '%';
            });
        });
    </script>
@endsection
