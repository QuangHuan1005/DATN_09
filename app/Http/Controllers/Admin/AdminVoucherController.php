<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $products = Product::orderBy('name')->get();
    return view('admin.vouchers.create', compact('products'));
}


    /**
     * Store a newly created resource in storage.
     */ public function store(Request $request)
{
    $request->validate([
        'voucher_code' => 'required|unique:vouchers,voucher_code',
        'discount_type' => 'required|in:fixed,percent',
        'quantity' => 'required|integer|min:1',
        'user_limit' => 'required|integer|min:1',
        'discount_value' => 'required|numeric|min:0',
        'sale_price' => 'required|numeric|min:0',
        'min_order_value' => 'required|numeric|min:0',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:0,1',
        'description' => 'nullable|string|max:500',
        'product_ids' => 'nullable|array',
    ],[
    // --- Lỗi Voucher Code ---
    'voucher_code.required' => 'Mã Voucher là bắt buộc.',
    'voucher_code.unique' => 'Mã Voucher này đã tồn tại, vui lòng chọn mã khác.',

    // --- Lỗi Loại Giảm Giá (Discount Type) ---
    'discount_type.required' => 'Loại giảm giá là bắt buộc.',
    'discount_type.in' => 'Loại giảm giá không hợp lệ (Chỉ chấp nhận "fixed" hoặc "percent").',

    // --- Lỗi Số lượng (Quantity) ---
    'quantity.required' => 'Số lượng Voucher là bắt buộc.',
    'quantity.integer' => 'Số lượng Voucher phải là số nguyên.',
    'quantity.min' => 'Số lượng Voucher phải lớn hơn hoặc bằng 1.',

    // --- Lỗi Giới hạn người dùng (User Limit) ---
    'user_limit.required' => 'Giới hạn sử dụng trên mỗi người dùng là bắt buộc.',
    'user_limit.integer' => 'Giới hạn sử dụng phải là số nguyên.',
    'user_limit.min' => 'Giới hạn sử dụng phải lớn hơn hoặc bằng 1.',

    // --- Lỗi Giá trị giảm (Discount Value) ---
    'discount_value.required' => 'Giá trị giảm là bắt buộc.',
    'discount_value.numeric' => 'Giá trị giảm phải là một số.',
    'discount_value.min' => 'Giá trị giảm không được nhỏ hơn 0.',

    // --- Lỗi Giá bán (Sale Price - Có thể là giá trị giảm tối đa/áp dụng cho đơn hàng...) ---
    'sale_price.required' => 'Giá bán/Giảm tối đa là bắt buộc.',
    'sale_price.numeric' => 'Giá bán/Giảm tối đa phải là một số.',
    'sale_price.min' => 'Giá bán/Giảm tối đa không được nhỏ hơn 0.',

    // --- Lỗi Giá trị đơn hàng tối thiểu (Min Order Value) ---
    'min_order_value.required' => 'Giá trị đơn hàng tối thiểu là bắt buộc.',
    'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
    'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn 0.',

    // --- Lỗi Ngày bắt đầu (Start Date) ---
    'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
    'start_date.date' => 'Ngày bắt đầu không hợp lệ.',

    // --- Lỗi Ngày kết thúc (End Date) ---
    'end_date.required' => 'Ngày kết thúc là bắt buộc.',
    'end_date.date' => 'Ngày kết thúc không hợp lệ.',
    'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',

    // --- Lỗi Trạng thái (Status) ---
    'status.required' => 'Trạng thái là bắt buộc.',
    'status.in' => 'Trạng thái không hợp lệ (Chỉ chấp nhận 0 hoặc 1).',

    // --- Lỗi Mô tả (Description) ---
    'description.string' => 'Mô tả phải là chuỗi ký tự.',
    'description.max' => 'Mô tả không được vượt quá 500 ký tự.',

    // --- Lỗi ID sản phẩm (Product IDs) ---
    'product_ids.array' => 'Danh sách sản phẩm không hợp lệ.',
]);

    // 🔹 Tính sale_price hợp lệ
    if ($request->discount_type === 'fixed') {
        $priceAfterDiscount = $request->min_order_value - $request->discount_value;
    } else {
        $priceAfterDiscount = $request->min_order_value - ($request->min_order_value * $request->discount_value / 100);
    }

    $sale_price = max(0, max($request->sale_price, $priceAfterDiscount));

    // 🔥 Tạo voucher
    $voucher = Voucher::create([
        'voucher_code'    => $request->voucher_code,
        'discount_type'   => $request->discount_type,
        'discount_value'  => $request->discount_value,
        'sale_price'      => $sale_price,
        'min_order_value' => $request->min_order_value,
        'quantity'        => $request->quantity,
        'user_limit'      => $request->user_limit,
        'total_used'      => 0,
        'start_date'      => $request->start_date,
        'end_date'        => $request->end_date,
        'status'          => $request->status,
        'description'     => $request->description,
    ]);

    // 🔥 Lưu danh sách sản phẩm áp dụng voucher
    if ($request->product_ids) {
        $voucher->products()->sync($request->product_ids);
    }

    return redirect()->route('admin.vouchers.index')
        ->with('success', 'Thêm voucher thành công!');
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'voucher_code'    => 'required|unique:vouchers,voucher_code,' . $voucher->id,
            'discount_type'   => 'required|in:fixed,percent',
            'discount_value'  => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'quantity'        => 'required|integer|min:1',
            'user_limit'      => 'required|integer|min:1',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'status'          => 'required|in:0,1',
            'description'     => 'nullable|string|max:500',
        ]);

        // Tính lại sale_price khi update
        $minAfterDiscount = 0;

        if ($request->discount_type === 'fixed') {
            $priceAfterDiscount = $request->min_order_value - $request->discount_value;
            $minAfterDiscount = max($request->sale_price, $priceAfterDiscount);
        } else {
            $priceAfterDiscount = $request->min_order_value - ($request->min_order_value * $request->discount_value / 100);
            $minAfterDiscount = max($request->sale_price, $priceAfterDiscount);
        }
        $sale_price = max(0, $minAfterDiscount);



        $voucher->update([
            'voucher_code'    => $request->voucher_code,
            'discount_type'   => $request->discount_type,
            'discount_value'  => $request->discount_value,
            'sale_price'      => $sale_price,
            'min_order_value' => $request->min_order_value,
            'quantity'        => $request->quantity,
            'user_limit'      => $request->user_limit,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'status'          => $request->status,
            'description'     => $request->description,
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function edit(string $id)
{
    $voucher = Voucher::findOrFail($id);
    $products = Product::orderBy('name')->get();
    $selectedProducts = $voucher->products->pluck('id')->toArray();

    return view('admin.vouchers.edit', compact('voucher', 'products', 'selectedProducts'));
}

    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Xóa voucher thành công!');
    }
}
