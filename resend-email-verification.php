<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Resend Email Verification</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        session_start();
                        if (isset($_SESSION['status'])) { 
                            echo '<div class="alert alert-warning">' . $_SESSION['status'] . '</div>';
                            unset($_SESSION['status']); // Clear session message
                        }
                        ?>
                        <form action="resend-code.php" method="POST">
                            <div class="form-group mb-3"> 
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                            </div> 
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary w-100">Resend Verification Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
