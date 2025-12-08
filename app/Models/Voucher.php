<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Kiểm tra voucher còn hạn không
    public function isActive()
    {
        $today = now()->toDateString();
        return $this->status == 1 && $this->start_date <= $today && $this->end_date >= $today;
    }
}
