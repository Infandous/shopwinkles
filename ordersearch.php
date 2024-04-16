<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// connect to server
$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// sanitize
$search = mysqli_real_escape_string($conn, $_GET['search']);

// set and send query
$query = "SELECT * FROM OrderInfo WHERE OrderID = '$search'";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

echo '<div class="order-container">';
$row = mysqli_fetch_assoc($result);
echo '<div class="order-box">';
echo '<p>' . $row['OrderID'] . '</p>';
//echo '<p> Product Id: ' . $row['ProductID'] . '</p>';
//echo '<p> Customer Id: ' . $row['CustomerID'] . '</p>';
echo '<p> Date Purchased: ' . $row['Date_Purchased'] . '</p>';
echo '<p> Delivery Date:' . $row['Expected_Delivery'] . '</p>';
echo '</div>';
echo '</div>';

$_GET['search'] = '';

mysqli_free_result($result);
mysqli_close($conn);
?>
