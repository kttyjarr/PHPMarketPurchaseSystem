<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'supermarket_customers');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->begin_transaction();
        
        $cartData = json_decode($_POST['cartData'], true);
        $userId = $_SESSION['user_id'];
        
        $totalPrice = 0;
        $products = [];

        foreach ($cartData as $item) {
            $product = $item['product'];
            $price = floatval($item['price']);
            $quantity = intval($item['quantity']);
            
            $totalPrice += $price * $quantity;
            $products[] = [
                'product' => $product,
                'price' => $price,
                'quantity' => $quantity
            ];
        }

        $productsJson = json_encode($products);

        $stmt = $conn->prepare("INSERT INTO purchases (user_id, products, total_price) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $userId, $productsJson, $totalPrice);
        
        if (!$stmt->execute()) {
            throw new Exception("Error inserting purchase");
        }
        
        $conn->commit();
        echo json_encode(['success' => true]);
        
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}

$conn->close();