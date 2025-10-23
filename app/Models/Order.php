<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id','payment_status_id','order_status_id','voucher_id',
        'order_code','name','address','phone','subtotal','discount',
        'total_amount','note'
    ];

    public function user()           { return $this->belongsTo(User::class); }
    public function status()         { return $this->belongsTo(OrderStatus::class, 'order_status_id'); }
    public function paymentStatus()  { return $this->belongsTo(PaymentStatus::class, 'payment_status_id'); }
    public function voucher()        { return $this->belongsTo(Voucher::class, 'voucher_id'); }
    public function details()        { return $this->hasMany(OrderDetail::class, 'order_id'); }
    public function payment()        { return $this->hasOne(Payment::class, 'order_id'); }
    public function invoice()        { return $this->hasOne(Invoice::class, 'order_id'); }

    // Quy tắc HỦY: chỉ khi status ∈ {1:Chờ xác nhận, 2:Xác nhận} & chưa hoàn tiền
    public function getCancelableAttribute(): bool
    {
        return in_array($this->order_status_id, [1,2]) && $this->payment_status_id !== 3;
    }
}

