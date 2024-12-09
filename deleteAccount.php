<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'supermarket_customers');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

try {
    $conn->begin_transaction();

    // Get user ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user['id'];
    $stmt->close();

    // Delete credit card credentials
    $stmt = $conn->prepare("DELETE FROM credit_card_credentials WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $conn->commit();
        session_unset();
        session_destroy();
        header("Location: register.html");
        exit();
    } else {
        throw new Exception("Error deleting user");
    }
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    $stmt->close();
    $conn->close();
}
?>