@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-3">🎁 Đổi điểm lấy voucher</h3>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <p>
        Điểm hiện có:
        <strong class="text-primary">
            {{ $user->points ?? 0 }}
        </strong>
    </p>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Mã voucher</th>
                <th>Giảm</th>
                <th>Điểm cần</th>
                <th>Số lượng</th>
                <th width="160">Thao tác</th>
            </tr>
        </thead>

        <tbody>
        @forelse($vouchers as $voucher)
            @php
                $notEnoughPoints = ($user->points ?? 0) < $voucher->points_required;
                $outOfStock = $voucher->quantity <= $voucher->total_used;
            @endphp

            <tr>
                {{-- Mã voucher --}}
                <td>{{ $voucher->voucher_code }}</td>

                {{-- Giảm --}}
                <td>
                    @if($voucher->discount_type === 'percent')
                        {{ $voucher->discount_value }}%
                    @else
                        {{ number_format($voucher->discount_value) }}đ
                    @endif
                </td>

                {{-- Điểm cần --}}
                <td>{{ $voucher->points_required }}</td>

                {{-- Số lượng --}}
                <td>
                    {{ $voucher->quantity - $voucher->total_used }}
                </td>

                {{-- Thao tác --}}
                <td>
                    @if($outOfStock)
                        <span class="badge bg-secondary">Hết lượt</span>
                    @elseif($notEnoughPoints)
                        <button class="btn btn-sm btn-secondary w-100" disabled>
                            Không đủ điểm
                        </button>
                    @else
                        <form method="POST"
                              action="{{ route('account.reward.redeem', $voucher->id) }}"
                              onsubmit="return confirm('Bạn chắc chắn muốn đổi voucher này?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                Đổi
                            </button>
                        </form>
                    @endif
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    Hiện chưa có voucher nào để đổi
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>
@endsection
