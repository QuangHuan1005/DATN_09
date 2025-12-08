<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Thêm trait SoftDeletes

class Category extends Model
{
    use HasFactory, SoftDeletes; // Kích hoạt SoftDeletes

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
    ];

    /**
     * Mối quan hệ 1-nhiều với Product
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
