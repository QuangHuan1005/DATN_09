@extends('admin.master')

@section('content')
<div class="container-xxl">
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            {{-- **LƯU Ý:** Bạn nên mở comment khối hiển thị lỗi chung này nếu không muốn hiển thị lỗi dưới từng trường
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            --}}

            <form action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="dropzone"
                id="myAwesomeDropzone"
                data-plugin="dropzone"
                data-previews-container="#file-previews"
                data-upload-preview-template="#uploadPreviewTemplate">

                @csrf

                {{-- KHỐI UP HÌNH CHÍNH – Trường 'image' là trường mà controller đã validate --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thêm ảnh sản phẩm</h4>
                    </div>
                    <div class="card-body">
                        {{-- Dropzone thường xử lý việc tải ảnh riêng, nhưng nếu muốn hiện lỗi validation từ Laravel cho trường 'image' thì thêm: --}}
                        @error('image')
                            <div class="text-danger mb-3" style="font-size:13px">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <div class="fallback">
                            {{-- Lưu ý: Tên trường trong Dropzone có thể khác. Trong controller bạn dùng 'image', nên dùng 'image' ở đây hoặc cấu hình Dropzone. Tôi giữ nguyên tên bạn dùng là 'file' và giả định bạn đã cấu hình Dropzone đúng cách. --}}
                            <input name="file" type="file" multiple />
                        </div>
                        <div class="dz-message needsclick">
                            <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                            <h3 class="mt-4">
                                Thả ảnh của bạn vào đây, hoặc
                                <span class="text-primary">nhấp để chọn tệp.</span>
                            </h3>
                            <span class="text-muted fs-13">
                                Kích thước khuyến nghị 1200 x 1600 (3:4). Cho phép các định dạng PNG, JPG và GIF.
                            </span>
                        </div>
                        <div class="dropzone-previews mt-3" id="file-previews"></div>
                    </div>
                </div>

                ---

                {{-- THÔNG TIN SẢN PHẨM --}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông Tin Sản Phẩm</h4>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- Tên sản phẩm --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên Sản Phẩm</label>
                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Tên sản phẩm">
                                    {{-- Thêm hiển thị lỗi cho trường 'name' --}}
                                    @error('name')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Danh mục --}}
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="product-categories" class="form-label">Danh Mục Sản Phẩm</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                        id="product-categories"
                                        name="category_id"
                                        data-choices
                                        data-choices-groups
                                        data-placeholder="Chọn danh mục">
                                        <option value="">Chọn một danh mục</option>
                                        @foreach ($categories ?? [] as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Thêm hiển thị lỗi cho trường 'category_id' --}}
                                    @error('category_id')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Mô tả --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô Tả</label>
                                    <textarea class="form-control bg-light-subtle @error('description') is-invalid @enderror"
                                        name="description"
                                        id="description"
                                        rows="7"
                                        placeholder="Mô tả về sản phẩm">{{ old('description') }}</textarea>
                                    {{-- Thêm hiển thị lỗi cho trường 'description' --}}
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Mã SP / Chất liệu / Tình trạng --}}
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="product_code" class="form-label">Mã Sản Phẩm Gốc</label>
                                    <input type="text" id="product_code" name="product_code" class="form-control @error('product_code') is-invalid @enderror"
                                        value="{{ old('product_code') }}" placeholder="#******">
                                    {{-- Thêm hiển thị lỗi cho trường 'product_code' --}}
                                    @error('product_code')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted" style="font-size:12px">
                                        Mã này dành cho sản phẩm gốc (dùng khi không có biến thể).
                                    </small>
                                </div>
                            </div>

                            {{-- Trường 'material' và 'status' không có trong validation ở controller trước đó, nhưng tôi thêm code lỗi sẵn nếu bạn có thể bổ sung validation cho chúng sau --}}

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="product-material" class="form-label">Chất Liệu</label>
                                    <input type="text" id="product-material" name="material" class="form-control @error('material') is-invalid @enderror"
                                        value="{{ old('material') }}" placeholder="Cotton 100%, denim...">
                                    @error('material')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Tình Trạng</label>
                                    <select class="form-control @error('status') is-invalid @enderror" name="status" id="status"
                                        data-choices data-choices-groups
                                        data-placeholder="Tình trạng sản phẩm">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đang kinh doanh</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Hết hàng</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1" style="font-size:13px">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                ---

                {{-- ACTION BUTTONS --}}
                <div class="p-3 bg-light mb-3 rounded">
                    <div class="row justify-content-end g-2">
                        <div class="col-lg-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100">
                                Hủy
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                Thêm Mới Sản Phẩm
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection