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
        // ====== 1. Xử lý Năm lọc ======
        $year = $request->input('year', date('Y'));

        // ====== 2. Bộ lọc thời gian (Cho biểu đồ Ngày và KPIs) ======
        $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->subDays(29)->startOfDay();

        if ($from->gt($to)) {
            $temp = $from;
            $from = $to->copy()->startOfDay();
            $to = $temp->endOfDay();
        }

        $dateFormat = 'Y-m-d';

        /**
         * Điều kiện lọc đơn hàng "Sạch" và ĐÃ HOÀN THÀNH
         * Mục tiêu: Khớp 100% với trang danh sách đơn hàng khi Admin lọc trạng thái "Hoàn thành"
         */
        $validOrdersScope = function($query) {
            $query->where('o.total_amount', '>', 0)
                  ->whereNotNull('o.name')
                  ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
                  ->where('o.order_status_id', 5); // Chỉ tính đơn đã Hoàn thành
        };

        // ====== 3. Doanh thu theo THÁNG (Cho Bar Chart - Dùng doanh thu Gộp) ======
        $monthlyOrders = DB::table('orders as o')
            ->selectRaw('MONTH(o.created_at) as month, SUM(o.total_amount) as revenue')
            ->whereYear('o.created_at', $year)
            ->where($validOrdersScope)
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        $monthlyLabels = [];
        $monthlyRevenues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = "Tháng $m";
            // Dùng doanh thu gộp để khi click vào cột biểu đồ sẽ khớp với danh sách đơn hàng
            $monthlyRevenues[] = (float)($monthlyOrders[$m] ?? 0);
        }

        // ====== 4. Doanh thu theo NGÀY (Cho Line Chart - Dùng doanh thu Gộp) ======
        $revenueDaily = DB::table('orders as o')
            ->selectRaw('DATE(o.created_at) as d, SUM(o.total_amount) as revenue')
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->groupBy('d')
            ->pluck('revenue', 'd')
            ->toArray();

        $labels = [];
        $revenues = [];
        $cursor = (clone $from)->startOfDay();
        while ($cursor <= $to) {
            $key = $cursor->format($dateFormat);
            $labels[]   = $key;
            $revenues[] = (float)($revenueDaily[$key] ?? 0);
            $cursor->addDay();
        }

        // ====== 5. KPIs Tổng quan & Xử lý phần TRỪ (Refund) ======
        
        // 5.1 Doanh thu gộp (Gross Revenue) - Tổng tiền các hóa đơn Hoàn thành
        $totalGrossRevenue = array_sum($revenues);
        
        // 5.2 Tổng tiền hoàn trả (Refunds) - Tiền trừ
        $totalRefundAmount = DB::table('order_returns')
            ->whereBetween('updated_at', [$from, $to])
            ->where('status', 'completed')
            ->sum('refund_amount');

        // 5.3 Doanh thu thực nhận (Net Revenue)
        $netRevenue = max(0, $totalGrossRevenue - $totalRefundAmount);

        // Đơn hàng đã hoàn thành
        $totalPaidOrders = DB::table('orders as o')
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->count();

        // Tổng lượng giao dịch (bao gồm cả đơn Hủy/Chờ/Hoàn...)
        $allOrders = DB::table('orders as o')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereNotNull('o.name')
            ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
            ->count();

        // ====== 6. Tỉ lệ đơn hàng theo trạng thái ======
        $statusCounts = DB::table('orders as o')
            ->select('o.order_status_id', DB::raw('COUNT(*) as c'))
            ->whereBetween('o.created_at', [$from, $to])
            ->whereNotNull('o.name')
            ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
            ->groupBy('o.order_status_id')
            ->pluck('c', 'o.order_status_id')
            ->toArray();

        $statusMap = [1 => 'Chờ xác nhận', 2 => 'Xác nhận', 3 => 'Đang giao hàng', 4 => 'Đã giao hàng', 5 => 'Hoàn thành', 6 => 'Hủy', 7 => 'Hoàn hàng'];
        $statusLabels = [];
        $statusValues = [];
        foreach ($statusMap as $sid => $name) {
            $statusLabels[] = $name;
            $statusValues[] = (int)($statusCounts[$sid] ?? 0);
        }

        // ====== 7. Top 10 sản phẩm bán chạy (Dựa trên hóa đơn thành công) ======
        $topProducts = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM((od.price * od.quantity / NULLIF(o.subtotal, 0)) * o.total_amount) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->where('o.subtotal', '>', 0)
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        $tpLabels = $topProducts->pluck('product_name')->toArray();
        $tpRevenue = $topProducts->pluck('revenue')->map(fn($v) => (float)$v)->toArray();
        $tpQty = $topProducts->pluck('qty_sold')->map(fn($v) => (int)$v)->toArray();

        // ====== 8. Top danh mục bán chạy ======
        $topCategories = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->select(
                'c.name as category_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM((od.price * od.quantity / NULLIF(o.subtotal, 0)) * o.total_amount) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->where('o.subtotal', '>', 0)
            ->groupBy('c.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // ====== 9. Top khách hàng VIP ======
        $topCustomers = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->select(
                'u.name',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(o.total_amount) as total_spent')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->groupBy('u.id', 'u.name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // ====== 10. Sản phẩm tồn kho thấp ======
        $lowStocks = DB::table('product_variants as pv')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->leftJoin('colors as c', 'c.id', '=', 'pv.color_id')
            ->leftJoin('sizes as s', 's.id', '=', 'pv.size_id')
            ->select(
                'p.product_code',
                'p.name as product_name',
                'c.name as color',
                's.name as size',
                'pv.quantity',
                'p.id as product_id',
                'pv.id as variant_id'
            )
            ->orderBy('pv.quantity', 'asc')
            ->limit(10)
            ->get();

        // ====== 11. Đơn hàng gần đây (Chờ xác nhận) ======
        $recentPending = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->select('o.id', 'o.order_code', 'o.total_amount', 'o.created_at', 'u.name as customer')
            ->where('o.order_status_id', 1) 
            ->whereNotNull('o.name')
            ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
            ->orderByDesc('o.created_at')
            ->limit(10)
            ->get();

        // ====== 12. Tỉ lệ hoàn hàng theo sản phẩm ======
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

        // Trả về View
        return view('admin.dashboard', [
            'year' => $year,
            'from' => $from,
            'to' => $to,
            'labels' => $labels,
            'revenues' => $revenues,
            'monthlyLabels' => $monthlyLabels,
            'monthlyRevenues' => $monthlyRevenues,
            'totalRevenue' => $totalGrossRevenue, // Doanh thu gộp
            'totalRefund' => $totalRefundAmount,   // Tiền bị trừ
            'netRevenue' => $netRevenue,           // Doanh thu thực tế
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
            'retLabels' => $returnByProduct->pluck('product_name')->toArray(),
            'retValues' => $returnByProduct->pluck('qty_return')->map(fn($v) => (int)$v)->toArray(),
        ]);
    }
}