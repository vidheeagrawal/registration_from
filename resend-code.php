<?php
session_start();
include('dbcon.php');

if (isset($_POST['resend_email_verify_btn'])) {
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);

        // Check if email exists in the database
        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

        if (mysqli_num_rows($checkemail_query_run) > 0) {
            $row = mysqli_fetch_assoc($checkemail_query_run);
            $verify_token = $row['verify_token'];

            // Resend verification email (You can replace this with your actual email sending function)
            $subject = "Resend Email Verification";
            $message = "Hello, please click the link below to verify your email address: \n";
            $message .= "http://yourwebsite.com/verify-email.php?token=" . $verify_token;
            $headers = "From: no-reply@yourwebsite.com";

            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['status'] = "Verification email has been sent. Please check your inbox.";
            } else {
                $_SESSION['status'] = "Failed to send verification email. Try again later.";
            }
        } else {
            $_SESSION['status'] = "Email address not found. Please register first.";
        }
    } else {
        $_SESSION['status'] = "Please enter an email address.";
    }

    header("Location: resend-email-verification.php");
    exit(0);
}
?>
