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

    <div class="orders">
        <div class="order-head">
            <h6>Orders</h6>
            <form method="GET" action="{{ route('admin.orders') }}">
                <input type="text" name="search" placeholder="Search orders" value="{{ request('search') }}">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <select name="sort" onchange="this.form.submit()">
                    <option value="" disabled selected hidden>Sort by</option>
                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Newest)</option>
                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (Oldest)</option>
                    <option value="amount_high" {{ request('sort') == 'amount_high' ? 'selected' : '' }}>Amount (High)</option>
                    <option value="amount_low" {{ request('sort') == 'amount_low' ? 'selected' : '' }}>Amount (Low)</option>
                </select>
            </form>
        </div>
        <div class="order-table">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name ?? $order->user->name ?? 'Guest' }}</td>
                            <td>
                                <div class="order-items">
                                    @foreach($order->orderItems as $item)
                                        <div class="order-item">
                                            {{ $item->quantity }}x {{ $item->product->product_name ?? 'Deleted Product' }} ({{ $item->product->product_size ?? 'N/A' }})
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                            <td>
                                <button class="status-btn" data-id="{{ $order->id }}" data-status="{{ $order->status }}">Status</button>
                                <button class="delete-order-btn" data-id="{{ $order->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="order-footer">
            <div class="pagination-info">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
            </div>
            <div class="pagination-buttons">
                <button 
                    @if($orders->onFirstPage()) disabled @endif
                    onclick="window.location='?page={{ $orders->currentPage() - 1 }}&search={{ request('search') }}&status={{ request('status') }}&sort={{ request('sort') }}'">
                    Previous
                </button>
                <button 
                    @if(!$orders->hasMorePages()) disabled @endif
                    onclick="window.location='?page={{ $orders->currentPage() + 1 }}&search={{ request('search') }}&status={{ request('status') }}&sort={{ request('sort') }}'">
                    Next
                </button>
            </div>
        </div>
    </div>

    <div class="pop-window">
        <div class="status-container">
            <h2>Change Order Status</h2>
            <div class="status-options">
                <div class="status-option pending" data-status="pending">
                    Pending
                </div>
                <div class="status-option completed" data-status="completed">
                    Completed
                </div>
                <div class="status-option cancelled" data-status="cancelled">
                    Cancelled
                </div>
            </div>
            <button id="cancelStatusBtn" class="cancel-btn">Cancel</button>
        </div>

        <div class="confirm-container">
            <h2>Confirm Delete</h2>
            <p>Are you sure you want to delete this order? This action cannot be undone.</p>
            <div class="confirm-buttons">
                <button id="confirmDeleteBtn" class="confirm-delete-btn">Delete</button>
                <button id="cancelDeleteBtn" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
@endsection