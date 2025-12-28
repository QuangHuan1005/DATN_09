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
        'points_required', // 👈 QUAN TRỌNG
    ];

    /**
     * Trạng thái hiển thị (chuẩn thực tế)
     */
    public function getDisplayStatusAttribute()
    {
        $now = now();

        if ($this->status == 0) {
            return 'stopped'; // Admin tắt
        }

        if ($this->start_date && $now->lt($this->start_date)) {
            return 'upcoming'; // Chưa tới ngày
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return 'expired'; // Hết hạn
        }

        if ($this->quantity <= 0) {
            return 'out_of_stock'; // Hết voucher
        }

        return 'active';
    }

    /**
     * Kiểm tra dùng được hay không
     */
    public function canBeUsed()
    {
        return $this->display_status === 'active';
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'voucher_products',
            'voucher_id',
            'product_id'
        );
    }
}
