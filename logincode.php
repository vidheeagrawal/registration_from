<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_btn'])) {
    // ✅ Get & Sanitize Input
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim($_POST['password']);

    // ✅ Check if email & password are entered
    if (empty($email) || empty($password)) {
        $_SESSION['status'] = "All fields are required.";
        header("Location: login.php");
        exit();
    }

    // ✅ Prepare SQL Statement to prevent SQL injection
    $stmt = $con->prepare("SELECT id, name, email, phone, password, verify_status FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // ✅ Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email, $phone, $hashed_password, $verify_status);
        $stmt->fetch();

        // ✅ Check if email is verified
        if ($verify_status == 1) { 
            // ✅ Verify password
            if (password_verify($password, $hashed_password)) { 
                // ✅ Store user details in session
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_phone'] = $phone;

                $_SESSION['status'] = "Login successful!";
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['status'] = "Incorrect password. Please try again.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "Please verify your email before logging in.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "No account found with this email.";
        header("Location: login.php");
        exit();
    }
}
?>
