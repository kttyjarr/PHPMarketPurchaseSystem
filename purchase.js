document.addEventListener('DOMContentLoaded', function() {
    const cartList = document.getElementById('cartList');
    const totalAmount = document.getElementById('totalAmount');
    let total = 0;


    document.querySelectorAll('.product').forEach(button => {
        button.addEventListener('click', function() {

            const productText = this.textContent;
            const price = parseFloat(productText.match(/₱(\d+\.?\d*)/)[1]);
            
            // Create list item
            const li = document.createElement('li');
            li.className = 'cart-item';
            

            li.innerHTML = `
                ${productText}
                <button class="remove-item">×</button>
            `;
            
            
            const removeBtn = li.querySelector('.remove-item');
            removeBtn.addEventListener('click', function() {
                total -= price;
                totalAmount.textContent = total.toFixed(2);
                li.remove();
            });
            
            
            cartList.appendChild(li);
            total += price;
            totalAmount.textContent = total.toFixed(2);
        });
    });
});