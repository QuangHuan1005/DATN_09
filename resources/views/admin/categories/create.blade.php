@extends('admin.master')

@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông Tin Chung</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Danh Mục</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Tên danh mục">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="parent_id" class="form-label">Danh Mục Cha</label>
                                    <select class="form-control @error('parent_id') is-invalid @enderror" name="parent_id"
                                        id="parent_id" data-choices data-choices-groups data-placeholder="Chọn danh mục">
                                        <option value=""><em>(Danh mục gốc)</em></option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-0">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" id="description" rows="7"
                                            placeholder="Mô về danh mục">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    Thêm Mới
                                </button>
                            </div>
                            <div class="col-lg-2">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100">
                                    Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
