<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .order-info {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .order-details {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Đặt hàng thành công!</h1>
    </div>
    
    <div class="content">
        <p>Xin chào <strong>{{ $order->name }}</strong>,</p>
        
        <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.</p>
        
        <div class="order-info">
            <h2 style="margin-top: 0;">Thông tin đơn hàng</h2>
            <p><strong>Mã đơn hàng:</strong> #{{ $order->order_code }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong> {{ $order->status->name ?? 'Chờ xác nhận' }}</p>
        </div>
        
        <div class="order-details">
            <h3>Chi tiết đơn hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $detail)
                        @php
                            $variant = $detail->productVariant;
                            $product = $variant->product ?? null;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $product->name ?? 'Sản phẩm' }}</strong>
                                @if($variant)
                                    @if($variant->size)
                                        <br><small>Size: {{ $variant->size->name }}</small>
                                    @endif
                                    @if($variant->color)
                                        <br><small>Màu: {{ $variant->color->name }}</small>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price) }}đ</td>
                            <td>{{ number_format($detail->price * $detail->quantity) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-top: 20px; text-align: right;">
                <p>Tạm tính: <strong>{{ number_format($order->subtotal) }}đ</strong></p>
                @if($order->discount > 0)
                    <p>Giảm giá: <strong style="color: #d32f2f;">-{{ number_format($order->discount) }}đ</strong></p>
                @endif
                @if($order->voucher)
                    <p><small>Mã giảm giá: {{ $order->voucher->voucher_code }}</small></p>
                @endif
                <p class="total">Tổng tiền: {{ number_format($order->total_amount) }}đ</p>
            </div>
        </div>
        
        <div class="order-info">
            <h3>Thông tin giao hàng</h3>
            <p><strong>Người nhận:</strong> {{ $order->name }}</p>
            <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('orders.show', $order->id) }}" class="btn">Xem chi tiết đơn hàng</a>
        </div>
        
        <p>Chúng tôi sẽ cập nhật tình trạng đơn hàng của bạn qua email. Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với chúng tôi.</p>
        
        <p>Trân trọng,<br>
        <strong>Đội ngũ hỗ trợ khách hàng</strong></p>
    </div>
    
    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống. Vui lòng không trả lời email này.</p>
        <p>&copy; {{ date('Y') }} Tất cả quyền được bảo lưu.</p>
    </div>
</body>
</html>
@component('mail::message')
# {{ $statusLabel }}

Xin chào {{ $order->name ?? ($order->user->name ?? 'Bạn') }},

Đơn hàng của bạn với mã **{{ $order->order_code }}** hiện đang ở trạng thái:  
**{{ $statusLabel }}**

**Thông tin đơn hàng:**

- Mã đơn: {{ $order->order_code }}
- Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
- Tổng tiền: {{ number_format($order->total_amount, 0, ',', '.') }}₫
- Người nhận: {{ $order->name }}
- Số điện thoại: {{ $order->phone }}
- Địa chỉ: {{ $order->address }}

@component('mail::button', ['url' => route('orders.show', $order->id)])
Xem chi tiết đơn hàng
@endcomponent

Cảm ơn bạn đã mua sắm tại {{ config('app.name') }}!

@endcomponent
