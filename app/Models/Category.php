<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
       protected $table = 'categories';

    protected $fillable = ['name', 'slug', 'parent_id'];

    // Thêm quan hệ 1-nhiều với Product
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
