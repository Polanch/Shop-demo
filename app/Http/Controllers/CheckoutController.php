<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $request->validate([
                'items' => 'required|array',
                'items.*.product_id' => 'required|integer',
                'items.*.name' => 'required|string',
                'items.*.price' => 'required|numeric',
                'items.*.quantity' => 'required|integer|min:1',
                'total' => 'required|numeric'
            ]);

            // Get authenticated user's name
            $customerName = Auth::check() ? Auth::user()->username : 'Guest';

            // Create order
            $order = Order::create([
                'user_id' => Auth::id() ?? null,
                'customer_name' => $customerName,
                'total_amount' => $request->total,
                'status' => 'pending',
                'order_date' => now()
            ]);

            // Create order items and update stock
            foreach ($request->items as $item) {
                // Find product by ID
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product not found with ID: " . $item['product_id']);
                }

                // Check stock
                if ($product->product_stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for: " . $item['name']);
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price_at_purchase' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);

                // Reduce stock
                $product->product_stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
