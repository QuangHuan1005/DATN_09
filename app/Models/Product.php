<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'product_code',
        'name',
        'description',
        'view',
        'material',
        'onpage',

    ];

    protected $dates = ['deleted_at'];

    // App\Models\Product.php

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

<<<<<<< HEAD
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
=======
public function variants()
{
    return $this->hasMany(ProductVariant::class, 'product_id');
}
>>>>>>> 067d11aa1ee70cf6b384050e89f5b2daf2e504e8

    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class);
    }

    // Ảnh đại diện (1 ảnh duy nhất cho card sản phẩm)
    public function firstPhoto()
    {
        return $this->hasOne(ProductPhotoAlbum::class)
            ->orderBy('id', 'asc'); // hoặc where('is_main', 1)
    }
    // Trong Product model
    public function orderDetails()
    {
        return $this->hasManyThrough(
            OrderDetail::class,
            ProductVariant::class,
            'product_id',      // khóa ngoại trên product_variants
            'product_variant_id', // khóa ngoại trên order_details
            'id',              // khóa chính trên products
            'id'               // khóa chính trên product_variants
        );
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
