<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    // ==================== COLOR MANAGEMENT ====================
    
    /**
     * Display a listing of colors.
     */
    public function colorsIndex()
    {
        $colors = Color::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attributes.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new color.
     */
    public function colorsCreate()
    {
        return view('admin.attributes.colors.create');
    }

    /**
     * Store a newly created color in storage.
     */
    public function colorsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'color_code' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/|unique:colors,color_code',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên màu là bắt buộc',
            'name.unique' => 'Tên màu đã tồn tại',
            'color_code.required' => 'Mã màu là bắt buộc',
            'color_code.regex' => 'Mã màu phải có định dạng #RRGGBB (ví dụ: #FF5733)',
            'color_code.unique' => 'Mã màu đã tồn tại',
            'status.required' => 'Trạng thái là bắt buộc',
        ]);

        Color::create($validated);

        return redirect()->route('admin.attributes.colors.index')
            ->with('success', 'Thêm màu sắc thành công!');
    }

    /**
     * Show the form for editing the specified color.
     */
    public function colorsEdit(Color $color)
    {
        return view('admin.attributes.colors.edit', compact('color'));
    }

    /**
     * Update the specified color in storage.
     */
    public function colorsUpdate(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'color_code' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/|unique:colors,color_code,' . $color->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên màu là bắt buộc',
            'name.unique' => 'Tên màu đã tồn tại',
            'color_code.required' => 'Mã màu là bắt buộc',
            'color_code.regex' => 'Mã màu phải có định dạng #RRGGBB (ví dụ: #FF5733)',
            'color_code.unique' => 'Mã màu đã tồn tại',
            'status.required' => 'Trạng thái là bắt buộc',
        ]);

        $color->update($validated);

        return redirect()->route('admin.attributes.colors.index')
            ->with('success', 'Cập nhật màu sắc thành công!');
    }

    /**
     * Remove the specified color from storage.
     */
    public function colorsDestroy(Color $color)
    {
        // Kiểm tra xem màu có được sử dụng trong product variants không
        if ($color->variants()->count() > 0) {
            return redirect()->route('admin.attributes.colors.index')
                ->with('error', 'Không thể xóa màu này vì đang được sử dụng trong ' . $color->variants()->count() . ' biến thể sản phẩm!');
        }

        $color->delete();

        return redirect()->route('admin.attributes.colors.index')
            ->with('success', 'Xóa màu sắc thành công!');
    }

    // ==================== SIZE MANAGEMENT ====================
    
    /**
     * Display a listing of sizes.
     */
    public function sizesIndex()
    {
        $sizes = Size::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attributes.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new size.
     */
    public function sizesCreate()
    {
        return view('admin.attributes.sizes.create');
    }

    /**
     * Store a newly created size in storage.
     */
    public function sizesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
            'size_code' => 'required|string|max:10|unique:sizes,size_code',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên kích thước là bắt buộc',
            'name.unique' => 'Tên kích thước đã tồn tại',
            'size_code.required' => 'Mã kích thước là bắt buộc',
            'size_code.unique' => 'Mã kích thước đã tồn tại',
            'status.required' => 'Trạng thái là bắt buộc',
        ]);

        Size::create($validated);

        return redirect()->route('admin.attributes.sizes.index')
            ->with('success', 'Thêm kích thước thành công!');
    }

    /**
     * Show the form for editing the specified size.
     */
    public function sizesEdit(Size $size)
    {
        return view('admin.attributes.sizes.edit', compact('size'));
    }

    /**
     * Update the specified size in storage.
     */
    public function sizesUpdate(Request $request, Size $size)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
            'size_code' => 'required|string|max:10|unique:sizes,size_code,' . $size->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'Tên kích thước là bắt buộc',
            'name.unique' => 'Tên kích thước đã tồn tại',
            'size_code.required' => 'Mã kích thước là bắt buộc',
            'size_code.unique' => 'Mã kích thước đã tồn tại',
            'status.required' => 'Trạng thái là bắt buộc',
        ]);

        $size->update($validated);

        return redirect()->route('admin.attributes.sizes.index')
            ->with('success', 'Cập nhật kích thước thành công!');
    }

    /**
     * Remove the specified size from storage.
     */
    public function sizesDestroy(Size $size)
    {
        // Kiểm tra xem size có được sử dụng trong product variants không
        if ($size->variants()->count() > 0) {
            return redirect()->route('admin.attributes.sizes.index')
                ->with('error', 'Không thể xóa kích thước này vì đang được sử dụng trong ' . $size->variants()->count() . ' biến thể sản phẩm!');
        }

        $size->delete();

        return redirect()->route('admin.attributes.sizes.index')
            ->with('success', 'Xóa kích thước thành công!');
    }
}

