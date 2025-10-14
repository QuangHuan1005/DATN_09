<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withTrashed()
            ->whereNull('parent_id')
            ->orderBy('id', 'asc');

        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $categories = $query->paginate(3);

        return view('admin.categories.index', compact('categories'))->with('keyword', $request->keyword);
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'parent_id'   => $request->parent_id ?: null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '<>', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'parent_id'   => $request->parent_id ?: null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function show(Category $category)
    {
        $children = Category::where('parent_id', $category->id)->get();
        return view('admin.categories.show', compact('category', 'children'));
    }

    public function destroy(Category $category)
    {
        if (method_exists($category, 'products') && $category->products()->count() > 0) {
            return back()->with('error', 'Danh mục này còn sản phẩm, không thể xóa!');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa mềm danh mục');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')->with('success', 'Khôi phục danh mục thành công');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if (method_exists($category, 'products') && $category->products()->count() > 0) {
            return back()->with('error', 'Danh mục còn sản phẩm, không thể xóa vĩnh viễn!');
        }

        $category->forceDelete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa vĩnh viễn danh mục thành công');
    }
}
