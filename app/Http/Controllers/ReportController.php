<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
                        ->where('status', 'completed')
                        ->get();

        $totalSales = $orders->sum('total_amount');
        $orderCount = $orders->count();

        // Grup berdasarkan tanggal
        $dailySales = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m-d');
        })->map(function ($orders) {
            return $orders->sum('total_amount');
        });

        $dates = [];
        $salesData = [];

        foreach ($dailySales as $date => $amount) {
            $dates[] = Carbon::parse($date)->format('d M');
            $salesData[] = $amount;
        }

        return view('reports.sales', compact(
            'orders',
            'totalSales',
            'orderCount',
            'startDate',
            'endDate',
            'dates',
            'salesData'
        ));
    }

    public function inventory()
    {
        $products = Product::with('category')->get();

        $totalProducts = $products->count();
        $totalValue = $products->sum(function ($product) {
            return $product->price * $product->stock_quantity;
        });

        $lowStockProducts = $products->filter(function ($product) {
            return $product->isLowStock();
        });

        $categories = $products->groupBy('category.name')->map(function ($products) {
            return [
                'count' => $products->count(),
                'value' => $products->sum(function ($product) {
                    return $product->price * $product->stock_quantity;
                })
            ];
        });

        return view('reports.inventory', compact(
            'products',
            'totalProducts',
            'totalValue',
            'lowStockProducts',
            'categories'
        ));
    }

    public function generate(Request $request)
    {
        $type = $request->type;
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        if ($type === 'sales') {
            $orders = Order::whereBetween('created_at', [$startDate, $endDate])
                            ->where('status', 'completed')
                            ->with('items.product')
                            ->get();

            $data = [
                'orders' => $orders,
                'totalSales' => $orders->sum('total_amount'),
                'orderCount' => $orders->count(),
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];

            return view('reports.exports.sales', $data);
        }
        elseif ($type === 'inventory') {
            $products = Product::with('category')->get();

            $data = [
                'products' => $products,
                'totalProducts' => $products->count(),
                'totalValue' => $products->sum(function ($product) {
                    return $product->price * $product->stock_quantity;
                }),
                'lowStockProducts' => $products->filter(function ($product) {
                    return $product->isLowStock();
                }),
                'date' => Carbon::now(),
            ];

            return view('reports.exports.inventory', $data);
        }

        return redirect()->back()->with('error', 'Tipe laporan tidak valid');
    }
}
