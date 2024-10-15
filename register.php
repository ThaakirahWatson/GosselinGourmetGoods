<?php
session_start();
require_once("class_OnlineStore.php");

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<p>Passwords do not match. Please try again.</p>";
    } else {
        // Call the registration method
        $message = $onlineStore->registerUser($fullName, $email, $customerNumber, $password);
        if ($message) {
            echo $message; // Display message based on registration success or failure
        }
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
    <title>Register - Gosselin Gourmet Goods</title>
</head>
<body>
    <div class="container">
        <h1>Gosselin Gourmet Goods</h1>
        <h2>Register</h2>
        <form action="login.php" method="POST">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="customerNumber">Customer Number:</label>
            <input type="text" id="customerNumber" name="customerNumber" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>

            <button type="submit">Register</button>
        </form>
        <p class="footer">Already have an account? <a href="login.php">Login here.</a></p>
    </div>
</body>
</html>
