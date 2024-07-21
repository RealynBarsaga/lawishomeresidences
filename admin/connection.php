<?php
// Database credentials
$db_server = "localhost";
$MySQL_username = "u510162695_db_barangay";
$Password = "1Db_barangay";    
$MySQL_database_name = "u510162695_db_barangay";

// Establishing connection with server
$con = mysqli_connect($db_server, $MySQL_username, $Password, $MySQL_database_name);

// Checking connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Setting the default timezone
date_default_timezone_set("Asia/Manila");

echo "Connected successfully";
?>