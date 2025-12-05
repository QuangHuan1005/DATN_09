<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    protected $fillable = ['name'];

    /**
     * =====================
     * 🔗 Quan hệ (Relationships)
     * =====================
     */

    // Mỗi trạng thái có thể có nhiều đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_status_id');
    }

    /**
     * =====================
     * 🧠 Accessors & Logic
     * =====================
     */

    // Màu hiển thị cho trạng thái (dùng trong giao diện admin)
    public function getColorAttribute(): string
    {
        return match ($this->id) {
            1 => 'secondary',   // Chờ xác nhận
            2 => 'info',        // Xác nhận
            3 => 'warning',     // Đang giao hàng
            4 => 'primary',     // Đã giao hàng
            5 => 'success',     // Hoàn thành
            6 => 'danger',      // Hủy
            7 => 'dark',        // Hoàn hàng
            default => 'light',
        };
    }

    // Kiểm tra xem có phải là trạng thái đã hoàn tất hay không
    public function getIsFinalAttribute(): bool
    {
        return in_array($this->id, [5, 6, 7]);
    }

    // Kiểm tra xem có phải là trạng thái đang xử lý không
    public function getIsProcessingAttribute(): bool
    {
        return in_array($this->id, [1, 2, 3, 4]);
    }

    /**
     * =====================
     * 🔍 Scope - Truy vấn nhanh
     * =====================
     */

    // Lọc các trạng thái đang xử lý
    public function scopeProcessing($query)
    {
        return $query->whereIn('id', [1, 2, 3, 4]);
    }

    // Lọc các trạng thái đã kết thúc
    public function scopeFinal($query)
    {
        return $query->whereIn('id', [5, 6, 7]);
    }
}
