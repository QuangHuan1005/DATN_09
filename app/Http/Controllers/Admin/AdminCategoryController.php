<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminCategoryController extends Controller
{
    /**
     * Hiển thị danh sách danh mục cha (có phân trang, tìm kiếm).
     */
    public function index(Request $request)
    {
        $query = Category::withTrashed()
            ->with('parent')
            ->orderBy('id', 'desc');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        $categories = $query->paginate(5);

        return view('admin.categories.index', compact('categories'), [
            'pageTitle' => 'Danh sách danh mục'
        ])
            ->with('keyword', $request->keyword);
    }

    /**
     * Hiển thị form tạo danh mục mới.
     */
    public function create()
    {
        // Lấy danh mục cha (danh mục gốc) để chọn parent
        $categories = Category::whereNull('parent_id')->get();

        return view('admin.categories.create', compact('categories'),
            ['pageTitle' => 'Thêm mới danh mục']);
    }

    /**
     * Xử lý lưu danh mục mới vào database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'slug.unique' => 'Slug đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id ?: null,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '<>', $category->id)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Cập nhật danh mục.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'slug.unique' => 'Slug đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id ?: null,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Hiển thị chi tiết danh mục cùng các danh mục con.
     */
    public function show(Category $category)
    {
        $children = Category::where('parent_id', $category->id)->get();

        return view('admin.categories.show', compact('category', 'children'));
    }

    /**
     * Xóa mềm danh mục (soft delete).
     */
    public function destroy(Category $category)
    {
        if (method_exists($category, 'products') && $category->products()->count() > 0) {
            return back()->with('error', 'Danh mục này còn sản phẩm, không thể xóa!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Đã xóa mềm danh mục');
    }

    /**
     * Khôi phục danh mục đã xóa mềm.
     */
    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Khôi phục danh mục thành công');
    }

    /**
     * Xóa vĩnh viễn danh mục.
     */
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);

        if (method_exists($category, 'products') && $category->products()->count() > 0) {
            return back()->with('error', 'Danh mục còn sản phẩm, không thể xóa vĩnh viễn!');
        }

        $category->forceDelete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa vĩnh viễn danh mục thành công');
    }
}
