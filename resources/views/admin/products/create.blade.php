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
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"class="dropzone"
                    id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews"
                    data-upload-preview-template="#uploadPreviewTemplate">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm ảnh sản phẩm</h4>
                        </div>
                        <div class="card-body">
                            <!-- File Upload -->
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                            <div class="dz-message needsclick">
                                <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                <h3 class="mt-4">Thả ảnh của bạn vào đây, hoặc <span class="text-primary">nhấp để chọn
                                        tệp.</span></h3>
                                <span class="text-muted fs-13">
                                    Kích thước khuyến nghị 1200 x 1600 (3:4). Cho phép các định dạng PNG, JPG và GIF.
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                        </div>

                        {{-- FORM CHÍNH --}}

                        <div class="card-body">
                            <div class="row">
                                {{-- Tên sản phẩm --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Tên sản phẩm">
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
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Size / Màu sắc (demo UI, chưa map dữ liệu biến thể) --}}
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <div class="mt-3">
                                        <h5 class="text-dark fw-medium">Size :</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group" aria-label="Chọn size">
                                            @php
                                                $sizesDemo = ['XS', 'S', 'M', 'XL', 'XXL', '3XL'];
                                            @endphp
                                            @foreach ($sizesDemo as $s)
                                                @php
                                                    // name="sizes[]" để gửi mảng size[]
                                                    $id = 'size-' . strtolower($s);
                                                @endphp
                                                <input type="checkbox" class="btn-check" id="{{ $id }}"
                                                    name="sizes[]" value="{{ $s }}"
                                                    {{ is_array(old('sizes')) && in_array($s, old('sizes')) ? 'checked' : '' }}>
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    for="{{ $id }}">{{ $s }}</label>
                                            @endforeach
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size:12px">
                                            (Tạm thời lưu size dạng mảng sizes[]. Sau này map vào bảng product_variants.)
                                        </small>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="mt-3">
                                        <h5 class="text-dark fw-medium">Màu sắc :</h5>
                                        <div class="d-flex flex-wrap gap-2" role="group" aria-label="Chọn màu">
                                            @php
                                                $colorsDemo = [
                                                    ['id' => 'dark', 'labelClass' => 'text-dark', 'name' => 'Đen'],
                                                    [
                                                        'id' => 'yellow',
                                                        'labelClass' => 'text-warning',
                                                        'name' => 'Vàng',
                                                    ],
                                                    ['id' => 'white', 'labelClass' => 'text-white', 'name' => 'Trắng'],
                                                    [
                                                        'id' => 'blue',
                                                        'labelClass' => 'text-primary',
                                                        'name' => 'Xanh dương',
                                                    ],
                                                    [
                                                        'id' => 'green',
                                                        'labelClass' => 'text-success',
                                                        'name' => 'Xanh lá',
                                                    ],
                                                    ['id' => 'red', 'labelClass' => 'text-danger', 'name' => 'Đỏ'],
                                                    ['id' => 'sky', 'labelClass' => 'text-info', 'name' => 'Xanh nhạt'],
                                                    ['id' => 'gray', 'labelClass' => 'text-secondary', 'name' => 'Xám'],
                                                ];
                                            @endphp

                                            @foreach ($colorsDemo as $c)
                                                @php
                                                    $colorInputId = 'color-' . $c['id'];
                                                @endphp
                                                <input type="checkbox" class="btn-check" id="{{ $colorInputId }}"
                                                    name="colors[]" value="{{ $c['name'] }}"
                                                    {{ is_array(old('colors')) && in_array($c['name'], old('colors')) ? 'checked' : '' }}>
                                                <label
                                                    class="btn btn-light avatar-sm rounded d-flex justify-content-center align-items-center"
                                                    for="{{ $colorInputId }}">
                                                    <i class="bx bxs-circle fs-18 {{ $c['labelClass'] }}"></i>
                                                </label>
                                            @endforeach
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size:12px">
                                            (Cũng lưu dạng mảng colors[]. Sau này đưa vào bảng màu/variants thật.)
                                        </small>
                                    </div>
                                </div>
                            </div>

                            {{-- Mô tả --}}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control bg-light-subtle" name="description" id="description" rows="7"
                                            placeholder="Mô tả về sản phẩm">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Mã SP / Tồn kho / Chất liệu --}}
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_code" class="form-label">Mã Sản Phẩm</label>
                                        <input type="text" id="product_code" name="product_code" class="form-control"
                                            value="{{ old('product_code') }}" placeholder="#******">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-stock" class="form-label">Số Lượng</label>
                                        <input type="number" id="product-stock" name="quantity" class="form-control"
                                            value="{{ old('quantity') }}" placeholder="0" min="0">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-material" class="form-label">Chất Liệu</label>
                                        <input type="text" id="product-material" name="material" class="form-control"
                                            value="{{ old('material') }}" placeholder="Cotton 100%, denim...">
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

                                    {{-- Onpage --}}

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="onepage" class="form-label">Hiển Thị Trang Chủ</label>
                                            <select class="form-control" name="onpage" id="onepage" data-choices
                                                data-choices-groups data-placeholder="Select Onepage">
                                                <option value="0" selected>Không</option>
                                                <option value="1">Có</option>
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
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        Thêm Mới
                                    </button>
                                </div>
                                <div class="col-lg-2">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100">
                                        Hủy
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> {{-- end FORM CHÍNH --}}




                
            </div>
        </div>
    </div>
@endsection
