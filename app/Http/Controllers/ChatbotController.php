public function vnpayReturn(Request $request)
    {
        // 1. Kiểm tra dữ liệu trả về từ VNPay
        if ($request->vnp_ResponseCode == "00") {
            // --- THANH TOÁN THÀNH CÔNG ---

            // Tìm đơn hàng theo mã (vnp_TxnRef thường là order_code)
            $orderCode = $request->vnp_TxnRef;
            $order = Order::where('order_code', $orderCode)->first();

            if ($order) {
                // Cập nhật trạng thái đơn hàng -> Đã thanh toán
                // Giả sử payment_status_id = 2 là "Đã thanh toán"
                $order->update(['payment_status_id' => 2]); 

                // === GỬI MAIL XÁC NHẬN TẠI ĐÂY ===
                $user = $order->user; // Hoặc lấy email từ Auth::user() nếu user đang login
                $emailToSend = $user ? $user->email : null; // Cần xử lý trường hợp khách vãng lai nếu có

                if ($emailToSend) {
                    Mail::to($emailToSend)->send(new OrderConfirmationMail($order));
                }
            }

            return redirect()->route('checkout.success')->with('success', 'Thanh toán VNPay thành công! Đã gửi email xác nhận.');
        } else {
            // --- THANH TOÁN THẤT BẠI ---
            
            // Có thể bạn muốn xóa đơn hàng tạm hoặc cập nhật trạng thái "Hủy/Thất bại"
            $orderCode = $request->vnp_TxnRef;
            Order::where('order_code', $orderCode)->update(['payment_status_id' => 3]); // Ví dụ 3 là thất bại

            return redirect()->route('checkout.index')->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy.');
        }
    }