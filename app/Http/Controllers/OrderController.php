<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    // Display all orders for admin
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.product', 'user']);

        // Search by order ID or customer name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('id', 'like', "%{$request->search}%")
                  ->orWhere('customer_name', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'date_asc':
                    $query->orderBy('order_date', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('order_date', 'desc');
                    break;
                case 'amount_high':
                    $query->orderBy('total_amount', 'desc');
                    break;
                case 'amount_low':
                    $query->orderBy('total_amount', 'asc');
                    break;
                default:
                    $query->orderBy('order_date', 'desc');
            }
        } else {
            $query->orderBy('order_date', 'desc');
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('admin_orders', compact('orders'));
    }

    // Update order status
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $validated['status']]);

        return redirect()->route('admin.orders')->with('success', 'Order status updated successfully!');
    }

    // Delete order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete(); // OrderItems will be deleted automatically due to cascade

        return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
    }
}
