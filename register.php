<?php
    session_start();

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'supermarket_customers');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: registersuccesul.html");
            exit(); 
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
        exit();
    }
?>