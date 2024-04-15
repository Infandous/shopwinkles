<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // connect to server
    $conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Generate a unique customerID
    $customerID = substr(uniqid('Cust'), 0, 7);
    //INSERT INTO `Customer` (`CustomerID`, `Name`, `Address`, `Phone_Number`, `Card_Number`, `CVV`, `Expiry_Date`, `Email`) 
    //VALUES ('0000000', 'Manual Test', NULL, '0000000000', NULL, NULL, NULL, 'test@manual.test');

    // Prepare SQL query
    $sql = "INSERT INTO Customer (CustomerID, Name, Address, Phone_Number, Card_Number, CVV, Expiry_Date, Password, Email) 
    VALUES ('$customerID', '$name', NULL, '$phone', NULL, NULL, NULL, '$password', '$email')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to sign-in page
        header("Location: signin.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>
