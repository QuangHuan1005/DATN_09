@extends('layouts.app')

@section('content')
<div class="site-content-wrapper py-5">
    <div class="container" style="max-width: 1140px; margin: 0 auto;">
        
        {{-- THÔNG BÁO FLASH MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #f0fdf4; color: #166534;">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:check-circle-bold" class="me-2" style="font-size: 24px;"></iconify-icon>
                    <div>
                        <strong>Thành công!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px; background-color: #fef2f2; color: #991b1b;">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:danger-bold" class="me-2" style="font-size: 24px;"></iconify-icon>
                    <div>
                        <strong>Lỗi!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Header --}}
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
            @php
                /**
                 * Chuyển danh sách voucher đã sở hữu thành Collection có Key là ID 
                 * để tìm kiếm cực nhanh và lấy được dữ liệu cột pivot 'is_used'
                 */
                $ownedVouchers = $user->ownedVouchers ? $user->ownedVouchers->keyBy('id') : collect();
            @endphp

            @forelse($vouchers as $voucher)
                @php
                    $userVoucherInfo = $ownedVouchers->get($voucher->id);
                    $isOwned = !is_null($userVoucherInfo);
                    
                    // Lấy giá trị is_used từ bảng trung gian (pivot)
                    $isUsed = $isOwned && $userVoucherInfo->pivot->is_used == 1;
                    
                    $hasEnoughPoints = ($user->points ?? 0) >= $voucher->points_required;
                @endphp
                <div class="col-xl-4 col-md-6">
                    <div class="voucher-ticket shadow-sm {{ $isUsed ? 'ticket-used' : ($isOwned ? 'ticket-owned' : '') }}">
                        {{-- Phần trái --}}
                        <div class="ticket-left" style="{{ $isUsed ? 'background: #94a3b8;' : ($isOwned ? 'background: #64748b;' : '') }}">
                            <div class="discount-value">
                                @if($voucher->discount_type === 'percent')
                                    {{ $voucher->discount_value }}%
                                @else
                                    {{ number_format($voucher->discount_value / 1000) }}K
                                @endif
                            </div>
                            <div class="discount-label">GIẢM GIÁ</div>
                        </div>

                        {{-- Phần phải --}}
                        <div class="ticket-right">
                            <div class="ticket-info">
                                <h5 class="voucher-code text-uppercase">{{ $voucher->voucher_code }}</h5>
                                <div class="min-order">Đơn tối thiểu: {{ number_format($voucher->min_order_value) }}đ</div>
                                <div class="points-required">
                                    <iconify-icon icon="solar:tag-price-bold" class="me-1"></iconify-icon>
                                    {{ number_format($voucher->points_required) }} điểm
                                </div>
                            </div>
                            
                            <div class="action-form">
                                @if($isUsed)
                                    <button type="button" class="btn-redeem btn-used" disabled>
                                        ĐÃ DÙNG
                                    </button>
                                @elseif($isOwned)
                                    <button type="button" class="btn-redeem btn-owned" disabled>
                                        ĐÃ CÓ
                                    </button>
                                @else
                                    <form action="{{ route('account.reward.redeem', $voucher->id) }}" method="POST" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn dùng {{ number_format($voucher->points_required) }} điểm để đổi voucher này?')">
                                        @csrf
                                        <button type="submit" class="btn-redeem" {{ !$hasEnoughPoints ? 'disabled' : '' }}>
                                            {{ !$hasEnoughPoints ? 'KĐ ĐIỂM' : 'ĐỔI' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            {{-- Hiệu ứng đục lỗ --}}
                            <div class="hole hole-top"></div>
                            <div class="hole hole-bottom"></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <iconify-icon icon="solar:box-minimalistic-linear" style="font-size: 64px; color: #cbd5e1;"></iconify-icon>
                    <p class="text-muted mt-3">Hiện chưa có voucher nào khả dụng.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .site-content-wrapper { background-color: #f8fafc; min-height: 80vh; font-family: 'Inter', sans-serif; }

    .reward-points-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .reward-points-badge .coin-icon { font-size: 32px; color: #f59e0b; }
    .reward-points-badge .points-text small { font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: 600; }
    .reward-points-badge .points-text strong { font-size: 22px; color: #0f172a; }

    .voucher-ticket {
        display: flex;
        background: white;
        border-radius: 12px;
        height: 140px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .voucher-ticket:hover:not(.ticket-owned):not(.ticket-used) { transform: translateY(-5px); box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1) !important; }
    .ticket-owned { border-color: #cbd5e1; }
    .ticket-used { opacity: 0.6; filter: grayscale(0.5); }

    .ticket-left {
        flex: 0 0 100px;
        background: #0f172a; 
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border-right: 2px dashed #f8fafc;
    }
    .discount-value { font-size: 28px; font-weight: 800; }
    .discount-label { font-size: 10px; font-weight: 600; opacity: 0.8; letter-spacing: 1px; }

    .ticket-right {
        flex: 1;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }
    .voucher-code { font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
    .min-order { font-size: 12px; color: #64748b; margin-bottom: 10px; }
    .points-required { font-size: 14px; color: #2563eb; font-weight: 700; display: flex; align-items: center; }
    
    .btn-redeem {
        background: #2563eb; 
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        transition: 0.2s;
        z-index: 5;
    }
    .btn-redeem:hover:not(:disabled) { background: #1d4ed8; transform: scale(1.05); }
    .btn-redeem:disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; }
    
    .btn-owned { background: #64748b !important; color: #ffffff !important; }
    .btn-used { background: #94a3b8 !important; color: #ffffff !important; }

    .hole {
        position: absolute;
        width: 20px;
        height: 20px;
        background: #f8fafc; 
        border-radius: 50%;
        left: -10px;
        z-index: 2;
        border: 1px solid #e2e8f0;
    }
    .hole-top { top: -10px; }
    .hole-bottom { bottom: -10px; }
</style>
@endsection