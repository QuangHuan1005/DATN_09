@extends('layouts.admin.app')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-3">Quản lý sản phẩm</h3>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        {{-- Tìm kiếm --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm theo tên sản phẩm..." value="{{ request('keyword') }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>


        <div class="mb-3">
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Thêm sản phẩm</a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Mô tả</th>
                    <th>Danh mục</th> 
                    <th>Chất liệu</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="{{ $product->deleted_at ? 'table-secondary' : '' }}">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_code }}</td>

                        <td>{{ $product->name }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No image" width="60" height="60"
                                    style="object-fit: cover; border-radius: 8px;">
                            @endif
                        </td>
                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $product->description ?? 'Không có mô tả' }}
                        </td>
                        <td>{{ $product->category->name ?? 'Chưa phân loại' }}</td> 
                        <td>{{ $product->material ?? '-' }}</td>
                        <td>
                            @if ($product->deleted_at)
                                <span class="badge bg-secondary">Đã ẩn</span>
                            @else
                                <span class="badge bg-success">Hiển thị</span>
                            @endif
                        </td>
                        <td>{{ $product->created_at?->format('d/m/Y H:i') }}</td>
                        <td>
                            @if (!$product->deleted_at)
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-sm btn-warning">Sửa</a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc muốn ẨN sản phẩm này?')">
                                        Ẩn
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success"
                                        onclick="return confirm('Hiển thị lại sản phẩm này?')">
                                        Hiện
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Chưa có sản phẩm nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Phân trang --}}
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
@endsection
