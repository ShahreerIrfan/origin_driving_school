<?php
session_start();
include("../includes/config.php");
include("../includes/header.php");

// Restrict access to admins only
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// --- Fetch Stats ---
$total_students = $conn->query("SELECT COUNT(*) AS c FROM students")->fetch_assoc()['c'] ?? 0;
$total_instructors = $conn->query("SELECT COUNT(*) AS c FROM instructors")->fetch_assoc()['c'] ?? 0;
$total_invoices = $conn->query("SELECT COUNT(*) AS c FROM invoices")->fetch_assoc()['c'] ?? 0;
$total_revenue = $conn->query("SELECT SUM(amount) AS s FROM invoices WHERE status='Paid'")->fetch_assoc()['s'] ?? 0;
$pending_invoices = $conn->query("SELECT COUNT(*) AS c FROM invoices WHERE status='Pending'")->fetch_assoc()['c'] ?? 0;
$upcoming_classes = $conn->query("SELECT * FROM classes WHERE `date` >= NOW() ORDER BY `date` ASC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* Header - stays full width */
        .header {
            background: #007bff;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #343a40;
            color: white;
            position: fixed;
            top: 60px; /* below header */
            bottom: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 10px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }

        /* Main Content */
        .content {
            margin-left: 220px; /* same as sidebar */
            padding: 80px 20px 20px; /* top padding for header space */
        }

        /* KPI Cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card h3 {
            margin: 10px 0;
            color: #333;
        }

        /* Table */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>

<!-- Header -->


<!-- Sidebar -->
<div class="sidebar">
    <a href="admin_dashboard.php">📊 Dashboard</a>
    <a href="manage_students.php">👨‍🎓 Manage Students</a>
    <a href="manage_instructors.php">👩‍🏫 Manage Instructors</a>
    <a href="manage_classes.php">📅 Manage Classes</a>
    <a href="manage_courses.php">📚 Manage Courses</a>
    <a href="manage_fleet.php">🚘 Manage Fleet</a>
    <a href="manage_branches.php">🏢 Manage Branches</a>
    <a href="manage_invoices.php">💵 Manage Invoices</a>
</div>

<!-- Main Content -->
<div class="content">
    <h2>Dashboard Overview</h2>

    <!-- KPI Cards -->
    <div class="cards">
        <div class="card">
            <h3><?= $total_students ?></h3>
            <p>Total Students</p>
        </div>
        <div class="card">
            <h3><?= $total_instructors ?></h3>
            <p>Total Instructors</p>
        </div>
        <div class="card">
            <h3><?= $total_invoices ?></h3>
            <p>Total Invoices</p>
        </div>
        <div class="card">
            <h3>$5600</h3>
            <p>Total Revenue</p>
        </div>
        <div class="card">
            <h3><?= $pending_invoices ?></h3>
            <p>Pending Invoices</p>
        </div>
    </div>

    <!-- Upcoming Classes -->
    <h2>Upcoming Classes</h2>
    <table>
        <tr>
            <th>Class Name</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Location</th>
        </tr>
        <?php if ($upcoming_classes && $upcoming_classes->num_rows > 0): ?>
            <?php while($row = $upcoming_classes->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['class_name'] ?></td>
                    <td><?= date("d M Y, H:i", strtotime($row['date'])) ?></td>
                    <td><?= $row['duration'] ?></td>
                    <td><?= $row['location'] ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No upcoming classes found.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
