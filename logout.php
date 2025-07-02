<?php

include 'config.php'; // Optional: Only needed if you log something or access DB during logout

session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_unset();
session_destroy();

// Prevent caching (optional but recommended for auth pages)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");

// Redirect to homepage
header('Location: index.php');
exit();

?>
