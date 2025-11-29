@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Thêm Voucher mới</h3>
    </div>

    {{-- Hiển thị lỗi validation --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading fs-15"><i class="bi bi-exclamation-triangle me-2"></i> Lỗi nhập liệu</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form thêm Voucher mới --}}
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                {{-- Hàng 1: Mã Voucher & Loại giảm giá --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mã voucher <span class="text-danger">*</span></label>
                        <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" class="form-select" id="discount_type" required>
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo %</option>
                        </select>
                    </div>
                </div>

                {{-- Hàng 2: Số lượng & Giới hạn mỗi người --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số lượng (Tổng cộng) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giới hạn mỗi người (Số lần sử dụng) <span class="text-danger">*</span></label>
                        <input type="number" name="user_limit" value="{{ old('user_limit', 1) }}" class="form-control" min="1" required>
                    </div>
                </div>

                {{-- Hàng 3: Giá trị giảm, Đơn tối thiểu, Giảm tối đa --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Giá trị giảm (<span id="discount-label" class="text-primary">{{ old('discount_type') == 'percent' ? '%' : 'VNĐ' }}</span>) <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="discount_value" value="{{ old('discount_value') }}" class="form-control" min="0" step="1" required>
                        @error('discount_value')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                        <input type="number" name="min_order_value" value="{{ old('min_order_value', 0) }}" class="form-control" step="1000" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị giảm tối đa (Sale Price)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" class="form-control" step="1000" min="0">
                        <small class="text-muted">Đặt giới hạn tối đa cho mức giảm (chỉ áp dụng nếu Loại giảm giá là %)</small>
                    </div>
                </div>

                {{-- Hàng 4: Ngày bắt đầu và Ngày kết thúc --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" class="form-control" required>
                    </div>
                </div>
                
                {{-- Hàng 5: Trạng thái và Mô tả --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" rows="1" class="form-control" placeholder="Mô tả chi tiết về điều kiện áp dụng nếu cần">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Lưu voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Cập nhật nhãn đơn vị giảm giá khi thay đổi Loại giảm giá
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('discount_type');
        const label = document.getElementById('discount-label');

        // Hàm cập nhật nhãn
        function updateDiscountLabel() {
            label.textContent = typeSelect.value === 'fixed' ? 'VNĐ' : '%';
        }

        // Cập nhật ngay khi tải trang (để đảm bảo trạng thái old() ban đầu là đúng)
        updateDiscountLabel(); 
        
        // Thêm sự kiện thay đổi
        typeSelect.addEventListener('change', updateDiscountLabel);
    });
</script>
@endsection