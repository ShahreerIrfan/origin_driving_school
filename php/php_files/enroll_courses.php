<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// Ensure only students can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['user_id'];
$msg = "";

// Enroll student
if (isset($_GET['enroll'])) {
    $course_id = intval($_GET['enroll']);
    $check = $conn->query("SELECT * FROM enrollments WHERE student_id=$student_id AND course_id=$course_id");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO enrollments (student_id, course_id) VALUES ($student_id, $course_id)");

        // Create invoice automatically
        $course = $conn->query("SELECT price FROM courses WHERE course_id=$course_id")->fetch_assoc();
        $amount = $course['price'];
        $conn->query("INSERT INTO invoices (student_id, course_id, amount, status, payment_status) 
                      VALUES ($student_id, $course_id, '$amount', 'Pending', 'Pending')");

        $msg = "✅ Enrolled successfully! Invoice generated.";
    } else {
        $msg = "⚠️ You are already enrolled in this course!";
    }
}

// Fetch courses
$courses = $conn->query("SELECT * FROM courses");
?>

<link rel="stylesheet" href="../../assets/css/enroll_course/enroll_course.css">

<div class="container">
    <h2>📚 Available Courses</h2>
    <?php if (!empty($msg)): ?>
        <div class="message"><?= $msg ?></div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Course</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $courses->fetch_assoc()): ?>
        <tr>
            <td><?= $row['course_name'] ?></td>
            <td>$<?= number_format($row['price'], 2) ?></td>
            <td><?= $row['duration'] ?> hrs</td>
            <td><?= $row['description'] ?></td>
            <td>
                <a href="?enroll=<?= $row['course_id'] ?>" class="btn-enroll">Enroll</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include("../includes/footer.php"); ?>
