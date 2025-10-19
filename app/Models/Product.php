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

    public function photoAlbums()
    {
        return $this->hasMany(ProductPhotoAlbum::class, 'product_id');
    }

    public function firstPhoto()
    {
        return $this->hasOne(ProductPhotoAlbum::class, 'product_id')->oldest();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault();
    }
}
