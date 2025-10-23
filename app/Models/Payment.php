<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = ['order_id','payment_method_id','payment_code','payment_amount','status'];

    public function order()  { return $this->belongsTo(Order::class, 'order_id'); }
    public function method() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
}
