<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Thống Kê Chi Tiết
     * Đã xử lý: Khấu trừ tiền hoàn trả (refund) trực tiếp vào doanh thu đơn hàng gốc.
     */
    public function index(Request $request)
    {
        // ====== 1. XỬ LÝ BỘ LỌC THỜI GIAN ======
        $year = $request->input('year', date('Y'));
        
        // Mặc định xem 30 ngày gần nhất nếu không có input từ người dùng
        $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->subDays(29)->startOfDay();

        // Tự động đảo ngược nếu ngày bắt đầu > ngày kết thúc
        if ($from->gt($to)) {
            $temp = $from;
            $from = $to->copy()->startOfDay();
            $to = $temp->endOfDay();
        }

        $dbDateFormat = 'Y-m-d';

        // Danh sách tên cần loại bỏ (dữ liệu rác/test)
        $excludedNames = ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'];

        /**
         * Điều kiện lọc đơn hàng "Sạch":
         * - Tổng tiền > 0
         * - Tên khách hàng không null và không nằm trong danh sách loại trừ
         */
        $cleanOrdersOnly = function($query) use ($excludedNames) {
            $query->where('o.total_amount', '>', 0)
                  ->whereNotNull('o.name')
                  ->whereNotIn('o.name', $excludedNames);
        };

        // ====== 2. DOANH THU THEO THÁNG (Cho Bar Chart) ======
        // Doanh thu thực (Net) = (Tổng tiền đơn) - (Tiền hoàn của chính đơn đó)
        $monthlyData = DB::table('orders as o')
            ->leftJoin('order_returns as re', function($join) {
                $join->on('o.id', '=', 're.order_id')
                     ->where('re.status', '=', 'completed');
            })
            ->selectRaw('
                MONTH(o.created_at) as month, 
                SUM(o.total_amount - IFNULL(re.refund_amount, 0)) as net_total
            ')
            ->whereYear('o.created_at', $year)
            ->whereIn('o.order_status_id', [5, 7]) // Hoàn thành (5) hoặc Hoàn trả (7)
            ->where($cleanOrdersOnly)
            ->groupBy('month')
            ->pluck('net_total', 'month');

        $monthlyLabels = [];
        $monthlyRevenues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = "Tháng $m";
            $monthlyRevenues[] = (float)($monthlyData[$m] ?? 0);
        }

        // ====== 3. DOANH THU THEO NGÀY (Line Chart) ======
        // Khấu trừ tiền hoàn trực tiếp để khớp với danh sách đơn hàng thực tế của ngày đó
        $dailyData = DB::table('orders as o')
            ->leftJoin('order_returns as re', function($join) {
                $join->on('o.id', '=', 're.order_id')
                     ->where('re.status', '=', 'completed');
            })
            ->selectRaw("
                DATE(o.created_at) as d, 
                SUM(o.total_amount - IFNULL(re.refund_amount, 0)) as net_total
            ")
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7]) 
            ->where($cleanOrdersOnly)
            ->groupBy('d')
            ->pluck('net_total', 'd');

        $labels = [];
        $revenues = [];
        $cursor = (clone $from)->startOfDay();

        while ($cursor <= $to) {
            $dateKey = $cursor->format($dbDateFormat);
            $labels[] = $dateKey; 
            $revenues[] = (float)($dailyData[$dateKey] ?? 0);
            $cursor->addDay();
        }

        // ====== 4. KPIs TỔNG QUAN (Trong kỳ báo cáo) ======
        $grossData = DB::table('orders as o')
            ->selectRaw('SUM(o.total_amount) as gross_revenue, COUNT(o.id) as total_paid_orders')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7]) 
            ->where($cleanOrdersOnly)
            ->first();

        $totalGrossRevenueInPeriod = (float)($grossData->gross_revenue ?? 0);
        $totalPaidOrders           = (int)($grossData->total_paid_orders ?? 0);

        $totalRefundAmountInPeriod = DB::table('order_returns as re')
            ->whereBetween('re.updated_at', [$from, $to])
            ->where('re.status', 'completed')
            ->sum('re.refund_amount');

        $netRevenue = $totalGrossRevenueInPeriod - $totalRefundAmountInPeriod;

        $allOrders = DB::table('orders as o')
            ->whereBetween('o.created_at', [$from, $to])
            ->where($cleanOrdersOnly)
            ->count();

        $totalQtySold = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7])
            ->where($cleanOrdersOnly)
            ->sum('od.quantity');

        // ====== 5. TỶ LỆ ĐƠN HÀNG THEO TRẠNG THÁI (Pie Chart) ======
        $statusCounts = DB::table('orders as o')
            ->select('o.order_status_id', DB::raw('COUNT(*) as c'))
            ->whereBetween('o.created_at', [$from, $to])
            ->where($cleanOrdersOnly)
            ->groupBy('o.order_status_id')
            ->pluck('c', 'o.order_status_id')
            ->toArray();

        $statusMap = [
            1 => 'Chờ xác nhận', 2 => 'Xác nhận', 3 => 'Đang giao hàng', 
            4 => 'Đã giao hàng', 5 => 'Hoàn thành', 6 => 'Hủy', 7 => 'Hoàn trả'
        ];
        $statusLabels = []; $statusValues = [];
        foreach ($statusMap as $sid => $name) {
            $statusLabels[] = $name;
            $statusValues[] = (int)($statusCounts[$sid] ?? 0);
        }

        // ====== 6. TOP 10 SẢN PHẨM HIỆU QUẢ ======
        $topProducts = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->leftJoin('order_returns as re', function($join) {
                $join->on('o.id', '=', 're.order_id')->where('re.status', '=', 'completed');
            })
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM((od.price * od.quantity / NULLIF(o.subtotal, 0)) * (o.total_amount - IFNULL(re.refund_amount, 0))) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7])
            ->where('o.subtotal', '>', 0)
            ->where($cleanOrdersOnly)
            ->groupBy('p.id', 'p.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // ====== 7. TOP DANH MỤC ĐÓNG GÓP DOANH THU ======
        $topCategories = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->leftJoin('order_returns as re', function($join) {
                $join->on('o.id', '=', 're.order_id')->where('re.status', '=', 'completed');
            })
            ->select(
                'c.name as category_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM((od.price * od.quantity / NULLIF(o.subtotal, 0)) * (o.total_amount - IFNULL(re.refund_amount, 0))) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7])
            ->where('o.subtotal', '>', 0)
            ->where($cleanOrdersOnly)
            ->groupBy('c.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // ====== 8. KHÁCH HÀNG VIP ======
        $topCustomers = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->leftJoin('order_returns as re', function($join) {
                $join->on('o.id', '=', 're.order_id')->where('re.status', '=', 'completed');
            })
            ->select(
                'u.name',
                DB::raw('COUNT(DISTINCT o.id) as orders_count'),
                DB::raw('SUM(o.total_amount - IFNULL(re.refund_amount, 0)) as total_spent')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7])
            ->where($cleanOrdersOnly)
            ->groupBy('u.id', 'u.name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // ====== 9. SẢN PHẨM TỒN KHO THẤP ======
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

        // ====== 10. TỶ LỆ HOÀN HÀNG THEO SẢN PHẨM ======
        $returnByProduct = DB::table('orders as o')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select('p.name as product_name', DB::raw('SUM(od.quantity) as qty_return'))
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.order_status_id', 7) 
            ->where($cleanOrdersOnly)
            ->groupBy('p.name')
            ->orderByDesc('qty_return')
            ->limit(8)
            ->get();

        return view('admin.dashboard', [
            'year'            => $year,
            'from'            => $from,
            'to'              => $to,
            'labels'          => $labels,
            'revenues'        => $revenues, 
            'monthlyLabels'   => $monthlyLabels,
            'monthlyRevenues' => $monthlyRevenues,
            'totalRevenue'    => $totalGrossRevenueInPeriod,
            'totalRefund'     => $totalRefundAmountInPeriod,
            'netRevenue'      => $netRevenue,
            'totalPaidOrders' => $totalPaidOrders,
            'allOrders'       => $allOrders,
            'totalQtySold'    => (int)$totalQtySold,
            'statusLabels'    => $statusLabels,
            'statusValues'    => $statusValues,
            'topProducts'     => $topProducts,
            'tpLabels'        => $topProducts->pluck('product_name')->toArray(),
            'tpRevenue'       => $topProducts->pluck('revenue')->map(fn($v) => (float)$v)->toArray(),
            'tpQty'           => $topProducts->pluck('qty_sold')->map(fn($v) => (int)$v)->toArray(),
            'topCategories'   => $topCategories,
            'topCustomers'    => $topCustomers,
            'lowStocks'       => $lowStocks,
            'retLabels'       => $returnByProduct->pluck('product_name')->toArray(),
            'retValues'       => $returnByProduct->pluck('qty_return')->map(fn($v) => (int)$v)->toArray(),
        ]);
    }
}