<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'supermarket_customers');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}

// Fetch user ID
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

// Fetch purchase history
$stmt = $conn->prepare("SELECT products, total_price, purchase_date FROM purchases WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$purchases = [];
while ($row = $result->fetch_assoc()) {
    $purchases[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: url(Photos/login.svg) no-repeat;
            background-size: cover;
            color: #ffffff;
        }
        .container {
            padding: 40px;
            width: 80%;
            margin: 0 auto;
            background-color: #1f1f1f;
            border-radius: 10px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ffffff;
        }
        th {
            background-color: #333333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchase History</h1>
        <?php if (count($purchases) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Products</th>
                        <th>Total Price</th>
                        <th>Purchase Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchases as $purchase): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($purchase['products']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['purchase_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No purchase history found.</p>
        <?php endif; ?>
    </div>
</body>
</html>