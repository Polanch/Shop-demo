<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        // Total sales metrics
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        // Sales by size (Pie Chart)
        $salesBySize = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('products.product_size', DB::raw('SUM(order_items.subtotal) as total'))
            ->groupBy('products.product_size')
            ->get();

        $sizeLabels = $salesBySize->pluck('product_size')->toArray();
        $sizeData = $salesBySize->pluck('total')->map(fn($val) => (float)$val)->toArray();

        // Top selling products (Bar Chart)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select(
                'products.product_name',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_sales')
            )
            ->groupBy('products.product_name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        $productLabels = $topProducts->pluck('product_name')->toArray();
        $productQuantities = $topProducts->pluck('total_quantity')->toArray();
        $productSales = $topProducts->pluck('total_sales')->map(fn($val) => (float)$val)->toArray();

        // Monthly sales (Bar Chart - Last 6 months)
        $monthlySales = Order::where('status', 'completed')
            ->where('order_date', '>=', now()->subMonths(5)->startOfMonth())
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('YEAR(order_date) as year'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthLabels = [];
        $monthData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabels[] = $date->format('M Y');
            
            $monthDataPoint = $monthlySales->first(function($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });
            
            $monthData[] = $monthDataPoint ? (float)$monthDataPoint->total : 0;
        }

        // Order status distribution (Doughnut Chart)
        $orderStatuses = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $statusLabels = $orderStatuses->pluck('status')->map(fn($s) => ucfirst($s))->toArray();
        $statusData = $orderStatuses->pluck('count')->toArray();

        return view('admin_sales', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'sizeLabels',
            'sizeData',
            'productLabels',
            'productQuantities',
            'productSales',
            'monthLabels',
            'monthData',
            'statusLabels',
            'statusData'
        ));
    }
}
