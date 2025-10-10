@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Chỉnh sửa sản phẩm: <strong>{{ $product->name }}</strong></h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" value="{{ $product->product_code }}" disabled>
        </div>

        {{-- Chọn danh mục --}}
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ (int) old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Chất liệu</label>
            <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Hiển thị trang chủ</label>
            <select name="onpage" class="form-select">
                <option value="0" {{ (int) old('onpage', $product->onpage) === 0 ? 'selected' : '' }}>Không</option>
                <option value="1" {{ (int) old('onpage', $product->onpage) === 1 ? 'selected' : '' }}>Có</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ảnh hiện tại</label><br>
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="image" width="140" class="rounded mb-2 border">
            @else
                <p class="text-muted">Chưa có ảnh</p>
            @endif

            <label class="form-label mt-2">Thay ảnh (nếu muốn)</label>
            <input type="file" name="image" class="form-control">
            <small class="form-text text-muted">Bỏ trống nếu không muốn thay ảnh.</small>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
