<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $threshold = (int) config('inventory.low_stock_threshold', 5);

        try {
            $query = ProductVariant::query()
                ->with([
                    'product:id,product_code,name,category_id',
                    'color:id,name,color_code',
                    'size:id,name,size_code',
                ])
                ->select(['id','product_id','color_id','size_id','price','sale','image','quantity','status'])
                ->when($request->filled('q'), function ($q) use ($request) {
                    $kw = trim($request->q);
                    $q->whereHas('product', fn($p) =>
                        $p->where('name','like',"%{$kw}%")
                          ->orWhere('product_code','like',"%{$kw}%")
                    );
                })
                ->when($request->filled('category_id'), function ($q) use ($request) {
                    $q->whereHas('product', fn($p) => $p->where('category_id', $request->category_id));
                })
                ->orderByDesc('id');

            $variants = $query->paginate(10)->withQueryString();

            return view('admin.inventory.index', [
                'variants'  => $variants,
                'threshold' => $threshold,
            ]);
        } catch (\Throwable $e) {
            return view('admin.inventory.index', [
                'variants'  => collect(),
                'threshold' => $threshold,
                'error'     => 'Không thể tải dữ liệu',
            ]);
        }
    }

    public function updateQuantity(Request $request, ProductVariant $variant)
    {
        $data = $request->validate([
            'quantity' => ['required','integer','min:0'],
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.integer'  => 'Số lượng không hợp lệ',
            'quantity.min'      => 'Số lượng không được âm',
        ]);

        try {
            DB::transaction(fn() => $variant->update(['quantity' => $data['quantity']]));

            return response()->json([
                'status'   => true,
                'message'  => 'Cập nhật thành công',
                'quantity' => (int) $data['quantity'],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Cập nhật thất bại',
            ], 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        $payload = $request->validate([
            'items'             => ['required','array','min:1'],
            'items.*.id'        => ['required','integer','exists:product_variants,id'],
            'items.*.quantity'  => ['required','integer','min:0'],
        ]);

        try {
            DB::transaction(function () use ($payload) {
                foreach ($payload['items'] as $row) {
                    ProductVariant::whereKey($row['id'])->update(['quantity' => $row['quantity']]);
                }
            });
            return back()->with('success','Đã cập nhật số lượng hàng loạt.');
        } catch (\Throwable $e) {
            return back()->with('error','Cập nhật thất bại.');
        }
    }
}
