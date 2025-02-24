<?php
session_start();
include('dbcon.php');

if (isset($_GET['token'])) {
    $verify_token = $_GET['token'];

    // ✅ Check if Token Exists
    $check_token_query = "SELECT verify_token, verify_status FROM users WHERE verify_token=? LIMIT 1";
    $stmt = $con->prepare($check_token_query);
    $stmt->bind_param("s", $verify_token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_token, $verify_status);
        $stmt->fetch();
        $stmt->close(); // ✅ Close the first statement

        // ✅ Check if Email Already Verified
        if ($verify_status == 1) {
            $_SESSION['status'] = "✅ Email already verified.";
            header("Location: login.php");
            exit();
        }

        // ✅ Update Verification Status
        $update_query = "UPDATE users SET verify_status=1 WHERE verify_token=?";
        $stmt_update = $con->prepare($update_query);
        $stmt_update->bind_param("s", $verify_token);

        if ($stmt_update->execute()) {
            $_SESSION['status'] = "✅ Email verified successfully!";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['status'] = "❌ Verification failed. Please try again.";
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "❌ Invalid verification link.";
        header("Location: register.php");
        exit();
    }
} else {
    $_SESSION['status'] = "❌ No verification token provided.";
    header("Location: register.php");
    exit();
}
?>
