<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// ADD Exam
if (isset($_POST['add_exam'])) {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $duration  = $_POST['duration'];
    $location  = $_POST['location'];
    $course_id = $_POST['course_id'];
    $status    = $_POST['status'];

    $sql = "INSERT INTO exams (exam_name, exam_date, duration, location, course_id, status) 
            VALUES ('$exam_name', '$exam_date', '$duration', '$location', '$course_id', '$status')";
    mysqli_query($conn, $sql);
    header("Location: manage_exam.php");
    exit();
}

// DELETE Exam
if (isset($_GET['delete'])) {
    $exam_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM exams WHERE exam_id=$exam_id");
    header("Location: manage_exams.php");
    exit();
}

// UPDATE Exam
if (isset($_POST['update_exam'])) {
    $exam_id   = $_POST['exam_id'];
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $duration  = $_POST['duration'];
    $location  = $_POST['location'];
    $course_id = $_POST['course_id'];
    $status    = $_POST['status'];

    $sql = "UPDATE exams SET 
                exam_name='$exam_name', exam_date='$exam_date', duration='$duration',
                location='$location', course_id='$course_id', status='$status'
            WHERE exam_id=$exam_id";
    mysqli_query($conn, $sql);
    header("Location: manage_exams.php");
    exit();
}

// READ Exams
$result = mysqli_query($conn, "SELECT exams.*, courses.course_name 
                               FROM exams 
                               LEFT JOIN courses ON exams.course_id = courses.course_id");
$courses = mysqli_query($conn, "SELECT * FROM courses"); // for dropdown
?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/exam/manage _exam.css">

<div class="container">
    <h2>📝 Manage Exams</h2>

    <!-- Add Exam Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Exam Name:</label>
            <input type="text" name="exam_name" required>
        </div>
        <div class="form-group">
            <label>Date & Time:</label>
            <input type="datetime-local" name="exam_date" required>
        </div>
        <div class="form-group">
            <label>Duration:</label>
            <input type="time" name="duration" required>
        </div>
        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="location" required>
        </div>
        <div class="form-group">
            <label>Course:</label>
            <select name="course_id">
                <option value="">-- Select Course --</option>
                <?php while ($c = mysqli_fetch_assoc($courses)): ?>
                    <option value="<?= $c['course_id'] ?>"><?= $c['course_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status">
                <option value="upcoming">Upcoming</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" name="add_exam">➕ Add Exam</button>
    </form>

    <!-- Exam List -->
    <h3>📋 Exam List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Exam Name</th>
            <th>Date</th>
            <th>Duration</th>
            <th>Location</th>
            <th>Course</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['exam_id'] ?></td>
            <td><?= $row['exam_name'] ?></td>
            <td><?= $row['exam_date'] ?></td>
            <td><?= $row['duration'] ?></td>
            <td><?= $row['location'] ?></td>
            <td><?= $row['course_name'] ?: '-' ?></td>
            <td>
                <?php if ($row['status'] == 'upcoming'): ?>
                    <span class="badge badge-upcoming">Upcoming</span>
                <?php elseif ($row['status'] == 'completed'): ?>
                    <span class="badge badge-completed">Completed</span>
                <?php else: ?>
                    <span class="badge badge-cancelled">Cancelled</span>
                <?php endif; ?>
            </td>
            <td class="actions">
                <!-- Edit -->
                <i class="fa-solid fa-pen-to-square edit-btn"
                   onclick="openModal(
                        '<?= $row['exam_id'] ?>',
                        '<?= htmlspecialchars($row['exam_name']) ?>',
                        '<?= $row['exam_date'] ?>',
                        '<?= $row['duration'] ?>',
                        '<?= htmlspecialchars($row['location']) ?>',
                        '<?= $row['course_id'] ?>',
                        '<?= $row['status'] ?>'
                   )"></i>
                <!-- Delete -->
                <a href="?delete=<?= $row['exam_id'] ?>" onclick="return confirm('Delete this exam?')">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>✏️ Update Exam</h2>
        <form method="POST">
            <input type="hidden" name="exam_id" id="examId">
            <label>Exam Name:</label>
            <input type="text" name="exam_name" id="examName" required>
            <label>Date & Time:</label>
            <input type="datetime-local" name="exam_date" id="examDate" required>
            <label>Duration:</label>
            <input type="time" name="duration" id="examDuration" required>
            <label>Location:</label>
            <input type="text" name="location" id="examLocation" required>
            <label>Course:</label>
            <input type="text" name="course_id" id="examCourse">
            <label>Status:</label>
            <select name="status" id="examStatus">
                <option value="upcoming">Upcoming</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button type="submit" name="update_exam">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, date, duration, location, course, status) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("examId").value = id;
    document.getElementById("examName").value = name;
    document.getElementById("examDate").value = date.replace(" ", "T");
    document.getElementById("examDuration").value = duration;
    document.getElementById("examLocation").value = location;
    document.getElementById("examCourse").value = course;
    document.getElementById("examStatus").value = status;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
