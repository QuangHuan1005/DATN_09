@extends('admin.master')


@section('title', 'Sửa biến thể sản phẩm')

@section('content')
<div class="container mt-4">
    <!-- Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ $type ? route('admin.products.variants.type', $type) : route('admin.products.variants') }}" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <h1 class="h2 mb-0">Sửa {{ $typeName ?? 'biến thể' }}</h1>
            </div>
        </div>
    </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit"></i> Thông tin biến thể
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.products.variants.update', $variant) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <input type="hidden" name="type" value="{{ $type }}">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên {{ $typeName ?? 'biến thể' }}</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $variant->name) }}" required>
                                </div>

                                @if($type === 'size')
                                <div class="mb-3">
                                    <label for="size_code" class="form-label">Giá trị</label>
                                    <input type="text" class="form-control" id="size_code" name="size_code" 
                                           value="{{ old('size_code', $variant->size_code) }}" 
                                           placeholder="VD: S, M, L, XL">
                                </div>
                                @elseif($type === 'color')
                                <div class="mb-3">
                                    <label for="color_code" class="form-label">Giá trị</label>
<<<<<<< HEAD
<input type="text" class="form-control" id="color_code" name="color_code" 
=======
                                    <input type="text" class="form-control" id="color_code" name="color_code" 
>>>>>>> origin/phong
                                           value="{{ old('color_code', $variant->color_code) }}" 
                                           placeholder="VD: #FF0000, #0000FF">
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $variant->description) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="active" {{ old('status', $variant->status) === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ old('status', $variant->status) === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Cập nhật
                                    </button>
                                    <a href="{{ $type ? route('admin.products.variants.type', $type) : route('admin.products.variants') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
@endsection
=======
@endsection


>>>>>>> origin/phong
