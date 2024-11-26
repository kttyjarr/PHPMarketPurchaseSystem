<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase</title>
    <link rel="stylesheet" href="purchase.css">
</head>
<body>
    <h1>The Grocery Hub</h1>
    <div class="container">
        <div class="categories">
            <div class="category">
                <div class="category-title">Food & Beverages</div>
                <button class="product">Rice (1 kg) - ₱50.0</button>
                <button class="product">Bread (loaf) - ₱60.0</button>
                <button class="product">Eggs (1 dozen) - ₱100.0</button>
                <button class="product">Chicken (1 kg) - ₱180.0</button>
                <button class="product">Pork (1 kg) - ₱250.0</button>
                <button class="product">Cooking Oil (1 liter) - ₱150.0</button>
                <button class="product">Milk (1 liter) - ₱90.0</button>
                <button class="product">Coffee (100 g) - ₱120.0</button>
                <button class="product">Sugar (1 kg) - ₱55.0</button>
                <button class="product">Soft Drinks (1.5 liters) - ₱70.0</button>
            </div>
            
            <div class="category">
                <div class="category-title">Snacks</div>
                <button class="product">Potato Chips (Large Pack) - ₱65.0</button>
                <button class="product">Biscuits (Pack) - ₱50.0</button>
                <button class="product">Chocolate Bar (1 piece) - ₱80.0</button>
                <button class="product">Instant Noodles (Pack) - ₱20.0</button>
            </div>
            <div class="category">
                <div class="category-title">Fruits & Vegetables</div>
                <button class="product">Bananas (1 kg) - ₱60.0</button>
                <button class="product">Apples (1 kg) - ₱150.0</button>
                <button class="product">Carrots (1 kg) - ₱80.0</button>
                <button class="product">Tomatoes (1 kg) - ₱70.0</button>
                <button class="product">Onions (1 kg) - ₱120.0</button>
                <button class="product">Garlic (1 kg) - ₱180.0</button>
            </div>
            <div class="category">
                <div class="category-title">Beverages</div>
                <button class="product">Bottled Water (1 liter) - ₱20.0</button>
                <button class="product">Juice Juice (1L) - ₱95.0</button>
                <button class="product">Beer (Can) - ₱60.0</button>
            </div>
            <div class="category">
                <div class="category-title">Spices & Condiments</div>
                <button class="product">Salt (1kg) - ₱25.0</button>
                <button class="product">Soy Sauce (500ml) - ₱40.0</button>
                <button class="product">Vinegar (500ml) - ₱45.0</button>
                <button class="product">Black Pepper (50g) - ₱35.0</button>
            </div>
        </div>
        
        <div class="cart">
            <form id="purchaseForm" method="POST" action="process_purchase.php">
                <div class="cart-header">Your Cart</div>
                
                <div class="cart-items">
                    <ul id="cartList"></ul>
                </div>
                <div class="total-section">Total: ₱<span id="totalAmount">0.00</span></div>
                <input type="hidden" name="cartData" id="cartData">
                <button type="submit" id="submit-button" class="submit-button">Buy</button>
            </form>
        </div>
    </div>
    <script src="purchase.js"></script>
</body>
</html>