<?php include("../includes/header.php"); ?>
<?php
include("../includes/config.php");

$user_id = $_SESSION['user_id'];
$role    = $_SESSION['role'];

if ($role == 'student') {
    $sql = "SELECT s.*, c.class_name, c.date, c.location, i.name as instructor 
            FROM schedules s
            JOIN classes c ON s.class_id = c.class_id
            JOIN instructors i ON s.instructor_id = i.instructor_id
            WHERE s.student_id = '$user_id'";
} elseif ($role == 'instructor') {
    $sql = "SELECT c.*, s.student_id, st.name as student 
            FROM schedules s
            JOIN classes c ON s.class_id = c.class_id
            JOIN students st ON s.student_id = st.student_id
            WHERE s.instructor_id = '$user_id'";
} else { // admin sees all
    $sql = "SELECT s.*, c.class_name, c.date, st.name as student, i.name as instructor 
            FROM schedules s
            JOIN classes c ON s.class_id = c.class_id
            JOIN students st ON s.student_id = st.student_id
            JOIN instructors i ON s.instructor_id = i.instructor_id";
}

$result = $conn->query($sql);
?>

<div class="container">
    <h2>📋 Scheduled Classes</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Class Name</th>
            <th>Date</th>
            <th>Location</th>
            <th>Instructor</th>
            <th>Student</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['class_name']; ?></td>
            <td><?= $row['date']; ?></td>
            <td><?= $row['location']; ?></td>
            <td><?= $row['instructor'] ?? $row['instructor_id']; ?></td>
            <td><?= $row['student'] ?? $row['student_id']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
