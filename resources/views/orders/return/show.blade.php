@extends('master')

@section('content')
<body class="wp-singular page-template page-template-fullwidth page page-id-11 logged-in wp-embed-responsive wp-theme-mixtas ltr theme-mixtas woocommerce-account woocommerce-page woocommerce-view-order woocommerce-js elementor-default elementor-kit-6 body-loaded" data-elementor-device-mode="laptop">

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
                                                    
                                                    @php
                                                        // Định nghĩa nhãn thủ công để tránh lỗi "Không xác định"
                                                        $statusLabels = [
                                                            'pending'            => 'Chờ xác nhận',
                                                            'approved'           => 'Đã chấp nhận',
                                                            'waiting_for_return' => 'Chờ gửi hàng',
                                                            'returned'           => 'Đã nhận hàng',
                                                            'refunded'           => 'Đã hoàn tiền',
                                                            'completed'          => 'Hoàn tất',
                                                            'rejected'           => 'Bị từ chối'
                                                        ];

                                                        $statusBadges = [
                                                            'pending'            => 'badge-on-hold',
                                                            'approved'           => 'badge-processing',
                                                            'waiting_for_return' => 'badge-shipping',
                                                            'returned'           => 'badge-shipping',
                                                            'refunded'           => 'badge-processing',
                                                            'completed'          => 'badge-completed',
                                                            'rejected'           => 'badge-cancelled'
                                                        ];

                                                        $currentReturnStatus = $return->status;
                                                        $displayLabel = $statusLabels[$currentReturnStatus] ?? 'Không xác định';
                                                        $displayBadge = $statusBadges[$currentReturnStatus] ?? '';
                                                        
                                                        $returnStepMeta = [
                                                            'pending' => ['label' => 'Chờ xác nhận', 'desc' => 'Yêu cầu đã gửi'],
                                                            'approved' => ['label' => 'Đã chấp nhận', 'desc' => 'Yêu cầu đã duyệt'],
                                                            'waiting_for_return' => ['label' => 'Chờ gửi hàng', 'desc' => 'Vui lòng gửi hàng'],
                                                            'returned' => ['label' => 'Đã nhận hàng', 'desc' => 'Shop đã nhận hàng'],
                                                            'refunded' => ['label' => 'Đã hoàn tiền', 'desc' => 'Chờ bạn xác nhận'],
                                                            'completed' => ['label' => 'Hoàn tất', 'desc' => 'Giao dịch kết thúc'],
                                                        ];

                                                        $returnStatusMap = [
                                                            'pending' => 1, 'approved' => 2, 'waiting_for_return' => 3,
                                                            'returned' => 4, 'refunded' => 5, 'completed' => 6, 'rejected' => 1,
                                                        ];

                                                        $activeReturnStep = $returnStatusMap[$currentReturnStatus] ?? 1;
                                                    @endphp

                                                    {{-- Header tóm tắt --}}
                                                    <div class="order-header">
                                                        <div>
                                                            <strong>Yêu cầu hoàn hàng cho đơn: {{ $return->order->order_code }}</strong>
                                                        </div>
                                                        <div>
                                                            <span class="badge {{ $displayBadge }}">{{ $displayLabel }}</span>
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
                                                                    @if ($stepNumber < 6)
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
                                                                            $imageUrl = ($detail && $detail->productVariant && $detail->productVariant->image) ? asset($detail->productVariant->image) : null;
                                                                        @endphp
                                                                        <div class="product-item">
                                                                            <div class="product-thumbnail-wrapper">
                                                                                @if($imageUrl) <img src="{{ $imageUrl }}" class="product-thumbnail">
                                                                                @else <div class="product-thumbnail-placeholder"><span>📦</span></div> @endif
                                                                            </div>
                                                                            <div class="product-info">
                                                                                <strong>{{ $item['product_name'] ?? 'Sản phẩm' }}</strong><br>
                                                                                <small>Số lượng: {{ $item['quantity'] }} | Giá: {{ number_format($item['original_price'] ?? 0) }}đ</small>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="detail-row"><span class="label">Lý do:</span><span>{{ $return->reason }}</span></div>
                                                        <div class="detail-row"><span class="label">Số tiền hoàn:</span><strong style="color: #b91c1c;">{{ number_format($return->refund_amount) }}đ</strong></div>

                                                        {{-- BIÊN LAI HOÀN TIỀN --}}
                                                        <div class="detail-row" style="flex-direction: column; margin-top: 20px; border-bottom: none;">
                                                            <span class="label" style="margin-bottom: 10px;">🧾 Biên lai hoàn tiền (Từ cửa hàng):</span>
                                                            @if($return->admin_refund_proof)
                                                                <div style="padding: 15px; background: #f0fdf4; border-radius: 10px; border: 1px solid #bbf7d0;">
                                                                    <a href="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" target="_blank">
                                                                        <img src="{{ asset('storage/' . str_replace('\\', '/', $return->admin_refund_proof)) }}" style="max-width: 250px; border-radius: 6px; border: 2px solid #fff;">
                                                                    </a>
                                                                    <p style="font-size: 12px; color: #166534; margin-top: 5px; font-style: italic;">Đã xác nhận hoàn tiền thành công.</p>
                                                                </div>

                                                                @if($currentReturnStatus === 'refunded')
                                                                    <div style="margin-top: 20px;">
                                                                        <button type="button" class="confirm-received-btn" id="btnConfirmOpen">
                                                                            <i class="fa fa-check-circle"></i> Tôi đã nhận được tiền
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div style="padding: 20px; background: #f9fafb; border-radius: 10px; border: 1px dashed #d1d5db; text-align: center; color: #9ca3af;">
                                                                    <p style="font-size: 13px; margin: 0;">Shop chưa cập nhật ảnh biên lai hoàn tiền.</p>
                                                                </div>
                                                            @endif

                                                            @if($currentReturnStatus === 'completed')
                                                                <div style="margin-top: 20px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; text-align: center;">
                                                                    <p style="margin: 0; color: #166534; font-weight: bold; font-size: 15px;">✨ Yêu cầu đã hoàn tất. Tiền đã về túi bạn!</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="woocommerce-order-details__actions" style="margin-top: 20px;">
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
        </div>
    </div>

    {{-- MODAL --}}
    <div id="customConfirmModal" class="custom-modal-overlay">
        <div class="custom-modal-content">
            <div class="custom-modal-header"><h5 style="color:white; margin:0">Xác nhận nhận tiền</h5><span class="custom-modal-close-icon">&times;</span></div>
            <div class="custom-modal-body" style="padding: 30px; text-align: center;">
                <div style="font-size: 50px; margin-bottom: 15px;">💰</div>
                <p style="font-size: 16px; color: #374151;">Bạn xác nhận đã nhận đủ số tiền <strong>{{ number_format($return->refund_amount) }}đ</strong>?</p>
                <div class="custom-modal-alert">Lưu ý: Sau khi xác nhận, yêu cầu sẽ đóng lại.</div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" class="btn-check-again close-modal-trigger">Kiểm tra lại</button>
                <form action="{{ route('orders.return.confirm_received', $return->id) }}" method="POST" style="flex: 1; margin:0">
                    @csrf
                    <button type="submit" class="btn-confirm-final">Xác nhận ngay</button>
                </form>
            </div>
        </div>
    </div>
</body>

<style>
    .custom-modal-overlay { display: none; position: fixed; z-index: 999999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); align-items: center; justify-content: center; }
    .custom-modal-overlay.active { display: flex; }
    .custom-modal-content { background-color: #fff; border-radius: 12px; width: 90%; max-width: 450px; box-shadow: 0 20px 40px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.3s ease; }
    @keyframes modalFadeIn { from {transform: translateY(-20px); opacity: 0;} to {transform: translateY(0); opacity: 1;} }
    .custom-modal-header { background: #166534; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
    .custom-modal-close-icon { color: white; cursor: pointer; font-size: 28px; line-height: 1; }
    .custom-modal-alert { background: #fffbeb; color: #92400e; padding: 12px; border-radius: 8px; font-size: 13px; margin-top: 15px; border: 1px solid #fef3c7; line-height: 1.4; }
    .custom-modal-footer { padding: 15px 20px; background: #f9fafb; display: flex; gap: 10px; border-top: 1px solid #eee; }
    .btn-check-again { flex: 1; background: #fff; border: 1px solid #d1d5db; border-radius: 6px; padding: 10px; cursor: pointer; font-weight: 600; color: #374151; }
    .btn-confirm-final { width: 100%; background: #166534; color: #fff; border: none; border-radius: 6px; padding: 10px; cursor: pointer; font-weight: 700; }
    .confirm-received-btn { background: linear-gradient(135deg, #166534 0%, #15803d 100%); color: white !important; width: 100%; padding: 14px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2); }
    .order-header { background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
    .return-address-notice { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px 20px; margin-bottom: 25px; border-radius: 8px; color: #78350f; font-size: 14px; }
    .return-progress-container { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 25px; }
    .order-progress { display: flex; align-items: center; gap: 10px; margin: 10px 0 0; }
    .step { display: flex; align-items: center; gap: 8px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; background: #e5e7eb; }
    .dot.active { background: #111827; }
    .bar { height: 2px; width: 46px; background: #e5e7eb; }
    .bar.active { background: #111827; }
    .detail-row { display: flex; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #f3f4f6; }
    .detail-row .label { font-weight: 600; min-width: 160px; color: #374151; }
    .product-item { display: flex; align-items: center; gap: 15px; padding: 10px 0; }
    .product-thumbnail { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb; }
    .badge { padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; color: white; }
    .badge-on-hold { background: #f59e0b; }
    .badge-processing { background: #3b82f6; }
    .badge-shipping { background: #6366f1; }
    .badge-completed { background: #166534; }
    .badge-cancelled { background: #ef4444; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalOverlay = document.getElementById('customConfirmModal');
    const openBtn = document.getElementById('btnConfirmOpen');
    const closeIcons = document.querySelectorAll('.custom-modal-close-icon, .close-modal-trigger');
    if (openBtn) {
        openBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }
    closeIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            modalOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    });
});
</script>
@endsection