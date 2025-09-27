<?php
// Start session only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Origin Driving School</title>
    <link rel="stylesheet" href="/driving_school/assets/css/global.css"> <!-- global styles -->
</head>
<body>

<!-- Navbar -->
<header>
    <nav class="navbar">
        <div class="logo">🚗 Origin Driving School</div>
        <ul class="nav-links">
            <!-- Public links -->
            <li><a href="/driving_school/index.php">Home</a></li>
            <li><a href="/driving_school/php/php_files/register.php">Register</a></li>

            <!-- Role-specific / Auth logic -->
            <?php if (!isset($_SESSION['role'])): ?>
                <!-- If not logged in -->
                <li><a href="/driving_school/php/php_files/login.php">Login</a></li>
            <?php else: ?>
                <!-- If logged in show only dashboard -->
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="/driving_school/php/php_files/admin_dashboard.php">Dashboard</a></li>
                <?php elseif ($_SESSION['role'] === 'instructor'): ?>
                    <li><a href="/driving_school/php/php_files/instructor_dashboard.php">Dashboard</a></li>
                <?php elseif ($_SESSION['role'] === 'student'): ?>
                    <li><a href="/driving_school/php/php_files/student_dashboard.php">Dashboard</a></li>
                <?php endif; ?>
                <!-- Common logout link -->
                <li><a href="/driving_school/php/php_files/logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
