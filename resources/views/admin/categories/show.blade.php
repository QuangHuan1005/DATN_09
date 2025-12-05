@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Chi tiết danh mục</h1>

    {{-- Thông tin danh mục cha --}}
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Thông tin danh mục: {{ $category->name }}
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $category->id }}</p>
            <p><strong>Tên danh mục:</strong> {{ $category->name }}</p>
            <p><strong>Slug:</strong> {{ $category->slug }}</p>
            <p><strong>Mô tả:</strong> {{ $category->description ?? 'Không có' }}</p>
            <p>
                <strong>Trạng thái:</strong>
                @if($category->trashed())
                    <span class="badge bg-danger">Đã xóa mềm</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Danh mục con --}}
    <h3>Danh mục con của "{{ $category->name }}"</h3>
    @if($children->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($children as $child)
                    <tr @if($child->trashed()) class="table-danger" @endif>
                        <td>{{ $child->id }}</td>
                        <td>{{ $child->name }}</td>
                        <td>{{ $child->slug }}</td>
                        <td>{{ $child->description }}</td>
                        <td>
                            @if($child->trashed())
                                <span class="badge bg-danger">Đã xóa mềm</span>
                            @else
                                <span class="badge bg-success">Hoạt động</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Danh mục này chưa có danh mục con nào</div>
    @endif

    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
