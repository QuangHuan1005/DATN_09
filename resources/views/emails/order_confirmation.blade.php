<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        /* Reset CSS cơ bản cho Email */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .order-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #eee;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }

        .table-custom th {
            background-color: #eee;
            padding: 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        .table-custom td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            margin-top: 20px;
            border-top: 2px solid #eee;
            padding-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .grand-total {
            font-weight: bold;
            color: #d32f2f;
            font-size: 18px;
        }

        .footer {
            background-color: #333;
            color: #aaa;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            background: #e0f2f1;
            color: #00695c;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="header">
            <h1>XÁC NHẬN ĐƠN HÀNG</h1>
            <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
        </div>

        <div class="content">
            <p>Xin chào <strong>{{ $order->name }}</strong>,</p>
            <p>Đơn hàng của bạn đã được tiếp nhận và đang trong quá trình xử lý. Dưới đây là thông tin chi tiết:</p>

            <div class="order-info">
                <h3 style="margin-top: 0; border-bottom: 1px solid #ddd; padding-bottom: 5px;">Thông tin giao hàng</h3>
                <p><strong>Mã đơn hàng:</strong> <span class="badge">{{ $order->order_code }}</span></p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Người nhận:</strong> {{ $order->name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Phương thức thanh toán:</strong>
                    @if ($order->payment_method_id == 1)
                        Tiền mặt (COD)
                    @else
                        VNPay
                    @endif
                </p>
                @if ($order->note)
                    <p><strong>Ghi chú:</strong> <i>{{ $order->note }}</i></p>
                @endif
            </div>

            <h3>Chi tiết sản phẩm</h3>
            <table class="table-custom">
                <thead>
                    <tr>
                        <th width="45%">Sản phẩm</th>
                        <th width="15%" class="text-center">SL</th>
                        <th width="20%" class="text-right">Đơn giá</th>
                        <th width="20%" class="text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        @php
                            // Lấy biến thể sản phẩm để hiển thị size/màu (nếu có)
                            $variant = $detail->productVariant;
                            $product = $variant->product;
                            $itemName = $product->name ?? 'Sản phẩm';
                            $attributes = [];
                            if ($variant->color) {
                                $attributes[] = 'Màu: ' . $variant->color->name;
                            }
                            if ($variant->size) {
                                $attributes[] = 'Size: ' . $variant->size->size_code;
                            }
                            $attrString = implode(' - ', $attributes);
                        @endphp
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center;">
                                    {{-- Nếu bạn muốn hiện ảnh, cần đảm bảo link ảnh là tuyệt đối (http://...) --}}
                                    {{-- <img src="{{ asset('storage/' . $product->image) }}" class="product-img" style="margin-right: 10px;"> --}}
                                    <div>
                                        <strong>{{ $itemName }}</strong>
                                        @if ($attrString)
                                            <br><small style="color: #666;">{{ $attrString }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ $detail->quantity }}</td>
                            <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td class="text-right">
                                <strong>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</strong>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-row">
                    <span>Tạm tính:</span>
                    <span>{{ number_format($order->subtotal, 0, ',', '.') }} đ</span>
                </div>
                @if ($order->discount > 0)
                    <div class="total-row" style="color: green;">
                        <span>Giảm giá (Voucher):</span>
                        <span>- {{ number_format($order->discount, 0, ',', '.') }} đ</span>
                    </div>
                @endif
                <div class="total-row">
                    <span>Phí vận chuyển:</span>
                    <span>{{ number_format($order->shipping_fee, 0, ',', '.') }} đ</span>
                </div>
                <div class="total-row" style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px;">
                    <span class="grand-total">TỔNG THANH TOÁN:</span>
                    <span class="grand-total">{{ number_format($order->total_amount, 0, ',', '.') }} đ</span>
                </div>
            </div>

           <div style="text-align: center; margin-top: 30px;">
    <a href="{{ route('orders.show', $order->id) }}"
       style="background-color: #004d40; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Xem chi tiết đơn hàng
    </a>
</div>
        </div>

        <div class="footer">
            <p>Mọi thắc mắc xin vui lòng liên hệ hotline: 1900 xxxx</p>
            <p>&copy; {{ date('Y') }} Friday Shop. All rights reserved.</p>
        </div>
    </div>

</body>

</html>
