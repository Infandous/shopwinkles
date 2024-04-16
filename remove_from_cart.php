<?php
session_start();
// check if user signed in
if (!isset($_SESSION['customerID'])) {
    echo "User is not authenticated.";
    exit();
}

// make sure we have a productid
if (!isset($_POST['product_id'])) {
    echo "Product ID is missing.";
    exit();
}


$product_id = $_POST['product_id'];
// connect
$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    echo "Error: Could not connect to the database.";
    exit();
}
$customer_id = $_SESSION['customerID'];

// Remove the product from the cart
$sql = "DELETE FROM OrderInfo WHERE CustomerID = '$customer_id' AND ProductID = '$product_id' AND Date_Purchased IS NULL";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}
mysqli_close($conn);
header("Location: cart.html");
exit();
?>
