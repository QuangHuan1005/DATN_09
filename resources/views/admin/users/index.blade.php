@extends('layouts.admin.app')

@section('content')
<h1>Danh sách người dùng</h1>

{{-- ✅ Thông báo flash --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

{{-- ✅ Form lọc, tìm kiếm --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Tìm theo tên, email, SĐT" value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="role_id" class="form-select">
            <option value="">-- Tất cả vai trò --</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" type="submit">Lọc</button>
    </div>
</form>

{{-- ✅ Bảng danh sách người dùng --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Vai trò</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr @if($user->trashed()) class="table-secondary" @endif>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->role->name ?? 'Không xác định' }}</td>
            <td>
                @if($user->trashed())
                    <span class="text-muted">Đã ẩn</span>
                @else
                    {{ $user->is_locked ? 'Đã khóa' : 'Đang hoạt động' }}
                @endif
            </td>
            <td>
                @if(!$user->trashed())
                    {{-- Sửa --}}
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Sửa</a>

                    {{-- Ẩn (xóa mềm) --}}
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Bạn chắc chắn muốn ẩn người dùng này?')" class="btn btn-sm btn-danger">Ẩn</button>
                    </form>

                    {{-- Khóa / Mở khóa --}}
                    <form action="{{ route('admin.users.toggleLock', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-warning">
                            {{ $user->is_locked ? 'Mở khóa' : 'Khóa' }}
                        </button>
                    </form>
                @else
                    {{-- Khôi phục --}}
                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button onclick="return confirm('Bạn chắc chắn muốn khôi phục người dùng này?')" class="btn btn-sm btn-success">Khôi phục</button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">Không có người dùng nào.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ✅ Phân trang --}}
<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>
@endsection
