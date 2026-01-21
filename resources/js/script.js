// Hamburger Menu Toggle
const hamburgerMenu = document.getElementById('hamburger-menu');
const sidebar = document.querySelector('.sidebar');

if (hamburgerMenu) {
    hamburgerMenu.addEventListener('click', () => {
        hamburgerMenu.classList.toggle('active');
        sidebar.classList.toggle('active');
    });

    // Close sidebar when clicking on a menu item
    const sidebarLinks = sidebar.querySelectorAll('a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburgerMenu.classList.remove('active');
            sidebar.classList.remove('active');
        });
    });

    // Close sidebar when clicking outside
    document.addEventListener('click', (e) => {
        if (!hamburgerMenu.contains(e.target) && !sidebar.contains(e.target)) {
            hamburgerMenu.classList.remove('active');
            sidebar.classList.remove('active');
        }
    });
}

const alertWindow = document.getElementById('alertWindow');

if (alertWindow) { // only run if alert exists
    const closeBtn = document.getElementById('closeAlert');

    alertWindow.style.display = 'block';

    function closeAlert() {
        alertWindow.classList.add('fade-out');
        setTimeout(() => {
            alertWindow.style.display = 'none';
            alertWindow.classList.remove('fade-out');
        }, 400); // matches animation duration
    }

    setTimeout(() => {
        closeAlert();
    }, 3000);

    closeBtn.addEventListener('click', () => {
        closeAlert();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mode-btns');
    const img = document.getElementById('modes');

    btn.addEventListener('click', () => {
        const moon = btn.dataset.moon;
        const sun = btn.dataset.sun;
        const mode = btn.dataset.mode;

        if (mode === 'dark') {
            img.src = sun;
            btn.dataset.mode = 'light';
            btn.classList.add('light');
        } else {
            img.src = moon;
            btn.dataset.mode = 'dark';
            btn.classList.remove('light');
        }
    });
});

const ddBtn = document.getElementById('dd-btn');
const dropdown = document.querySelector('.drop-down-window');

ddBtn.addEventListener('click', (e) => {
    e.stopPropagation(); // prevent document click
    ddBtn.classList.toggle('active');

    if (dropdown.style.display === 'flex') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'flex';
    }
});

dropdown.addEventListener('click', (e) => {
    e.stopPropagation(); // allow clicking inside dropdown
});

document.addEventListener('click', () => {
    dropdown.style.display = 'none';
    ddBtn.classList.remove('active');
});

document.querySelectorAll('.size-menu').forEach(menu => {
    const buttons = menu.querySelectorAll('.sizes');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            // remove active from all buttons in THIS size-menu
            buttons.forEach(b => b.classList.remove('active'));

            // add active to clicked button
            btn.classList.add('active');
        });
    });
});

// Stock input display
const stockInput = document.getElementById('product_stock');
const stockDisplay = document.getElementById('stock-display');
const stockMinus = document.getElementById('stockMinus');
const stockPlus = document.getElementById('stockPlus');
const statusInput = document.getElementById('product_status');

function updateStatus() {
    let value = parseInt(stockInput.value);
    statusInput.value = value > 0 ? 'Available' : 'Unavailable';
}

if (stockInput && stockDisplay) {
    stockInput.addEventListener('input', function() {
        stockDisplay.textContent = this.value;
        updateStatus();
    });
}

// Stock +/- buttons
if (stockMinus && stockPlus && stockInput) {
    stockMinus.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(stockInput.value);
        if (value > 1) {
            stockInput.value = value - 1;
            stockDisplay.textContent = stockInput.value;
            updateStatus();
        }
    });

    stockPlus.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(stockInput.value);
        if (value < 200) {
            stockInput.value = value + 1;
            stockDisplay.textContent = stockInput.value;
            updateStatus();
        }
    });
}

// Product Modal Management
const addProductBtn = document.querySelector('.add-product');
const popWindow = document.querySelector('.pop-window');
const addContainer = document.querySelector('.add-container');
const editContainer = document.querySelector('.edit-container');
const confirmContainer = document.querySelector('.confirm-container');
const closeModalAddBtn = document.getElementById('closeModalAdd');
const closeModalEditBtn = document.getElementById('closeModalEdit');

function closeModal() {
    popWindow.style.display = 'none';
    if (addContainer) addContainer.classList.remove('active');
    if (editContainer) editContainer.classList.remove('active');
    if (confirmContainer) confirmContainer.classList.remove('active');
}

function openAddModal() {
    popWindow.style.display = 'flex';
    if (addContainer) addContainer.classList.add('active');
    if (editContainer) editContainer.classList.remove('active');
}

function openEditModal() {
    popWindow.style.display = 'flex';
    if (editContainer) editContainer.classList.add('active');
    if (addContainer) addContainer.classList.remove('active');
}

if (addProductBtn && popWindow) {
    addProductBtn.addEventListener('click', (e) => {
        e.preventDefault();
        openAddModal();
    });
    
    // Close modal when clicking outside the containers
    popWindow.addEventListener('click', (e) => {
        if (e.target === popWindow) {
            closeModal();
        }
    });
    
    // Close modal when clicking close button for add
    if (closeModalAddBtn) {
        closeModalAddBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeModal();
        });
    }
    
    // Close modal when clicking close button for edit
    if (closeModalEditBtn) {
        closeModalEditBtn.addEventListener('click', (e) => {
            e.preventDefault();
            closeModal();
        });
    }
}

// Edit Product Modal
const editButtons = document.querySelectorAll('.edit-btn');
editButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const productName = this.getAttribute('data-name');
        const productPrice = this.getAttribute('data-price');
        const productSize = this.getAttribute('data-size');
        const productStock = this.getAttribute('data-stock');
        const productStatus = this.getAttribute('data-status');
        
        // Open edit modal
        openEditModal();
        
        // Set the form action to the edit route
        const editForm = document.getElementById('editProductForm');
        editForm.action = `/admin/products/${productId}`;
        
        // Populate form fields with product data
        document.getElementById('edit_product_name').value = productName;
        document.getElementById('edit_product_price').value = productPrice;
        document.getElementById('edit_product_size').value = productSize;
        document.getElementById('edit_product_stock').value = productStock;
        document.getElementById('edit-stock-display').textContent = productStock;
        document.getElementById('edit_product_status').value = productStatus;
    });
});

// Delete Product
const deleteButtons = document.querySelectorAll('.delete-btn');
let deleteProductId = null;

function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.getAttribute('content') : '';
}

deleteButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        deleteProductId = this.getAttribute('data-id');
        if (popWindow && confirmContainer) {
            popWindow.style.display = 'flex';
            confirmContainer.classList.add('active');
        }
    });
});

const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

if (confirmDeleteBtn) {
    confirmDeleteBtn.addEventListener('click', function() {
        if (!deleteProductId) return;
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/products/${deleteProductId}`;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = getCsrfToken();

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(token);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    });
}

if (cancelDeleteBtn) {
    cancelDeleteBtn.addEventListener('click', function() {
        closeModal();
        deleteProductId = null;
    });
}
const editStockInput = document.getElementById('edit_product_stock');
const editStockDisplay = document.getElementById('edit-stock-display');
const editStockMinus = document.getElementById('editStockMinus');
const editStockPlus = document.getElementById('editStockPlus');
const editStatusInput = document.getElementById('edit_product_status');

function updateEditStatus() {
    let value = parseInt(editStockInput.value);
    if (editStatusInput) {
        editStatusInput.value = value > 0 ? 'Available' : 'Unavailable';
    }
}

if (editStockInput && editStockDisplay) {
    editStockInput.addEventListener('input', function() {
        editStockDisplay.textContent = this.value;
        updateEditStatus();
    });
}

if (editStockMinus && editStockPlus && editStockInput) {
    editStockMinus.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(editStockInput.value);
        if (value > 1) {
            editStockInput.value = value - 1;
            editStockDisplay.textContent = editStockInput.value;
            updateEditStatus();
        }
    });

    editStockPlus.addEventListener('click', (e) => {
        e.preventDefault();
        let value = parseInt(editStockInput.value);
        if (value < 200) {
            editStockInput.value = value + 1;
            editStockDisplay.textContent = editStockInput.value;
            updateEditStatus();
        }
    });
}

// Orders Page - Status Change Modal
const statusButtons = document.querySelectorAll('.status-btn');
const statusContainer = document.querySelector('.status-container');
const statusOptions = document.querySelectorAll('.status-option');
const cancelStatusBtn = document.getElementById('cancelStatusBtn');
let currentOrderId = null;
let currentOrderStatus = null;

if (statusButtons.length > 0) {
    statusButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            currentOrderId = this.getAttribute('data-id');
            currentOrderStatus = this.getAttribute('data-status');
            
            if (popWindow && statusContainer) {
                popWindow.style.display = 'flex';
                statusContainer.classList.add('active');
                if (confirmContainer) confirmContainer.classList.remove('active');
                
                // Highlight current status
                statusOptions.forEach(opt => {
                    if (opt.getAttribute('data-status') === currentOrderStatus) {
                        opt.classList.add('selected');
                    } else {
                        opt.classList.remove('selected');
                    }
                });
            }
        });
    });
    
    // Handle status option click
    statusOptions.forEach(option => {
        option.addEventListener('click', function() {
            const newStatus = this.getAttribute('data-status');
            
            if (!currentOrderId) return;
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/orders/${currentOrderId}/status`;
            
            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = getCsrfToken();
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'PUT';
            
            const statusField = document.createElement('input');
            statusField.type = 'hidden';
            statusField.name = 'status';
            statusField.value = newStatus;
            
            form.appendChild(token);
            form.appendChild(method);
            form.appendChild(statusField);
            document.body.appendChild(form);
            form.submit();
        });
    });
    
    if (cancelStatusBtn) {
        cancelStatusBtn.addEventListener('click', function() {
            closeModal();
            currentOrderId = null;
            currentOrderStatus = null;
        });
    }
}

// Orders Page - Delete Order
const deleteOrderButtons = document.querySelectorAll('.delete-order-btn');
let deleteOrderId = null;

if (deleteOrderButtons.length > 0) {
    deleteOrderButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            deleteOrderId = this.getAttribute('data-id');
            
            if (popWindow && confirmContainer) {
                popWindow.style.display = 'flex';
                confirmContainer.classList.add('active');
                if (statusContainer) statusContainer.classList.remove('active');
            }
        });
    });
    
    // Update confirm delete button for orders
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            // Check if we're deleting an order or product
            if (deleteOrderId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/orders/${deleteOrderId}`;
                
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = getCsrfToken();
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            } else if (deleteProductId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${deleteProductId}`;
                
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = getCsrfToken();
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    if (cancelDeleteBtn) {
        cancelDeleteBtn.addEventListener('click', function() {
            closeModal();
            deleteOrderId = null;
            deleteProductId = null;
        });
    }
}

// Users Page - Toggle Status (Block/Unblock)
const toggleStatusButtons = document.querySelectorAll('.toggle-status-btn');

if (toggleStatusButtons.length > 0) {
    toggleStatusButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const action = currentStatus === 'active' ? 'block' : 'unblock';
            
            if (confirm(`Are you sure you want to ${action} this user?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}/toggle-status`;
                
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = getCsrfToken();
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'PUT';
                
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
}

// Users Page - Delete User
const deleteUserButtons = document.querySelectorAll('.delete-user-btn');
const confirmDeleteUserBtn = document.getElementById('confirmDeleteUserBtn');
const cancelDeleteUserBtn = document.getElementById('cancelDeleteUserBtn');
let deleteUserId = null;

if (deleteUserButtons.length > 0) {
    deleteUserButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            deleteUserId = this.getAttribute('data-id');
            
            if (popWindow && confirmContainer) {
                popWindow.style.display = 'flex';
                confirmContainer.classList.add('active');
            }
        });
    });
    
    if (confirmDeleteUserBtn) {
        confirmDeleteUserBtn.addEventListener('click', function() {
            if (deleteUserId) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${deleteUserId}`;
                
                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = getCsrfToken();
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                
                form.appendChild(token);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    if (cancelDeleteUserBtn) {
        cancelDeleteUserBtn.addEventListener('click', function() {
            closeModal();
            deleteUserId = null;
        });
    }
}