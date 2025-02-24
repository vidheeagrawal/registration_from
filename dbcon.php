<?php
// Enable error reporting (for debugging purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$servername = "localhost";
$username = "root";
$password = "vidhee123";  // Ensure your password is secure and not exposed in production
$dbname = "registration_db";

// Create a database connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

// Optional: Set character set to UTF-8 for proper encoding
$con->set_charset("utf8");

?>
