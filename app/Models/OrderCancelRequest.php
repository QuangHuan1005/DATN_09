<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancelRequest extends Model
{
    use HasFactory;

    protected $table = 'order_cancel_requests';

    protected $fillable = [
        'order_id',
        'user_id',
        'cancel_by',      // customer | admin
        'reason_user',    
        'reason_admin',   
        'refund_image',
        'status_id',      // Link tới bảng order_cancel_statuses
        'status',         // Lưu slug: pending, accepted, rejected, refunded
        'bank_name',       
        'account_number',  
        'account_holder',
    ];

    // ============================
    // 🔗 Quan hệ (Relationships)
    // ============================

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cancelStatus()
    {
        return $this->belongsTo(OrderCancelStatus::class, 'status_id');
    }

    // ============================
    // 🔥 Accessors & Scopes
    // ============================

    /**
     * Hiển thị nhãn người hủy đơn
     */
    public function getCanceledByLabelAttribute()
    {
        // Sử dụng $this->cancel_by để khớp chính xác với cột trong DB
        return match ($this->cancel_by) { 
            'customer', 'user' => 'Khách hàng', // Thêm case 'user' nếu DB lưu là user
            'admin'            => 'Quản trị viên',
            default            => 'Không xác định',
        };
    }

    /**
     * Kiểm tra xem yêu cầu đã được hoàn tiền chưa
     */
    public function isRefunded()
    {
        return $this->status === 'refunded' || $this->status_id == 4;
    }
}