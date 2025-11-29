@extends('admin.master')
@section('content')
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12 col-lg-12 ">

                {{-- Hiển thị lỗi validate --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                    </div>

                    {{-- FORM CHÍNH --}}
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                {{-- Tên sản phẩm --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name', $product->name) }}" placeholder="Tên sản phẩm">
                                    </div>
                                </div>

                                {{-- Danh mục --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="product-categories" class="form-label">Danh Mục Sản Phẩm</label>
                                        <select class="form-control" id="product-categories" name="category_id" data-choices
                                            data-choices-groups data-placeholder="Chọn danh mục">
                                            <option value="">Chọn một danh mục</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ (int) old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Size --}}
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <h5 class="text-dark fw-medium">Size:</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @php
                                            $allSizes = \App\Models\Size::where('status', 1)->get();
                                            $productSizes = $product->variants->pluck('size_id')->toArray();
                                        @endphp
                                        @foreach ($allSizes as $size)
                                            @php $id = 'size-' . $size->id; @endphp
                                            <input type="checkbox" class="btn-check" id="{{ $id }}" name="sizes[]"
                                                value="{{ $size->id }}"
                                                {{ is_array(old('sizes', $productSizes)) && in_array($size->id, old('sizes', $productSizes)) ? 'checked' : '' }}>
                                            <label for="{{ $id }}"
                                                class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                {{ $size->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Color --}}
                                <div class="col-lg-6">
                                    <h5 class="text-dark fw-medium">Màu sắc:</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @php
                                            $allColors = \App\Models\Color::where('status', 1)->get();
                                            $productColors = $product->variants->pluck('color_id')->toArray();
                                        @endphp
                                        @foreach ($allColors as $color)
                                            @php $colorInputId = 'color-' . $color->id; @endphp
                                            <input type="checkbox" class="btn-check" id="{{ $colorInputId }}"
                                                name="colors[]" value="{{ $color->id }}"
                                                {{ is_array(old('colors', $productColors)) && in_array($color->id, old('colors', $productColors)) ? 'checked' : '' }}>
                                            <label for="{{ $colorInputId }}"
                                                class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center">
                                                <i class="bx bxs-circle fs-18" style="color: {{ $color->color_code }}"></i>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Mô tả --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" id="description" rows="7"
                                            placeholder="Mô tả về sản phẩm">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Mã SP / Tồn kho / Chất liệu --}}
                            <div class="row">
                                {{-- Mã sản phẩm --}}
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_code" class="form-label">Mã Sản Phẩm</label>
                                        <input type="text" id="product_code" name="product_code" class="form-control"
                                            value="{{ old('product_code', $product->product_code) }}"
                                            placeholder="#******">
                                    </div>
                                </div>

                                {{-- Số lượng --}}
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Số Lượng</label>
                                        @foreach ($product->variants as $variant)
                                            <input type="hidden" name="variants[{{ $variant->id }}][id]"
                                                value="{{ $variant->id }}">
                                            <input type="number" name="variants[{{ $variant->id }}][quantity]"
                                                class="form-control mb-2"
                                                value="{{ old('variants.' . $variant->id . '.quantity', $variant->quantity) }}"
                                                min="0" placeholder="Số lượng biến thể {{ $variant->id }}">
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Chất liệu --}}
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-material" class="form-label">Chất Liệu</label>
                                        <input type="text" id="product-material" name="material" class="form-control"
                                            value="{{ old('material', $product->material) }}"
                                            placeholder="Cotton 100%, denim...">
                                    </div>
                                </div>
                            </div>

                        </div> {{-- end card-body Thông tin sản phẩm --}}

                        {{-- KHỐI GIÁ --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h4 class="card-title">Chi Tiết Giá</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    {{-- Giá gốc --}}
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="product-price" class="form-label">Giá</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20">
                                                    <i class='bx bx-dollar'></i>
                                                </span>
                                                <input type="number" id="product-price" name="price"
                                                    class="form-control" value="{{ old('price') }}" placeholder="000"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Giá giảm / sale price --}}
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="product-discount" class="form-label">Giảm Giá</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text fs-20">
                                                    <i class='bx bxs-discount'></i>
                                                </span>
                                                <input type="number" id="product-discount" name="sale"
                                                    class="form-control" value="{{ old('sale') }}" placeholder="000"
                                                    min="0">
                                            </div>
                                            <small class="text-muted" style="font-size:12px">
                                                Nếu trống hoặc = 0 thì hiểu là không giảm.
                                            </small>
                                        </div>
                                    </div>

                                    {{-- Onepage --}}
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="onepage" class="form-label">Hiển Thị Trang Chủ</label>
                                            <select class="form-control" name="onpage" id="onepage" data-choices
                                                data-choices-groups data-placeholder="Select Onepage">
                                                <option value="0"
                                                    {{ (int) old('onpage', $product->onpage) === 0 ? 'selected' : '' }}>
                                                    Không
                                                </option>
                                                <option value="1"
                                                    {{ (int) old('onpage', $product->onpage) === 1 ? 'selected' : '' }}>Có
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="p-3 bg-light mb-3 rounded">
                            <div class="row justify-content-end g-2">
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        Cập nhập
                                    </button>
                                </div>
                                <div class="col-lg-2">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </div>

                    </form> {{-- end FORM CHÍNH --}}
                </div>
            </div>
        </div>
    </div>
@endsection
