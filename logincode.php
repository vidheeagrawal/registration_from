<?php
session_start();
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_btn'])) { // ✅ Secure method check
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])) && !empty($_POST['csrf_token'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        //  CSRF Protection
        if ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
            $_SESSION['status'] = "Security check failed. Please try again.";
            header("Location: login.php");
            exit();
        }

        //  Check if the user exists
        $login_query = "SELECT id, name, email, password, verify_status FROM users WHERE email=? LIMIT 1";
        $stmt = $con->prepare($login_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result(); 

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // 

            // ✅ Check if the email is verified
            if ($user['verify_status'] == 1) {
                // ✅ Verify password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
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
    } else {
        $_SESSION['status'] = "All fields are mandatory.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Invalid request.";
    header("Location: login.php");
    exit();
}
?>
