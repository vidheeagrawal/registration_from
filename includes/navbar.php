<?php
// ✅ Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Get current page for active navbar highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">TIU Project</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                
                <!-- ✅ Home Link -->
                <li class="nav-item">
                  <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>

                <?php if(isset($_SESSION['user_id'])): ?>
                  <!-- ✅ Show when user is logged in -->
                  <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-danger fw-bold <?= ($current_page == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Logout</a>
                  </li>
                <?php else: ?>
                  <!-- ✅ Show when user is not logged in -->
                  <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'register.php') ? 'active' : ''; ?>" href="register.php">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?= ($current_page == 'login.php') ? 'active' : ''; ?>" href="login.php">Login</a>
                  </li>
                <?php endif; ?>

              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Debugging: Show login status only in index.php (Fix duplicate messages) -->
<?php if ($current_page == 'index.php' && isset($_SESSION['user_id'])): ?>
  <div class="alert alert-success text-center mt-3">
    ✅ Logged in as: <strong><?= $_SESSION['user_name']; ?></strong> (ID: <?= $_SESSION['user_id']; ?>)
  </div>
<?php elseif ($current_page == 'index.php'): ?>
  <div class="alert alert-warning text-center mt-3">
    ❌ No user is logged in. <a href="login.php" class="text-dark fw-bold">Login Here</a>
  </div>
<?php endif; ?>
