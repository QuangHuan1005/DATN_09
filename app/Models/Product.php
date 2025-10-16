<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;


    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'products';

    // Các cột có thể gán giá trị hàng loạt
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
    protected $dates = ['deleted_at'];  

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    /**
     * Mối quan hệ 1-nhiều: Product có nhiều ảnh chi tiết (ProductPhotoAlbum)
     */
    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class, 'product_id');
    }

    /**
     * Mối quan hệ 1-nhiều: Product có nhiều đánh giá (Review)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    /**
     * Mối quan hệ n-1: Product thuộc về một Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }
}
