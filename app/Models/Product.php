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
        'role_id',
        'product_code',
        'name',
        'image',
        'quantity',
        'description',
        'view',
        'material',
        'onpage',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class);
    }

    // Ảnh đại diện
    public function firstPhoto()
    {
        return $this->hasOne(ProductPhotoAlbum::class)
                    ->orderBy('id', 'asc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 🔥 Sản phẩm thuộc nhiều voucher
    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_products', 'product_id', 'voucher_id');
    }
    
}
