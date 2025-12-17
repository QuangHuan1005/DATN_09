@extends('master')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Đánh giá Sản phẩm trong Đơn hàng #{{ $orderId }}</h2>
        </div>
        <div class="card-body p-4">
            <p class="text-muted">Bạn đang đánh giá sản phẩm có ID: **{{ $productId }}**</p>

            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="order_id" value="{{ $orderId }}">
                <input type="hidden" name="product_id" value="{{ $productId }}">

                <div class="mb-4">
                    <label class="form-label d-block fw-bold" for="rating">
                        Xếp hạng (1-5 Sao) <span class="text-danger">*</span>
                    </label>
                    
                    <div class="rating-stars">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required @if(old('rating') == $i) checked @endif />
                            <label for="star{{ $i }}" title="{{ $i }} sao">
                                <i class="fas fa-star"></i> </label>
                        @endfor
                    </div>
                    @error('rating')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">Nội dung đánh giá (Tùy chọn)</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('orders.show', $orderId) }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-success">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <style>
       /* TĂNG CƯỜNG ƯU TIÊN VÀ XÁC ĐỊNH LỖI */
        
        .rating-stars {
            direction: rtl !important; /* Đảm bảo RTL được áp dụng */
            display: inline-block !important; 
            font-size: 0 !important;
        }
        .rating-stars input[type="radio"] {
            display: none !important; /* Đảm bảo radio button bị ẩn */
        }
        
        /* 1. Thiết lập màu mặc định */
        .rating-stars label {
            font-size: 30px !important; 
            color: #ccc !important; /* Màu xám mặc định */
            padding: 0 5px !important;
            cursor: pointer !important;
            transition: color 0.2s !important;
            display: inline-block !important;
            line-height: 1 !important;
        }

        /* 2. Đảm bảo Icon <i> kế thừa màu từ label */
        .rating-stars label i.fas.fa-star {
            color: inherit !important;
        }

        /* 3. TÔ MÀU KHI HOVER/CHỌN (Quan trọng nhất) */
        .rating-stars label:hover,
        .rating-stars label:hover ~ label,
        .rating-stars input[type="radio"]:checked ~ label {
            color: #ffc107 !important; /* Màu vàng khi chọn hoặc hover */
        }
        
        /* Đảm bảo ngôi sao được chọn vẫn giữ màu vàng */
        .rating-stars input[type="radio"]:checked + label {
            color: #ffc107 !important;
        }
    </style>
@endpush