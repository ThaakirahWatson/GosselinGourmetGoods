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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Gosselin Gourmet Goods</title>
    <meta http-equiv="content-type"
        content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" href="home.css" />
</head>

<body>
    <!--<h1>Gosselin Gourmet</h1>-->
    <!--<h2>Shop by Category</h2>-->
    <?php
    //echo "<p><a href='GosselinGourmetCoffee.php?PHPSESSID=" . session_id() . "'>Gourmet Coffees</a></p>\n";
    //echo "<p><a href='ElectronicsBoutique.php?PHPSESSID=" . session_id() . "'>Electronics Boutique</a></p>\n";
    //echo "<p><a href='OldTymeAntiques.php?PHPSESSID=" . session_id() . "'>Antiques</a></p>\n";
    echo "<h2>Shopping Cart</h2>\n";
    //Unpack back to an object and store in $Cart
    //$Cart = unserialize($_SESSION['curCart']);
    //Now one can work with the object **************
    /*echo "<p> Show the CART first </p>";
    echo "<p>In addItem in ShowCart.php Note 3 WcR in ShowCart</p>";*/
    $Store->processUserInput();
    $Store->showCart();
    $_SESSION['currentStore'] = serialize($Store);
    ?>


    <p><a href='<?php echo "Checkout.php?PHPSESSID=" . session_id() . "&operation=checkout" ?>'>Checkout</a></p>
    <p><a href="CancelOrder.php">Cancel Order</a></p>
</body>

</html>