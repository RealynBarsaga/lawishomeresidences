<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u510162695_db_barangay');
define('DB_PASSWORD', '1Db_barangay');
define('DB_DATABASE', 'u510162695_db_barangay');

// Establishing Connection with Server
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Setting the default timezone
date_default_timezone_set("Asia/Manila");
?>
