<?php 

session_start();
include('auth.php'); // ✅ Ensures only logged-in users can access

$page_title = "Dashboard";

include('includes/header.php');
include('includes/navbar.php');

// ✅ Debugging: Check if session values exist
if (!isset($_SESSION['user_id'])) {
    $_SESSION['status'] = "Please login to access the dashboard.";
    header("Location: login.php");
    exit();
}
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h4>Access granted only when you are Logged IN</h4>
                        <hr>

                        <!-- ✅ Display user info properly -->
                        <h5>Username: <?= $_SESSION['user_name'] ?? 'N/A'; ?></h5>
                        <h5>Email: <?= $_SESSION['user_email'] ?? 'N/A'; ?></h5>
                        <h5>Phone: <?= $_SESSION['user_phone'] ?? 'N/A'; ?></h5>

                        <p>Welcome, <strong><?= $_SESSION['user_name'] ?? 'User'; ?></strong>!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
