<?php
// Include the OnlineStore class file
include("class_OnlineStore.php");

function __construct() {
    include("inc_OnlineStoreDB.php");
    $this->DBConnect = $DBConnect;
    $this->createTables(); // Call the method to create tables when the class is instantiated
}

// Instantiate the OnlineStore class
$onlineStore = new OnlineStore();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the customer number and password from the form input
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    // Call the register method to register the user
    $onlineStore->register($customerNumber, $password);
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
