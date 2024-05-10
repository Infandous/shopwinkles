<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $address = $_POST['address'];
    $card_number = $_POST['card_number'];
    $cvv = $_POST['cvv'];
    $expiry_date = $_POST['expiry_date'];
    $save_card = isset($_POST['save_card']) ? 1 : 0;

    $customer_id = $_SESSION['customerID'];

    $conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    $sql = "SELECT OrderID FROM OrderInfo WHERE CustomerID = '$customer_id' AND Date_Purchased IS NULL";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $order_id = $row['OrderID'];

        // update Date_Purchased for the current OrderID
        $update_sql = "UPDATE OrderInfo 
        SET Date_Purchased = CURRENT_TIMESTAMP, 
            Expected_Delivery = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 3 DAY) WHERE OrderID = '$order_id' AND CustomerID = '$customer_id'";
        if (mysqli_query($conn, $update_sql)) {
            $_SESSION['order_id'] = $order_id;
            header("Location: order_successful.html");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    
    mysqli_close($conn);
    
}
?>
