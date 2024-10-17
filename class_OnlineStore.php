<?php
class OnlineStore {
    private $DBConnect = NULL;
    private $storeID = "";
    private $inventory = array();
    private $shoppingCart = array();

    function __construct() {
        include("inc_OnlineStoreDB.php");
        $this->DBConnect = $DBConnect;
        // $this->createTables(); // Call the method to create tables when the class is instantiated
    }

    function __destruct() {
        if (!$this->DBConnect->connect_error) {
            $this->DBConnect->close();
        }
    }

    //  

    public function register($customerNumber, $password, $customerName, $customerEmail) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $SQLString = "INSERT INTO users (customerNumber, password, customerName, customerEmail) VALUES (?, ?, ?, ?)";
        $stmt = $this->DBConnect->prepare($SQLString);
        $stmt->bind_param("isss", $customerNumber, $hashedPassword, $customerName, $customerEmail);
        if ($stmt->execute()) {
            header("Location: login.php");

            echo "User registered successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    public function login($customerNumber, $password) {
        $SQLString = "SELECT * FROM users WHERE customerNumber = ?";
        $stmt = $this->DBConnect->prepare($SQLString);
        $stmt->bind_param("i", $customerNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['customerNumber'];
                header("Location: home.php");
                exit();
            } else {
                return "Invalid Customer Number or Password.";
            }
        } else {
            return "Invalid Customer Number or Password.";
        }
    }


    public function setStoreID($storeID) {
        if ($this->storeID != $storeID) {
            $this->storeID = $storeID;
            $SQLString = "SELECT * FROM inventory " .
                " WHERE storeID = '" .
                $this->storeID . "'";
            $QueryResult = @$this->DBConnect->query($SQLString);
            if ($QueryResult === FALSE) {
                $this->storeID = "";
            } else {
                $this->inventory = array();
                $this->shoppingCart = array();
                while (($Row = $QueryResult->fetch_assoc()) !== NULL) {
                    $this->inventory[$Row['productID']]
                        = array();
                    $this->inventory[$Row['productID']]['name']
                        = $Row['name'];
                    $this->inventory[$Row['productID']]['description']
                        = $Row['description'];
                    $this->inventory[$Row['productID']]['price']
                        = $Row['price'];
                    $this->shoppingCart[$Row['productID']]
                        = 0;
                }
            }
        }
    }

    public function getStoreInformation() {
        $retval = FALSE;
        if ($this->storeID != "") {
            $SQLString = "SELECT * FROM store_info WHERE storeID = '" . $this->storeID . "'";
            $QueryResult = @$this->DBConnect->query($SQLString);
            if ($QueryResult !== FALSE) {
                $retval = $QueryResult->fetch_assoc(); // This should populate store_info
            }
        }
        return $retval;
    }

    public function getProductList() {
        global $storeID;
        $retval = FALSE;
        $subtotal = 0;

        if (count($this->inventory) > 0) {
            echo "<table width='100%'>\n";
            echo "<tr><th>Product</th><th>Description</th>" .
                "<th>Price Each</th><th># in Cart</th>" .
                "<th>Total Price</th><th>&nbsp;</ th></tr>\n";
            foreach ($this->inventory as $ID => $Info) {
                echo "<tr><td>" .
                    htmlentities($Info['name'])
                    . "</td>\n";
                echo "<td>" .
                    htmlentities($Info['description']) .
                    "</td>\n";
                printf("<td class='currency'>$%.2f
                       </td>\n", $Info['price']);
                echo "<td class='currency'>" .
                    $this->shoppingCart[$ID] .
                    "</td>\n";
                printf("<td class='currency'>$%.2f
                       </td>\n", $Info['price'] *
                    $this->shoppingCart[$ID]);
                echo "<td><a href='" .
                    $_SERVER['SCRIPT_NAME'] .
                    "?PHPSESSID=" . session_id() .
                    "&ItemToAdd=$ID'>Add " .
                    " Item</a><br />\n";
                echo "<a href='" . $_SERVER['SCRIPT_NAME'] .
                    "?PHPSESSID=" . session_id() .
                    "&ItemToRemove=$ID'>Remove " .
                    " Item</a></td>\n";
                $subtotal += ($Info['price'] *
                    $this->shoppingCart[$ID]);
            }
            echo "<tr><td colspan='4'>Subtotal</td>\n";
            printf(
                "<td class='currency'>$%.2f</td>\n",
                $subtotal
            );
            echo "<td><a href='" . $_SERVER['SCRIPT_NAME'] . "?PHPSESSID=" . session_id() . "&EmptyCart=TRUE'>Empty " .
                " Cart</a></td></tr>\n";
            echo "</table>";
            echo "<p><a href='Checkout.php?PHPSESSID=" .
                session_id() . "&CheckOut=$storeID'>Checkout</a></p>\n";

            $retval = TRUE;
        }
        return ($retval);
    }

    public function showCart() {
        $subtotal = 0;
        $retval = FALSE;
        $count = 0;
        if (count($this->inventory) > 0) {
            echo "<table width='100%'>\n";
            echo "<tr><th>Product</th><th>Description</th>" .
                "<th>Price Each</th><th># in Cart</th>" .
                "<th>Total Price</th><th>&nbsp;</ th></tr>\n";
            foreach ($this->inventory as $ID => $Info) {
                if ($this->shoppingCart[$ID] !== 0) {
                    echo "<tr><td>" .
                        htmlentities($Info['name'])
                        . "</td>\n";
                    echo "<td>" .
                        htmlentities($Info['description']) .
                        "</td>\n";
                    printf("<td class='currency'>$%.2f
                       </td>\n", $Info['price']);
                    echo "<td class='currency'>" .
                        $this->shoppingCart[$ID] .
                        "</td>\n";
                    printf("<td class='currency'>$%.2f
                       </td>\n", $Info['price'] *
                        $this->shoppingCart[$ID]);
                    echo "<td><a href='" .
                        $_SERVER['SCRIPT_NAME'] .
                        "?PHPSESSID=" . session_id() .
                        "&ItemToAdd=$ID'>Add " .
                        " Item</a><br />\n";
                    echo "<a href='" . $_SERVER['SCRIPT_NAME'] .
                        "?PHPSESSID=" . session_id() .
                        "&ItemToRemove=$ID'>Remove " .
                        " Item</a></td>\n";
                    $subtotal += ($Info['price'] *
                        $this->shoppingCart[$ID]);
                }
            }
            echo "<tr><td colspan='4'>Subtotal</td>\n";
            printf(
                "<td class='currency'>$%.2f</td>\n",
                $subtotal
            );
            echo "<td><a href='" . $_SERVER['SCRIPT_NAME'] . "?PHPSESSID=" . session_id() . "&EmptyCart=TRUE'>Empty " .
                " Cart</a></td></tr>\n";
            echo "</table>";
            $retval = TRUE;
        }
        return ($retval);
    }

    // first statement retrieves the product ID that was appended to the Add Item link in the getProductList() function 
    // The second statement adds 1 to the count of that item in the $shoppingCart[] array.
    private function addItem() {
        $ProdID = $_GET['ItemToAdd'];
        if (array_key_exists($ProdID, $this->shoppingCart))
            $this->shoppingCart[$ProdID] += 1;
    }

    //function to restore the database connection
    function __wakeup() {
        include("inc_OnlineStoreDB.php");
        $this->DBConnect = $DBConnect;
    }

    // use the $_GET['ItemToRemove'] variable to identify the item. 
    // If the item is found and the value in the $shoppingCart[] array data member for that item is greater than 0, 
    // subtract 1 from the $shoppingCart[] array element.
    private function removeItem() {
        $ProdID = $_GET['ItemToRemove'];
        if (array_key_exists($ProdID, $this->shoppingCart))
            if ($this->shoppingCart[$ProdID] > 0)
                $this->shoppingCart[$ProdID] -= 1;
    }

    //empties the cart by setting the value of all the elements
    //of the $shoppingCart[] array data member to 0
    private function emptyCart() {
        foreach ($this->shoppingCart as $key => $value)
            $this->shoppingCart[$key] = 0;
    }

    //statements that call the appropriate member functions
    //based on elements found in the $_GET[] array
    public function processUserInput() {
        if (!empty($_GET['ItemToAdd']))
            $this->addItem();
        if (!empty($_GET['ItemToRemove']))
            $this->removeItem();
        if (!empty($_GET['EmptyCart']))
            $this->emptyCart();
    }

    //the foreach loop builds a SQL string for each product in the shopping cart
    //and inserts it into the database
    public function checkout() {
        $ProductsOrdered = 0;
        foreach ($this->shoppingCart as $productID => $quantity) {
            if ($quantity > 0) {
                ++$ProductsOrdered;
                $SQLString = "INSERT INTO orders " .
                    " (orderID, productId, quantity) " .
                    "VALUES('" . session_id() . "'," .
                    "'$productID', $quantity)";
                $QueryResult = $this->DBConnect->query($SQLString);
            }
        }
        echo "<p><strong>Your order has been recorded</strong></p>\n";
    }
}
