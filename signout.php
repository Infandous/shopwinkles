<?php
session_start();
// destroy the session
session_destroy();

// redirect user
header("Location: signin.html");
exit();
?>
