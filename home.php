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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <h1>Online Store</h1>
    <p>Welcome!</p>
    <h2>Visit Our Stores</h2>
    <div class="store-list">
        <div class="store-item">
            <a href="OldTymeAntiques.php">Old Tyme Antiques</a>
            <p class="store-description">Offers a variety of antique furniture.</p>
            <img src="images/antique.jpeg" alt="Old Tyme Antiques" class="store-image">
        </div>
        <div class="store-item">
            <a href="GosselinGourmetCoffee.php">Gosselin Gourmet Coffee</a>
            <p class="store-description">Offers a variety of coffee types that you didn't know existed.</p>
            <img src="images/coffee.jpeg" alt="Gosselin Gourmet Coffee" class="store-image">
        </div>
        <div class="store-item">
            <a href="ElectronicsBoutique.php">Electronics Boutique</a>
            <p class="store-description">Sells a variety of electronic items.</p>
            <img src="images/electronic.jpeg" alt="Electronics Boutique" class="store-image">
        </div>
    </div>
    <div class="logout-container">
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>

</html>