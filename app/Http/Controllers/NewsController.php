<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
        $news = News::with(['author', 'category'])
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        $sidebarData = $this->getSidebarData();
        return view('blog.index', array_merge(compact('news'), $sidebarData));
    }

    /**
     * @return array
     */
    protected function getSidebarData()
    {
        $categories = NewsCategory::withCount('news')
            ->having('news_count', '>', 0)
            ->orderBy('name', 'asc')
            ->get();

        $recentPosts = News::where('status', 'published')
            ->latest()
            ->take(4)
            ->get();
            
        $allPosts = News::where('status', 'published')->get(['seo_keywords']);
        $keywordCounts = [];
        
        foreach ($allPosts as $post) {
            if ($post->seo_keywords) {
                $keywords = array_map('trim', explode(',', $post->seo_keywords));
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    if (!empty($keyword)) {
                        $keyword = Str::slug($keyword, ' ');
                        $keywordCounts[$keyword] = ($keywordCounts[$keyword] ?? 0) + 1;
                    }
                }
            }
        }

        arsort($keywordCounts);
        $topKeywords = array_slice($keywordCounts, 0, 15, true);
        ksort($topKeywords);
        
        $minCount = min($topKeywords) ?: 1;
        $maxCount = max($topKeywords) ?: 1;

        return [
            'categories' => $categories,
            'recentPosts' => $recentPosts,
            'topKeywords' => $topKeywords,
            'minCount' => $minCount,
            'maxCount' => $maxCount,
        ];
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
public function show($slug)
{
    $item = News::with(['author', 'category'])
                ->where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();

    $sidebarData = $this->getSidebarData();
    
    // TRUYỀN DỮ LIỆU SANG VIEW VỚI TÊN LÀ 'post' (hoặc 'newsItem')
    return view('blog.show', array_merge(['post' => $item], $sidebarData));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
