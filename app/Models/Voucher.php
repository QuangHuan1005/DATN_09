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
        'points_required',
    ];

    /**
     * Ép kiểu dữ liệu (QUAN TRỌNG)
     * Giúp start_date và end_date luôn là đối tượng Carbon để so sánh chính xác
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'status'     => 'integer',
        'quantity'   => 'integer',
        'total_used' => 'integer',
    ];

    /**
     * Trạng thái hiển thị thông minh (Sửa lỗi Logic thời gian)
     */
    public function getDisplayStatusAttribute()
    {
        $now = now();

        // 1. Kiểm tra Admin có chủ động tắt hay không
        if ($this->status === 0) {
            return 'disabled'; // Tạm dừng
        }

        // 2. Kiểm tra thời gian bắt đầu (Sắp diễn ra)
        if ($this->start_date && $now->lt($this->start_date)) {
            return 'upcoming';
        }

        // 3. Kiểm tra thời gian kết thúc (Hết hạn)
        if ($this->end_date && $now->gt($this->end_date)) {
            return 'expired';
        }

        // 4. Kiểm tra số lượng còn lại (Hết mã)
        if (($this->quantity - $this->total_used) <= 0) {
            return 'out_of_stock';
        }

        return 'active'; // Đang hoạt động
    }

    /**
     * Helper kiểm tra khả dụng để áp dụng vào giỏ hàng
     */
    public function canBeUsed()
    {
        return $this->display_status === 'active';
    }

    /**
     * Quan hệ với sản phẩm
     */
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