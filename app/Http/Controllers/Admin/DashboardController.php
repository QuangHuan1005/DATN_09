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
        // Ưu tiên năm từ request, nếu không có mặc định năm hiện tại
        $year = $request->input('year', date('Y'));

        // ====== 2. Bộ lọc thời gian (Cho biểu đồ Ngày và KPIs) ======
        $to   = $request->input('to') ? Carbon::parse($request->input('to'))->endOfDay() : now()->endOfDay();
        $from = $request->input('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->subDays(29)->startOfDay();

        // CHẶN LỌC LÙI: Nếu ngày bắt đầu > ngày kết thúc, hoán đổi chúng để query không bị rỗng
        if ($from->gt($to)) {
            $temp = $from;
            $from = $to->copy()->startOfDay();
            $to = $temp->endOfDay();
        }

        $dateFormat = 'Y-m-d';

        // ====== 3. Doanh thu theo THÁNG (Khấu trừ hoàn hàng) ======
        // Lấy doanh thu từ bảng orders
        $monthlyOrders = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', $year)
            ->where('payment_status_id', 2) // Chỉ tính đơn đã thanh toán
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Lấy số tiền hoàn từ bảng order_returns (Chỉ tính trạng thái completed)
        $monthlyRefunds = DB::table('order_returns')
            ->selectRaw('MONTH(updated_at) as month, SUM(refund_amount) as refund')
            ->whereYear('updated_at', $year)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('refund', 'month')
            ->toArray();

        $monthlyLabels = [];
        $monthlyRevenues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyLabels[] = "Tháng $m";
            $rawRevenue = (float)($monthlyOrders[$m] ?? 0);
            $rawRefund = (float)($monthlyRefunds[$m] ?? 0);
            // Doanh thu thuần = Doanh thu - Hoàn trả (Không nhỏ hơn 0)
            $monthlyRevenues[] = max(0, $rawRevenue - $rawRefund);
        }

        // ====== 4. Doanh thu theo NGÀY (Vẽ Line Chart - Khấu trừ hoàn hàng) ======
        $revenueDaily = DB::table('orders')
            ->selectRaw('DATE(created_at) as d, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_status_id', 2)
            ->groupBy('d')
            ->pluck('revenue', 'd')
            ->toArray();

        $refundDaily = DB::table('order_returns')
            ->selectRaw('DATE(updated_at) as d, SUM(refund_amount) as refund')
            ->whereBetween('updated_at', [$from, $to])
            ->where('status', 'completed')
            ->groupBy('d')
            ->pluck('refund', 'd')
            ->toArray();

        $labels = [];
        $revenues = [];
        $cursor = (clone $from)->startOfDay();
        while ($cursor <= $to) {
            $key = $cursor->format($dateFormat);
            $labels[]   = $key;
            
            $dayRevenue = (float)($revenueDaily[$key] ?? 0);
            $dayRefund  = (float)($refundDaily[$key] ?? 0);
            
            // Doanh thu thực nhận thực tế trong ngày sau khi trừ hoàn hàng
            $revenues[] = max(0, $dayRevenue - $dayRefund);
            $cursor->addDay();
        }

        // ====== 5. Tổng quan nhanh (KPIs) ======
        $totalRevenue = array_sum($revenues);
        
        // Đếm đơn hàng đã thanh toán (payment_status_id = 2)
        $totalPaidOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->where('payment_status_id', 2)
            ->count();

        // Đếm tất cả đơn hàng phát sinh trong kỳ
        $allOrders = DB::table('orders')
            ->whereBetween('created_at', [$from, $to])
            ->count();

        // ====== 6. Tỉ lệ đơn hàng theo trạng thái (Pie/Doughnut) ======
        $statusCounts = DB::table('orders')
            ->select('order_status_id', DB::raw('COUNT(*) as c'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('order_status_id')
            ->pluck('c', 'order_status_id')
            ->toArray();

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

        // ====== 7. Top sản phẩm bán chạy (Doanh thu & Số lượng) ======
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
            ->where('o.payment_status_id', 2)
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
                DB::raw('SUM(od.price * od.quantity) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.payment_status_id', 2)
            ->groupBy('c.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        // ====== 9. Top khách hàng ======
        $topCustomers = DB::table('orders as o')
            ->join('users as u', 'u.id', '=', 'o.user_id')
            ->select(
                'u.name',
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(o.total_amount) as total_spent')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.payment_status_id', 2)
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
            ->orderByDesc('o.created_at')
            ->limit(10)
            ->get();

        // ====== 12. Tỉ lệ hoàn hàng (Theo sản phẩm) ======
        $returnByProduct = DB::table('orders as o')
            ->join('order_details as od', 'od.order_id', '=', 'o.id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select('p.name as product_name', DB::raw('SUM(od.quantity) as qty_return'))
            ->whereBetween('o.created_at', [$from, $to])
            ->where('o.order_status_id', 7) // Trạng thái hoàn hàng (Status ID: 7)
            ->groupBy('p.name')
            ->orderByDesc('qty_return')
            ->limit(8)
            ->get();

        // Trả về View với đầy đủ dữ liệu
        return view('admin.dashboard', [
            'year' => $year,
            'from' => $from,
            'to' => $to,
            'labels' => $labels,
            'revenues' => $revenues,
            'monthlyLabels' => $monthlyLabels,
            'monthlyRevenues' => $monthlyRevenues,
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
            'retLabels' => $returnByProduct->pluck('product_name')->toArray(),
            'retValues' => $returnByProduct->pluck('qty_return')->map(fn($v) => (int)$v)->toArray(),
        ]);
    }
}