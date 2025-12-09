@extends('admin.master')

@section('content')
    <div class="container-xxl">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thêm Mới {{ $type == 'colors' ? 'Màu Sắc' : 'Kích Thước' }}</h4>
                    </div>
                    <form action="{{ route('admin.attributes.store', $type) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="variant-name" class="form-label text-dark">Tên Biến Thể</label>
                                        <input type="text" id="variant-name" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Tên Biến Thể">
                                        @error('name')
                                            <div class="text-danger mt-1" style="font-size:13px">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="value-name" class="form-label text-dark">Giá Trị</label>
                                        @if ($type == 'colors')
                                            <input type="color" id="value-name" class="form-control form-control-color"
                                                value="{{ old('color_code') }}" placeholder="Nhập Giá Trị" name="color_code">
                                            @error('color_code')
                                                <div class="text-danger mt-1" style="font-size:13px">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @else
                                            <input type="text" id="value-name" class="form-control"
                                                value="{{ old('size_code') }}" placeholder="Nhập Giá Trị" name="size_code">
                                            @error('size_code')
                                                <div class="text-danger mt-1" style="font-size:13px">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label text-dark">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" id="description" rows="7"
                                            placeholder="Mô tả {{ $type == 'colors' ? 'màu sắc' : 'kích thước' }}..."name="description">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top">
                            <a href="{{ route('admin.attributes.show', $type) }}" class="btn btn-primary">Quay Lại</a>
                            <button type="submit" class="btn btn-outline-secondary">
                                Thêm Mới
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
