<?php 
session_start();
$page_title = "Registration Form";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h5>Register Your Account</h5>
                    </div>
                    <div class="card-body">
                        <!-- ✅ Show error/success messages -->
                        <?php if(isset($_SESSION['status'])): ?>
                            <div class="alert alert-warning text-center">
                                <?= $_SESSION['status']; unset($_SESSION['status']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="code.php" method="POST" onsubmit="return validateForm()">
                            <!-- ✅ CSRF Token for Security -->
                            <input type="hidden" name="csrf_token" value="<?= bin2hex(random_bytes(32)); ?>">

                            <div class="form-group mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" required pattern="\d{10}" title="Enter a valid 10-digit phone number">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required 
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}"
                                title="Password must be at least 8 characters long, include a capital letter, a number, and a special character"
                                oninput="checkPasswordMatch()">
                            </div>
                            <div class="form-group mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required oninput="checkPasswordMatch()">
                                <small id="passwordMatchMessage" class="text-danger"></small>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="register_btn" class="btn btn-primary w-100">Register Now</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="login.php">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkPasswordMatch() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var message = document.getElementById("passwordMatchMessage");

    if (password !== confirm_password) {
        message.innerHTML = "Passwords do not match!";
    } else {
        message.innerHTML = "";
    }
}

function validateForm() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (password !== confirm_password) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>

<?php include('includes/footer.php'); ?>
