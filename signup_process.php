<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
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

    // generate uniquie customerID
    $customerID = generateUniqueID($conn);

    // write query
    $sql = "INSERT INTO Customer (CustomerID, Name, Address, Phone_Number, Card_Number, CVV, Expiry_Date, Password, Email) 
    VALUES ('$customerID', '$name', NULL, '$phone', NULL, NULL, NULL, '$password', '$email')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to sign-in page
        header("Location: signin.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        header("Location: signup.html");
    }
    mysqli_close($conn);
}


function generateUniqueID($conn) {
    $uniqueID = '';
    do {
        //should result in length 11
        $randomString = generateRandomString(8);
        $uniqueID = 'Cus' . $randomString;
        // make sure we didnt generate an ID that already exists
        $query = "SELECT COUNT(*) AS count FROM Customer WHERE CustomerID = '$uniqueID'";
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
