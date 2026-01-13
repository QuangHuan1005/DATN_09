@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom py-3">
                    <h4 class="card-title mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa Voucher: {{ $voucher->voucher_code }}</h4>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            {{-- Cấu hình cơ bản --}}
                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Mã Voucher <span class="text-danger">*</span></label>
                                <input type="text" name="voucher_code" class="form-control @error('voucher_code') is-invalid @enderror" 
                                    value="{{ old('voucher_code', $voucher->voucher_code) }}" placeholder="Ví dụ: KM2026">
                                @error('voucher_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Loại giảm giá <span class="text-danger">*</span></label>
                                <select name="discount_type" id="discount_type" class="form-select">
                                    <option value="fixed" {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>Giảm tiền cố định (đ)</option>
                                    <option value="percent" {{ old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label fw-bold">Giá trị giảm (<span id="discount_unit"></span>) <span class="text-danger">*</span></label>
                                <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" 
                                    value="{{ old('discount_value', $voucher->discount_value) }}">
                                @error('discount_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Điều kiện nâng cao --}}
                            <div class="col-md-6 mb-4 p-3 bg-light-subtle border rounded">
                                <label class="form-label fw-bold text-success"><i class="bi bi-shield-check"></i> Cấu hình giảm tối đa</label>
                                <div class="input-group">
                                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $voucher->sale_price ?? 0) }}">
                                    <span class="input-group-text">đ</span>
                                </div>
                                <small class="text-muted">(*) Chỉ có tác dụng khi chọn giảm theo <b>Phần trăm</b>.</small>
                            </div>

                            <div class="col-md-6 mb-4 p-3 bg-light-subtle border rounded">
                                <label class="form-label fw-bold text-warning"><i class="bi bi-coin"></i> Cấu hình đổi điểm</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-dark"><i class="bi bi-coin"></i></span>
                                    <input type="number" name="points_required" class="form-control" value="{{ old('points_required', $voucher->points_required ?? 0) }}">
                                </div>
                                <small class="text-muted">(*) Nhập điểm nếu đây là voucher đổi thưởng, ngược lại để là <b>0</b>.</small>
                            </div>

                            <div class="col-12"><hr class="my-2"></div>

                            {{-- Các thông số định lượng --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Tổng số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $voucher->quantity) }}">
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Giới hạn/Khách <span class="text-danger">*</span></label>
                                <input type="number" name="user_limit" class="form-control @error('user_limit') is-invalid @enderror" value="{{ old('user_limit', $voucher->user_limit) }}">
                                @error('user_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Đơn tối thiểu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="min_order_value" class="form-control" value="{{ old('min_order_value', $voucher->min_order_value) }}">
                                    <span class="input-group-text">đ</span>
                                </div>
                            </div>

                             <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold">Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', $voucher->status) == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ old('status', $voucher->status) == 0 ? 'selected' : '' }}>Tạm ngừng</option>
                                </select>
                            </div>

                            {{-- Thời gian --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_date" id="start_date" 
                                    class="form-control @error('start_date') is-invalid @enderror" 
                                    value="{{ old('start_date', date('Y-m-d\TH:i', strtotime($voucher->start_date))) }}">
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày kết thúc <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="end_date" id="end_date" 
                                    class="form-control @error('end_date') is-invalid @enderror" 
                                    value="{{ old('end_date', date('Y-m-d\TH:i', strtotime($voucher->end_date))) }}">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Sản phẩm áp dụng (Trống = Tất cả)</label>
                                <select name="product_ids[]" class="form-select select2" multiple>
                                    @php $appliedProductIds = $voucher->products->pluck('id')->toArray(); @endphp
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}" {{ in_array($p->id, $appliedProductIds) ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Mô tả ngắn</label>
                                <textarea name="description" class="form-control" rows="2">{{ old('description', $voucher->description) }}</textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-save me-1"></i> Cập nhật Voucher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const discountType = document.getElementById('discount_type');
        const discountUnit = document.getElementById('discount_unit');

        // Thay đổi nhãn đơn vị đ/%
        discountType.addEventListener('change', function() {
            discountUnit.textContent = this.value === 'fixed' ? 'đ' : '%';
        });

        // Logic thời gian: Ngày kết thúc không được nhỏ hơn ngày bắt đầu
        startDate.addEventListener('change', function() {
            endDate.min = this.value;
        });
        
        // Khởi tạo Select2
        if (typeof $('.select2').select2 === "function") {
            $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });
        }
    });
</script>
@endsection