@extends('master')

@section('content')
<div class="site-wrapper" style="background-color: #f5f5f5;">
    {{-- Header hệ thống --}}
    @include('layouts.header')

    <div id="site-content" class="site-content-wrapper py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    {{-- Breadcrumb mini --}}
                    <nav class="woocommerce-breadcrumb mb-3" style="font-size: 0.85rem;">
                        <a href="{{ url('/') }}">Trang chủ</a><span class="delimiter">/</span>
                        <a href="{{ route('orders.index') }}">Đơn hàng</a><span class="delimiter">/</span>Đánh giá
                    </nav>

                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden bg-white">
                        {{-- Tiêu đề Card --}}
                        <div class="card-header bg-white border-0 pt-4 pb-2 text-center">
                            <h4 class="fw-bold mb-1" style="color: #222; text-transform: uppercase; letter-spacing: 1px;">Đánh giá sản phẩm</h4>
                            <p class="text-muted small">Mã đơn hàng: <span class="text-dark fw-bold">#{{ $order->order_code }}</span></p>
                        </div>
                        
                        <div class="card-body p-4 pt-2">
                            {{-- Box thông tin sản phẩm & Biến thể --}}
                            <div class="d-flex align-items-center p-3 mb-4 rounded-4 bg-light border-0 shadow-sm">
                                <div class="flex-shrink-0">
                                    @php
                                        // Ưu tiên lấy ảnh của biến thể, nếu không có lấy ảnh sản phẩm gốc
                                        $displayImage = $productVariant->image ?? ($product->image_url ?? null);
                                    @endphp
                                    <img src="{{ $displayImage ? asset('storage/' . $displayImage) : 'https://via.placeholder.com/100' }}" 
                                         onerror="this.src='https://via.placeholder.com/100'"
                                         class="rounded-3 shadow-sm border" width="90" height="90" style="object-fit: cover;">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 1.1rem; line-height: 1.2;">{{ $product->name }}</h6>
                                    <div class="mb-2">
                                        <span class="badge bg-white text-primary border px-2 py-1" style="font-weight: 500; font-size: 0.75rem;">
                                            Phân loại: {{ $productVariant->color->name ?? '' }} - {{ $productVariant->size->name ?? '' }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-0"><i class="fa fa-check-circle text-success"></i> Đã xác thực mua hàng</p>
                                </div>
                            </div>

                            {{-- Form gửi đánh giá --}}
                            <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                                @csrf
                                {{-- Dữ liệu ẩn để định danh --}}
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" value="{{ $productVariant->id }}">

                                {{-- Phần chọn Sao --}}
                                <div class="text-center mb-4">
                                    <label class="form-label fw-bold d-block mb-3" style="font-size: 1.05rem;">Chất lượng sản phẩm</label>
                                    <div class="rating-stars">
                                        <input type="radio" id="star5" name="rating" value="5" required {{ old('rating') == 5 ? 'checked' : '' }} />
                                        <label for="star5" title="5 sao"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }} />
                                        <label for="star4" title="4 sao"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }} />
                                        <label for="star3" title="3 sao"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }} />
                                        <label for="star2" title="2 sao"><i class="fas fa-star"></i></label>
                                        
                                        <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }} />
                                        <label for="star1" title="1 sao"><i class="fas fa-star"></i></label>
                                    </div>
                                    <div id="rating-label" class="rating-text-label text-warning fw-bold mt-3" style="font-size: 1.1rem;">Chạm để đánh giá</div>
                                    @error('rating')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phần nhập nội dung --}}
                                <div class="mb-4">
                                    <label for="content" class="form-label fw-bold small text-secondary">Nhận xét chi tiết</label>
                                    <textarea name="content" id="content" 
                                        class="form-control border-0 bg-light rounded-4 @error('content') is-invalid @enderror" 
                                        rows="5" 
                                        placeholder="Sản phẩm rất đẹp, đóng gói cẩn thận, giao hàng nhanh...">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nút hành động --}}
                                <div class="row g-3 mt-2">
                                    <div class="col-4">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-light w-100 fw-bold rounded-pill py-2 border text-secondary shadow-sm">
                                            TRỞ LẠI
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold text-white px-4 rounded-pill py-2" 
                                                style="background: linear-gradient(135deg, #ee4d2d 0%, #ff7337 100%); border: none;">
                                            HOÀN THÀNH
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer hệ thống --}}
                @include('layouts.footer')
        
</div>

{{-- Styles --}}
<style>
    .rounded-4 { border-radius: 1.25rem !important; }
    
    /* Star Rating System */
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 15px;
    }
    .rating-stars input[type="radio"] { display: none !important; }
    .rating-stars label {
        font-size: 48px;
        color: #ddd;
        cursor: pointer;
        transition: transform 0.2s, color 0.2s;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input[type="radio"]:checked ~ label {
        color: #ffc107;
        transform: scale(1.15);
        filter: drop-shadow(0 0 3px rgba(255,193,7,0.3));
    }

    /* Textarea Customization */
    #content {
        padding: 18px;
        font-size: 15px;
        resize: none;
        border: 1px solid transparent;
        transition: all 0.3s;
    }
    #content:focus {
        background: #fff !important;
        border: 1px solid #ee4d2d !important;
        box-shadow: 0 5px 15px rgba(238, 77, 45, 0.1);
        outline: none;
    }
</style>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ratingLabels = {
            1: 'Tệ',
            2: 'Không hài lòng',
            3: 'Bình thường',
            4: 'Hài lòng',
            5: 'Tuyệt vời'
        };
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const labelText = document.getElementById('rating-label');

        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                labelText.innerText = ratingLabels[this.value];
                labelText.style.color = "#ee4d2d";
            });
        });
    });
</script>
@endsection