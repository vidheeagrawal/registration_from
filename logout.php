<?php
session_start();
session_unset(); // ✅ Clears all session variables
session_destroy(); // ✅ Destroys the session

// ✅ Redirect user to login page
$_SESSION['status'] = "You have logged out successfully.";
header("Location: login.php");
exit(); // ✅ Stops further execution
?>
