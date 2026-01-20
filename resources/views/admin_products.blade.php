@extends('layouts.admin')

@section('content')
    <div class="products">
        <div class="product-head">
            <h6>Products</h6>
           <form method="GET" action="{{ route('admin.products') }}">
                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                
                <select name="sort" onchange="this.form.submit()">
                    <option value="" disabled selected hidden>Sort by</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Date</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price Low</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price High</option>
                    <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stock Low</option>
                    <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stock High</option>
                </select>
            </form>
        </div>
        <div class="product-table">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Name</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td><img src="{{ Vite::asset('resources/images/side-4.png') }}" class="tb-pic"></td>
                            <td>{{ $product->product_name }}</td>
                            <td>${{ number_format($product->product_price, 2) }}</td>
                            <td>{{ $product->product_size }}</td>
                            <td>{{ $product->product_stock }}</td>
                            <td>{{ $product->product_status }}</td>
                            <td>
                                <button class="edit-btn" data-id="{{ $product->id }}">Edit</button>
                                <button class="delete-btn" data-id="{{ $product->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="product-footer">
            <div class="pagination-info">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
            </div>
            <div class="pagination-buttons">
                <button 
                    @if($products->onFirstPage()) disabled @endif
                    onclick="window.location='?page={{ $products->currentPage() - 1 }}'">
                    Previous
                </button>

                <!-- Next button -->
                <button 
                    @if(!$products->hasMorePages()) disabled @endif
                    onclick="window.location='?page={{ $products->currentPage() + 1 }}'">
                    Next
                </button>
            </div>
        </div>
    </div>
@endsection