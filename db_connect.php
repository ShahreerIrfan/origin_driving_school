<?php
echo "Welcome to the stage where we are ready to get connected to a database <br>";

/* 
Ways to connect to a MySQL Database:
1. MySQLi extension (we’ll use this here)
2. PDO
*/

// Database credentials
$servername = "localhost";
$username   = "root"; // Default XAMPP username
$password   = "";     // Default XAMPP password is empty
$database   = "origin_driving_school_db"; // Your database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn) {
    die("❌ Sorry, we failed to connect: " . mysqli_connect_error());
} else {
    echo "✅ Connection was successful!";
}
?>
