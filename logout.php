<?php
// Include the OnlineStore class file
include("class_OnlineStore.php");

function __construct() {
    include("inc_OnlineStoreDB.php");
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the customer number and password from the form input
    $customerNumber = $_POST['customerNumber'];
    $password = $_POST['password'];

    // Call the login method to log in the user
    $onlineStore->login($customerNumber, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="home.css" />
</head>

<body>

    <h1>Logout Successful</h1>
    <p>You have successfully logged out.</p>
    <p>If you would like to log back in, please click the button below:</p>

    <!-- Centered Login Button -->
    <div class="login-container">
        <a href="login.php" class="login-button">Login</a>
    </div>

</body>

</html>