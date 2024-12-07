let cart = [];

// Load cart from localStorage if exists
document.addEventListener('DOMContentLoaded', () => {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartDisplay();
    }
});

// Add click event listeners to all product buttons
document.querySelectorAll('.product').forEach(button => {
    button.addEventListener('click', function() {
        const category = this.closest('.category').querySelector('.category-title').textContent;
        const buttonText = this.textContent;
        const productName = buttonText.substring(0, buttonText.lastIndexOf('-')).trim();
        const price = parseFloat(buttonText.split('₱')[1]);
        
        addToCart(category, productName, price);
    });
});

function addToCart(category, productName, price) {
    const existingItem = cart.find(item => item.product === productName);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            category: category,
            product: productName,
            price: price,
            quantity: 1
        });
    }
    
    // Save to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartList = document.getElementById('cartList');
    const totalAmount = document.getElementById('totalAmount');
    let total = 0;
    
    // Clear current cart
    cartList.innerHTML = '';
    
    // Add each item to cart
    cart.forEach((item, index) => {
        const li = document.createElement('li');
        li.className = 'cart-item';
        
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        li.innerHTML = `
            <span class="item-info">${item.product} x${item.quantity} - ₱${itemTotal.toFixed(2)}</span>
            <button type="button" class="remove-btn" data-index="${index}">Remove</button>
        `;
        
        cartList.appendChild(li);
    });
    
    // Update total
    totalAmount.textContent = total.toFixed(2);
    document.getElementById('cartData').value = JSON.stringify(cart);
}

// for remove buttons
document.getElementById('cartList').addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-btn')) {
        const index = parseInt(e.target.dataset.index);
        removeFromCart(index);
    }
});

// Form submission
document.getElementById('purchaseForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }
    
    try {
        const formData = new FormData(e.target);
        const response = await fetch('process_purchase.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        if (result.success) {
            alert('Purchase successful!');
            cart = [];
            localStorage.removeItem('cart');
            updateCartDisplay();
        } else {
            alert('Purchase failed: ' + result.error);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to process purchase');
    }
});