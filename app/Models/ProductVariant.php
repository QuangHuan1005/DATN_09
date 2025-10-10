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
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    // Scope: lấy biến thể đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Accessor: hiển thị trạng thái
    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Hoạt động' : 'Ngừng bán';
    }
}
