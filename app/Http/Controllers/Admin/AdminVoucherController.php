<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
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
        return view('admin.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     */  public function store(Request $request)
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
        ]);

        // 🔹 Tính giá sau giảm (sale_price)
        $minAfterDiscount = 0;

        if ($request->discount_type === 'fixed') {
            $priceAfterDiscount = $request->min_order_value - $request->discount_value;
            $minAfterDiscount = max($request->sale_price, $priceAfterDiscount);
        } else {
            $priceAfterDiscount = $request->min_order_value - ($request->min_order_value * $request->discount_value / 100);
            $minAfterDiscount = max($request->sale_price, $priceAfterDiscount);
        }
        $sale_price = max(0, $minAfterDiscount);

        Voucher::create([
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

        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm voucher thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
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
    public function destroy(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Xóa voucher thành công!');
    }
}
