<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "Please log in to access this page.";
    header("Location: login.php");
    exit();
}
?>
