<?php
require_once("aShoppingCartClass.php");
session_start();

$DBConnect = new mysqli("localhost", "root", "", "ggg");

if ($DBConnect->connect_error) {
    die("Database connection failed: " . $DBConnect->connect_error);
}

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $DBConnect->real_escape_string($_POST['customerNumber']);
    $password = $_POST['password'];

    $query = "SELECT * FROM customers WHERE customer_number = '$customerNumber'";
    $result = $DBConnect->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['customerNumber'] = $customerNumber;
            header("Location: ggg.php"); // Redirect to the main page after successful login
            exit();
        } else {
            echo "<p>Invalid password. Please try again.</p>";
        }
    } else {
        echo "<p>Customer number not found. Please register first.</p>";
    }

    $DBConnect->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="GosselinGourmet.css">
    <link rel="stylesheet" href="GosselinGourmetStyle.css">
    <title>Login - Gosselin Gourmet Goods</title>
</head>
<body>
    <div class="flex-container">
    <h1 class="header">Gosselin Gourmet Goods</h1>
    <h2>Login</h2>
    <form action="ggg.php" method="POST">
        <label for="customer-number">Customer Number:</label>
        <input type="text" id="customer-number" name="customer-number" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p class="footer">If you do not have an account, <a href="register.php">register here</a>.</p>
</div>

</body>
</html>
