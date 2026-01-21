<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="/build/assets/consumer_style-ts1IZ2Fh.css">
</head>
<body>
    <div class="top-nav">
        <div class="logo-container">
            <img src="/images/mylogo.png" id="mylogo">
            <h1>Yame T-Shirt Company</h1>
        </div>
        <div class="profile-menu">
            <div class="pfp"><img src="/images/pfp.png" id="pfp"></div>
            <div class="username-box">{{ auth()->user()->username ?? 'Guest' }}</div>
            <div class="notification-box"><img src="/images/notif.png" id="notif"></div>
            <div class="cart-box"><img src="/images/cart.png" id="cart"></div>
            <div class="drop-down-button" id="dd-btn"><img src="/images/arrow.png" id="arrow"></div>
        </div>
        <div class="drop-down-window" id="drop-down-window">
            <ul class="dd-menu">
                <li>
                    <a href="#">
                        <img src="/images/pfp.png" class="dd-icons">
                        <p>Profile</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="/images/dd3.png" class="dd-icons">
                        <p>Settings</p>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%; height: 100%; margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; width: 100%; height: 100%; display: grid; grid-template-columns: 30px auto; grid-template-rows: 1fr; color: black; padding: 0; text-align: left;">
                            <img src="/images/dd4.png" class="dd-icons" style="transform: rotate(180deg);">
                            <p style="width: 100%; height: 100%; display: flex; align-items: center; padding-left: 15px; margin: 0;">Logout</p>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <div class="right-nav">
        <ul class="nav-section">
            <li>Home</li>
            <li>Trending</li>
            <li>For You</li>
            <li>New Releases</li>
        </ul>
        <ul class="filter-section">
            <li>Recently Added</li>
            <li>Favorites</li>
            <li>Most Popular</li>
            <li>Recommended</li>
        </ul>
        <ul class="sort-section">
            <li>Price Low</li>
            <li>Price High</li>
        </ul>
    </div>
    <div class="main-shop">
        <div class="searchbar-container">
            <input type="text" name="" id="search-bar" placeholder="Search for you Shirt">
            <img src="/images/search.png" id="search-icon">
        </div>
        <div class="product-container">
            @foreach($products as $product)
                <div class="product-card {{ $product->product_stock == 0 ? 'sold-out' : '' }}">
                    <div class="product-image">
                        @if($product->pictures)
                            <img src="{{ asset('storage/' . $product->pictures) }}" class="prod-pic">
                        @else
                            <img src="/images/empty.png" class="prod-pic">
                        @endif
                        @if($product->product_stock == 0)
                            <div class="sold-out-overlay">
                                <span>SOLD OUT</span>
                            </div>
                        @endif
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">{{ $product->product_name }}</h4>
                        <p class="product-price">${{ number_format($product->product_price, 2) }}</p>
                        @if($product->product_stock > 0 && $product->product_stock <= 5)
                            <p class="stock-warning">Only {{ $product->product_stock }} left!</p>
                        @endif
                    </div>
                    <button class="add-to-cart-button" {{ $product->product_stock == 0 ? 'disabled' : '' }} data-product-id="{{ $product->id }}" data-stock="{{ $product->product_stock }}">
                        {{ $product->product_stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Cart Window -->
    <div class="cart-window">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <button class="close-cart">&times;</button>
        </div>
        <div class="cart-items">
            <!-- Cart items will be dynamically added here -->
            <p class="empty-cart-message">Your cart is empty</p>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span class="total-amount">$0.00</span>
            </div>
            <button class="checkout-button">Checkout</button>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="payment-modal" id="payment-modal">
        <div class="payment-container">
            <div class="payment-header">
                <h3>Payment Details</h3>
                <button class="close-payment">&times;</button>
            </div>
            <form id="payment-form">
                <div class="form-group">
                    <label for="card-name">Cardholder Name</label>
                    <input type="text" id="card-name" placeholder="John Doe" required>
                </div>
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry">Expiry Date</label>
                        <input type="text" id="expiry" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" placeholder="123" maxlength="3" required>
                    </div>
                </div>
                <div class="payment-summary">
                    <span>Total Amount:</span>
                    <span class="payment-total">$0.00</span>
                </div>
                <button type="submit" class="confirm-payment-btn">Confirm Payment</button>
            </form>
        </div>
    </div>

    <script src="/build/assets/consumer_script-CPanSm2g.js"></script>
</body>
</html>