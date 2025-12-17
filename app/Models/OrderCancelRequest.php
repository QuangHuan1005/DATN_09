<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCancelRequest extends Model
{
    use HasFactory;

    // Tên bảng (Nếu tên bảng không phải là số nhiều của tên Model, bạn cần định nghĩa nó)
    // Tên bảng của bạn là order_cancel_requests nên đây là tùy chọn, nhưng nên đặt
    protected $table = 'order_cancel_requests'; 

    // Các trường được phép lưu dữ liệu qua phương thức create()
    protected $fillable = [
        'order_id',
        'user_id',
        'reason_user',
        'reason_admin',
        'refund_images',
        'status',
    ];
    
    // =======================================================
    // 🔗 CÁC QUAN HỆ (RELATIONSHIPS)
    // =======================================================

    // Quan hệ với đơn hàng (Order)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Quan hệ với người dùng (User)
    public function user()
    {
        // Giả định Model User nằm trong App\Models\User
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function status()
{
    return $this->belongsTo(OrderCancelStatus::class, 'status_id');
}
}