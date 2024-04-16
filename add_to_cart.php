<?php
session_start();

$name = isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
if (!$name) {
    header("Location: signin.html");
    exit();
}

$product = $_POST['product_id'];

$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

$product_id = mysqli_real_escape_string($conn, $product);
$customer_id = $_SESSION['customerID'];

$sql = "SELECT OrderID FROM OrderInfo WHERE CustomerID = '$customer_id' AND Date_Purchased IS NULL";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) == 0) {
    $order_id = generateUniqueID($conn);
} else {
    $row = mysqli_fetch_assoc($result);
    $order_id = $row['OrderID'];
}

$sql = "SELECT * FROM OrderInfo WHERE ProductID = '$product_id' AND OrderID = '$order_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $product_id = $row['ProductID'];
    
    $update_query = "UPDATE OrderInfo SET Quantity = Quantity + 1 WHERE CustomerID = '$customer_id' AND ProductID = '$product_id' AND Date_Purchased IS NULL";
    $update_result = mysqli_query($conn, $update_query);
    
    if (!$update_result) {
        echo "Error updating quantity: " . mysqli_error($conn);
        exit();
    }
    header("Location: cart.html");
} else {
    $insert_sql = "INSERT INTO OrderInfo (OrderID, ProductID, CustomerID, Date_Purchased, Expected_Delivery) VALUES ('$order_id', '$product_id', '$customer_id', NULL, NULL)";
    if (mysqli_query($conn, $insert_sql)) {
        echo "Product added to cart successfully.";
        header("Location: cart.html");
    } else {
        echo "Error adding product to cart: " . mysqli_error($conn);
    }
}

function generateUniqueID($conn) {
    $uniqueID = '';
    do {
        //should result in length 11
        $randomString = generateRandomString(8);
        $uniqueID = 'Ord' . $randomString;
        // make sure we didnt generate an ID that already exists
        $query = "SELECT COUNT(*) AS count FROM OrderInfo WHERE OrderID = '$uniqueID'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    } while ($row['count'] > 0);
    return $uniqueID;
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>
