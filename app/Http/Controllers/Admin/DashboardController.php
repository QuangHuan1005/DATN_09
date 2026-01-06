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

        // Điều kiện lọc đơn hàng "Sạch" (Loại bỏ rác và chỉ tính đơn đã thanh toán)
        // Dùng alias 'o' để tránh lỗi Ambiguous (xung đột tên cột name/created_at)
        $validOrdersScope = function($query) {
            $query->where('o.total_amount', '>', 0)
                  ->whereNotNull('o.name')
                  ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
                  ->where('o.payment_status_id', 2);
        };

        // ====== 3. Doanh thu theo THÁNG (Khấu trừ hoàn hàng) ======
        $monthlyOrders = DB::table('orders as o')
            ->selectRaw('MONTH(o.created_at) as month, SUM(o.total_amount) as revenue')
            ->whereYear('o.created_at', $year)
            ->where($validOrdersScope)
            ->groupBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

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
            $monthlyRevenues[] = max(0, $rawRevenue - $rawRefund);
        }

        // ====== 4. Doanh thu theo NGÀY (Vẽ Line Chart - Khấu trừ hoàn hàng) ======
        $revenueDaily = DB::table('orders as o')
            ->selectRaw('DATE(o.created_at) as d, SUM(o.total_amount) as revenue')
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
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
            $revenues[] = max(0, $dayRevenue - $dayRefund);
            $cursor->addDay();
        }

        // ====== 5. Tổng quan nhanh (KPIs) ======
        $totalRevenue = array_sum($revenues);
        
        $totalPaidOrders = DB::table('orders as o')
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->count();

        $allOrders = DB::table('orders as o')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereNotNull('o.name')
            ->whereNotIn('o.name', ['N/A', 'aaaa', 'ghbhfdj', 'test', 'Admin'])
            ->count();

        // ====== 6. Tỉ lệ đơn hàng theo trạng thái (Pie/Doughnut) ======
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

        // ====== 7. Top sản phẩm bán chạy (Doanh thu & Số lượng) ======
        // Giải pháp: Phân bổ Voucher chiết khấu để khớp tổng doanh thu
        $topProducts = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->select(
                'p.id as product_id',
                'p.name as product_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                DB::raw('SUM((od.price * od.quantity / o.subtotal) * o.total_amount) as revenue')
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

        // ====== 8. Top danh mục bán chạy (Khấu trừ Voucher) ======
        $topCategories = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->join('product_variants as pv', 'pv.id', '=', 'od.product_variant_id')
            ->join('products as p', 'p.id', '=', 'pv.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->select(
                'c.name as category_name',
                DB::raw('SUM(od.quantity) as qty_sold'),
                // Phân bổ tỉ lệ giảm giá từ Voucher vào doanh thu danh mục
                DB::raw('SUM((od.price * od.quantity / o.subtotal) * o.total_amount) as revenue')
            )
            ->whereBetween('o.created_at', [$from, $to])
            ->where($validOrdersScope)
            ->where('o.subtotal', '>', 0)
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

        // ====== 12. Tỉ lệ hoàn hàng (Theo sản phẩm) ======
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