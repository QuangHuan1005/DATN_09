<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'voucher_code'    => 'required|unique:vouchers,voucher_code',
            'discount_type'   => 'required|in:fixed,percent',
            'discount_value'  => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('Giá trị giảm theo phần trăm không thể vượt quá 100%.');
                    }
                    if ($request->discount_type === 'fixed' && $value > $request->min_order_value) {
                        $fail('Giá trị giảm cố định không được lớn hơn đơn hàng tối thiểu.');
                    }
                },
            ],
            'quantity'        => 'required|integer|min:1',
            'user_limit'      => 'required|integer|min:1',
            'sale_price'      => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'status'          => 'required|in:0,1',
            'description'     => 'nullable|string|max:500',
            'product_ids'     => 'nullable|array',
        ], [
            'voucher_code.required' => 'Mã Voucher là bắt buộc.',
            'voucher_code.unique'   => 'Mã Voucher này đã tồn tại.',
            'start_date.after_or_equal' => 'Ngày bắt đầu không được là ngày quá khứ.',
            'end_date.after_or_equal'   => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        try {
            DB::beginTransaction();

            // Tính toán sale_price an toàn: sale_price thực tế không nên nhỏ hơn mức tối thiểu hệ thống tính toán
            $priceAfterDiscount = ($request->discount_type === 'fixed') 
                ? ($request->min_order_value - $request->discount_value)
                : ($request->min_order_value - ($request->min_order_value * $request->discount_value / 100));

            $sale_price = max($request->sale_price, 0);

            $voucher = Voucher::create([
                'voucher_code'    => strtoupper($request->voucher_code),
                'discount_type'   => $request->discount_type,
                'discount_value'  => $request->discount_value,
                'sale_price'      => $sale_price,
                'min_order_value' => $request->min_order_value,
                'points_required' => $request->input('points_required', 0),
                'quantity'        => $request->quantity,
                'user_limit'      => $request->user_limit,
                'total_used'      => 0,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'status'          => $request->status,
                'description'     => $request->description,
            ]);

            if ($request->filled('product_ids')) {
                $voucher->products()->sync($request->product_ids);
            }

            DB::commit();
            return redirect()->route('admin.vouchers.index')->with('success', 'Thêm voucher thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())->withInput();
        }
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
            'discount_value'  => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percent' && $value > 100) {
                        $fail('Giá trị giảm theo phần trăm không thể vượt quá 100%.');
                    }
                    if ($request->discount_type === 'fixed' && $value > $request->min_order_value) {
                        $fail('Giá trị giảm cố định không được lớn hơn đơn hàng tối thiểu.');
                    }
                },
            ],
            'min_order_value' => 'required|numeric|min:0',
            'points_required' => 'nullable|integer|min:0',
            'quantity'        => 'required|integer|min:1',
            'user_limit'      => 'required|integer|min:1',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'status'          => 'required|in:0,1',
            'description'     => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $sale_price = max($request->sale_price, 0);

            $voucher->update([
                'voucher_code'    => strtoupper($request->voucher_code),
                'discount_type'   => $request->discount_type,
                'discount_value'  => $request->discount_value,
                'sale_price'      => $sale_price,
                'min_order_value' => $request->min_order_value,
                'points_required' => $request->input('points_required', 0),
                'quantity'        => $request->quantity,
                'user_limit'      => $request->user_limit,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'status'          => $request->status,
                'description'     => $request->description,
            ]);

            $voucher->products()->sync($request->input('product_ids', []));

            DB::commit();
            return redirect()->route('admin.vouchers.index')->with('success', 'Cập nhật voucher thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi cập nhật: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa voucher thành công!');
    }

    /**
     * History of voucher claims/usage.
     */
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

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('users.name', 'like', "%$keyword%")
                  ->orWhere('users.email', 'like', "%$keyword%")
                  ->orWhere('vouchers.voucher_code', 'like', "%$keyword%");
            });
        }

        if ($request->filled('status')) {
            $query->where('user_vouchers.is_used', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('user_vouchers.created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('user_vouchers.created_at', '<=', $request->end_date);
        }

        $history = $query->latest('user_vouchers.created_at')->paginate(10)->withQueryString();

        return view('admin.vouchers.history', compact('history'));
    }
}