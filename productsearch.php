<?php
// connect to server
$conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// sanitize
$search = mysqli_real_escape_string($conn, $_GET['search']);

// set and send query
$query = "SELECT * FROM Product WHERE Name LIKE '$search%'";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

echo '<div class="product-container">';
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        // Start a new row if count is divisible by 4 (four products per row)
        if ($count % 4 === 0) {
            echo '<div class="product-row">';
        }

        // Display product box
        echo '<div class="product-box">';
        echo '<p>' . $row['Name'] . '</p>';
        echo '<p>Category: ' . $row['Category'] . '</p>';
        echo '<p>Price: $' . $row['Price'] . '</p>';
        echo '<p>Rating: ' . ($row['Rating'] ?? 'N/A') . '</p>';

        echo '<form action="add_to_cart.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . $row['ProductID'] . '">';
        echo '<button type="submit">Add to Cart</button>';
        echo '</form>';
        
        echo '</div>';

        // End the row if count is divisible by 4 or it's the last product
        if (($count + 1) % 4 === 0 || $count === mysqli_num_rows($result) - 1) {
            echo '</div>'; // End product-row
        }

        $count++;
    }

echo '</div>';
$_GET['search'] = '';

mysqli_free_result($result);
mysqli_close($conn);
?>
