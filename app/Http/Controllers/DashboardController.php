<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik untuk dashboard
        $totalProducts = Product::count();

        // Produk dengan stok menipis
        $lowStockProducts = Product::whereRaw('stock_quantity <= min_stock_threshold')->get();
        $lowStockCount = $lowStockProducts->count();

        // Pesanan hari ini
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $todayRevenue = Order::whereDate('created_at', Carbon::today())
                            ->where('status', 'completed')
                            ->sum('total_amount');

        // Data untuk grafik penjualan 7 hari terakhir
        $last7Days = [];
        $salesData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $last7Days[] = $date->format('d M');

            $dailySales = Order::whereDate('created_at', $date)
                            ->where('status', 'completed')
                            ->sum('total_amount');
            $salesData[] = $dailySales;
        }

        return view('dashboard.index', compact(
            'totalProducts',
            'lowStockProducts',
            'lowStockCount',
            'todayOrders',
            'todayRevenue',
            'last7Days',
            'salesData'
        ));
    }
}
