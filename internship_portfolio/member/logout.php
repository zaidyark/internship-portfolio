<?php
// member/logout.php
include '../includes/config.php';

// Destroy member session variables
unset($_SESSION['member_id']);
unset($_SESSION['member_email']);
unset($_SESSION['member_name']);

// Destroy entire session if no admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    session_destroy();
    }

    $_SESSION['message'] = "You have been logged out successfully!";
    $_SESSION['message_type'] = "success";
    header("Location: ../index.php");
    exit();
    ?>