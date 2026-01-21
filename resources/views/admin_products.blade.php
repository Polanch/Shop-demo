@extends('layouts.admin')

@section('content')
    @if(session('success') || session('error'))
        <div class="alert-window {{ session('success') ? 'success' : 'error' }}" id="alertWindow">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            <button id="closeAlert">Close</button>
            <div class="alert-progress-bar"></div>
        </div>
    @endif

    <div class="products">
        <div class="product-head">
            <h6>Products</h6>
           <form method="GET" action="{{ route('admin.products') }}">
                <button type="button" class="add-product">Add Product</button>
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
                            <td>
                                @if($product->pictures)
                                    <img src="{{ asset('storage/' . $product->pictures) }}" class="tb-pic">
                                @else
                                    <img src="{{ Vite::asset('resources/images/empty.png') }}" class="tb-pic">
                                @endif
                            </td>
                            <td>{{ $product->product_name }}</td>
                            <td>${{ number_format($product->product_price, 2) }}</td>
                            <td>{{ $product->product_size }}</td>
                            <td>{{ $product->product_stock }}</td>
                            <td>{{ $product->product_status }}</td>
                            <td>
                                <button class="edit-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->product_name }}"
                                    data-price="{{ $product->product_price }}"
                                    data-size="{{ $product->product_size }}"
                                    data-stock="{{ $product->product_stock }}"
                                    data-status="{{ $product->product_status }}"
                                    data-picture="{{ $product->pictures }}">Edit</button>
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
    <div class="pop-window">
        <div class="add-container">
            <button class="close-modal-btn" id="closeModalAdd">×</button>
            <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h2>Add New Product</h2>
                
                @if($errors->any())
                    <div style="color: red; margin-bottom: 10px;">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}" required>

                <label for="product_price">Product Price:</label>
                <input type="number" id="product_price" name="product_price" step="0.01" value="{{ old('product_price') }}" required>

                <label for="product_size">Product Size:</label>
                <select id="product_size" name="product_size" required>
                    <option value="" disabled selected hidden>Select a size</option>
                    <option value="XXS" {{ old('product_size') == 'XXS' ? 'selected' : '' }}>XXS</option>
                    <option value="XS" {{ old('product_size') == 'XS' ? 'selected' : '' }}>XS</option>
                    <option value="S" {{ old('product_size') == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ old('product_size') == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ old('product_size') == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ old('product_size') == 'XL' ? 'selected' : '' }}>XL</option>
                    <option value="XXL" {{ old('product_size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                    <option value="3XL" {{ old('product_size') == '3XL' ? 'selected' : '' }}>3XL</option>
                </select>

                <label for="product_stock">Product Stock:</label>
                <div class="stock-control">
                    <button type="button" class="stock-btn stock-minus" id="stockMinus">−</button>
                    <input type="range" name="product_stock" id="product_stock" min="1" max="200" value="1">
                    <button type="button" class="stock-btn stock-plus" id="stockPlus">+</button>
                    <span id="stock-display">1</span>
                </div>

                <input type="hidden" id="product_status" name="product_status" value="Available">

                <label for="pictures">Product Picture:</label>
                <input type="file" id="pictures" name="pictures" accept="image/*">

                <button type="submit">Add Product</button>
            </form>
        </div>

        <div class="edit-container">
            <button class="close-modal-btn" id="closeModalEdit">×</button>
            <form action="" method="post" enctype="multipart/form-data" id="editProductForm">
                @csrf
                @method('PUT')
                <h2>Edit Product</h2>
                
                <label for="edit_product_name">Product Name:</label>
                <input type="text" id="edit_product_name" name="product_name" required>

                <label for="edit_product_price">Product Price:</label>
                <input type="number" id="edit_product_price" name="product_price" step="0.01" required>

                <label for="edit_product_size">Product Size:</label>
                <select id="edit_product_size" name="product_size" required>
                    <option value="" disabled selected hidden>Select a size</option>
                    <option value="XXS">XXS</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                    <option value="3XL">3XL</option>
                </select>

                <label for="edit_product_stock">Product Stock:</label>
                <div class="stock-control">
                    <button type="button" class="stock-btn stock-minus" id="editStockMinus">−</button>
                    <input type="range" name="product_stock" id="edit_product_stock" min="1" max="200" value="1">
                    <button type="button" class="stock-btn stock-plus" id="editStockPlus">+</button>
                    <span id="edit-stock-display">1</span>
                </div>

                <label for="edit_product_status">Product Status:</label>
                <select id="edit_product_status" name="product_status" required>
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>

                <label for="edit_pictures">Product Picture:</label>
                <input type="file" id="edit_pictures" name="pictures" accept="image/*">

                <button type="submit">Update Product</button>
            </form>
        </div>

        <div class="confirm-container">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
            <div class="confirm-buttons">
                <button id="confirmDeleteBtn" class="confirm-delete-btn">Delete</button>
                <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
@endsection
