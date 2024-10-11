<?php
require_once("aShoppingCartClass.php");
session_start();

$DBConnect = new mysqli("localhost", "root", "", "ggg");

if ($DBConnect->connect_error) {
    die("Database connection failed: " . $DBConnect->connect_error);
}

// Process the registration form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerNumber = $DBConnect->real_escape_string($_POST['customerNumber']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO customers (customer_number, password) VALUES ('$customerNumber', '$password')";

    if ($DBConnect->query($query) === TRUE) {
        echo "<p>Registration successful! You can now <a href='login.php'>login</a>.</p>";
    } else {
        echo "<p>Error: " . $query . "<br>" . $DBConnect->error . "</p>";
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
    <title>Register - Gosselin Gourmet Goods</title>
</head>
<body>
<div class="container">
        <h1>Gosselin Gourmet Goods</h1>
        <h2>Register</h2>
        <form action="ggg.php" method="POST">
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
