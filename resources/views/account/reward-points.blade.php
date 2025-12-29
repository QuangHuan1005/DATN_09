@extends('layouts.app')

@section('content')
<div class="site-content-wrapper py-5">
    <div class="container" style="max-width: 1140px; margin: 0 auto;">
        
        {{-- Header: Đơn giản hóa với tông màu trung tính --}}
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1" style="font-size: 28px; color: #1e293b;">🎁 Shop Đổi Thưởng</h2>
                <p class="text-muted" style="font-size: 16px;">Sử dụng điểm tích lũy để nhận ưu đãi mua sắm.</p>
            </div>
            <div class="reward-points-badge shadow-sm">
                <iconify-icon icon="solar:coin-bold" class="coin-icon"></iconify-icon>
                <div class="points-text">
                    <small>Điểm của bạn</small>
                    <strong>{{ number_format($user->points ?? 0) }}</strong>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($vouchers as $voucher)
                <div class="col-xl-4 col-md-6">
                    <div class="voucher-ticket shadow-sm">
                        {{-- Phần trái: Màu phẳng, thanh lịch --}}
                        <div class="ticket-left">
                            <div class="discount-value">
                                @if($voucher->discount_type === 'percent')
                                    {{ $voucher->discount_value }}%
                                @else
                                    {{ number_format($voucher->discount_value / 1000) }}K
                                @endif
                            </div>
                            <div class="discount-label">GIẢM GIÁ</div>
                        </div>

                        {{-- Phần phải: Trắng sạch sẽ --}}
                        <div class="ticket-right">
                            <div class="ticket-info">
                                <h5 class="voucher-code">{{ $voucher->voucher_code }}</h5>
                                <div class="min-order">Đơn tối thiểu: {{ number_format($voucher->min_order_value) }}đ</div>
                                <div class="points-required">
                                    <i class="bi bi-tag-fill me-1"></i>{{ number_format($voucher->points_required) }} điểm
                                </div>
                            </div>
                            
                            <form action="{{ route('account.reward.redeem', $voucher->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-redeem" {{ ($user->points < $voucher->points_required) ? 'disabled' : '' }}>
                                    ĐỔI
                                </button>
                            </form>
                            
                            {{-- Hiệu ứng đục lỗ tiệp màu nền --}}
                            <div class="hole hole-top"></div>
                            <div class="hole hole-bottom"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Hiện chưa có voucher nào khả dụng.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Nền tổng thể màu xám cực nhẹ */
    .site-content-wrapper { background-color: #f8fafc; min-height: 80vh; font-family: 'Inter', sans-serif; }

    /* Badge điểm: Tông xanh Navy trắng */
    .reward-points-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .reward-points-badge .coin-icon { font-size: 28px; color: #f59e0b; }
    .reward-points-badge .points-text { display: flex; flex-direction: column; line-height: 1.2; }
    .reward-points-badge .points-text small { font-size: 11px; color: #64748b; text-transform: uppercase; }
    .reward-points-badge .points-text strong { font-size: 20px; color: #0f172a; }

    /* Voucher Ticket Layout: Đơn giản hóa */
    .voucher-ticket {
        display: flex;
        background: white;
        border-radius: 10px;
        height: 140px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .voucher-ticket:hover { transform: translateY(-3px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }

    .ticket-left {
        flex: 0 0 90px;
        background: #0f172a; /* Màu Navy tối cực sang */
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-radius: 10px 0 0 10px;
    }
    .discount-value { font-size: 24px; font-weight: 700; }
    .discount-label { font-size: 10px; font-weight: 500; opacity: 0.8; letter-spacing: 1px; }

    .ticket-right {
        flex: 1;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }
    .voucher-code { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .min-order { font-size: 12px; color: #64748b; margin-bottom: 8px; }
    .points-required { font-size: 13px; color: #2563eb; font-weight: 600; }
    
    .btn-redeem {
        background: #2563eb; /* Xanh Royal */
        color: white;
        border: none;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-redeem:hover:not(:disabled) { background: #1d4ed8; }
    .btn-redeem:disabled { background: #cbd5e1; color: #94a3b8; cursor: not-allowed; }

    /* Hiệu ứng lỗ bấm vé: Tiệp màu với nền nền #f8fafc */
    .hole {
        position: absolute;
        width: 14px;
        height: 14px;
        background: #f8fafc;
        border-radius: 50%;
        left: -7px;
        border: 1px solid #e2e8f0;
    }
    .hole-top { top: -7px; }
    .hole-bottom { bottom: -7px; }
</style>
@endsection