<?php
    
        $username = $_POST['username'];
        $password = $_POST['password'];
        
    
        // Database connection
        $con = new mysqli ("localhost", "root", "", "supermarket_customers");
        if ($con->connect_error) {
            die("Failed to Connect to Server: " . $con->connect_error);
        } else {
            $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if ($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                if ($data['password'] === $password) {
                    echo "Login Successful";
                } else {
                    echo "Invalid Username or Password";
                }
            } else {
                echo "Invalid Username or Password";
            }
        }
?>