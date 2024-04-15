<?php
// Start or resume the session
session_start();

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
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $cardnumber = mysqli_real_escape_string($conn, $_POST['cardnumber']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
    $exp_date = mysqli_real_escape_string($conn, $_POST['exp_date']);

    if ($name) $updates[] = "name = '$name'";
    if ($email) $updates[] = "email = '$email'";
    if ($phone) $updates[] = "phone = '$phone'";
    if ($password) $updates[] = "password = '$password'";
    if ($address) $updates[] = "address = '$address'";
    if ($cardnumber) $updates[] = "cardnumber = '$cardnumber'";
    if ($cvv) $updates[] = "cvv = '$cvv'";
    if ($exp_date) $updates[] = "exp_date = '$exp_date'";


    // Prepare the SQL query
    $query = "UPDATE users SET ";
    $updates = [];
    $conditions = [];
    //get customer ID
    $customerID = $_SESSION['customerID']; 
    $conditions[] = "CustomerID = '$customerID'";

    if (!empty($updates)) { //ensure there are changes
        $query .= implode(', ', $updates) . " WHERE " . implode(' AND ', $conditions); //create query
        if (mysqli_query($conn, $query)) { //send query
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "No updates were made because all form fields were empty.";
    }



    mysqli_close($conn);
}
?>
