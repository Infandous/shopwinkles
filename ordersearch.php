<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
// connect to server
$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// sanitize
$search = mysqli_real_escape_string($conn, $_GET['search']);

// set and send query
$query = "SELECT OrderInfo.OrderID, OrderInfo.Date_Purchased, OrderInfo.Expected_Delivery, Customer.Name 
            FROM OrderInfo
            JOIN Customer ON OrderInfo.CustomerID = Customer.CustomerID 
            WHERE OrderInfo.OrderID = '$search'";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

if(mysqli_num_rows($result)>0){
    echo '<div class="order-container">';
    $row = mysqli_fetch_assoc($result);
    echo '<div class="order-box">';
    echo '<p>' . $row['OrderID'] . '</p>';
    echo '<p> Customer Name: ' . $row['Name'] . '</p>';
    echo '<p> Date Purchased: ' . $row['Date_Purchased'] . '</p>';
    echo '<p> Delivery Date:' . $row['Expected_Delivery'] . '</p>';
    echo '</div>';
    echo '</div>';

$_GET['search'] = '';
}
mysqli_free_result($result);
mysqli_close($conn);
?>
