<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Gửi $categories cho tất cả view chứa header.blade.php
        View::composer('layouts.header', function ($view) {
            $view->with('categories', Category::all());
        });
    }
}
