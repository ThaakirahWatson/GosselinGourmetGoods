<?php

session_start();
require_once("class_OnlineStore.php");
if (class_exists("OnlineStore")) {
    if (isset($_SESSION['currentStore'])) {
        $Store = unserialize($_SESSION['currentStore']);
    } else {
        $Store = new OnlineStore();
    }
} else {

    $ErrorMsgs[] = "The OnlineStore class is not available!";
    $Store = NULL;
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the customer number and password from the form input
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];
    $customerName = $_POST['fullName'];
    $customerEmail = $_POST['email'];

    // Call the register method to register the user
    $Store->register($customerNumber, $password, $customerName, $customerEmail);
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
        <form action="register.php" method="POST">
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