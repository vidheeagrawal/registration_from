<?php 

session_start();
include('auth.php'); // ✅ Ensures only logged-in users can access

$page_title = "Dashboard";

include('includes/header.php');
include('includes/navbar.php');

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
                        <h5>Username: <?= isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'N/A'; ?></h5>
                        <h5>Email: <?= isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'N/A'; ?></h5>
                        <h5>Phone: <?= isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : 'N/A'; ?></h5>

                        <p>Welcome, <strong><?= $_SESSION['user_name'] ?? 'User'; ?></strong>!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
