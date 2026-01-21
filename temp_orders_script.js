
// Orders Page JavaScript

// Change Order Status
const statusButtons = document.querySelectorAll('.status-btn');
const statusContainer = document.querySelector('.status-container');
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
                if (addContainer) addContainer.classList.remove('active');
                if (editContainer) editContainer.classList.remove('active');
                if (confirmContainer) confirmContainer.classList.remove('active');
            }
        });
    });
}

// Status option selection
const statusOptions = document.querySelectorAll('.status-option');
if (statusOptions.length > 0) {
    statusOptions.forEach(option => {
        option.addEventListener('click', function() {
            const newStatus = this.getAttribute('data-status');
            
            if (currentOrderId && newStatus) {
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
                
                const status = document.createElement('input');
                status.type = 'hidden';
                status.name = 'status';
                status.value = newStatus;
                
                form.appendChild(token);
                form.appendChild(method);
                form.appendChild(status);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
}

// Delete Order
const deleteOrderButtons = document.querySelectorAll('.delete-order-btn');
let deleteOrderId = null;

if (deleteOrderButtons.length > 0) {
    deleteOrderButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            deleteOrderId = this.getAttribute('data-id');
            if (popWindow && confirmContainer) {
                popWindow.style.display = 'flex';
                confirmContainer.classList.add('active');
                if (addContainer) addContainer.classList.remove('active');
                if (editContainer) editContainer.classList.remove('active');
                if (statusContainer) statusContainer.classList.remove('active');
            }
        });
    });
    
    // Update the confirm delete button to handle orders too
    if (confirmDeleteBtn) {
        const originalHandler = confirmDeleteBtn.onclick;
        confirmDeleteBtn.onclick = function() {
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
                // Original product delete handler
                if (originalHandler) originalHandler();
            }
        };
    }
}
