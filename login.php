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

    // Call the login method to log in the user
    $errorMessage = $Store->login($customerNumber, $password);
}
?>

<!DOCTYPE html>
<html>

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
        <?php if (!empty($errorMessage)) { ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php } ?>
        <form action="login.php" method="POST">
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