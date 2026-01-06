<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <h1>Cảm ơn bạn đã đặt hàng, {{ $order->name }}!</h1>
    <p>Mã đơn hàng: <strong>{{ $order->order_code }}</strong></p>
    <p>Tổng tiền: {{ number_format($order->total_amount) }} VNĐ</p>
    
    <h3>Chi tiết đơn hàng:</h3>
    <ul>
        @foreach($order->details as $detail)
            <li>
                {{ $detail->productVariant->product->name ?? 'Sản phẩm' }} 
                (x{{ $detail->quantity }}) - 
                {{ number_format($detail->price) }} VNĐ
            </li>
        @endforeach
    </ul>
    
    <p>Chúng tôi sẽ sớm liên hệ để giao hàng.</p>
</body>
</html>