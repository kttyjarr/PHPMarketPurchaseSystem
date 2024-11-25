<?php

    $username = $_POST['username'];
    $password = $_POST['password'];
    

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'supermarket_customers');
    if ($conn->connect_error) {
        die('Connection Failed: ' .$conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        echo "Registration Successful";
        echo '<br><a href="login.html">Return to Login Page</a>';
        $stmt->close();
        $conn->close();
    }
?>