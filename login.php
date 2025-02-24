<?php 
session_start(); // ✅ Start session before checking user login

if (isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "You are already logged in.";
    header("Location: dashboard.php");
    exit();
}

$page_title = "Login Form";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Login to Your Account</h5>
                    </div>
                    <div class="card-body">
                        <!-- ✅ Show error/success messages -->
                        <?php if(isset($_SESSION['status'])): ?>
                            <div class="alert alert-warning text-center">
                                <?= $_SESSION['status']; unset($_SESSION['status']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="logincode.php" method="POST">
                            <!-- ✅ CSRF Token for Security -->
                            <input type="hidden" name="csrf_token" value="<?= bin2hex(random_bytes(32)); ?>">

                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" required autocomplete="off">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">👁️</button>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="login_btn" class="btn btn-primary w-100">Login Now</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Don't have an account? <a href="register.php">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ✅ Show/Hide Password Toggle Function
function togglePassword() {
    var passwordField = document.getElementById("password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
    } else {
        passwordField.type = "password";
    }
}
</script>

<?php include('includes/footer.php'); ?>
