@extends('master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-star-half-alt me-2"></i>Đánh giá Sản phẩm - Đơn hàng #{{ $orderId }}</h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        Bạn đang đánh giá sản phẩm có ID: <strong>#{{ $productId }}</strong>
                    </div>

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="order_id" value="{{ $orderId }}">
                        <input type="hidden" name="product_id" value="{{ $productId }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold d-block">Xếp hạng (1-5 Sao) <span class="text-danger">*</span></label>
                            <div class="rating-stars">
    @for ($i = 1; $i <= 5; $i++)
        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required @if(old('rating') == $i) checked @endif />
        <label for="star{{ $i }}" title="{{ $i }} sao">
            <i class="fas fa-star"></i>
        </label>
    @endfor
</div>
                            @error('rating')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">Nội dung đánh giá (Tùy chọn)</label>
                            <textarea name="content" id="content" 
                                class="form-control @error('content') is-invalid @enderror" 
                                rows="5" 
                                placeholder="Hãy chia sẻ cảm nhận của bạn về chất lượng sản phẩm và dịch vụ nhé...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('orders.show', $orderId) }}" class="btn btn-light px-4">Hủy</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-paper-plane me-2"></i>Gửi đánh giá
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Bọc bên ngoài để căn lề trái cho cụm sao */
    .rating-wrapper {
        display: inline-block;
    }

    .rating-stars {
        display: flex;
        flex-direction: row-reverse; /* Đảo ngược để logic hover từ trái qua phải hoạt động */
        justify-content: flex-end;
    }

    /* Ẩn triệt để nút radio tròn */
    .rating-stars input[type="radio"] {
        display: none !important;
    }

    .rating-stars label {
        font-size: 35px; /* Tăng kích thước sao cho dễ bấm */
        color: #e9ecef; /* Màu xám nhạt khi chưa chọn */
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        padding: 0 2px;
    }

    /* Hiệu ứng khi di chuột vào (Hover) */
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffca08; /* Màu vàng sáng */
        transform: scale(1.1);
    }

    /* Hiệu ứng khi đã chọn (Checked) */
    .rating-stars input[type="radio"]:checked ~ label {
        color: #ffc107; /* Màu vàng chuẩn */
    }

    /* Đảm bảo textarea trông đẹp hơn */
    #content:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }
</style>
@endpush