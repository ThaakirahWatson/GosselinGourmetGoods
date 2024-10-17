<?php
session_start();
require_once("class_OnlineStore.php");
$storeID = $_SESSION['CheckOut'];
$storeInfo = array();
if (class_exists("OnlineStore")) {
    if (isset($_SESSION['currentStore']))
        $Store = unserialize($_SESSION['currentStore']);
    else {
        $Store = new OnlineStore();
    }
    $Store->setStoreID($storeID);
    $storeInfo = $Store->getStoreInformation();
} else {
    $ErrorMsgs[] = "The OnlineStore class is not available!";
    $Store = NULL;
}
?>
<!DOCTYPE html>
<html lang="">

<head>
    <title><?php echo $storeInfo['name']; ?> Checkout</title>
    <link rel="stylesheet" type="text/css" href="home.css" />
</head>

<body>
    <h1><?php echo ($storeInfo['name']); ?></h1>
    <h2>Checkout</h2>
    <?php
    if (isset($_SESSION['user_id'])) { // Check if user is logged in
        $Store->checkout();
    } else {
        echo "<p>You need to be logged in to checkout.</p>";
        echo "<p><a href='login.php'>Login</a></p>";
    }
    ?>
</body>

</html>