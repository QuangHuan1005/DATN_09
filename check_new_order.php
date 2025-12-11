<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$order = \App\Models\Order::where('order_code', 'ORD_6791987441400_82C422_1')->first();

if ($order) {
    echo "Order ID: {$order->id}\n";
    echo "Order Code: {$order->order_code}\n";
    echo "Order Status ID: {$order->order_status_id}\n";
    echo "Payment Status ID: {$order->payment_status_id}\n";
    echo "Payment Status Name: " . ($order->paymentStatus ? $order->paymentStatus->name : 'null') . "\n";

    // Kiểm tra payment record
    $payment = $order->payment;
    if ($payment) {
        echo "Payment Record Found:\n";
        echo "  Payment ID: {$payment->id}\n";
        echo "  Payment Method ID: {$payment->payment_method_id}\n";
        echo "  Payment Method Name: " . ($payment->paymentMethod ? $payment->paymentMethod->name : 'null') . "\n";
        echo "  Payment Status: {$payment->status}\n";
        echo "  Payment Code: {$payment->payment_code}\n";
    } else {
        echo "No Payment Record Found!\n";

        // Tìm xem có thể tạo payment record không
        // Giả sử là COD nếu không có payment record
        echo "Creating payment record for COD...\n";
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => 1, // COD
            'payment_code' => 'COD_' . $order->order_code,
            'payment_amount' => $order->total_amount,
            'status' => 0, // Pending
        ]);
        echo "Payment record created!\n";
    }
} else {
    echo "Order not found\n";
}
