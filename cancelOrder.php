<?php
// Include the OnlineStore class file
include("class_OnlineStore.php");

function __construct() {
    include("inc_OnlineStoreDB.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancelled</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <div class="container">
        <h1>Your Order Has Been Cancelled</h1>
        <p>If you'd like to continue shopping, click the link below:</p>
        <a href="home.php" class="continue-shopping">Continue Shopping</a>
    </div>
</body>

</html>