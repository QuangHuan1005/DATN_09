<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_code',
        'discount_type',
        'quantity',
        'user_limit',
        'discount_value',
        'sale_price',
        'min_order_value',
        'total_used',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    // Thuộc tính ảo để hiển thị trạng thái bằng chữ
    public function getDisplayStatusAttribute()
    {
        $now = now();
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);
        $remaining = $this->quantity - $this->total_used;

        if ($this->status == 0) return 'stopped'; // Dừng
        if ($now->gt($end)) return 'expired';    // Hết hạn
        if ($remaining <= 0) return 'out_of_stock'; // Hết mã
        if ($now->lt($start)) return 'upcoming'; // Sắp chạy
        
        return 'active'; // Hoạt động
    }

    // Kiểm tra nhanh voucher có thực sự sử dụng được không (Dùng trong Controller)
    public function canBeUsed()
    {
        return $this->display_status === 'active';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'voucher_products', 'voucher_id', 'product_id');
    }
}