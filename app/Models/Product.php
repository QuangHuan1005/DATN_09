<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tên bảng trong CSDL
    protected $table = 'products';

    // Các cột có thể gán dữ liệu hàng loạt
    protected $fillable = [
        'category_id',
        'role_id',
        'product_code',
        'name',
        'image',
        'description',
        'material',
        'onpage'
    ];

    /**
     * Liên kết 1-nhiều: Product có nhiều biến thể (ProductVariant)
     */
    public function variants()
    {
        return $this->hasMany(\App\Models\ProductVariant::class, 'product_id');
    }

    /**
     * Liên kết 1-nhiều: Product có nhiều ảnh chi tiết (ProductPhotoAlbum)
     */
    public function photoAlbums()
    {
        return $this->hasMany(\App\Models\ProductPhotoAlbum::class, 'product_id');
    }

    /**
     * Liên kết 1-nhiều: Product có nhiều đánh giá (Review)
     */
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'product_id');
    }

    /**
     * Liên kết n-1: Product thuộc về một Category
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}
