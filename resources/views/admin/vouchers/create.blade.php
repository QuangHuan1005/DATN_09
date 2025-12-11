@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Thêm Voucher mới</h3>
    </div>

    {{-- Hiển thị thông báo thành công hoặc lỗi chung (nếu có) --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Form thêm Voucher mới --}}
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                {{-- Hàng 1: Mã Voucher & Loại giảm giá --}}
                <div class="row mb-3">
                    {{-- Mã Voucher (voucher_code) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mã voucher <span class="text-danger">*</span></label>
                        <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" 
                               class="form-control @error('voucher_code') is-invalid @enderror" >
                        @error('voucher_code')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Loại giảm giá (discount_type) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" >
                            <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo %</option>
                        </select>
                        @error('discount_type')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Hàng 2: Số lượng & Giới hạn mỗi người --}}
                <div class="row mb-3">
                    {{-- Số lượng (quantity) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số lượng (Tổng cộng) <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" 
                               class="form-control @error('quantity') is-invalid @enderror" min="1" >
                        @error('quantity')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Giới hạn mỗi người (user_limit) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giới hạn mỗi người (Số lần sử dụng) <span class="text-danger">*</span></label>
                        <input type="number" name="user_limit" value="{{ old('user_limit', 1) }}" 
                               class="form-control @error('user_limit') is-invalid @enderror" min="1" >
                        @error('user_limit')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Hàng 3: Giá trị giảm, Đơn tối thiểu, Giảm tối đa --}}
                <div class="row mb-3">
                    {{-- Giá trị giảm (discount_value) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Giá trị giảm (<span id="discount-label" class="text-primary">{{ old('discount_type') == 'percent' ? '%' : 'VNĐ' }}</span>) <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="discount_value" value="{{ old('discount_value') }}" 
                               class="form-control @error('discount_value') is-invalid @enderror" min="0" step="1" >
                        @error('discount_value')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Giá trị đơn hàng tối thiểu (min_order_value) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                        <input type="number" name="min_order_value" value="{{ old('min_order_value', 0) }}" 
                               class="form-control @error('min_order_value') is-invalid @enderror" step="1000" min="0" >
                        @error('min_order_value')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Giá trị giảm tối đa (sale_price) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị giảm tối đa (Sale Price)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', 0) }}" 
                               class="form-control @error('sale_price') is-invalid @enderror" step="1000" min="0">
                        <small class="text-muted">Đặt giới hạn tối đa cho mức giảm (chỉ áp dụng nếu Loại giảm giá là %)</small>
                        @error('sale_price')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Hàng 4: Ngày bắt đầu và Ngày kết thúc --}}
                <div class="row mb-3">
                    {{-- Ngày bắt đầu (start_date) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" 
                               class="form-control @error('start_date') is-invalid @enderror" >
                        @error('start_date')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Ngày kết thúc (end_date) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}" 
                               class="form-control @error('end_date') is-invalid @enderror" >
                        @error('end_date')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Hàng 5: Chọn sản phẩm áp dụng --}}
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Sản phẩm áp dụng</label>
                        <select name="product_ids[]" 
                                class="form-select @error('product_ids') is-invalid @enderror" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ collect(old('product_ids'))->contains($product->id) ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Nếu không chọn, voucher áp dụng cho tất cả sản phẩm.</small>
                        @error('product_ids')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Hàng 6: Trạng thái và Mô tả --}}
                <div class="row mb-4">
                    {{-- Trạng thái (status) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" >
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status', '1') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Mô tả (description) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="description" rows="1" 
                                  class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Mô tả chi tiết về điều kiện áp dụng nếu cần">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1 fs-13">{{ $message }}</div>
                        @enderror
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
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('discount_type');
        const label = document.getElementById('discount-label');

        function updateDiscountLabel() {
            // Cập nhật nhãn và đảm bảo giá trị cũ được giữ nếu có lỗi validation
            const selectedValue = typeSelect.value || "{{ old('discount_type', 'fixed') }}"; 
            label.textContent = selectedValue === 'fixed' ? 'VNĐ' : '%';
        }

        updateDiscountLabel(); 
        typeSelect.addEventListener('change', updateDiscountLabel);
    });
</script>
@endsection