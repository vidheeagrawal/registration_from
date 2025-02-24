<?php
require 'config.php'; // ✅ Load Database Credentials

// ✅ Establish Database Connection
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// ✅ Check Connection
if ($con->connect_error) {
    die("❌ Database Connection Failed: " . $con->connect_error);
}
?>
