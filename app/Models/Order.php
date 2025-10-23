<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id','payment_status_id','order_status_id','voucher_id','order_code',
        'name','address','phone','subtotal','discount','total_amount','note'
    ];

    public function user()          { return $this->belongsTo(User::class); }
    public function status()        { return $this->belongsTo(OrderStatus::class, 'order_status_id'); }
    public function paymentStatus() { return $this->belongsTo(PaymentStatus::class, 'payment_status_id'); }
    public function voucher()       { return $this->belongsTo(Voucher::class, 'voucher_id'); }

    public function details()       { return $this->hasMany(OrderDetail::class, 'order_id'); }
    public function payments()      { return $this->hasMany(Payment::class, 'order_id'); }
    public function notifs()        { return $this->hasMany(Notification::class, 'order_id'); }
}
