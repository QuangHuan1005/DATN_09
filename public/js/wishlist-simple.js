// Simple Wishlist JavaScript - No conflicts
console.log('Simple wishlist script loaded');

// Wait for page to be fully loaded
window.addEventListener('load', function() {
    console.log('Page fully loaded');
    
    // Add click handlers to wishlist buttons
    function addWishlistHandlers() {
        const buttons = document.querySelectorAll('.add_to_wishlist');
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
            alert('Không tìm thấy ID sản phẩm!');
            return;
        }
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('Không tìm thấy CSRF token!');
            return;
        }
        
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
        .then(response => response.json())
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
                        alert('Đã xóa sản phẩm khỏi wishlist!');
                        // Change button appearance
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.style.color = '#ccc';
                        }
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error removing from wishlist:', error);
                    alert('Có lỗi xảy ra khi xóa khỏi wishlist!');
                });
            } else {
                // Add to wishlist
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
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đã thêm sản phẩm vào wishlist!');
                        // Change button appearance
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.style.color = '#e74c3c';
                        }
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error adding to wishlist:', error);
                    alert('Có lỗi xảy ra khi thêm vào wishlist!');
                });
            }
        })
        .catch(error => {
            console.error('Error checking wishlist:', error);
            alert('Có lỗi xảy ra khi kiểm tra wishlist!');
        });
    }
    
    // Initialize
    addWishlistHandlers();
    
    // Re-initialize after 2 seconds (in case of dynamic content)
    setTimeout(addWishlistHandlers, 2000);
});
