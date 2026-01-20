<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Fetch all products for admin panel
    public function adminIndex(Request $request)
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('product_name', 'like', "%{$request->search}%");
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name':
                    $query->orderBy('product_name');
                    break;
                case 'date':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_low':
                    $query->orderBy('product_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('product_price', 'desc');
                    break;
                case 'stock_low':
                    $query->orderBy('product_stock', 'asc');
                    break;
                case 'stock_high':
                    $query->orderBy('product_stock', 'desc');
                    break;
            }
        }

        // Pagination
        $products = $query->paginate(10)->withQueryString(); // keep search/sort in query string

        return view('admin_products', compact('products'));
}
}
