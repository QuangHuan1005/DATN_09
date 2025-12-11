```blade
@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Sửa danh mục</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug',$category->slug) }}">
        </div>
        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description',$category->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
