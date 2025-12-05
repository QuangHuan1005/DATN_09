<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'status',
        'published_at',
        'views',
        'reading_time',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',   
        'updated_at' => 'datetime',  
    ];

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\NewsCategory::class, 'category_id');
    }
}
