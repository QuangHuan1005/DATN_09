// Wishlist Handler - Chỉ xử lý nút trái tim có sẵn
console.log('Wishlist handler loaded');

// Wait for page to be fully loaded
window.addEventListener('load', function() {
    console.log('Page fully loaded');
    
    // Tìm tất cả nút wishlist có sẵn
    function initWishlistButtons() {
        const buttons = document.querySelectorAll('.nova_product_wishlist_btn, .add_to_wishlist');
        console.log('Found wishlist buttons:', buttons.length);
        
        buttons.forEach((button, index) => {
            // Remove existing listeners
            button.removeEventListener('click', handleWishlistClick);
            // Add new listener
            button.addEventListener('click', handleWishlistClick);
            console.log(`Button ${index} ready`);
        });
    }
    
    function handleWishlistClick(e) {
        e.preventDefault();
        e.stopPropagation();
        
        console.log('Wishlist button clicked!');
        
        const productId = this.getAttribute('data-product-id');
        console.log('Product ID:', productId);
        
        if (!productId) {
            showNotification('Không tìm thấy ID sản phẩm!', 'error');
            return;
        }
        
        // Check if user is authenticated
        const authCheck = document.querySelector('meta[name="auth-check"]');
        if (!authCheck || authCheck.getAttribute('content') !== 'true') {
            showNotification('Vui lòng đăng nhập để sử dụng chức năng wishlist!', 'error');
            return;
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            showNotification('Không tìm thấy CSRF token!', 'error');
            return;
        }
        
        console.log('CSRF Token:', csrfToken.getAttribute('content'));
        
        // Check if already in wishlist
        fetch('/wishlist/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => {
            console.log('Check response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Check result:', data);
            
            if (data.is_in_wishlist) {
                // Remove from wishlist
                fetch('/wishlist/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Đã xóa sản phẩm khỏi wishlist!', 'info');
                        // Change button appearance
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.style.color = '#ccc';
                        }
                        // Update wishlist count
                        document.dispatchEvent(new CustomEvent('wishlistUpdated'));
                    } else {
                        showNotification('Lỗi: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error removing from wishlist:', error);
                    showNotification('Có lỗi xảy ra khi xóa khỏi wishlist!', 'error');
                });
            } else {
                // Add to wishlist
                console.log('Adding to wishlist...');
                fetch('/wishlist/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => {
                    console.log('Add response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text().then(text => {
                        console.log('Add response text:', text);
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Failed to parse JSON:', e);
                            console.error('Response was:', text);
                            throw new Error('Server returned HTML instead of JSON. Check server logs.');
                        }
                    });
                })
                .then(data => {
                    console.log('Add result:', data);
                    if (data.success) {
                        showNotification('Thêm thành công vào Yêu thích!', 'success');
                        // Change button appearance
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.style.color = '#e74c3c';
                        }
                        // Update wishlist count
                        document.dispatchEvent(new CustomEvent('wishlistUpdated'));
                    } else {
                        showNotification('Lỗi: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error adding to wishlist:', error);
                    showNotification('Có lỗi xảy ra khi thêm vào wishlist!', 'error');
                });
            }
        })
        .catch(error => {
            console.error('Error checking wishlist:', error);
            showNotification('Có lỗi xảy ra khi kiểm tra wishlist!', 'error');
        });
    }
    
    // Show notification
    function showNotification(message, type = 'success') {
        // Remove existing notification
        const existingNotification = document.querySelector('.wishlist-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `wishlist-notification ${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-heart" style="color: #e74c3c; margin-right: 10px;"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Add CSS for notification
        notification.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border: 2px solid #e74c3c;
            border-radius: 8px;
            padding: 20px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 9999;
            font-size: 16px;
            color: #333;
            display: flex;
            align-items: center;
            animation: slideIn 0.3s ease-out;
        `;
        
        // Add animation CSS if not exists
        if (!document.querySelector('#wishlist-notification-styles')) {
            const style = document.createElement('style');
            style.id = 'wishlist-notification-styles';
            style.textContent = `
                @keyframes slideIn {
                    from { opacity: 0; transform: translate(-50%, -60%); }
                    to { opacity: 1; transform: translate(-50%, -50%); }
                }
                @keyframes slideOut {
                    from { opacity: 1; transform: translate(-50%, -50%); }
                    to { opacity: 0; transform: translate(-50%, -40%); }
                }
                .wishlist-notification.success { border-color: #27ae60; }
                .wishlist-notification.error { border-color: #e74c3c; }
                .wishlist-notification.info { border-color: #3498db; }
            `;
            document.head.appendChild(style);
        }
        
        // Add to body
        document.body.appendChild(notification);
        
        // Auto hide after 4 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }
    
    // Initialize
    initWishlistButtons();
    
    // Re-initialize after 2 seconds (in case of dynamic content)
    setTimeout(initWishlistButtons, 2000);
});
