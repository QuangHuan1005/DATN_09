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
        // ====== 1. Xử lý Bộ lọc thời gian ======
        $year = $request->input('year', date('Y'));
        
        // Mặc định xem 30 ngày gần nhất nếu không có input
        $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->subDays(29)->startOfDay();

        // Đảo ngược nếu ngày bắt đầu lớn hơn ngày kết thúc
        if ($from->gt($to)) {
            $temp = $from;
            $from = $to->copy()->startOfDay();
            $to = $temp->endOfDay();
        }

        $dbDateFormat = 'Y-m-d';

        // Danh sách tên rác cần loại bỏ
        $excludedNames = ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'];

        /**
         * Điều kiện lọc đơn hàng "Sạch"
         */
        $cleanOrdersOnly = function($query) use ($excludedNames) {
            $query->where('o.total_amount', '>', 0)
                  ->whereNotNull('o.name')
                  ->whereNotIn('o.name', $excludedNames);
        };

        // ====== 2. Doanh thu theo THÁNG (Cho Bar Chart - Dòng tiền thực tế) ======
        // Doanh thu phát sinh từ đơn mới
        $monthlyGross = DB::table('orders as o')
            ->selectRaw('MONTH(o.created_at) as month, SUM(o.total_amount) as total')
            ->whereYear('o.created_at', $year)
            ->whereIn('o.order_status_id', [5, 7]) // Hoàn thành hoặc Hoàn trả
            ->where($cleanOrdersOnly)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Tiền hoàn trả tính theo thời điểm hoàn tiền thành công (updated_at của phiếu hoàn)
        $monthlyRefunds = DB::table('order_returns as re')
            ->selectRaw('MONTH(re.updated_at) as month, SUM(re.refund_amount) as total')
            ->whereYear('re.updated_at', $year)
            ->where('re.status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyLabels = [];
        $monthlyRevenues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = "Tháng $m";
            $netMonth = ($monthlyGross[$m] ?? 0) - ($monthlyRefunds[$m] ?? 0);
            $monthlyRevenues[] = (float)$netMonth; // Cho phép số âm nếu hoàn tiền > bán được
        }

        // ====== 3. Doanh thu theo NGÀY (Line Chart) ======

// Lấy TIỀN THU VÀO (Tính theo ngày đơn hàng phát sinh)
$dailyGross = DB::table('orders as o')
    ->selectRaw('DATE(o.created_at) as d, SUM(o.total_amount) as total')
    ->whereBetween('o.created_at', [$from, $to])
    ->whereIn('o.order_status_id', [5, 7]) // Hoàn thành & Hoàn trả
    ->where($cleanOrdersOnly)
    ->groupBy('d')
    ->pluck('total', 'd');

// Lấy TIỀN CHI RA (Dựa vào cột refund_amount riêng của bạn)
// Tính theo ngày bạn thực hiện bấm "Hoàn tiền thành công"
$dailyRefunds = DB::table('order_returns as re')
    ->selectRaw('DATE(re.updated_at) as d, SUM(re.refund_amount) as total')
    ->whereBetween('re.updated_at', [$from, $to])
    ->where('re.status', 'completed')
    ->groupBy('d')
    ->pluck('total', 'd');

$labels = [];
$revenues = [];
$cursor = (clone $from)->startOfDay();

while ($cursor <= $to) {
    $dateKey = $cursor->format($dbDateFormat);
    $labels[] = $dateKey; 

    // DOANH THU THỰC TẾ = (Tổng thu từ đơn hàng) - (Số tiền thực trả khách)
    // Nếu đơn 1 triệu hoàn 200k, Gross là 1tr, Refund là 200k => Bạn vẫn còn 800k. 
    // Không cần quan tâm đơn đó có mấy sản phẩm.
    $netDay = ($dailyGross[$dateKey] ?? 0) - ($dailyRefunds[$dateKey] ?? 0);
    $revenues[] = (float)$netDay;
    
    $cursor->addDay();
}

        // ====== 4. KPIs Tổng quan (Thực nhận trong kỳ) ======
        // Tổng tiền đơn hàng phát sinh trong kỳ
        $grossData = DB::table('orders as o')
            ->selectRaw('SUM(o.total_amount) as gross_revenue, COUNT(o.id) as total_paid_orders')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.order_status_id', [5, 7]) 
            ->where($cleanOrdersOnly)
            ->first();

        $totalGrossRevenueInPeriod = (float)($grossData->gross_revenue ?? 0);
        $totalPaidOrders           = (int)($grossData->total_paid_orders ?? 0);

        // Tổng tiền hoàn trả thực hiện trong kỳ (re.updated_at)
        $totalRefundAmountInPeriod = DB::table('order_returns as re')
            ->whereBetween('re.updated_at', [$from, $to])
            ->where('re.status', 'completed')
            ->sum('re.refund_amount');

        // Doanh thu thực nhận cuối cùng trong kỳ
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

        // ====== 5. Tỉ lệ đơn hàng theo trạng thái (Pie Chart) ======
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

        // ====== 6. Top 10 sản phẩm (Trừ đi tỉ lệ hoàn trả) ======
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

        // ====== 7. Top danh mục bán chạy ======
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

        // ====== 8. Top khách hàng VIP ======
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

        // ====== 9. Sản phẩm tồn kho thấp ======
        $lowStocks = DB::table('product_variants as pv')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->leftJoin('colors as c', 'c.id', '=', 'pv.color_id')
            ->leftJoin('sizes as s', 's.id', '=', 'pv.size_id')
            ->select('p.product_code', 'p.name as product_name', 'c.name as color', 's.name as size', 'pv.quantity', 'p.id as product_id', 'pv.id as variant_id')
            ->orderBy('pv.quantity', 'asc')->limit(10)->get();

        // ====== 10. Hoàn hàng theo sản phẩm ======
        $returnByProduct = DB::table('orders as o')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select('p.name as product_name', DB::raw('SUM(od.quantity) as qty_return'))
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.order_status_id', 7) 
            ->where($cleanOrdersOnly)
            ->groupBy('p.name')->orderByDesc('qty_return')->limit(8)->get();

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