@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <form action="{{ route('admin.attributes.sizes.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm Kích Thước Mới</h4>
                        </div>
                        <div class="card-body">
                            {{-- Thông báo lỗi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Kích Thước <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" 
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" 
                                            placeholder="Ví dụ: Small, Medium, Large">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="size_code" class="form-label">Mã Kích Thước <span class="text-danger">*</span></label>
                                        <input type="text" id="size_code" name="size_code" 
                                            class="form-control @error('size_code') is-invalid @enderror"
                                            value="{{ old('size_code') }}" 
                                            placeholder="Ví dụ: S, M, L, XL"
                                            maxlength="10">
                                        <small class="text-muted">Mã ngắn gọn để hiển thị (tối đa 10 ký tự)</small>
                                        @error('size_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
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
                                            placeholder="Mô tả về kích thước (tùy chọn)">{{ old('description') }}</textarea>
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
                                <a href="{{ route('admin.attributes.sizes.index') }}" class="btn btn-outline-secondary w-100">
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
@endsection

