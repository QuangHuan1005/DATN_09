<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'price',
        'sale',
        'image',
        'quantity',
        'status',  // trạng thái: 1 = active, 0 = inactive
    ];

    /**
     * Biến thể thuộc về 1 sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Biến thể có màu sắc
     */
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    /**
     * Biến thể có kích cỡ
     */
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /**
     * Scope: Lấy biến thể đang hoạt động (status = 1)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Accessor: hiển thị trạng thái dạng text
     */
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'Hoạt động' : 'Ngừng bán';
    }
}
