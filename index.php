<?php
// Start session
session_start();

// If user is logged in, redirect based on role
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: php/php_files/admin_dashboard.php");
            exit();
        case 'instructor':
            header("Location: php/php_files/instructor_dashboard.php");
            exit();
        case 'student':
            header("Location: php/php_files/student_dashboard.php");
            exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Origin Driving School</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include("php/includes/header.php"); ?>

    <h1>Welcome to Origin Driving School Management System</h1>
    <p>Please <a href="php/php_files/login.php">Login</a> or <a href="php/php_files/register.php">Register</a>.</p>

    <?php include("php/includes/footer.php"); ?>
</body>
</html>
