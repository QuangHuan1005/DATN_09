<!DOCTYPE html>
<html>
<head>
    <title>Cập nhật trạng thái đơn hàng</title>
</head>
<body>
    <h1>Xin chào {{ $order->name }},</h1>
    
    @if($messageType == 'cancel')
        <p style="color: red;">Đơn hàng <strong>{{ $order->order_code }}</strong> của bạn đã bị HỦY.</p>
    @elseif($messageType == 'return')
        <p style="color: orange;">Đơn hàng <strong>{{ $order->order_code }}</strong> đang được xử lý HOÀN TRẢ.</p>
    @else
        <p>Trạng thái đơn hàng <strong>{{ $order->order_code }}</strong> đã được cập nhật thành: 
            <strong style="color: blue;">{{ $statusName }}</strong>
        </p>
    @endif

    <p>Vui lòng kiểm tra lại thông tin trên website.</p>
</body>
</html>