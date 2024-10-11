<?php
session_start();
// $_SESSION = array();
require_once("class_OnlineStore.php");

$storeID = "ANTIQUE";
$storeInfo = array();

if (class_exists("OnlineStore")) {
    if (isset($_SESSION['currentStore']))
        $Store = unserialize($_SESSION['currentStore']);
    else {
        $Store = new OnlineStore();
    }
    $Store->setStoreID($storeID);
    $storeInfo = $Store->getStoreInformation();
    $Store->processUserInput();
} else {
    $ErrorMsgs[] = "The OnlineStore class is not available!";
    $Store = NULL;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $storeInfo['name']; ?></title>
    <link rel="stylesheet" href="<?php echo $storeInfo['css_file']; ?>" />
</head>

<body>
    <h1><?php echo htmlentities($storeInfo['name']); ?></h1>
    <h2><?php echo htmlentities($storeInfo['description']); ?></h2>
    <p><?php echo htmlentities($storeInfo['welcome']); ?></p>


    <?php                                     //shows the inventory in a table and sets the session variable
    $Store->getProductList();
    $_SESSION['currentStore'] = serialize($Store);
    ?>
</body>

</html>