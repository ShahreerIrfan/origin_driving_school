<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/sidebar/std_dsboard_sdbar.css"> <!-- external css -->
</head>
<body>

    <!-- Student Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="student_dashboard.php" class="active">🏠 Dashboard</a>
        <a href="student_profile.php">👤 My Profile</a>
        <a href="student_schedule.php">📅 My Classes</a>
        <a href="student_performance.php">📊 My Progress</a>
        <a href="student_invoices.php">💳 Payments & Invoices</a>
        <a href="student_courses.php">📚 Courses & Enrollment</a>
        <a href="../../php/php_files/instructor_performance.php">⭐ Instructor Feedback</a>
        <a href="student_exam.php">📝 Exam Booking</a>
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
