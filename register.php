<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$cardNumber = $_POST['cardNumber'];
$cardHolderName = $_POST['cardHolderName'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'supermarket_customers');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    // Insert user details into users table
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        // Get the user ID of the newly created user
        $user_id = $stmt->insert_id;

        // Insert credit card details into credit_card_credentials table
        $stmt = $conn->prepare("INSERT INTO credit_card_credentials (user_id, card_number, card_holder_name, expiry_date, cvv) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $cardNumber, $cardHolderName, $expiryDate, $cvv);
        $stmt->execute();

        $_SESSION['username'] = $username;
        header("Location: registersuccessful.html");
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    exit();
}
?>