<?php
include("../includes/header.php");
session_start();
if (empty($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: /driving_school/php/php_files/login.php");
    exit;
}
 ?>
