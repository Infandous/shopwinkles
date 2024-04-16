<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['name'])) {
    echo "User is not authenticated.";
    exit();
}

// Database connection
$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    echo "Error: Could not connect to the database.";
    exit();
}

// Retrieve customer ID from the session
$customer_id = $_SESSION['customerID'];

// Query to fetch cart items
$sql = "SELECT Product.Name, Product.Category, Product.Price, OrderInfo.Quantity, Product.ProductID
        FROM OrderInfo
        INNER JOIN Product ON OrderInfo.ProductID = Product.ProductID
        WHERE OrderInfo.CustomerID = '$customer_id' AND OrderInfo.Date_Purchased IS NULL";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

if (mysqli_num_rows($result) > 0) {
    // Display cart items
    echo '<div class="cart-items">';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="cart-item">';
        echo '<p>Name: ' . $row['Name'] . '</p>';
        echo '<p>Price: $' . $row['Price'] . '</p>';
        echo '<p>Quantity: ' . $row['Quantity'] . '</p>';
        echo '<form action="remove_from_cart.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
        echo '<button type="submit">Remove from Cart</button>';
        echo '</form>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "Your cart is empty.";
}

// Close the database connection
mysqli_close($conn);
?>
