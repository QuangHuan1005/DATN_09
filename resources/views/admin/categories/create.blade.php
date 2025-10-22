@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Thêm danh mục</h1>

    {{-- Hiển thị tất cả lỗi validation nếu có --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã xảy ra lỗi:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        {{-- Tên danh mục --}}
        <div class="mb-3">
            <label for="name">Tên danh mục</label>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug">Slug</label>
            <input
                type="text"
                id="slug"
                name="slug"
                class="form-control @error('slug') is-invalid @enderror"
                value="{{ old('slug') }}"
            >
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Mô tả --}}
        <div class="mb-3">
            <label for="description">Mô tả</label>
            <textarea
                id="description"
                name="description"
                class="form-control @error('description') is-invalid @enderror"
                rows="3"
            >{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Danh mục cha --}}
        <div class="mb-3">
            <label for="parent_id">Danh mục cha</label>
            <select
                id="parent_id"
                name="parent_id"
                class="form-control @error('parent_id') is-invalid @enderror"
            >
                <option value="">-- Không chọn (Danh mục gốc) --</option>
                @foreach($categories as $cat)
                    <option
                        value="{{ $cat->id }}"
                        {{ old('parent_id') == $cat->id ? 'selected' : '' }}
                    >{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nút submit và hủy --}}
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
