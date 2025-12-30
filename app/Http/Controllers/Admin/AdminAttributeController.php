<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    // ==================== COLOR MANAGEMENT (QUẢN LÝ MÀU SẮC) ====================
    
    /**
     * Danh sách màu sắc.
     */
    public function colorsIndex()
    {
        $colors = Color::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attributes.colors.index', compact('colors'));
    }

    /**
     * Form thêm mới màu sắc.
     */
    public function colorsCreate()
    {
        return view('admin.attributes.colors.create');
    }

    /**
     * Lưu màu sắc mới vào Database.
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
     * Form chỉnh sửa màu sắc.
     */
    public function colorsEdit(Color $color)
    {
        return view('admin.attributes.colors.edit', compact('color'));
    }

    /**
     * Cập nhật màu sắc.
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
     * Xóa màu sắc (có kiểm tra ràng buộc biến thể).
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

    // ==================== SIZE MANAGEMENT (QUẢN LÝ KÍCH THƯỚC) ====================
    
    /**
     * Danh sách kích thước.
     */
    public function sizesIndex()
    {
        $sizes = Size::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.attributes.sizes.index', compact('sizes'));
    }

    /**
     * Form thêm mới kích thước.
     */
    public function sizesCreate()
    {
        return view('admin.attributes.sizes.create');
    }

    /**
     * Lưu kích thước mới.
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
     * Form chỉnh sửa kích thước.
     */
    public function sizesEdit(Size $size)
    {
        return view('admin.attributes.sizes.edit', compact('size'));
    }

    /**
     * Cập nhật kích thước.
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
     * Xóa kích thước (có kiểm tra ràng buộc biến thể).
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