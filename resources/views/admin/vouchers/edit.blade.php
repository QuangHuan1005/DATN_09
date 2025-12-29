@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Chỉnh sửa Voucher: {{ $voucher->voucher_code }}</h3>
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

    {{-- Form chỉnh sửa Voucher --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Hàng 1: Mã Voucher & Loại giảm giá --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Mã voucher <span class="text-danger">*</span></label>
                        <input type="text" name="voucher_code" value="{{ old('voucher_code', $voucher->voucher_code) }}"
                            class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                        <select name="discount_type" id="discount_type" class="form-select" required>
                            <option value="fixed"
                                {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
                            <option value="percent"
                                {{ old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : '' }}>Giảm theo %</option>
                        </select>
                    </div>
                </div>

                {{-- Hàng 2: Hình thức phát hành & Điểm đổi (MỚI BỔ SUNG) --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Hình thức phát hành <span class="text-danger">*</span></label>
                        <select id="is_reward_selector" class="form-select border-primary">
                            <option value="0" {{ old('points_required', $voucher->points_required) == 0 ? 'selected' : '' }}>Voucher công khai (Tặng mọi người)</option>
                            <option value="1" {{ old('points_required', $voucher->points_required) > 0 ? 'selected' : '' }}>Voucher đổi thưởng (Dùng điểm để đổi)</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="points_required_group" style="{{ old('points_required', $voucher->points_required) > 0 ? '' : 'display: none;' }}">
                        <label class="form-label fw-bold">Số điểm cần đổi <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-warning text-dark"><i class="bi bi-coin"></i></span>
                            <input type="number" name="points_required" id="points_required_input" 
                                class="form-control" value="{{ old('points_required', $voucher->points_required ?? 0) }}" min="0">
                        </div>
                        <small class="text-muted">Cần số điểm này để đổi lấy mã giảm giá.</small>
                    </div>
                </div>

                {{-- Hàng 3: Số lượng & Giới hạn mỗi người --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Số lượng (Tổng cộng)</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $voucher->quantity) }}"
                            class="form-control" min="1">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giới hạn mỗi người (Số lần sử dụng)</label>
                        <input type="number" name="user_limit" value="{{ old('user_limit', $voucher->user_limit) }}"
                            class="form-control" min="1">
                    </div>
                </div>
                
                {{-- Hàng 4: Giá trị giảm, Đơn tối thiểu, Giảm tối đa --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">
                            Giá trị giảm (<span id="discount_label" class="text-primary">{{ $voucher->discount_type == 'fixed' ? 'VNĐ' : '%' }}</span>) <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="discount_value" id="discount_value"
                            value="{{ old('discount_value', $voucher->discount_value) }}" class="form-control" step="1" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                        <input type="number" name="min_order_value"
                            value="{{ old('min_order_value', $voucher->min_order_value) }}" class="form-control" step="1" required min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Giá trị giảm tối đa (Sale Price)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price', $voucher->sale_price) }}"
                            class="form-control" step="1000" min="0">
                        <small class="text-muted">Chặn mức giảm tối đa khi dùng %</small>
                    </div>
                </div>

                {{-- Hàng 5: Ngày bắt đầu và Ngày kết thúc --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                        <input type="date" name="start_date"
                            value="{{ old('start_date', substr($voucher->start_date, 0, 10)) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" value="{{ old('end_date', substr($voucher->end_date, 0, 10)) }}"
                            class="form-control" required>
                    </div>
                </div>

                {{-- Trạng thái --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status', $voucher->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status', $voucher->status) == 0 ? 'selected' : '' }}>Ngừng hoạt động</option>
                    </select>
                </div>

                {{-- Mô tả --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Mô tả</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Mô tả chi tiết">{{ old('description', $voucher->description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Cập nhật voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logic 1: Cập nhật nhãn VNĐ/%
        const typeSelect = document.getElementById('discount_type');
        const label = document.getElementById('discount_label');
        
        function updateDiscountLabel() {
            label.textContent = typeSelect.value === 'fixed' ? 'VNĐ' : '%';
        }
        updateDiscountLabel(); 
        typeSelect.addEventListener('change', updateDiscountLabel);

        // Logic 2: Ẩn/Hiện ô nhập điểm (MỚI)
        const rewardSelector = document.getElementById('is_reward_selector');
        const pointsGroup = document.getElementById('points_required_group');
        const pointsInput = document.getElementById('points_required_input');

        rewardSelector.addEventListener('change', function() {
            if (this.value === '1') {
                pointsGroup.style.display = 'block';
            } else {
                pointsGroup.style.display = 'none';
                pointsInput.value = 0;
            }
        });
    });
</script>
@endsection