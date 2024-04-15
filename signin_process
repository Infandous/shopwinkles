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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare SQL query
    $sql = "SELECT * FROM Customer WHERE Email = '$email' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Sign in successful
        $row = mysqli_fetch_assoc($result);
        // Store user data in session variables
        $_SESSION['customerID'] = $row['CustomerID'];
        $_SESSION['name'] = $row['Name'];

        // Redirect to dashboard or home page
        header("Location: home.html");
        exit();
    } else {
        // Sign in failed
        $_SESSION['error'] = "Invalid email or password. Please try again.";
        header("Location: signin.html"); // Redirect back to sign-in page
        exit();
    }

    mysqli_close($conn);
}
?>
