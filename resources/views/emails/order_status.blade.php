@php
    $userName = $order->user->name ?? 'bạn';
    $orderCode = $order->order_code ?? '#' . $order->id;
@endphp

<div style="font-family: Arial, Helvetica, sans-serif; line-height: 1.6; color:#222;">
    <h2 style="margin:0 0 10px;">{{ $title }}</h2>

    <p style="margin:0 0 10px;">
        Xin chào <b>{{ $userName }}</b>,
    </p>

    @if (!empty($messageText))
        <p style="margin:0 0 10px;">{{ $messageText }}</p>
    @endif

    <div style="border:1px solid #e5e5e5; border-radius:10px; padding:14px; margin:14px 0;">
        <p style="margin:0 0 6px;"><b>Mã đơn:</b> {{ $orderCode }}</p>
        <p style="margin:0 0 6px;"><b>Tổng tiền:</b> {{ number_format((int) $order->total_amount, 0, ',', '.') }}đ</p>
        <p style="margin:0 0 6px;"><b>Phí ship:</b> {{ number_format((int) $order->shipping_fee, 0, ',', '.') }}đ</p>
        <p style="margin:0 0 6px;"><b>Thanh toán:</b> {{ optional($order->paymentStatus)->name ?? '—' }}</p>
        <p style="margin:0;"><b>Trạng thái đơn:</b> {{ optional($order->status)->name ?? $order->order_status_id }}</p>
    </div>

    {{-- Nếu bạn có details (order_details) thì hiện danh sách sản phẩm --}}
    @if ($order->relationLoaded('details') && $order->details?->count())
        <h3 style="margin:18px 0 8px;">Sản phẩm</h3>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; border-bottom:1px solid #eee; padding:8px;">Tên</th>
                    <th style="text-align:right; border-bottom:1px solid #eee; padding:8px;">SL</th>
                    <th style="text-align:right; border-bottom:1px solid #eee; padding:8px;">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->details as $d)
                    @php
                        $variant = $d->productVariant;
                        $productName = $variant?->product?->name ?? 'Sản phẩm';
                        $color = $variant?->color?->name;
                        $size = $variant?->size?->name;
                        $variantText = trim(($color ? "Màu: $color" : '') . ($size ? " | Size: $size" : ''), ' |');
                    @endphp
                    <tr>
                        <td style="border-bottom:1px solid #f3f3f3; padding:8px;">
                            <div style="font-weight:600;">{{ $productName }}</div>
                            @if ($variantText)
                                <div style="font-size:12px; color:#666;">{{ $variantText }}</div>
                            @endif
                        </td>
                        <td style="border-bottom:1px solid #f3f3f3; padding:8px; text-align:right;">
                            {{ (int) $d->quantity }}
                        </td>
                        <td style="border-bottom:1px solid #f3f3f3; padding:8px; text-align:right;">
                            {{ number_format((int) $d->price, 0, ',', '.') }}đ
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p style="margin:16px 0 0; color:#666; font-size:12px;">
        Thời gian: {{ now()->format('d/m/Y H:i') }}
    </p>
</div>
