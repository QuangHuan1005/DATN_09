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
        'sale_price',
        'image',
        'quantity',
        'status',  // trạng thái: active, inactive
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

        public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
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

    /**
     * Lấy tên biến thể (Màu sắc - Kích cỡ)
     */
    public function getVariantName()
    {
        $parts = [];

        if ($this->color) {
            $parts[] = $this->color->name;
        }

        if ($this->size) {
            $parts[] = $this->size->name;
        }

        return implode(' - ', $parts) ?: 'Mặc định';
    }
}
