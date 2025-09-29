<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/sidebar/std_dsboard_sdbar.css">
</head>
<body>

<?php
// detect current file name (without query string)
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Student Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="student_dashboard.php" class="<?= ($current_page == 'student_dashboard.php') ? 'active' : '' ?>">🏠 Dashboard</a>
    <a href="../php_files/student_profile.php" class="<?= ($current_page == 'student_profile.php') ? 'active' : '' ?>">👤 My Profile</a>
    <a href="../php_files/book_class.php" class="<?= ($current_page == 'book_class.php') ? 'active' : '' ?>">📅 Book Class</a>
    <a href="../php_files/student_enrolled_class.php" class="<?= ($current_page == 'student_enrolled_class.php') ? 'active' : '' ?>">📅 My Classes</a>
    <a href="student_performance.php" class="<?= ($current_page == 'student_performance.php') ? 'active' : '' ?>">📊 My Progress</a>
    <a href="student_invoices.php" class="<?= ($current_page == 'student_invoices.php') ? 'active' : '' ?>">💳 Payments & Invoices</a>
    <a href="student_courses.php" class="<?= ($current_page == 'student_courses.php') ? 'active' : '' ?>">📚 Courses & Enrollment</a>
    <a href="../../php/php_files/instructor_performance.php" class="<?= ($current_page == 'instructor_performance.php') ? 'active' : '' ?>">⭐ Instructor Feedback</a>
    <a href="student_exam.php" class="<?= ($current_page == 'student_exam.php') ? 'active' : '' ?>">📝 Exam Booking</a>
    <hr>
    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<!-- Toggle Script for Mobile -->
<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>

</body>
</html>
