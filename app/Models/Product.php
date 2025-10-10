<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Nếu bảng là "products" thì không cần $table. Giữ cho rõ ràng:
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
    }
}
