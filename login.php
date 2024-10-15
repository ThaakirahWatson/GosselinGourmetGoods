<?php
session_start();
require_once("class_OnlineStore.php");

// Process the login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    // Call the login method
    $message = $onlineStore->loginUser($customerNumber, $password);
    if ($message) {
        echo $message; // Display error message if login fails
    }
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
        <form action="GosselinGourmetCoffee.php" method="POST">
            <label for="customerNumber">Customer Number:</label>
            <input type="text" id="customerNumber" name="customerNumber" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
        <p class="footer">If you do not have an account, <a href="register.php">register here</a>.</p>
    </div>
</body>
</html>
