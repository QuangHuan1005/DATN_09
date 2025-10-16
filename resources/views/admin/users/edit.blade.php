@extends('layouts.admin.app')

@section('content')
<div class="container">
    <h1>Sửa người dùng</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Điện thoại</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Vai trò</label>
            <select id="role_id" name="role_id" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="is_locked" name="is_locked" value="1" {{ $user->is_locked ? 'checked' : '' }}>
            <label class="form-check-label" for="is_locked">Khóa tài khoản</label>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
            <input type="password" id="password" name="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh đại diện</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        @if ($user->image)
        <div class="mb-3">
            <img src="{{ asset('uploads/users/' . $user->image) }}" alt="Ảnh đại diện" style="max-width: 150px;" class="img-thumbnail">
        </div>
        @endif

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
