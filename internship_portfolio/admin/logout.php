<?php
// admin/logout.php
include '../includes/config.php';

// Destroy all session variables
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>