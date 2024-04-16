<?php
// Start or resume the session
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // connect to server
    $conn = mysqli_connect('mysql.eecs.ku.edu', '447s24_j507s861', 'tieTexo3', '447s24_j507s861');
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    // get form data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // write query
    $sql = "SELECT * FROM Customer WHERE Email = '$email' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // successful signin
        $row = mysqli_fetch_assoc($result);
        // make session variables
        $_SESSION['customerID'] = $row['CustomerID'];
        $_SESSION['name'] = $row['Name'];

        // redirect user
        header("Location: home.html");
        exit();
    } else {
        // sign in failed
        //this error is not used write yet.
        $_SESSION['error'] = "Invalid email or password. Please try again.";
        header("Location: signin.html"); 
        exit();
    }

    mysqli_close($conn);
}
?>
