<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái đơn hàng</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 20px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { padding: 20px; text-align: center; color: #fff; }
        .content { padding: 20px; text-align: center; }
        .btn { display: inline-block; padding: 10px 20px; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 15px; font-weight: bold; }
        .details-box { background: #fafafa; border: 1px dashed #ccc; padding: 15px; margin-top: 20px; text-align: left; border-radius: 5px; }
        .footer { background: #333; color: #aaa; text-align: center; padding: 10px; font-size: 12px; }

        /* Dynamic colors based on status */
        .bg-success { background-color: #28a745; } /* Màu xanh lá: Giao thành công */
        .bg-danger { background-color: #dc3545; }  /* Màu đỏ: Hủy */
        .bg-warning { background-color: #ffc107; color: #333 !important; } /* Màu vàng: Đang giao/Hoàn trả */
        .bg-primary { background-color: #007bff; } /* Màu xanh dương: Mặc định */
    </style>
</head>
<body>

    @php
        $headerColor = 'bg-primary';
        $statusIcon = '📦'; // Icon mặc định
        
        if($messageType == '6') {
            $headerColor = 'bg-danger';
            $statusIcon = '🚫';
        } elseif($messageType == '7') {
            $headerColor = 'bg-warning';
            $statusIcon = '';
        } elseif(str_contains(strtolower($statusName), 'thành công') || str_contains(strtolower($statusName), 'hoàn thành')) {
            $headerColor = 'bg-success';
            $statusIcon = '✅';
        }
    @endphp

    <div class="email-container">
        <div class="header {{ $headerColor }}">
            <h1 style="margin:0;">{{ $statusIcon }} CẬP NHẬT ĐƠN HÀNG</h1>
        </div>

        <div class="content">
            <p>Xin chào <strong>{{ $order->name }}</strong>,</p>
            
            <p>Đơn hàng <strong>{{ $order->order_code }}</strong> của bạn vừa được cập nhật trạng thái:</p>
            
            <h2 style="text-transform: uppercase; color: #333;">{{ $statusName }}</h2>

            @if($messageType == '6')
                <p style="color: #dc3545;">Chúng tôi rất tiếc vì đơn hàng đã bị hủy. Nếu có nhầm lẫn, vui lòng liên hệ ngay với chúng tôi.</p>
            @elseif($messageType == '7')
                <p>Yêu cầu hoàn trả của bạn đang được xử lý.</p>
            @else
                <p>Vui lòng chú ý điện thoại để nhận hàng nhé!</p>
            @endif

            <div class="details-box">
                <p style="margin-top: 0;"><strong>Tóm tắt đơn hàng:</strong></p>
                <ul style="padding-left: 20px; margin-bottom: 0;">
                    @foreach($order->details->take(3) as $detail)
                        <li>
                            {{ $detail->productVariant->product->name ?? 'Sản phẩm' }} 
                            (x{{ $detail->quantity }})
                        </li>
                    @endforeach
                    @if($order->details->count() > 3)
                        <li>... và {{ $order->details->count() - 3 }} sản phẩm khác.</li>
                    @endif
                </ul>
                <p style="margin-top: 10px; border-top: 1px solid #ddd; padding-top: 10px;">
                    <strong>Tổng tiền: {{ number_format($order->total_amount, 0, ',', '.') }} đ</strong>
                </p>
            </div>

            <a href="#" class="btn {{ $headerColor }}">Kiểm tra đơn hàng</a>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Friday Shop. Cần hỗ trợ? Reply email này.</p>
        </div>
    </div>

</body>
</html>