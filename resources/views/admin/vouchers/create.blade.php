@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Thêm Voucher Mới</h4>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary btn-sm">Quay lại</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.vouchers.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Mã Voucher --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mã Voucher <span class="text-danger">*</span></label>
                                <input type="text" name="voucher_code" class="form-control @error('voucher_code') is-invalid @enderror" value="{{ old('voucher_code') }}" placeholder="Ví dụ: KM2024">
                                @error('voucher_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Loại giảm giá --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                                <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror">
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (đ)</option>
                                    <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                                </select>
                                @error('discount_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Giá trị giảm --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Giá trị giảm <span class="text-danger">*</span></label>
                                <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value') }}">
                                @error('discount_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- CỘT MỚI: PHÂN LOẠI VÀ ĐIỂM ĐỔI --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-primary">Hình thức phát hành <span class="text-danger">*</span></label>
                                <select id="is_reward_selector" class="form-select border-primary">
                                    <option value="0" {{ old('points_required') == 0 ? 'selected' : '' }}>Voucher công khai (Tặng mọi người)</option>
                                    <option value="1" {{ old('points_required') > 0 ? 'selected' : '' }}>Voucher đổi thưởng (Dùng điểm để đổi)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3" id="points_required_group" style="{{ old('points_required') > 0 ? '' : 'display: none;' }}">
                                <label class="form-label">Số điểm cần để đổi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-dark"><i class="bi bi-coin"></i></span>
                                    <input type="number" name="points_required" id="points_required_input" 
                                           class="form-control @error('points_required') is-invalid @enderror" 
                                           value="{{ old('points_required', 0) }}" min="0">
                                </div>
                                <small class="text-muted">Khách hàng sẽ dùng điểm tích lũy để đổi lấy mã này.</small>
                                @error('points_required') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Số lượng --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tổng số lượng phát hành <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Giới hạn mỗi người dùng --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Giới hạn mỗi khách <span class="text-danger">*</span></label>
                                <input type="number" name="user_limit" class="form-control @error('user_limit') is-invalid @enderror" value="{{ old('user_limit', 1) }}">
                                @error('user_limit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Giảm tối đa (sale_price) --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Số tiền giảm tối đa <span class="text-danger">*</span></label>
                                <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price', 0) }}">
                                @error('sale_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Đơn tối thiểu --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Đơn hàng tối thiểu <span class="text-danger">*</span></label>
                                <input type="number" name="min_order_value" class="form-control @error('min_order_value') is-invalid @enderror" value="{{ old('min_order_value', 0) }}">
                                @error('min_order_value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Ngày bắt đầu --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày bắt đầu <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Ngày kết thúc --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày kết thúc <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Trạng thái --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                </select>
                            </div>

                            {{-- Sản phẩm áp dụng --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sản phẩm áp dụng (Để trống nếu áp dụng tất cả)</label>
                                <select name="product_ids[]" class="form-select select2" multiple>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Mô tả --}}
                            <div class="col-12 mb-3">
                                <label class="form-label">Mô tả</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-light">Nhập lại</button>
                            <button type="submit" class="btn btn-primary">Tạo Voucher</button>
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
        const selector = document.getElementById('is_reward_selector');
        const pointsGroup = document.getElementById('points_required_group');
        const pointsInput = document.getElementById('points_required_input');

        selector.addEventListener('change', function() {
            if (this.value === '1') {
                pointsGroup.style.display = 'block';
                if(pointsInput.value == 0) pointsInput.value = 100; // Giá trị gợi ý
            } else {
                pointsGroup.style.display = 'none';
                pointsInput.value = 0;
            }
        });
    });
</script>
@endsection