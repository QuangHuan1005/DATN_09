<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\OrderDetail;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'role_id',
        'product_code',
        'name',
        'image',
        'description',
        'view',
        'material',
        'onpage',
    ];

    /**
     * Mỗi sản phẩm thuộc về một danh mục
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    /**
     * Mỗi sản phẩm có nhiều biến thể
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    /**
     * Mỗi sản phẩm có nhiều ảnh trong album
     */
    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class, 'product_id');
    }

    /**
     * Mỗi sản phẩm có nhiều đánh giá
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Mối quan hệ với chi tiết đơn hàng
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }
}
