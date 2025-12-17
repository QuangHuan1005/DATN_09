<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturnStatusLog extends Model
{
    use HasFactory;

    protected $table = 'order_return_status_logs';

    protected $fillable = [
        'order_return_id',
        'status',
        'actor_type',
        'actor_id',
    ];

    // Relationships
    public function orderReturn()
    {
        return $this->belongsTo(OrderReturn::class, 'order_return_id');
    }

    // Accessor để hiển thị tên người thực hiện
    public function getActorLabelAttribute(): string
    {
        if ($this->actor_type === 'admin') {
            return 'Quản trị viên';
        } elseif ($this->actor_type === 'user') {
            return 'Người dùng';
        }
        return 'Hệ thống';
    }
}