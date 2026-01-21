<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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

    // Store a newly created product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_size' => 'required|string|max:50',
            'product_stock' => 'required|integer|min:1|max:500',
            'product_status' => 'required|string|in:Available,Unavailable',
            'pictures' => 'nullable|mimes:jpeg,png,jpg,gif|max:20480', // 20MB max, removed strict image validation
        ]);

        // Handle file upload
        $picturePath = null;
        if ($request->hasFile('pictures')) {
            $picturePath = $request->file('pictures')->store('products', 'public');
        }

        // Create product
        Product::create([
            'product_name' => $validated['product_name'],
            'product_price' => $validated['product_price'],
            'product_size' => $validated['product_size'],
            'product_stock' => $validated['product_stock'],
            'product_status' => $validated['product_status'],
            'pictures' => $picturePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_size' => 'required|string|max:50',
            'product_stock' => 'required|integer|min:0|max:500',
            'product_status' => 'required|string|in:Available,Unavailable',
            'pictures' => 'nullable|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        // Handle file upload
        if ($request->hasFile('pictures')) {
            // Delete old picture if exists
            if ($product->pictures) {
                Storage::disk('public')->delete($product->pictures);
            }
            $validated['pictures'] = $request->file('pictures')->store('products', 'public');
        }

        // Update product
        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete picture if exists
        if ($product->pictures) {
            Storage::disk('public')->delete($product->pictures);
        }

        // Delete product
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
}
