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

    // App\Models\Product.php

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

// Ảnh đại diện (1 ảnh duy nhất cho card sản phẩm)
public function firstPhoto()
{
    return $this->hasOne(ProductPhotoAlbum::class)
                ->orderBy('id', 'asc'); // hoặc where('is_main', 1)
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

}
