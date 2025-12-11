@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <form action="{{ route('admin.attributes.colors.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm Màu Sắc Mới</h4>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Màu <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" 
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" 
                                            placeholder="Ví dụ: Đỏ, Xanh dương">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="color_code" class="form-label">Mã Màu <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" id="color_code" name="color_code" 
                                                class="form-control @error('color_code') is-invalid @enderror"
                                                value="{{ old('color_code', '#000000') }}" 
                                                placeholder="#FF5733"
                                                maxlength="7">
                                            <input type="color" class="form-control form-control-color" 
                                                id="colorPicker" 
                                                value="{{ old('color_code', '#000000') }}" 
                                                title="Chọn màu">
                                        </div>
                                        <small class="text-muted">Định dạng: #RRGGBB (ví dụ: #FF5733)</small>
                                        @error('color_code')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" 
                                            name="status" id="status">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-0">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" 
                                            id="description" rows="4"
                                            placeholder="Mô tả về màu sắc (tùy chọn)">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-3">
                                <a href="{{ route('admin.attributes.colors.index') }}" class="btn btn-outline-secondary w-100">
                                    <i class="bx bx-x"></i> Hủy
                                </a>
                            </div>
                            <div class="col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-check"></i> Thêm Mới
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Đồng bộ color picker với input text
        const colorPicker = document.getElementById('colorPicker');
        const colorCode = document.getElementById('color_code');

        colorPicker.addEventListener('input', function() {
            colorCode.value = this.value.toUpperCase();
        });

        colorCode.addEventListener('input', function() {
            const value = this.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                colorPicker.value = value;
            }
        });
    </script>
    @endpush
@endsection

