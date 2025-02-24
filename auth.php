<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "Access Denied. Please log in.";
    header("Location: login.php");
    exit();
}
?>
