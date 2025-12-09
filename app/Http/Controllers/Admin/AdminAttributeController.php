<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAttributeController extends Controller
{
    public function index()
    {
        $attributes = [
            'colors' => Color::orderBy('created_at', 'desc')->get(),
            'sizes' => Size::orderBy('created_at', 'desc')->get(),
        ];
        return view(
            'admin.attributes.index',
            compact('attributes'),
            ['pageTitle' => 'Danh sách thuộc tính sản phẩm']
        );
    }
    public function create($type)
    {
        if (!in_array($type, ['colors', 'sizes'])) {
            abort(404);
        }

        return view('admin.attributes.create', compact('type'));
    }


    public function store(Request $request, $type)
    {
        if ($type == 'colors') {

            $validated = $request->validate(
                [
                    'name'                  => 'unique:colors,name|required|string|max:255',
                    'color_code'            => 'unique:colors,color_code|required|string|max:20',
                    'description'           => 'nullable|string',
                ],
                [
                    'name.unique'           => 'Tên màu sắc đã tồn tại.',
                    'name.required'         => 'Vui lòng nhập màu sắc.',
                    'name.string'           => 'Tên màu sắc phải là chuỗi ký tự.',
                    'name.max'              => 'Tên màu sắc không được vượt quá 255 ký tự.',

                    'color_code.unique'     => 'Mã màu sắc đã tồn tại.',
                    'color_code.required'   => 'Vui lòng nhập màu sắc.',
                    'description.string'    => 'Mô tả màu sắc phải là chuỗi ký tự.',

                ]
            );

            Color::create([
                'name'        => $validated['name'],
                'color_code' => $validated['color_code'],
                'description' => $validated['description'] ?? null,
            ]);

            return redirect()
                ->route('admin.attributes.show', 'colors')
                ->with('success', 'Thêm màu thành công');
        }

        if ($type == 'sizes') {
            $request->validate([
                'name'                  => 'required|string|max:255|unique:sizes,name',
                'size_code'             => 'required|string|max:20|unique:sizes,size_code',
                'description'           => 'nullable|string',
            ], [
                'name.unique'           => 'Tên kich thước đã tồn tại.',
                'name.required'         => 'Vui lòng nhập kích thước.',
                'name.string'           => 'Tên kích thước phải là chuỗi ký tự.',
                'name.max'              => 'Tên kích thước không được vượt quá 255 ký tự.',

                'size_code.unique'     => 'Mã kích thước đã tồn tại.',
                'size_code.required'   => 'Vui lòng nhập kích thước.',

                'description.string'    => 'Mô tả kích thước phải là chuỗi ký tự.',

            ]);

            Size::create([
                'name'        => $request->name,
                'size_code' => $request->size_code,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.attributes.show', 'sizes')
                ->with('success', 'Thêm size thành công');
        }

        abort(404);
    }

    // Danh sách biến thể của 1 sản phẩm cụ thể
    public function show($type)
    {
        if ($type === 'colors') {
            $items = Color::orderBy('created_at', 'desc')->paginate(5);
            $title = 'Quản lý Màu sắc';
        } elseif ($type === 'sizes') {
            $items = Size::orderBy('created_at', 'desc')->paginate(5);
            $title = 'Quản lý Size';
        } else {
            abort(404);
        }
        return view('admin.attributes.show', compact('items', 'type', 'title'), ['pageTitle' => 'Chi tiết thuộc tính']);
    }
    public function edit($id)
    {
        $attributes = [
            'colors' => Color::orderBy('created_at', 'desc')->get(),
            'sizes' => Size::orderBy('created_at', 'desc')->get(),
        ];
        return view('admin.attributes.edit', compact('attributes'), ['pageTitle' => 'Chỉnh sửa thuộc tính']);
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($type, $id)
    {
        if ($type == 'colors') {
            Color::findOrFail($id)->delete();
            return back()->with('success', 'Đã xóa màu thành công');
        }

        if ($type == 'sizes') {
            Size::findOrFail($id)->delete();
            return back()->with('success', 'Đã xóa size thành công');
        }

        abort(404);
    }
}
