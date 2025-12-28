@php
    $userName = $order->name ?? ($order->user->name ?? 'bạn');
    $code = $order->order_code ?? ('#' . $order->id);

    // Thông tin giao hàng (đã có cột trong orders)
    $shipName  = $order->name ?? '—';
    $shipPhone = $order->phone ?? '—';
    $shipAddr  = $order->address ?? '—';

    // Trạng thái đơn (nếu có relation status -> name)
    $orderStatusText = optional($order->status)->name ?? ('#' . ($order->order_status_id ?? '—'));

    // Phương thức thanh toán:
    // - Nếu bạn có relation payment.method -> name (đúng kiểu bạn đang with('payment.method') ở show admin)
    // - Nếu không có, fallback theo id
    $paymentMethodText =
        optional(optional($order->payment)->method)->name
        ?? optional($order->paymentMethod)->name
        ?? ($order->payment_method_id ?? $order->payment_method ?? null);

    // Trạng thái thanh toán (nếu có relation paymentStatus -> name)
    $paymentStatusText = optional($order->paymentStatus)->name ?? ('#' . ($order->payment_status_id ?? 'Chưa thanh toán'));
@endphp

<div style="font-family: Arial, Helvetica, sans-serif; color:#222; line-height:1.6">
    <h2 style="margin:0 0 10px;">Đặt hàng thành công</h2>

    <p style="margin:0 0 10px;">Xin chào <b>{{ $userName }}</b>,</p>
    <p style="margin:0 0 10px;">Shop đã nhận đơn hàng của bạn và sẽ xử lý sớm nhất.</p>

    {{-- Khối tổng quan đơn hàng --}}
    <div style="border:1px solid #e5e5e5; border-radius:10px; padding:12px; margin:12px 0;">
        <p style="margin:0 0 6px;"><b>Mã đơn:</b> {{ $code }}</p>
        <p style="margin:0 0 6px;"><b>Tạm tính:</b> {{ number_format((float)$order->subtotal, 0, ',', '.') }}đ</p>
        <p style="margin:0 0 6px;"><b>Giảm giá:</b> {{ number_format((float)$order->discount, 0, ',', '.') }}đ</p>
        <p style="margin:0;"><b>Tổng tiền:</b> {{ number_format((float)$order->total_amount, 0, ',', '.') }}đ</p>
    </div>

    {{-- Thông tin giao hàng --}}
    <div style="border:1px solid #e5e5e5; border-radius:10px; padding:12px; margin:12px 0;">
        <h3 style="margin:0 0 8px;">Thông tin giao hàng</h3>
        <p style="margin:0 0 6px;"><b>Người nhận:</b> {{ $shipName }}</p>
        <p style="margin:0 0 6px;"><b>SĐT:</b> {{ $shipPhone }}</p>
        <p style="margin:0;"><b>Địa chỉ:</b> {{ $shipAddr }}</p>
    </div>

    {{-- Trạng thái & thanh toán --}}
    <div style="border:1px solid #e5e5e5; border-radius:10px; padding:12px; margin:12px 0;">
        <h3 style="margin:0 0 8px;">Trạng thái đơn & thanh toán</h3>

        <p style="margin:0 0 6px;"><b>Trạng thái đơn:</b> {{ $orderStatusText }}</p>

        <p style="margin:0 0 6px;">
            <b>Phương thức thanh toán:</b>
            {{ is_numeric($paymentMethodText) ? ('#' . $paymentMethodText) : ($paymentMethodText ?? 'Thanh Toán Khi Nhận Hàng') }}
        </p>

        <p style="margin:0;">
            <b>Trạng thái thanh toán:</b> {{ ($paymentStatusText ) }}
        </p>
    </div>

    {{-- Chi tiết sản phẩm --}}
    @if($order->details && $order->details->count())
        <h3 style="margin:16px 0 8px;">Chi tiết sản phẩm</h3>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Sản phẩm</th>
                    <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">SL</th>
                    <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Giá</th>
                    <th style="text-align:right; padding:8px; border-bottom:1px solid #eee;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $d)
                    @php
                        $name = $d->productVariant->product->name ?? ('Variant #' . $d->product_variant_id);
                        $lineTotal = (float)$d->price * (int)$d->quantity;
                    @endphp
                    <tr>
                        <td style="padding:8px; border-bottom:1px solid #f3f3f3;">
                            {{ $name }}
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f3f3; text-align:right;">
                            {{ (int)$d->quantity }}
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f3f3; text-align:right;">
                            {{ number_format((float)$d->price, 0, ',', '.') }}đ
                        </td>
                        <td style="padding:8px; border-bottom:1px solid #f3f3f3; text-align:right;">
                            {{ number_format($lineTotal, 0, ',', '.') }}đ
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p style="margin:14px 0 0; font-size:12px; color:#666;">
        Thời gian: {{ now()->format('d/m/Y H:i') }}
    </p>
</div>
