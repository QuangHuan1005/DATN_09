@extends('master')

@section('content')
<body class="wp-singular page-template page-template-templates page-template-fullwidth page-template-templatesfullwidth-php page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js woo-variation-swatches wvs-behavior-blur wvs-theme-mixtas wvs-show-label wvs-tooltip elementor-default elementor-kit-6 blog-sidebar-active blog-sidebar-right single-blog-sidebar-active kitify--js-ready body-loaded e--ua-blink e--ua-chrome e--ua-webkit" data-elementor-device-mode="laptop">

    <div class="site-wrapper">
        <div class="kitify-site-wrapper elementor-459kitify">
            @include('layouts.header')

            <div id="site-content" class="site-content-wrapper">
                <div class="container">
                    <div class="grid-x">
                        <div class="cell small-12">
                            <div class="site-content">
                                <div class="page-header-content">
                                    <nav class="woocommerce-breadcrumb">
                                        <a href="{{ url('/') }}">Home</a><span class="delimiter">/</span>
                                        <a href="{{ route('orders.index') }}">My account</a><span class="delimiter">/</span>
                                        <a href="{{ route('orders.show', $return->order->id) }}">Order {{ $return->order->order_code }}</a><span class="delimiter">/</span>Yêu cầu hoàn hàng
                                    </nav>
                                    <h1 class="page-title">Chi tiết yêu cầu hoàn hàng</h1>
                                </div>

                                <article class="hentry">
                                    <div class="entry-content">
                                        <div class="woocommerce">
                                            @include('account.partials.navigation')

                                            <div class="woocommerce-MyAccount-content">
                                                <div class="woocommerce-order-details">
                                                    
                                                    {{-- Header tóm tắt --}}
                                                    <div class="order-header">
                                                        <div>
                                                            <strong>Yêu cầu hoàn hàng cho đơn: {{ $return->order->order_code }}</strong>
                                                        </div>
                                                        <div>
                                                            <span class="badge {{ $return->status_badge_class }}">{{ $return->status_label }}</span>
                                                        </div>
                                                    </div>

                                                    {{-- Thông báo địa chỉ --}}
                                                    <div class="return-address-notice">
                                                        <p>
                                                            <strong>📍 Thông báo quan trọng:</strong> 
                                                            Quý khách vui lòng gửi hàng về địa chỉ 
                                                            <strong>Số nhà 123, đường Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</strong> 
                                                            để chúng tôi có thể xác nhận và tiến hành hoàn tiền cho quý khách.
                                                        </p>
                                                    </div>

                                                    @php
                                                        $returnStepMeta = [
                                                            'pending' => ['label' => 'Chờ xác nhận', 'desc' => 'Yêu cầu hoàn hàng đã được gửi'],
                                                            'approved' => ['label' => 'Đã chấp nhận', 'desc' => 'Yêu cầu đã được chấp nhận'],
                                                            'waiting_for_return' => ['label' => 'Chờ gửi hàng', 'desc' => 'Vui lòng gửi hàng về Friday'],
                                                            'returned' => ['label' => 'Đã nhận hàng', 'desc' => 'Friday đã nhận được hàng'],
                                                            'refunded' => ['label' => 'Đã hoàn tiền', 'desc' => 'Tiền đã được hoàn lại'],
                                                        ];

                                                        $returnStatusMap = [
                                                            'pending' => 1,
                                                            'approved' => 2,
                                                            'waiting_for_return' => 3,
                                                            'returned' => 4,
                                                            'refunded' => 5,
                                                            'rejected' => 1,
                                                        ];

                                                        $currentReturnStatus = $return->status;
                                                        $activeReturnStep = $returnStatusMap[$currentReturnStatus] ?? 1;
                                                    @endphp

                                                    {{-- Thanh tiến trình --}}
                                                    @if($currentReturnStatus !== 'rejected')
                                                        <div class="return-progress-container">
                                                            <h3 style="font-size: 1rem; color: #374151; margin-bottom: 15px;">Trạng thái hoàn hàng</h3>
                                                            <div class="order-progress" aria-label="Tiến trình hoàn hàng">
                                                                @foreach ($returnStepMeta as $statusKey => $meta)
                                                                    @php
                                                                        $stepNumber = $returnStatusMap[$statusKey];
                                                                        $isReached = $activeReturnStep >= $stepNumber;
                                                                    @endphp

                                                                    <div class="step">
                                                                        <span class="dot {{ $isReached ? 'active' : '' }}"></span>
                                                                        <div style="display:flex;flex-direction:column;align-items:flex-start">
                                                                            <span style="font-size:.83rem;color:#374151">{{ $meta['label'] }}</span>
                                                                            <span style="font-size:.78rem;color:#6b7280">{{ $meta['desc'] }}</span>
                                                                            @if($isReached)
                                                                                <span style="font-size:.75rem;color:#9ca3af">
                                                                                    {{ ($statusKey === 'pending') ? $return->created_at->format('H:i d/m/Y') : $return->updated_at->format('H:i d/m/Y') }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    @if ($stepNumber < 5)
                                                                        <span class="bar {{ $activeReturnStep > $stepNumber ? 'active' : '' }}"></span>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="return-rejected-notice">
                                                            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                                                <p style="color: #b91c1c; font-weight: 600; font-size: 16px; margin-bottom: 12px;">❌ Yêu cầu hoàn hàng đã bị từ chối</p>
                                                                @if($return->rejection_reason)
                                                                    <div style="margin-top: 10px; padding: 12px; background: white; border-radius: 6px; border-left: 3px solid #dc2626;">
                                                                        <p style="margin: 0; color: #374151; font-size: 14px; line-height: 1.6;">
                                                                            <strong style="color: #dc2626;">Lý do:</strong> {{ $return->rejection_reason }}
                                                                        </p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Chi tiết yêu cầu --}}
                                                    <div class="return-details">
                                                        <div class="detail-row">
                                                            <span class="label">Sản phẩm:</span>
                                                            <div class="product-list">
                                                                @php
                                                                    $productDetails = is_array($return->product_details) ? $return->product_details : json_decode($return->product_details, true);
                                                                @endphp

                                                                @if(!empty($productDetails))
                                                                    @foreach($productDetails as $item)
                                                                        @php
                                                                            $detailId = $item['order_detail_id'] ?? null;
                                                                            $detail = $detailId ? $return->order->details->where('id', $detailId)->first() : null;
                                                                            $imageUrl = ($detail && $detail->productVariant && $detail->productVariant->image) 
                                                                                        ? asset($detail->productVariant->image) : null;
                                                                        @endphp
                                                                        <div class="product-item">
                                                                            <div class="product-thumbnail-wrapper">
                                                                                @if($imageUrl)
                                                                                    <img src="{{ $imageUrl }}" class="product-thumbnail">
                                                                                @else
                                                                                    <div class="product-thumbnail-placeholder"><span>📦</span></div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="product-info">
                                                                                <strong>{{ $item['product_name'] ?? 'Sản phẩm' }}</strong>
                                                                                <br>
                                                                                <small>Số lượng: {{ $item['quantity'] }} | Giá: {{ number_format($item['price']) }}đ</small>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="detail-row">
                                                            <span class="label">Ngày yêu cầu:</span>
                                                            <span>{{ $return->created_at->format('d/m/Y H:i') }}</span>
                                                        </div>

                                                        <div class="detail-row">
                                                            <span class="label">Lý do:</span>
                                                            <span>{{ $return->reason }}</span>
                                                        </div>

                                                        <div class="detail-row">
                                                            <span class="label">Số tiền hoàn:</span>
                                                            <strong style="color: #b91c1c;">{{ number_format($return->refund_amount) }}đ</strong>
                                                        </div>

                                                        @if ($return->refundAccount)
                                                            <div class="detail-row">
                                                                <span class="label">Tài khoản nhận:</span>
                                                                <span>
                                                                    {{ $return->refundAccount->bank_name }} - 
                                                                    {{ $return->refundAccount->account_number }} 
                                                                    ({{ $return->refundAccount->account_holder }})
                                                                </span>
                                                            </div>
                                                        @endif
{{-- 📸 PHẦN 1: HÌNH ẢNH MINH CHỨNG CỦA KHÁCH HÀNG --}}
<div class="detail-row" style="flex-direction: column;">
    <span class="label" style="margin-bottom: 10px;">📸 Hình ảnh minh chứng (Bạn gửi):</span>
    <div class="return-images" style="display: flex; gap: 10px; flex-wrap: wrap;">
        @php
            // 1. Giải mã JSON (Vì DB lưu dạng ["refunds\/..."])
            $userImages = is_string($return->images) ? json_decode($return->images, true) : $return->images;
        @endphp

        @if(!empty($userImages) && count($userImages) > 0)
            @foreach ($userImages as $image)
                @php
                    // 2. Lấy tên file gốc (Bỏ phần 'refunds/' đi)
                    $fileName = basename(str_replace('\\', '/', $image));
                    
                    // 3. Vì bạn xác nhận ảnh nằm ở public/uploads/returns
                    // Ta sẽ ép đường dẫn về đúng thực tế vật lý
                    $fixedPath = 'uploads/returns/' . $fileName;
                    $imageUrl = asset($fixedPath);
                @endphp
                <div style="text-align: center;">
                    <a href="{{ $imageUrl }}" target="_blank">
                        <img src="{{ $imageUrl }}" 
                             style="width: 140px; height: 140px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;"
                             onerror="this.src='https://placehold.co/140x140?text=File+Not+Found';">
                    </a>
                    <div style="font-size: 10px; color: #666; margin-top: 5px;">{{ $fileName }}</div>
                </div>
            @endforeach
        @else
            {{-- HIỂN THỊ KHI NULL --}}
            <div style="width: 120px; height: 120px; background: #f3f4f6; border: 1px dashed #d1d5db; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-direction: column; color: #9ca3af;">
                <span style="font-size: 24px;">📷</span>
                <span style="font-size: 10px;">Chưa có ảnh</span>
            </div>
        @endif
    </div>
</div>

    {{-- 🧾 PHẦN 2: BIÊN LAI HOÀN TIỀN CỦA ADMIN --}}
    <div class="detail-row" style="flex-direction: column; margin-top: 20px;">
        <span class="label" style="margin-bottom: 10px;">🧾 Biên lai hoàn tiền (Từ cửa hàng):</span>
        
        @if($return->admin_refund_proof)
            {{-- HIỂN THỊ KHI CÓ ẢNH --}}
            <div style="padding: 15px; background: #f0fdf4; border-radius: 10px; border: 1px solid #bbf7d0;">
                <a href="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" target="_blank">
                    <img src="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" 
                         style="max-width: 250px; border-radius: 6px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                </a>
                <p style="font-size: 12px; color: #166534; margin-top: 5px; font-style: italic;">Đã xác nhận hoàn tiền thành công.</p>
            </div>
        @else
            {{-- HIỂN THỊ KHI NULL (VẪN HIỆN KHUNG ĐỂ BIẾT) --}}
            <div style="padding: 20px; background: #f9fafb; border-radius: 10px; border: 1px dashed #d1d5db; text-align: center; color: #9ca3af;">
                <div style="font-size: 30px; margin-bottom: 5px;">🧾</div>
                <p style="font-size: 13px; margin: 0;">Shop chưa cập nhật ảnh biên lai hoàn tiền.</p>
                <small style="font-size: 11px;">(Trạng thái hiện tại: <strong>{{ $return->status_label }}</strong>)</small>
            </div>
        @endif
    </div>
</div>

                                                    <div class="woocommerce-order-details__actions">
                                                        <a href="{{ route('orders.show', $return->order->id) }}" class="woocommerce-button button">Quay lại đơn hàng</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('layouts.footer')
            <div class="nova-overlay-global"></div>
        </div>
    </div>
</body>

<style>
    .order-header {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .return-address-notice {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 8px;
    }

    .return-address-notice p {
        margin: 0;
        line-height: 1.6;
        color: #78350f;
        font-size: 14px;
    }

    .return-progress-container {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .order-progress {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 10px 0 0;
    }

    .order-progress .step {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-progress .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #e5e7eb;
    }

    .order-progress .dot.active {
        background: #111827;
    }

    .order-progress .bar {
        height: 2px;
        width: 46px;
        background: #e5e7eb;
    }

    .order-progress .bar.active {
        background: #111827;
    }

    .return-details {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .detail-row .label {
        font-weight: 600;
        min-width: 160px;
        color: #374151;
        margin-right: 15px;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
    }

    .product-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .product-thumbnail-placeholder {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        border-radius: 8px;
        font-size: 24px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .78rem;
        font-weight: 700;
    }

    .badge-on-hold { background: #fff6ea; color: #9a3412; }
    .badge-processing { background: #eaf3ff; color: #1d4ed8; }
    .badge-completed { background: #eafaf0; color: #166534; }
    .badge-cancelled { background: #fff1f1; color: #b91c1c; }
    .badge-shipping { background: #e9fdf4; color: #047857; }

    .badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
</style>
@endsection