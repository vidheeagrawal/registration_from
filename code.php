<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader & Config
require 'vendor/autoload.php';
require 'config.php'; // ✅ Secure SMTP credentials

// ✅ Function to Send Email Verification
function sendEmailVerification($email, $name, $token)
{
    global $SMTP_HOST, $SMTP_USER, $SMTP_PASS;

    $mail = new PHPMailer(true);
    try {
        // ✅ Remove Debugging after testing
        // $mail->SMTPDebug  = SMTP::DEBUG_SERVER; 
        $mail->Debugoutput = 'html';

        // ✅ SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = $SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = $SMTP_USER;
        $mail->Password   = $SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // ✅ Set Email Headers
        $mail->setFrom($SMTP_USER, 'Vidhee Website');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email';

        // ✅ Email Body with Verification Link
        $verification_link = "http://localhost/registration-form/verify-email.php?token=" . $token;
        $mail->Body = "Hi $name,<br><br>
                       Please verify your email by clicking the link below:<br>
                       <a href='$verification_link'>$verification_link</a>";

        return $mail->send();
    } catch (Exception $e) {
        error_log("❌ Email Error: " . $mail->ErrorInfo);
        return false;
    }
}

// ✅ Secure User Registration Handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_btn'])) {
    // ✅ Prevent CSRF Attacks
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
        $_SESSION['status'] = "Security check failed. Please try again.";
        header("Location: register.php");
        exit();
    }

    // ✅ Get & Sanitize Input
    $name     = trim(htmlspecialchars($_POST['name']));
    $phone    = trim($_POST['phone']);
    $email    = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // ✅ Input Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $_SESSION['status'] = "All fields are required.";
        header("Location: register.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = "Invalid email format.";
        header("Location: register.php");
        exit();
    }

    if ($password !== $confirm) {
        $_SESSION['status'] = "Passwords do not match.";
        header("Location: register.php");
        exit();
    }

    // ✅ Check if Email Already Exists
    $stmt = $con->prepare("SELECT email FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['status'] = "Email already exists.";
        header("Location: register.php");
        exit();
    }

    // ✅ Generate Secure Token & Hash Password
    $verify_token = bin2hex(random_bytes(32));
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // ✅ Insert User into Database
    $stmt = $con->prepare("INSERT INTO users (name, phone, email, password, verify_token, verify_status) VALUES (?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("sssss", $name, $phone, $email, $hashed_password, $verify_token);

    if ($stmt->execute()) {
        if (sendEmailVerification($email, $name, $verify_token)) {
            $_SESSION['status'] = "Registration successful! Check your email.";
        } else {
            $_SESSION['status'] = "Registration successful, but email not sent.";
        }
    } else {
        $_SESSION['status'] = "Registration failed: " . $stmt->error;
    }

    header("Location: register.php");
    exit();
}
?>
