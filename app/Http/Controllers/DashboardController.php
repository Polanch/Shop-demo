<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedSize = $request->query('size', 'All');

        // Calculate total stocks for the selected size
        if ($selectedSize === 'All') {
            $totalStocks = Product::where('product_status', 'Available')
                ->sum('product_stock');
        } else {
            $totalStocks = Product::where('product_size', $selectedSize)
                ->where('product_status', 'Available')
                ->sum('product_stock');
        }

        // Calculate total orders
        $totalOrders = Order::count();

        // Calculate total profit (sum of all completed orders)
        $totalProfit = Order::where('status', 'completed')->sum('total_amount');

        // Calculate total sold items for selected size
        if ($selectedSize === 'All') {
            $totalSold = OrderItem::sum('quantity');
        } else {
            $totalSold = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.product_size', $selectedSize)
                ->sum('order_items.quantity');
        }

        // Available sizes
        $sizes = ['All', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', '3XL'];

        // Get stock count for each size
        $stockBySize = [];
        foreach ($sizes as $size) {
            if ($size === 'All') {
                $stockBySize[$size] = Product::where('product_status', 'Available')
                    ->sum('product_stock');
            } else {
                $stockBySize[$size] = Product::where('product_size', $size)
                    ->where('product_status', 'Available')
                    ->sum('product_stock');
            }
        }

        // Get sales data for the last 7 days for the chart
        if ($selectedSize === 'All') {
            // Overall sales
            $salesData = Order::where('status', 'completed')
                ->where('order_date', '>=', now()->subDays(6))
                ->select(
                    DB::raw('DATE(order_date) as date'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            // Sales by specific size
            $salesData = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', 'completed')
                ->where('orders.order_date', '>=', now()->subDays(6))
                ->where('products.product_size', $selectedSize)
                ->select(
                    DB::raw('DATE(orders.order_date) as date'),
                    DB::raw('SUM(order_items.subtotal) as total')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // Fill in missing dates with 0
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('M d');
            
            $dayData = $salesData->firstWhere('date', $date);
            $chartData[] = $dayData ? (float)$dayData->total : 0;
        }

        return view('admin_dashboard', compact(
            'totalStocks',
            'totalOrders',
            'totalProfit',
            'totalSold',
            'selectedSize',
            'sizes',
            'stockBySize',
            'chartLabels',
            'chartData'
        ));
    }
}
