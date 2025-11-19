<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;

    protected $table = 'news_categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
    ];
    public function news()
    {
        return $this->hasMany(\App\Models\News::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(NewsCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(NewsCategory::class, 'parent_id');
    }
    
}
