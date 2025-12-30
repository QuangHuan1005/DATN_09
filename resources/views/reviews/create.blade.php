@extends('master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                    <h5 class="fw-bold mb-1">Đánh giá sản phẩm</h5>
                    <p class="text-muted small">Mã đơn hàng: #{{ $orderId }}</p>
                </div>
                
                <div class="card-body p-4">
                    <div class="d-flex align-items-center p-3 mb-4 rounded-3 bg-light border">
                        <div class="flex-shrink-0">
                            {{-- Sử dụng hàm normalizeImageUrl đã có trong CheckoutController --}}
                            <img src="{{ asset('storage/products/' . $productId . '.jpg') }}" 
                                 onerror="this.src='https://via.placeholder.com/100'"
                                 class="rounded-3 shadow-sm" width="80" height="80" style="object-fit: cover;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 fw-bold text-dark">Sản phẩm #{{ $productId }}</h6>
                            <p class="text-muted small mb-0">Cảm ơn bạn đã mua hàng tại hệ thống!</p>
                        </div>
                    </div>

                    <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $orderId }}">
                        <input type="hidden" name="product_id" value="{{ $productId }}">

                        <div class="text-center mb-4">
                            <label class="form-label fw-bold d-block mb-2">Bạn cảm thấy sản phẩm thế nào?</label>
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
                            <div id="rating-label" class="rating-text-label text-warning fw-bold mt-2">Chạm để chọn sao</div>
                            @error('rating')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold small">Nội dung đánh giá</label>
                            <textarea name="content" id="content" 
                                class="form-control border-0 bg-light rounded-3 @error('content') is-invalid @enderror" 
                                rows="4" 
                                placeholder="Sản phẩm dùng rất tốt, tôi sẽ ủng hộ shop lần sau...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 pt-2">
                            <div class="col-4">
                                <a href="{{ route('orders.show', $orderId) }}" class="btn btn-outline-secondary w-100 fw-bold rounded-pill">TRỞ LẠI</a>
                            </div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-warning w-100 shadow-sm fw-bold text-white px-4 rounded-pill py-2" style="background-color: #ee4d2d; border-color: #ee4d2d;">
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

<style>
    body { background-color: #f0f2f5; }
    .card { border-radius: 20px !important; }

    /* --- CSS HỆ THỐNG SAO CHUYÊN NGHIỆP --- */
    .rating-stars {
        display: flex;
        flex-direction: row-reverse; /* Quan trọng để hover từ trái qua phải */
        justify-content: center;
        gap: 12px;
    }

    /* Ẩn triệt để nút tròn radio */
    .rating-stars input[type="radio"] {
        display: none !important;
        position: absolute;
    }

    .rating-stars label {
        font-size: 45px; /* Tăng kích thước sao để dễ click */
        color: #e9ecef;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    /* Hiệu ứng khi Hover và khi Clicked (Checked) */
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input[type="radio"]:checked ~ label {
        color: #ffc107; /* Màu vàng */
        transform: scale(1.1);
    }

    /* Văn bản phản hồi theo số sao */
    .rating-text-label {
        font-size: 14px;
        min-height: 21px;
    }

    /* Textarea tùy chỉnh */
    #content {
        padding: 15px;
        font-size: 14.5px;
        resize: none;
    }
    #content:focus {
        background: #fff !important;
        border: 1px solid #ee4d2d !important;
        box-shadow: none;
    }
</style>

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
            });
        });
    });
</script>
@endsection