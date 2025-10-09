@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Quản lý danh mục</h1>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tìm kiếm --}}
    <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên danh mục..." value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>

    {{-- Thêm danh mục --}}
    <div class="mb-3">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">+ Thêm danh mục</a>
    </div>

    {{-- Bảng danh mục --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Slug</th>
                <th>Mô tả</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr @if($category->trashed()) class="table-danger" @endif>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        {{ $category->parent ? $category->parent->name : '(Danh mục gốc)' }}
                    </td>
                    <td>
                        @if($category->trashed())
                            <span class="badge bg-danger">Đã xóa mềm</span>
                        @else
                            <span class="badge bg-success">Hoạt động</span>
                        @endif
                    </td>
                    <td>
                        @if(!$category->trashed())
                            <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa mềm danh mục này?')">
                                    Xóa mềm
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('Bạn có chắc muốn khôi phục danh mục này?')">
                                    Khôi phục
                                </button>
                            </form>
                            <form action="{{ route('admin.categories.forceDelete', $category->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-dark btn-sm" onclick="return confirm('Xóa vĩnh viễn, không thể hoàn tác. Tiếp tục?')">
                                    Xóa cứng
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Không có danh mục nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Phân trang --}}
   {{-- Thông tin và phân trang căn giữa --}}
<div class="text-center mt-3">

    {{-- Nút phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $categories->withQueryString()->onEachSide(1)->links() }}
    </div>
</div>


</div>
@endsection
