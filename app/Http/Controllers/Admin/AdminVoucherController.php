<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     */
    public function store(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|unique:vouchers,voucher_code',
            'discount_type' => 'required|in:fixed,percent',
            'quantity' => 'required|integer|min:1',
            'user_limit' => 'required|integer|min:1',
            'discount_value' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0', // Bổ sung validation cho điểm
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:500',
            'product_ids' => 'nullable|array',
        ], [
            // --- Giữ nguyên các thông báo lỗi của bạn và thêm thông báo cho điểm ---
            'voucher_code.required' => 'Mã Voucher là bắt buộc.',
            'voucher_code.unique' => 'Mã Voucher này đã tồn tại, vui lòng chọn mã khác.',
            'points_required.integer' => 'Số điểm yêu cầu phải là số nguyên.',
            'points_required.min' => 'Số điểm không được nhỏ hơn 0.',
            'discount_type.required' => 'Loại giảm giá là bắt buộc.',
            'quantity.required' => 'Số lượng Voucher là bắt buộc.',
            'discount_value.required' => 'Giá trị giảm là bắt buộc.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
        ]);

        // 🔹 Tính sale_price hợp lệ (Giữ nguyên logic của bạn)
        if ($request->discount_type === 'fixed') {
            $priceAfterDiscount = $request->min_order_value - $request->discount_value;
        } else {
            $priceAfterDiscount = $request->min_order_value - ($request->min_order_value * $request->discount_value / 100);
        }

        $sale_price = max(0, max($request->sale_price, $priceAfterDiscount));

        // 🔥 Tạo voucher (Bổ sung points_required)
        $voucher = Voucher::create([
            'voucher_code'    => $request->voucher_code,
            'discount_type'   => $request->discount_type,
            'discount_value'  => $request->discount_value,
            'sale_price'      => $sale_price,
            'min_order_value' => $request->min_order_value,
            'points_required' => $request->input('points_required', 0), // Lưu điểm đổi
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
     * Show the form for editing.
     */
    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $products = Product::orderBy('name')->get();
        $selectedProducts = $voucher->products->pluck('id')->toArray();

        return view('admin.vouchers.edit', compact('voucher', 'products', 'selectedProducts'));
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
            'points_required' => 'nullable|integer|min:0', // Bổ sung điểm khi update
            'quantity'        => 'required|integer|min:1',
            'user_limit'      => 'required|integer|min:1',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'status'          => 'required|in:0,1',
            'description'     => 'nullable|string|max:500',
        ]);

        // Tính lại sale_price khi update (Giữ nguyên logic của bạn)
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
            'points_required' => $request->input('points_required', 0), // Cập nhật điểm
            'quantity'        => $request->quantity,
            'user_limit'      => $request->user_limit,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'status'          => $request->status,
            'description'     => $request->description,
        ]);

        // Cập nhật sản phẩm áp dụng nếu có gửi product_ids
        if ($request->has('product_ids')) {
            $voucher->products()->sync($request->product_ids);
        }

        return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Xóa voucher thành công!');
    }

    public function history(Request $request)
{
    $query = DB::table('user_vouchers')
        ->join('users', 'user_vouchers.user_id', '=', 'users.id')
        ->join('vouchers', 'user_vouchers.voucher_id', '=', 'vouchers.id')
        ->select(
            'user_vouchers.*',
            'users.name as user_name',
            'users.email as user_email',
            'vouchers.voucher_code',
            'vouchers.discount_type',
            'vouchers.discount_value',
            'vouchers.points_required'
        );

    // 1. Tìm kiếm theo tên khách, email hoặc mã voucher
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('users.name', 'like', "%$keyword%")
              ->orWhere('users.email', 'like', "%$keyword%")
              ->orWhere('vouchers.voucher_code', 'like', "%$keyword%");
        });
    }

    // 2. Lọc theo trạng thái sử dụng
    if ($request->filled('status')) {
        $query->where('user_vouchers.is_used', $request->status);
    }

    // 3. Lọc theo khoảng ngày
    if ($request->filled('start_date')) {
        $query->whereDate('user_vouchers.created_at', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('user_vouchers.created_at', '<=', $request->end_date);
    }

    // 4. Phân trang (ví dụ 10 bản ghi/trang) và giữ lại các tham số lọc trên URL
    $history = $query->latest('user_vouchers.created_at')->paginate(10)->withQueryString();

    return view('admin.vouchers.history', compact('history'));
}
}