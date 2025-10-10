<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id','role_id','product_code','name','image','description','view','material','onpage'
    ];

    // Quan hệ: mỗi sản phẩm thuộc về 1 danh mục
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    // Quan hệ khác dùng ở HomeController
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    use HasFactory;


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
  
}
