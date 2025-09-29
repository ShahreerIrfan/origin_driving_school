<?php
session_start();
include("../includes/header.php");
include("../includes/config.php");
include("../includes/student_dashboard_sidebar.php");

// Ensure only logged-in students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'] ?? 0;

// Fetch enrolled classes
$sql = "SELECT s.schedule_id, c.class_name, c.date, c.duration, c.location, 
               i.name AS instructor_name, f.vehicle_name
        FROM schedules s
        JOIN classes c ON s.class_id = c.class_id
        JOIN instructors i ON s.instructor_id = i.instructor_id
        LEFT JOIN fleet f ON c.vehicle_id = f.vehicle_id
        WHERE s.student_id = '$student_id'
        ORDER BY c.date ASC";

$result = $conn->query($sql);
?>

<style>
.main-container {
    width: 800px;
    margin: 40px auto;
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.main-container h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
table th, table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}
table th {
    background: #007bff;
    color: #fff;
    font-weight: bold;
}
table tr:nth-child(even) {
    background: #f9f9f9;
}
table tr:hover {
    background: #f1f1f1;
}
.no-classes {
    text-align: center;
    color: #ff5722;
    font-size: 16px;
    margin-top: 20px;
}
</style>

<div class="main-container">
    <h2>📌 My Enrolled Classes</h2>

    <?php if ($result && $result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Class Name</th>
                <th>Instructor</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Location</th>
                <th>Vehicle</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['class_name']); ?></td>
                    <td><?= htmlspecialchars($row['instructor_name']); ?></td>
                    <td><?= htmlspecialchars($row['date']); ?></td>
                    <td><?= htmlspecialchars($row['duration']); ?></td>
                    <td><?= htmlspecialchars($row['location']); ?></td>
                    <td>BMW</td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-classes">⚠️ You haven’t enrolled in any classes yet.</p>
    <?php } ?>
</div>

<?php include("../includes/footer.php"); ?>
