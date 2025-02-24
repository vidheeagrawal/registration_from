<?php
session_start();
include('dbcon.php');

if (isset($_GET['token'])) {
    $verify_token = $_GET['token'];

    $check_token_query = "SELECT verify_token, verify_status FROM users WHERE verify_token=? LIMIT 1";
    $stmt = $con->prepare($check_token_query);
    $stmt->bind_param("s", $verify_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_token, $verify_status);
        $stmt->fetch();

        if ($verify_status == 1) {
            $_SESSION['status'] = "Email already verified.";
            header("Location: login.php");
            exit();
        }

        $update_query = "UPDATE users SET verify_status=1 WHERE verify_token=?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("s", $verify_token);
        if ($stmt->execute()) {
            $_SESSION['status'] = "Email verified successfully!";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['status'] = "Verification failed.";
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Invalid verification link.";
        header("Location: register.php");
        exit();
    }
}
?>
