<?php
include("../includes/header.php");
include("../includes/config.php");
include("../includes/sidebar.php");

// ================= CREATE =================
if (isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];

    $sql = "INSERT INTO courses (course_name, price, duration, description) 
            VALUES ('$course_name', '$price', '$duration', '$description')";
    mysqli_query($conn, $sql);
    header("Location: manage_courses.php"); // refresh
    exit();
}

// ================= DELETE =================
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];
    $sql = "DELETE FROM courses WHERE course_id=$course_id";
    mysqli_query($conn, $sql);
    header("Location: manage_courses.php"); 
    exit();
}

// ================= UPDATE =================
if (isset($_POST['update_course'])) {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];

    $sql = "UPDATE courses 
            SET course_name='$course_name', price='$price', duration='$duration', description='$description' 
            WHERE course_id=$course_id";
    mysqli_query($conn, $sql);
    header("Location: manage_courses.php");
    exit();
}

// ================= READ =================
$result = mysqli_query($conn, "SELECT * FROM courses");
?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="../../assets/css/courses/manage_courses.css"> 

<div class="container">
    <h2>📚 Manage Courses</h2>

    <!-- Add Course Form -->
    <form method="POST" class="add-form">
        <div class="form-group">
            <label>Course Name:</label>
            <input type="text" name="course_name" required>
        </div>
        <div class="form-group">
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" required>
        </div>
        <div class="form-group">
            <label>Duration (hours or lessons):</label>
            <input type="number" name="duration" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_course">➕ Add Course</button>
    </form>

    <!-- Course List -->
    <h3>📋 Course List</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Course</th>
            <th>Price</th>
            <th>Duration</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['course_id'] ?></td>
            <td><?= $row['course_name'] ?></td>
            <td>$<?= $row['price'] ?></td>
            <td><?= $row['duration'] ?></td>
            <td><?= $row['description'] ?></td>
            <td class="actions">
                <!-- Update button -->
                <i class="fa-solid fa-pen-to-square edit-btn" 
                   onclick="openModal(
                        '<?= $row['course_id'] ?>',
                        '<?= htmlspecialchars($row['course_name']) ?>',
                        '<?= $row['price'] ?>',
                        '<?= $row['duration'] ?>',
                        '<?= htmlspecialchars($row['description']) ?>'
                   )"></i>
                <!-- Delete button -->
                <a href="?delete=<?= $row['course_id'] ?>" onclick="return confirm('Delete this course?')">
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
        <h2>✏️ Update Course</h2>
        <form method="POST">
            <input type="hidden" name="course_id" id="courseId">
            <label>Course Name:</label>
            <input type="text" name="course_name" id="courseName" required>
            <label>Price ($):</label>
            <input type="number" step="0.01" name="price" id="coursePrice" required>
            <label>Duration:</label>
            <input type="number" name="duration" id="courseDuration" required>
            <label>Description:</label>
            <textarea name="description" id="courseDesc" rows="3" required></textarea>
            <button type="submit" name="update_course">💾 Save Changes</button>
        </form>
    </div>
</div>

<script>
function openModal(id, name, price, duration, desc) {
    document.getElementById("updateModal").style.display = "flex";
    document.getElementById("courseId").value = id;
    document.getElementById("courseName").value = name;
    document.getElementById("coursePrice").value = price;
    document.getElementById("courseDuration").value = duration;
    document.getElementById("courseDesc").value = desc;
}
function closeModal() {
    document.getElementById("updateModal").style.display = "none";
}
</script>

<?php include("../includes/footer.php"); ?>
