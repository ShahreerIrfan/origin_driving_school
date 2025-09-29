<style>
/* Sidebar */
.sidebar {
    width: 180px; /* reduced width */
    background: #343a40;
    color: white;
    position: fixed;
    top: 60px; /* below header */
    left: 0;
    bottom: 0;
    overflow-y: auto;
    transition: transform 0.3s ease;
    z-index: 999;
}

/* Sidebar Links */
.sidebar a {
    display: block;
    color: white;
    padding: 10px 14px; /* reduced padding */
    font-size: 14px;    /* smaller text */
    text-decoration: none;
}
.sidebar a:hover {
    background: #495057;
}
.sidebar a.active {
    background: #007bff;
}

/* Main Content */
.main-content {
    margin-left: 180px;   /* same as sidebar width */
    padding: 20px;
    transition: margin-left 0.3s ease;
}

/* Responsive: Mobile view */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
    }
    .sidebar.active {
        transform: translateX(0);
    }
    .main-content {
        margin-left: 0; /* no offset on mobile */
    }
}

</style>



<!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar">
    <a href="admin_dashboard.php">📊 Dashboard</a>
    <a href="manage_students.php">👨‍🎓 Manage Students</a>
    <a href="manage_instructors.php">👩‍🏫 Manage Instructors</a>
    <a href="manage_classes.php">📅 Manage Classes</a>
    <a href="manage_courses.php">📚 Manage Courses</a>
    <a href="manage_exam.php">📚 Manage Exam</a>
    <a href="manage_fleet.php">🚘 Manage Fleet</a>
    <a href="manage_branches.php">🏢 Manage Branches</a>
    <a href="manage_invoices.php">💵 Manage Invoices</a>
    <a href="reports.php">📈 Reports</a>
    <hr style="border: 0; height: 1px; background: #555; margin: 10px 0;">
    <a href="logout.php" style="color: #ff4d4d;">🚪 Logout</a>
</div>





<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
}
</script>
