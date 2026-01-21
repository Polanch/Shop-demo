// Cart functionality
document.addEventListener('DOMContentLoaded', function() {
    // Image lazy load fade-in effect
    const productImages = document.querySelectorAll('.prod-pic');
    productImages.forEach(img => {
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', () => img.classList.add('loaded'));
            img.addEventListener('error', () => img.classList.add('loaded')); // Show even on error
        }
    });

    const cartBox = document.querySelector('.cart-box');
    const cartWindow = document.querySelector('.cart-window');
    const closeCart = document.querySelector('.close-cart');
    const ddBtn = document.getElementById('dd-btn');
    const dropDownWindow = document.getElementById('drop-down-window');
    const cartItemsContainer = document.querySelector('.cart-items');
    const totalAmountElement = document.querySelector('.total-amount');
    const emptyCartMessage = document.querySelector('.empty-cart-message');

    // Initialize cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Update cart display
    function updateCartDisplay() {
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
            totalAmountElement.textContent = '$0.00';
            cartBox.classList.remove('has-items');
            return;
        }

        cartBox.classList.add('has-items');
        
        let cartHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            cartHTML += `
                <div class="cart-item" data-index="${index}">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                    <div class="cart-item-details">
                        <h4 class="cart-item-name">${item.name}</h4>
                        <p class="cart-item-price">$${item.price.toFixed(2)}</p>
                        <div class="cart-item-quantity">
                            <button class="qty-btn minus" data-index="${index}">-</button>
                            <span class="qty-display">${item.quantity}</span>
                            <button class="qty-btn plus" data-index="${index}">+</button>
                        </div>
                    </div>
                    <button class="remove-item" data-index="${index}">&times;</button>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = cartHTML;
        totalAmountElement.textContent = `$${total.toFixed(2)}`;
        
        // Update cart badge
        const badge = cartBox.querySelector('::after') || cartBox;
        cartBox.style.setProperty('--cart-count', `"${cart.length}"`);
    }

    // Add to cart
    document.querySelectorAll('.add-to-cart-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Check if button is disabled
            if (this.disabled) {
                return;
            }
            
            const productCard = this.closest('.product-card');
            const productId = parseInt(this.dataset.productId);
            const name = productCard.querySelector('.product-name').textContent;
            const priceText = productCard.querySelector('.product-price').textContent;
            const price = parseFloat(priceText.replace('$', '').replace(',', ''));
            const image = productCard.querySelector('.prod-pic').src;
            const stock = parseInt(this.dataset.stock) || 0;

            // Check if item already exists
            const existingItemIndex = cart.findIndex(item => item.product_id === productId);
            
            if (existingItemIndex > -1) {
                // Check if we can add more based on stock
                if (cart[existingItemIndex].quantity < stock) {
                    cart[existingItemIndex].quantity += 1;
                } else {
                    alert(`Sorry, only ${stock} items available in stock!`);
                    return;
                }
            } else {
                cart.push({
                    product_id: productId,
                    name: name,
                    price: price,
                    image: image,
                    quantity: 1,
                    stock: stock
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
            
            // Show feedback
            this.textContent = 'Added!';
            this.style.background = '#27ae60';
            setTimeout(() => {
                this.textContent = 'Add to Cart';
                this.style.background = '';
            }, 1000);
        });
    });

    // Handle quantity changes and item removal
    cartItemsContainer.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent cart from closing
        const index = parseInt(e.target.dataset.index);
        
        if (e.target.classList.contains('plus')) {
            const item = cart[index];
            if (item.quantity < item.stock) {
                cart[index].quantity += 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
            } else {
                alert(`Sorry, only ${item.stock} items available in stock!`);
            }
        }
        
        if (e.target.classList.contains('minus')) {
            if (cart[index].quantity > 1) {
                cart[index].quantity -= 1;
            } else {
                cart.splice(index, 1);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
        
        if (e.target.classList.contains('remove-item')) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartDisplay();
        }
    });

    // Toggle cart window when cart icon is clicked
    cartBox.addEventListener('click', function(e) {
        e.stopPropagation();
        cartWindow.classList.toggle('active');
        updateCartDisplay();
    });

    // Close cart when close button is clicked
    closeCart.addEventListener('click', function() {
        cartWindow.classList.remove('active');
    });

    // Checkout button
    const checkoutButton = document.querySelector('.checkout-button');
    const paymentModal = document.getElementById('payment-modal');
    const closePayment = document.querySelector('.close-payment');
    const paymentForm = document.getElementById('payment-form');
    const paymentTotal = document.querySelector('.payment-total');
    const cardNumberInput = document.getElementById('card-number');
    const expiryInput = document.getElementById('expiry');
    const cvvInput = document.getElementById('cvv');

    // Format card number input
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue;
    });

    // Format expiry date input
    expiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        e.target.value = value;
    });

    // Only allow numbers in CVV
    cvvInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Open payment modal when checkout is clicked
    checkoutButton.addEventListener('click', function(e) {
        e.stopPropagation();
        
        if (cart.length === 0) {
            alert('Your cart is empty!');
            return;
        }

        // Calculate and display total
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        paymentTotal.textContent = `$${total.toFixed(2)}`;

        // Open payment modal
        paymentModal.classList.add('active');
        cartWindow.classList.remove('active');
    });

    // Close payment modal
    closePayment.addEventListener('click', function() {
        paymentModal.classList.remove('active');
        paymentForm.reset();
    });

    // Close payment modal when clicking outside
    paymentModal.addEventListener('click', function(e) {
        if (e.target === paymentModal) {
            paymentModal.classList.remove('active');
            paymentForm.reset();
        }
    });

    // Handle payment form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Calculate total
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        // Prepare order data
        const orderData = {
            items: cart,
            total: total
        };

        // Show loading state
        const confirmBtn = document.querySelector('.confirm-payment-btn');
        confirmBtn.textContent = 'Processing Payment...';
        confirmBtn.disabled = true;

        // Send to backend (you'll need to create this route)
        fetch('/consumer/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Clear cart
                cart = [];
                localStorage.removeItem('cart');
                
                // Show success message
                alert('Payment successful! Order ID: ' + data.order_id);
                
                // Reload page to reflect updated stock
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Could not process order'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error processing payment. Please try again.');
        })
        .finally(() => {
            confirmBtn.textContent = 'Confirm Payment';
            confirmBtn.disabled = false;
        });
    });

    // Toggle dropdown menu
    ddBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        ddBtn.classList.toggle('active');
        dropDownWindow.classList.toggle('active');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!cartWindow.contains(event.target) && !cartBox.contains(event.target)) {
            cartWindow.classList.remove('active');
        }
        if (!dropDownWindow.contains(event.target) && !ddBtn.contains(event.target)) {
            dropDownWindow.classList.remove('active');
            ddBtn.classList.remove('active');
        }
    });

    // Initial cart display
    updateCartDisplay();
});
