<?php
$servername = "localhost";
$username   = "root";   // default for XAMPP
$password   = "";       // default for XAMPP is empty
$database   = "origin_driving_school_db";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>
