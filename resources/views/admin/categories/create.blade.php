@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Thêm danh mục</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        {{-- Danh mục cha --}}
        <div class="mb-3">
    <label>Danh mục cha</label>
    <select name="parent_id" class="form-control">
        <option value="">-- Không chọn (Danh mục gốc) --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>


        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
