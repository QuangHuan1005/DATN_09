<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = ['order_id','product_variant_id','price','quantity','status','estimated_delivery'];

    public function order()   { return $this->belongsTo(Order::class, 'order_id'); }
    public function variant() { return $this->belongsTo(ProductVariant::class, 'product_variant_id'); }
}
