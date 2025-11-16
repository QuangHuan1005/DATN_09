<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'order_status_id',
        'actor_type',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function getActorLabelAttribute()
    {
        return $this->actor_type === 'user' ? 'Người dùng' : 'Hệ thống';
    }
}
