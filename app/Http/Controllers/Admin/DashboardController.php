<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ====== Bộ lọc thời gian ======
        $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->subDays(29)->startOfDay();

        // Định dạng key ngày theo app timezone
        $dateFormat = 'Y-m-d';

        // ====== Doanh thu theo ngày (chỉ tính đơn đã thanh toán) ======
        // Sử dụng orders.total_amount với payment_status_id = 2 (Đã thanh toán)
        $revenueDaily = DB::table('orders')
            ->selectRaw('DATE(created_at) as d, SUM(total_amount) as revenue, COUNT(*) as orders_count')
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_status_id', 2)
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('revenue', 'd')
            ->toArray();

        // Fill missing dates = 0 để vẽ line chart mượt
        $labels = [];
        $revenues = [];
        $ordersPerDay = [];
        $cursor = (clone $from)->startOfDay();
        while ($cursor <= $to) {
            $key = $cursor->format($dateFormat);
            $labels[]   = $key;
            $revenues[] = (float)($revenueDaily[$key] ?? 0);
            $cursor->addDay();
        }

        // Tổng quan nhanh
        $totalRevenue = array_sum($revenues);
        $totalPaidOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_status_id', 2)
            ->count();

        $allOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        // ====== Tỉ lệ đơn hàng theo trạng thái (pie) ======
        $statusCounts = DB::table('orders')
            ->select('order_status_id', DB::raw('COUNT(*) as c'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id')
            ->toArray();

        // Map nhãn trạng thái (dựa trên seed của bạn)
        $statusMap = [
            1 => 'Chờ xác nhận',
            2 => 'Xác nhận',
            3 => 'Đang giao hàng',
            4 => 'Đã giao hàng',
            5 => 'Hoàn thành',
            6 => 'Hủy',
            7 => 'Hoàn hàng',
        ];
        $statusLabels = [];
        $statusValues = [];
        foreach ($statusMap as $sid => $name) {
            $statusLabels[] = $name;
            $statusValues[] = (int)($statusCounts[$sid] ?? 0);
        }

        // ====== Top sản phẩm bán chạy (theo doanh thu & số lượng) ======
        // order_details.price * quantity trong khoảng thời gian orders.created_at
        $topProducts = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM(od.price * od.quantity) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // Dữ liệu cho bar chart (doanh thu top 10)
        $tpLabels = $topProducts->pluck('product_name')->toArray();
        $tpRevenue = $topProducts->pluck('revenue')->map(fn($v) => (float)$v)->toArray();
        $tpQty = $topProducts->pluck('qty_sold')->map(fn($v) => (int)$v)->toArray();

        // ====== Top danh mục bán chạy ======
        $topCategories = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->select(
                'c.id as category_id',
                'c.name as category_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM(od.price * od.quantity) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->groupBy('c.id', 'c.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // ====== Top khách hàng (tổng chi tiêu, đơn hàng) ======
        $topCustomers = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->select(
                'u.id as user_id',
                'u.name',
                'u.email',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(o.total_amount) as total_spent'),
                DB::raw('AVG(o.total_amount) as avg_order_value'),
                DB::raw('SUM(CASE WHEN o.order_status_id IN (6,7) THEN 1 ELSE 0 END) as cancelled_or_returned')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->groupBy('u.id', 'u.name', 'u.email')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // ====== Sản phẩm tồn kho (biến thể) — sắp xếp tăng dần theo quantity ======
        $lowStocks = DB::table('product_variants as pv')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->leftJoin('colors as c', 'c.id', '=', 'pv.color_id')
            ->leftJoin('sizes as s', 's.id', '=', 'pv.size_id')
            ->select(
                'pv.id as variant_id',
                'p.id as product_id',
                'p.product_code',
                'p.name as product_name',
                'c.name as color',
                's.name as size',
                'pv.quantity'
            )
            ->orderBy('pv.quantity', 'asc')
            ->limit(10)
            ->get();

        // ====== Đơn hàng gần đây (chờ xác nhận) ======
        $recentPending = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->select('o.id', 'o.order_code', 'o.total_amount', 'o.created_at', 'u.name as customer')
            ->where('o.order_status_id', 1) // Chờ xác nhận
            ->orderByDesc('o.created_at')
            ->limit(10)
            ->get();

        // ====== (Optional) Tỉ lệ hoàn hàng (pie theo sản phẩm) ======
        // Dựa trên order_status_id=7 trong khoảng thời gian
        $returnByProduct = DB::table('orders as o')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select('p.name as product_name', DB::raw('SUM(od.quantity) as qty_return'))
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.order_status_id', 7)
            ->groupBy('p.name')
            ->orderByDesc('qty_return')
            ->limit(8)
            ->get();

        $retLabels = $returnByProduct->pluck('product_name')->toArray();
        $retValues = $returnByProduct->pluck('qty_return')->map(fn($v) => (int)$v)->toArray();

        // View data
        return view('admin.dashboard', [
            'from' => $from,
            'to' => $to,
            'labels' => $labels,
            'revenues' => $revenues,
            'totalRevenue' => $totalRevenue,
            'totalPaidOrders' => $totalPaidOrders,
            'allOrders' => $allOrders,

            'statusLabels' => $statusLabels,
            'statusValues' => $statusValues,

            'topProducts' => $topProducts,
            'tpLabels' => $tpLabels,
            'tpRevenue' => $tpRevenue,
            'tpQty' => $tpQty,

            'topCategories' => $topCategories,
            'topCustomers' => $topCustomers,
            'lowStocks' => $lowStocks,
            'recentPending' => $recentPending,

            'retLabels' => $retLabels,
            'retValues' => $retValues,
        ]);
    }
}
